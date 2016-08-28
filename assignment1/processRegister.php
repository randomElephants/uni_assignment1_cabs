<?php
session_start();
require_once("Validator.php");
<<<<<<< HEAD
require_once 'CustomerFactory.php';
require_once 'Customer.php';
require_once 'MySQLDatabase.php';
require_once 'settings.php';
=======
require_once("CustomerFactory.php");
require_once("MySQLDatabase.php");
require_once("settings.php");
>>>>>>> branch 'master' of https://github.com/randomElephants/uni_assignment1_cabs

<<<<<<< HEAD
if ((isset($_POST['email'])) &&
		(isset($_POST['name'])) &&
		(isset($_POST['phone'])) &&
		(isset($_POST['password'])) &&
		(isset($_POST['confirmPassword']))) {
			$email = trim($_POST['email']);
			$name = trim($_POST['name']);
			$phone = trim($_POST['phone']);
			$password = $_POST['password'];
			$confirm = $_POST['confirmPassword'];
		}

if (registrationIsValid($email, $name, $phone, $password, $confirm)) {
	$db = new MySQLDatabase($databaseHost, $databaseUsername, $databasePassword, $databaseName);
	$factory = new CustomerFactory($db);
	$customer = $factory->registerNewCustomer($email, $password, $name, $phone);
	if (!$customer) {
		die ("<p>customer is null!<p>");
	}
	$_SESSION['customer'] = $customer;
=======
$validator = new Validator();
$db = new MySQLDatabase($host, $username, $password, $database);
$factory = new CustomerFactory($db);

if ($validator->registrationIsValid()) {
	$_SESSION['customer'] = $factory->getCustomer();
>>>>>>> branch 'master' of https://github.com/randomElephants/uni_assignment1_cabs
	header("location:booking.php");
} else {
	//redirect back to previous page
	header("location:register.php");
}

<<<<<<< HEAD
function registrationIsValid($email, $name, $phone, $password, $confirm) {
	$validator = new Validator();
	$valid = false;
		
		if (($validator->isValidName($name)) && 
				($validator->isValidEmailFormat($email)) && 
				($validator->isValidPhone($phone)) &&
				($validator->isValidPassword($password)) &&
				($validator->isPasswordConfirmMatch($password, $confirm))) {
			$valid = true;
		}		
	
	return $valid;
}
=======
>>>>>>> branch 'master' of https://github.com/randomElephants/uni_assignment1_cabs
