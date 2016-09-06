<?php
session_start();

require_once("Validator.php");
require_once 'CustomerFactory.php';
require_once 'Customer.php';
require_once 'MySQLDatabase.php';
require_once 'settings.php';

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
		
		
	$validator = new Validator();

	if ($validator->registrationFormIsValid($email, $name, $phone, $password, $confirm)) {
		$db = new MySQLDatabase($databaseHost, $databaseUsername, $databasePassword, $databaseName);
		$factory = new CustomerFactory($db);
		$customer = $factory->registerNewCustomer($email, $password, $name, $phone);
		if (!$customer) {
			die ("<p>customer is null!<p>");
		}
		$_SESSION['customer'] = $customer;
		unset($_SESSION['error']);
		header("location:booking");
	} else {
		//redirect back to previous page
		$_SESSION['error'] = "Your registration form is invalid!";
		header("location:register");
	}
} else {
	//Here by accident, back to registration form!
	header("location:register");
}
	
