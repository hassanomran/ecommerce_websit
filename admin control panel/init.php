<?php

	include 'connect.php';

	// Routes

	$tpl 	= 'includes/templates/'; // Template Directory
	$lang 	= 'includes/languages/'; // Language Directory
	$func	= 'includes/functions/'; // Functions Directory
	$css 	= 'layout/css/'; // Css Directory
	$js 	= 'layout/js/'; // Js Directory

	// Include The Important Files

	// Include The Important Files
    include $func . 'functions.php';
   	include $lang . 'english.php';
	include $lang . 'arabic.php';
	include $tpl . 'header.php';

	//include the file except the file that have variable nonavbar
	if(!isset($nonavbar)){include $tpl . 'navbar.php';}

	// Include Navbar On All Pages Expect The One With $noNavbar Vairable

		

	