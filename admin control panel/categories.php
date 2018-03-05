<?php

	/*
	================================================
	== categories Page
	================================================
	*/

	ob_start(); // Output Buffering Start

	session_start();

	$pageTitle = 'categories';

	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') {
			$sort = 'ASC';
			$sort_array = array('ASC','DESC');
            if(isset($_GET['sort'])&& in_array($_GET['sort'], $sort_array))
            {
            	$sort = $_GET['sort'];
            }
			$stmt2 = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY ordering $sort");
			$stmt2->execute();
			$cats = $stmt2->fetchAll(); ?>
			<h1 class="text-center">Manage categories</h1>
			<div class="container categories">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-edit"></i>Manage categories
						<div class="ordering pull-right">
							<i class="fa fa-sort"></i>ordering:
							<a class="<?php if($sort == 'ASC'){echo 'active';} ?>" href="?sort=ASC">ASC</a>|
							<a class="<?php if($sort == 'DESC'){echo 'active';} ?>" href="?sort=DESC">DESC</a>
							<i class="fa fa-eye"></i>View:
							<span class="active" data-view="full">Full</span>
							<span data-view="Classic">Classic</span>
						</div>
					</div>
					<div class="panel-body">
						<?php
						foreach ($cats as $cats) {
							echo "<div class='cats'>";
							echo "<div class='hidden-buttons'>";
							echo "<a href='categories.php?do=Edit&catid=".$cats['ID']."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
							echo "<a href='categories.php?do=Delete&catid=".$cats['ID']."' class=' confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
							echo "</div>";
							echo "<h3>".$cats['Name']."</h3>";
							echo "<div class='full-view'>";
								echo "<p>";if($cats['Description']==''){echo"this category has no description";}else{echo $cats['Description'];}echo"</p>";
								if($cats['visibility']==1){echo "<span class='visibility'><i class='fa fa-eye'></i>hidden</span>"; } 
								if($cats['Allow_comment']==1){echo "<span class='commenting'><i class='fa fa-close'></i>comment Disabled</span>"; }
								if($cats['Allow_ads']==1){echo "<span class='advertising'><i class='fa fa-close'></i>Ads Disabled</span>"; } 
								$childcat = getAllFrom("*", "categories", "where parent = {$cats['ID']}", "", "ID", "ASC");
						      	if(!empty($childcat)){
                                echo "<h4 class = 'child-head'>child category </h4>";
                                echo "<ul class='list-unstyled child-cats'>";
								foreach ($childcat as $c) {

											echo "<li class='child-link'>
												<a href='categories.php?do=Edit&catid=" . $c['ID'] . "'>" . $c['Name'] . "</a>
												<a href='categories.php?do=Delete&catid=" . $c['ID'] . "' class='show-delete confirm'> Delete</a>
											</li>";
										  

									}
								
								echo "</ul>";
								}
							echo "</div>";
                            echo "</div>";
                            echo "<hr>";
                           //get child category

	      
						 } 
						?>
					</div>
				</div>
				<a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i>Add new category</a>
			</div>
			<?php

		} elseif ($do == 'Add') {?>

			<h1 class="text-center">Add New category</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<!-- Start name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="name of the category" />
						</div>
					</div>
					<!-- End name Field -->
					<!-- Start description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="description" class="form-control"   placeholder="Description the category" />
						</div>
					</div>
					<!-- End description Field -->
					<!-- Start Ordering Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Ordering</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="ordering" class="form-control" placeholder="Number to arrange the category" />
						</div>
					</div>
					<!-- End Ordering Field -->
					<!-- start category type-->
                    <div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">category type</label>
						<div class="col-sm-10 col-md-6">
							<select name="parent">
								<option value="0">None</option>
								<?php 
									$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", "ASC");
									foreach($allCats as $cat) {
										echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
									}
								?>
							</select>
						</div>
					</div>

				     <!-- end category type-->
					<!-- Start Visiblity Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Visible</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="vis-yes" type="radio" name="Visiblity" value="0" checked>
								<label for="vis-yes">Yes</label>
							</div>
							<div>
								<input id="vis-no" type="radio" name="Visiblity" value="1">
								<label for="vis-no">No</label>
							</div>
						</div>
					</div>
					<!-- End Visiblity Field -->
					<!-- Start commenting Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow commenting</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="com-yes" type="radio" name="commenting" value="0" checked>
								<label for="com-yes">Yes</label>
							</div>
							<div>
								<input id="com-no" type="radio" name="commenting" value="1" >
								<label for="com-no">No</label>
							</div>
						</div>
					</div>
					<!-- End commenting Field -->
					<!-- Start allow ads Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Ads</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="ad-yes" type="radio" name="ads" value="0" checked>
								<label for="ad-yes">Yes</label>
							</div>
							<div>
								<input id="ad-no" type="radio" name="ads" value="1" >
								<label for="ad-no">No</label>
							</div>
						</div>
					</div>
					<!-- End ads Field -->
					<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add category" class="btn btn-primary btn-lg" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
			</div>




        <?php 
		} elseif ($do == 'Insert') {
			// Insert Member Page

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>Insert category</h1>";
				echo "<div class='container'>";

				// Upload Variables

				// Get Variables From The Form

				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$parent 	= $_POST['parent'];
 				$order 		= $_POST['ordering'];
				$visible 	= $_POST['Visiblity'];
				$comment 	= $_POST['commenting'];
				$ads 	    = $_POST['ads'];

				// Validate The Form



					// Check If category Exist in Database

					$check = checkItem("Name", "categories", $name);

					if ($check == 1) {

						$theMsg = '<div class="alert alert-danger">Sorry This category Is Exist</div>';

						redirectHome($theMsg, 6);

					} else {

						// Insert category In Database

						$stmt = $con->prepare("INSERT INTO 
													categories(Name, Description,parent,Ordering,visibility,Allow_comment,Allow_ads)
												VALUES(:zname, :zdesc, :zpare, :zorder, :zvisible, :zcomment, :zads) ");
						$stmt->execute(array(

							'zname' 	=> $name,
							'zdesc' 	=> $desc,
							'zpare'     => $parent,
							'zorder' 	=> $order,
							'zvisible' 	=> $visible,
							'zcomment'	=> $comment,
							'zads'      => $ads

						));

						// Echo Success Message

						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

						redirectHome($theMsg, 'back');

					}

				


			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

				echo "</div>";

			}

			echo "</div>";

		} elseif ($do == 'Edit') {

			// Check If Get Request catid Is Numeric & Get Its Integer Value

			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

			// Select All Data Depend On This ID

			$stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");

			// Execute Query

			$stmt->execute(array($catid));

			// Fetch The Data

			$cat = $stmt->fetch();

			// The Row Count

			$count = $stmt->rowCount();

			// If There's Such ID Show The Form

			if ($count > 0) { ?>

			<h1 class="text-center">Edit category</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="catid" value="<?php echo $catid ?>" />
					<!-- Start name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name" class="form-control"  required="required" placeholder="name of the category"
							value="<?php echo $cat['Name']; ?>" />
						</div>
					</div>
					<!-- End name Field -->
					<!-- Start description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="description" class="form-control"   placeholder="Description the category" 
							value="<?php echo $cat['Description']; ?>"/>
						</div>
					</div>
					<!-- End description Field -->
					<!-- Start Ordering Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Ordering</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="ordering" class="form-control" placeholder="Number to arrange the category"
							value="<?php echo $cat['Ordering']; ?>" />
						</div>
					</div>
					<!-- End Ordering Field -->
					<!-- start category type-->
                    <div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">category type</label>
						<div class="col-sm-10 col-md-6">
							<select name="parent">
								<option value="0">None</option>
									<?php 
										$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", "ASC");
										foreach($allCats as $c) {
											echo "<option value='" . $c['ID'] . "'";
											if ($cat['parent'] == $c['ID']) { echo ' selected'; }
											echo ">" . $c['Name'] . "</option>";
										}
									?> 
							</select>
						</div>
					</div>

				     <!-- end category type-->
					<!-- Start Visiblity Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Visible</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="vis-yes" type="radio" name="Visiblity" value="0" <?php if($cat['visibility']== 0){echo "checked";} ?> />
								<label for="vis-yes">Yes</label>
							</div>
							<div>
								<input id="vis-no" type="radio" name="Visiblity" value="1" <?php if($cat['visibility']== 1){echo "checked";} ?> />
								<label for="vis-no">No</label>
							</div>
						</div>
					</div>
					<!-- End Visiblity Field -->
					<!-- Start commenting Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow commenting</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_comment']== 0){echo "checked";} ?> />
								<label for="com-yes">Yes</label>
							</div>
							<div>
								<input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_comment']== 1){echo "checked";} ?> >
								<label for="com-no">No</label>
							</div>
						</div>
					</div>
					<!-- End commenting Field -->
					<!-- Start allow ads Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Ads</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="ad-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_ads']== 0){echo "checked";} ?> />
								<label for="ad-yes">Yes</label>
							</div>
							<div>
								<input id="ad-no" type="radio" name="ads" value="1" <?php if($cat['Allow_ads']== 1){echo "checked";} ?> />
								<label for="ad-no">No</label>
							</div>
						</div>
					</div>
					<!-- End ads Field -->
					<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Update category" class="btn btn-primary btn-lg" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
			</div>

			<?php

			// If There's No Such ID Show Error Message

			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';

				redirectHome($theMsg);

				echo "</div>";

			}


		} elseif ($do == 'Update') {
				echo "<h1 class='text-center'>Update category</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get Variables From The Form

				$id 		= $_POST['catid'];
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$order 		= $_POST['ordering'];
				$parent     = $_POST['parent'];
				$visible 	= $_POST['Visiblity'];
				$comment 	= $_POST['commenting'];
				$ads 		= $_POST['ads'];

				// Validate The Form 

				// Check If There's No Error Proceed The Update Operation

						// Update The Database With This Info

						$stmt = $con->prepare("UPDATE 
											categories 
										SET 
											Name = ?, 
											Description = ?, 
											Ordering = ?, 
											parent = ?,
											Visibility = ?,
											Allow_Comment = ?,
											Allow_Ads = ? 
										WHERE 
											ID = ?");

				$stmt->execute(array($name, $desc, $order,$parent,$visible, $comment, $ads, $id));

				// Echo Success Message

				$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

				redirectHome($theMsg, 'back');

			} else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

			}

			echo "</div>";


		} elseif ($do == 'Delete') {
			 echo "<h1 class='text-center'>Delete Member</h1>";
			echo "<div class='container'>";

				// Check If Get Request userid Is Numeric & Get The Integer Value Of It

				$cat = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('ID', 'categories', $cat);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");

					$stmt->bindParam(":zid", $cat);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';


		} 

		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output

?>