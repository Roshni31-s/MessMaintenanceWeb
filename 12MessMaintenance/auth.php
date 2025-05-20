<?php
	session_start();
	if(!isset($_SESSION['username'])){
	    header("Location:login.php");
        exit(); // Always add exit() after header redirects
	}
?>