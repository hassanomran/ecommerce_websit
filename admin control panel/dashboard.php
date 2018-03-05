<?php
   ob_start();
	session_start();
	if (isset($_SESSION['Username'])) {
		$pageTitle = 'Dashboard';
	     include 'init.php';
        /* start dashboard page */
               $numuser = 5;
               $latestuser = getLatest("*","users",$numuser);

               $numItem = 6; // number of items
               $latestItem = getLatest("*","items",$numItem);
               $numcomments = 4;
        ?>
        <div class="container home-stats text-center">
        	<h1>Dashboard</h1>
        	<div class="row">
        		<div class="col-md-3">
        			<div class="stat st-members">
                        <i class="fa fa-users"></i>
        			<div class="info">
                          Total Members
                        <span><a href="members.php"><?php echo countItems('userID','users'); ?></a></span>         
                    </div>
        		</div>
        		</div>
        		<div class="col-md-3">
        			<div class="stat st-pending">
                        <i class="fa fa-user-plus"></i>
                        <div class="info">
                            pending Members
                    <span><a href="members.php?do=Manage&page=Pending"><?php echo checkItem('RegStatus','users',0); ?></a></span>
                        </div>
        		</div>
        		</div>
        		<div class="col-md-3">
        			<div class="stat st-items">
                        <i class="fa fa-tag"></i>
                        <div class="info">
                            Total Items
                    <span><a href="items.php"><?php echo countItems('item_ID','items'); ?></a></span>
                        </div>
        		</div>
        		</div>
        		<div class="col-md-3">
        			<div class="stat st-comments">
                        <i class="fa fa-comments"></i>
                        <div class="info">
                            Total comments
                    <span><a href="comments.php"><?php echo countItems('C_id','comments'); ?></a></span>
                        </div>
        		</div>
        		</div>
        	</div>
        </div>

    <div class="container latest">
    	<div class="row">
    		<div class="col-sm-6">
    			<div class="panel panel-default">
    				<div class="panel-heading">
    					<i class="fa fa-users"></i>latest <?php echo $numuser; ?> regisiter users
                        <span class="toggle-info pull-right"><i class="fa fa-plus fa-lg"></i></span>
    				</div>
    				<div class="panel-body">
                        <ul class="list-unstyled latest-users">
    					<?php 
                        if(! empty($latestuser)) {
                        foreach ($latestuser as $user) {
                            echo '<li>';
                            echo $user['Username'];
                            echo '<a href="members.php?do=Edit&userid=' . $user['userID'] . '">';
                            echo '<span class="btn btn-success pull-right">';
                            echo '<i class="fa fa-edit"></i> Edit';
                            if ($user['RegStatus'] == 0)
                             {
                                echo "<a href='members.php?do=Activate&userid=" . $user['userID'] . "' 
                                class='btn btn-info pull-right activate'>
                                <i class='fa fa-check'></i> Activate</a>";
                             }
                            echo '</span>';
                            echo '</a>';
                            echo '</li>';
                        }
                    } else{
                        echo "there is no users to show";
                    }
                        ?>
                        </ul>
    				</div>
    			</div>
    		</div>
    		<div class="col-sm-6">
    			<div class="panel panel-default">
    				<div class="panel-heading">
    					<i class="fa fa-tag"></i>latest <?php echo $numItem; ?> Items
                        <span class="toggle-info pull-right"><i class="fa fa-plus fa-lg"></i></span>
    				</div>
    				<div class="panel-body">
    					<ul class="list-unstyled latest-users">
                        <?php 
                        if(! empty($latestItem)){ 
                        foreach ($latestItem as $item) {
                            echo '<li>';
                            echo $item['Name'];
                            echo '<a href="items.php?do=Edit&itemid=' . $item['item_ID'] . '">';
                            echo '<span class="btn btn-success pull-right">';
                            echo '<i class="fa fa-edit"></i> Edit';
                            if ($item['Approve'] == 0)
                             {
                                echo "<a href='items.php?do=Approve&itemid=" . $item['item_ID'] . "' 
                                class='btn btn-info pull-right activate'>
                                <i class='fa fa-check'></i> Approve</a>";
                             }
                            echo '</span>';
                            echo '</a>';
                            echo '</li>';
                        }
                    }else {
                        echo "there is no items to show";
                    }
                        ?>
                        </ul>
    				</div>
    			</div>
    		</div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-comments-o"></i>latest <?php echo $numcomments; ?> comments
                        <span class="toggle-info pull-right"><i class="fa fa-plus fa-lg"></i></span>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                       <?php 
                                   $stmt = $con->prepare("SELECT
                                                  comments.*,
                                                  users.Username AS member
                                                 FROM
                                                  comments
                                                    INNER JOIN 
                                                    users
                                                    ON
                                                    users.userID = comments.user_id
                                                    ORDER BY C_id DESC
                                                    LIMIT $numcomments");
                                                 // Execute The Statement
                                     $stmt->execute();

                                               // Assign To Variable 

                                            $comments = $stmt->fetchAll();
                                            if(! empty($comments)) {
                                            foreach ($comments as $comment) {
                                            echo "<div class='comment-box'>";
                                            echo "<span class = 'member-n'>" .$comment['member']."</span>";
                                            echo "<p class = 'member-c'>" .$comment['comment']."</p>";
                                            echo "</div>";
                                            }
                                        } else{
                                            echo "there is no comments to show";
                                        }
                       ?>
                        </ul>
                    </div>
                </div>
            </div>
    	</div>

    </div>   


        <?php
        /* end dashboard page */

	     include $tpl .'footer.php';
	     
	} else 
	{
		
		header('location:index.php');
	}
    ob_end_flush();
    ?>