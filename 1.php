<?php 
	require 'auth.php';
	error_reporting(0);

	$handle = fopen("movie.txt", "r") or die('Opps!');
	if ($handle) {
		echo '<table>';
		while (($line = fgets($handle)) !== false) {
			echo '<tr>';
			echo '<td>';
			echo '<img src="2017_Oscars_poster.jpg" alt="icon" style="width:128px;height:128px;"/><br>';
			echo '</td>';
			echo '<td>';
			$myArray = explode(';', $line);
			echo 'Title: ' . $myArray[0] . '<br>';
			echo 'Category: ' . $myArray[1] . '<br>';
			echo 'Casts: ' . $myArray[2] . '<br>';
			echo 'Rental Price: ' . $myArray[3] . '<br>';
			echo '</td>';
			echo '</tr>';
		}
		echo '</table>';
		fclose($handle);
	} else {
		echo "error reading database!!!";
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
    <li>Movies</li>
    <li><a href="2.php">TV</a></li>

<?php
    if ($_SESSION['package'] == "Premium") {
?>
    	<li><a href="3.php">Premium Extra</a></li>
<?php
    }
?>
    <li><a href="logout.php">logout</a></li>
</ul>