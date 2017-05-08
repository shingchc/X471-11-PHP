<?php
error_reporting(0);
	session_start();

	if (!isset($_SESSION['username']))
	{
		header("Location: http://" . $_SERVER['HTTP_HOST'] 
		. dirname($_SERVER['PHP_SELF']) 
		. "/login.php");
	} else
	{
		print "Current User: " . $_SESSION['username'] . "<br />";
		print "Package Tier: ";
		if ($_SESSION['package'] == "Premium") {
			print "Premium";
		} else {
			print "Standard";
		}
	}
?>