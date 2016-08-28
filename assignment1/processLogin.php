<?php 
require_once 'settings.php';
require_once 'MySQLDatabase.php';

$db = new MySQLDatabase($databaseHost, $databaseUsername, $databasePassword, $databaseName);

if (loginIsValid($db)) {
	header("location:booking.php");
} else {
	header("location:login.php");
}

function loginIsValid() {
	
	if (loginFormIsValid() && userPasswordCorrect($db)) {
		return true;
	}
	else {
		return false;
	}
}

function loginFormIsValid() {
	$valid = false;
	$validator = new Validator();
	
	if (isset($_POST['email']) && isset($_POST['password'])) {
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		if ($validator->isValidEmailFormat($email) && $validator->isValidPassword($pw)) {
			return true;
		}
	}
	
	return $valid;
}