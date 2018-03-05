<?php
	session_start();
	$nonavbar = '';
	$pageTitle = 'login';
	if (isset($_SESSION['Username'])) {
	     header('location:dashboard.php'); //redirect to dashboard.php
	}
	include 'init.php';
	
	//include 'includes/languages//english.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$username = $_POST['user'];
		$password = $_POST['pass'];

		//check if the user exist in database
	$stmt = $con->prepare("SELECT
	                       userID,Username,password
	                       FROM users
	                       WHERE Username = ?
	                       AND password = ? 
	                       AND GroupID = 1
	                       LIMIT 1");
	$stmt->execute(array($username,sha1($password)));
	$row = $stmt->fetch();
	$count = $stmt->rowCount();
	
	//if count >0 this is mean database contain the record about this username
	if($count > 0)
	{
		$_SESSION['Username'] = $username; //register session name
		$_SESSION['ID'] = $row['userID'];  // register session ID
		header('location:dashboard.php'); //redirect to dashboard.php
		exit();
	}

		
	}
	
?>


	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
		<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
		<input class="btn btn-primary btn-block" type="submit" value="Login" />
	</form>


<?php include $tpl . 'footer.php'; ?>