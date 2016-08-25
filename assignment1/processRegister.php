<?php
require_once("Validator.php");

if (registrationIsValid()) {
	//header("location:booking.php");
	echo "Valid!";
} else {
	echo "Invalid!";
	//redirect back to previous page
	//header("location:register.php");
}

function registrationIsValid() {
	$validator = new Validator();
	$valid = false;
	
	if ((isset($_POST['email'])) && 
			(isset($_POST['name'])) && 
			(isset($_POST['phone']) &&
			(isset($_POST['password'])))) {
		$email = trim($_POST['email']);
		$name = trim($_POST['name']);
		$phone = trim($_POST['phone']);
		$password = $_POST['password'];
		
		if (($validator->isValidName($name)) && 
				($validator->isValidEmailFormat($email)) && 
				($validator->isValidPhone($phone)) &&
				($validator->isValidPassword($password))) {
			$valid = true;
		}		
	}
	
	return $valid;
}