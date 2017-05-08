<?php
	
	require 'auth.php';
	session_destroy();
	echo ('You have logged out.<br />');
	echo ('<br /><a href="login.php">Log back in</a>');

?>