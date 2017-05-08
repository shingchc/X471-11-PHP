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
    print 'Enter an Username: ';
    input_text('username', $_POST);
    print '<br/>';

    print 'Enter a new Password: ';
    input_password('password', $_POST);
    print '<br/>';

    print 'Select a Package: ';
    $package = array("Premium Extra - Find newest Movies and TV Shows available in our catalog!","Standard - Find all popular Movies in TV Shows!");
    input_select('package',$_POST,$package,false);
    print '<br/>';

    input_submit('submit','Press here to sign up!');

    print '<input type="hidden" name="_submit_check" value="1"/>';
    print '</form>';
}

function validate_form() {
    $errors = array();
        
    $username = trim($_POST['username']); 
    $password = trim($_POST['password']); 

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

    if ($errors != '')   {
        $myfile = fopen("users.txt", "a") or die("Unable to open file!");
        $txt = $username . ";" . $password . ";" . $_POST['package'];
        fwrite($myfile, "\n". $txt);
        fclose($myfile);
    }

    return $errors;
}


function process_form() {

    echo ('You have signed up.<br />');
	echo ('<br /><a href="login.php">Log in again to start</a>');

}

?>