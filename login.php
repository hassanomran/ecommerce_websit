<?php 
    ob_start();
    session_start();
	$pageTitle = 'login';
	
	if (isset($_SESSION['user'])) {
	     header('location: index.php'); //redirect to index.php
	}
	include 'init.php';
	
	//include 'includes/languages//english.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$users = $_POST['username'];
		$pass  = $_POST['password'];


		


		//check if the user exist in database
	$stmt = $con->prepare("SELECT
	                       	userID,Username,password
	                       FROM users
	                       WHERE Username   = ?
	                       AND   password   = ?  ");

	$stmt->execute(array($users,sha1($pass)));
    $get = $stmt->fetch();
	$count = $stmt->rowCount();
	
	//if count >0 this is mean database contain the record about this username
	if($count > 0)
	{
		$_SESSION['user'] = $users; //register session name
		$_SESSION['uid'] = $get['userID'];
		header('location: index.php'); //redirect to index.php
		exit();
	}
      else 
      {
      	$formErrors = array();

			$username 	= $_POST['username'];
			$password 	= $_POST['password'];
			$password2 	= $_POST['confirmedpassword'];
			$email 		= $_POST['email'];

			if (isset($username)) {

				$filterdUser = filter_var($username, FILTER_SANITIZE_STRING);

				if (strlen($filterdUser) < 4) {

					$formErrors[] = 'Username Must Be Larger Than 4 Characters';

				}

			}

			if (isset($password) && isset($password2)) {

				if (empty($password)) {

					$formErrors[] = 'Sorry Password Cant Be Empty';

				}

				if (sha1($password) !== sha1($password2)) {

					$formErrors[] = 'Sorry Password Is Not Match';

				}

			}

			if (isset($email)) {

				$filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

				if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {

					$formErrors[] = 'This Email Is Not Valid';

				}

			}

			// Check If There's No Error Proceed The User Add

			if (empty($formErrors)) {

				// Check If User Exist in Database

				$check = checkItem("Username", "users", $username);

				if ($check == 1) {

					$formErrors[] = 'Sorry This User Is Exists';

				} else {

					// Insert Userinfo In Database

					$stmt = $con->prepare("INSERT INTO 
											users(Username, password, Email, RegStatus, Date)
										VALUES(:zuser, :zpass, :zmail, 0, now())");
					$stmt->execute(array(

						'zuser' => $username,
						'zpass' => sha1($password),
						'zmail' => $email

					));

					// Echo Success Message

					$succesMsg = 'Congrats You Are Now Registerd User';

				}
				

			}

      }
		
	}


 ?>


	<h1 class="text-center">
	<span class="selected" data-class="login"> login</span>|<span class="signup">sign up</span>
</h1>


<!-- start login-->
<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-heading">
				<h2 class="text-center">Login</h2>
			</div>
			<hr />
			<div class="modal-body">
				<form role="form"  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">
							<span class="glyphicon glyphicon-user"></span>
							</span>
							<input type="text" class="form-control" name="username" placeholder="User Name"  autocomplete="off" required="required" />
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">
							<span class="glyphicon glyphicon-lock"></span>
							</span>
							<input type="password" class="form-control" name="password" placeholder="Password" autocomplete="new-password"  required="required" />
                            
						</div>

					</div>

					<div class="form-group text-center">
						<input type="submit" name="login" class="btn btn-success btn-lg" value="Login">
						<a href="#" class="btn btn-link">forget Password</a>
					</div>

				</form>
			</div>
		</div>
	</div>
	<!-- end login-->

<!-- start sign up-->

<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-heading">
				<h2 class="text-center">sign up</h2>
			</div>
			<hr />
			<div class="modal-body">
				<form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" role="form">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">
							<span class="glyphicon glyphicon-user"></span>
							</span>
							<input type="text"
							pattern=".{4,}"
			              	title="Username Must Be Between 4 Chars"
							class="form-control" name="username" placeholder="User Name"  autocomplete="off"
							  />
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">
							<span class="glyphicon glyphicon-lock"></span>
							</span>
							<input type="password" 
							minlength="4" 
							class="form-control" 
							name="password" 
							placeholder="type strong password" 
							autocomplete="new-password"  
							 />
                            
						</div>

					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">
							<span class="glyphicon glyphicon-lock"></span>
							</span>
							<input type="password"
							minlength="4" 
							class="form-control" 
							name="confirmedpassword" 
							placeholder="confirm password" 
							autocomplete="new-password" 
							  />
                             
						</div>

					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">
							<span class="glyphicon glyphicon-envelope"></span>
							</span>
							<input type="email" class="form-control" name="email" placeholder="type a valid email"  />

						</div>

					</div>

					<div class="form-group text-center">
						<input type="submit" name="signup" class="btn btn-success btn-lg" value="signup">
					</div>

				</form>
				<div class="the-errors text-center">
		<?php 

			if (!empty($formErrors)) {

				foreach ($formErrors as $error) {

					echo '<div class="msg error">' . $error . '</div>';

				}

			}

			if (isset($succesMsg)) {

				echo '<div class="msg success">' . $succesMsg . '</div>';

			}

		?>
	</div>
			</div>
		</div>
	</div>
	<!-- end sign up-->



<?php include $tpl.'footer.php';
ob_end_flush();

 ?>