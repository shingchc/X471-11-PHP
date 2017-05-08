<?php
require 'formhelpers.php';
error_reporting(0);
// This is identical to the input_text() function in formhelpers.php but
// prints a password box (in which asterisks obscure what's entered)
// instead of a plain text field
function input_password($field_name, $values) {
    print '<input type="password" name="' . $field_name .'" value="';
    print htmlentities($values[$field_name]) . '">';
}

session_start();

if ($_POST['_submit_check'])
{
    if ($form_errors = validate_form()) {
        show_form($form_errors);
    } else {
        process_form();
    } 
} else {
    show_form();
}

function show_form($errors = '') {
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';

    if ($errors) {
        print '<ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
    } 
    print 'Username: ';
    input_text('username', $_POST);
    print '<br/>';

    print 'Password: ';
    input_password('password', $_POST);
    print '<br/>';

    input_submit('submit','Log In');

    print '<input type="hidden" name="_submit_check" value="1"/>';

    print '<br/>';
    print '<a href="register.php">First Timer? Sign up now!</a>';

    print '</form>';
}

function validate_form() {
    $errors = array();
    
    $users = array();

    $username = trim($_POST['username']); 
    $password = trim($_POST['password']); 

	$handle = fopen("users.txt", "r") or die('Opps!');
	if ($handle) {
		while (($line = fgets($handle)) !== false) {

			$myArray = explode(';', trim($line));
            $users[$myArray[0]] = $myArray[1];
            if (array_key_exists($username, $users))   {
                break;
            }
        }
		fclose($handle);
	} else {
		echo "error reading database!!!";
	} 



    if (isset($_POST['username'])) { 
        if (empty($username)) {
            $errors[] = "Please enter your username";
        }

        if (strlen($username) > 10) {
            $errors[] = "Username cannot exceed 10 characters";
        }

        if(!preg_match("/^[a-zA-Z\d]+$/", $username)) {
            $errors[] = "Username must contain only alphanumericals";
        }
    } 

    if (isset($_POST['password'])) { 
        if (empty($password)) {
            $errors[] = "Please enter your password";
        }

        if (strlen($password) > 10) {
            $errors[] = "Password cannot exceed 10 characters";
        }

        if(!preg_match("/^[a-zA-Z\d]+$/", $password)) {
            $errors[] = "Password must contain only alphanumericals";
        }
    } 

    // Make sure user name is valid
    if (! array_key_exists($username, $users)) {
        $errors[] = 'Please enter a valid username and password.';
    }
                                   
    // See if password is correct
    $saved_password = $users[ $username ];
    if ($saved_password != $password) {
        $errors[] = 'Please enter a valid username and password..';
    }

    if ($errors != '')  {
        $package = $myArray[2];
        
        if ($package == 1)  {
            $_SESSION['package'] = "Standard";
        } else {
            // Premium package is 0 from users.txt
            $_SESSION['package'] = "Premium";            
        }
    }
    return $errors;
}


function process_form() {
    // Add the username to the session
    $_SESSION['username'] = $_POST['username'];

    print "Welcome, $_SESSION[username]<br>";
    print "Package Tier: ";
    if ($_SESSION['package'] == "Premium") {
        print "Premium";
    } else {
        print "Standard";
    }
?>
	<style>
		ul {
			list-style-type: none;
            border-left: 1px solid black;
		}
		li {
			display: inline;
			padding: 18px;
		}
	</style>
	<ul>
    	<li><a href="1.php">Movie</a></li>
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
<?php
}
?>