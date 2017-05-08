<?php
	require 'auth.php';
	require 'formhelpers.php';
	error_reporting(0);

	session_start();

	if ($_POST['_search'])
	{
		$criteria = trim($_POST['_search']);
	} 

	show_form();
	show_result($criteria);
	
	function show_form($errors = '') {
		print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';

		if ($errors) {
			print '<ul><li>';
			print implode('</li><li>',$errors);
			print '</li></ul>';
		} 
		
		print '<br>Search: ';
		input_search('_search', $_POST, "Search Title or Cast..");
		print '<br/>';

		print '</form>';
	}

	function show_result($criteria = '') {
		$handle = fopen("extra.txt", "r") or die('Opps!');
		if ($handle) {
			echo "Search result(s) for " . trim($criteria) . '...<br/>';
			echo '<table>';
			while (($line = fgets($handle)) !== false) {
				$myArray = explode(';', $line);
				if ($criteria == '' || stripos($myArray[0],$criteria) !== false
					|| stripos($myArray[2],$criteria) !== false)	{
					echo '<tr>';
					echo '<td>';
					echo '<img src="2017_Oscars_poster.jpg" alt="icon" style="width:128px;height:128px;"/><br>';
					echo '</td>';
					echo '<td>';
					echo 'Title: ' . $myArray[0] . '<br>';
					echo 'Category: ' . $myArray[1] . '<br>';
					echo 'Casts: ' . $myArray[2] . '<br>';
					echo 'Rental Price: ' . $myArray[3] . '<br>';
					echo '</td>';
					echo '</tr>';
				}
			}
			echo '</table>';
			fclose($handle);
		} else {
			echo "error reading database!!!";
		} 
	}
?>

<style>
	ul {
		list-style-type: none;
	}
	li {
		display: inline;
		padding: 18px;
	}
</style>

<ul>
    <li><a href="1.php">Movies</a></li>
    <li><a href="2.php">TV</a></li>
    <li>Premium Extra</li>
    <li><a href="logout.php">logout</a></li>
</ul>