<?php
session_start();
require_once("Validator.php");
require_once("CustomerFactory.php");
require_once("MySQLDatabase.php");
require_once("settings.php");

$validator = new Validator();
$db = new MySQLDatabase($host, $username, $password, $database);
$factory = new CustomerFactory($db);

if ($validator->registrationIsValid()) {
	$_SESSION['customer'] = $factory->getCustomer();
	header("location:booking.php");
} else {
	//redirect back to previous page
	header("location:register.php");
}

