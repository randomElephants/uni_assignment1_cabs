<?php 
require_once 'settings.php';
require_once 'MySQLDatabase.php';
require_once 'MySQLResult.php';
require_once 'Validator.php';
require_once 'CustomerFactory.php';
require_once 'Customer.php';

session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	$db = new MySQLDatabase($databaseHost, $databaseUsername, $databasePassword, $databaseName);
	$validator = new Validator();
	
	//TODO: password checking logic!!?
	if (($validator->loginFormIsValid($email, $password)) && (isEnteredCorrectPassword($email, $password, $db))) {
		header("location:booking.php");
	} else {
		header("location:login.php");
	}	

} else {
	//Here by accident: go back to login!
	header("location:login.php");
}

//TODO: gracefully handle non-existent customer on login\
//TODO: session stuff shouldn't be here :(
function isEnteredCorrectPassword($email, $password, $db) {
	$customerResult = $db->findCustomer($email);
	if ($customerResult->getRowCount() < 1) {
		die ("Couldn't find customer when checking password.");
	} else if ($customerResult->getRowCount() > 1) {
		die("More than one customer when checking password");
	} else {
		$customer = $customerResult->getFirstRow();
		$correctPassword=$customer['password'];
		if ($correctPassword === $password) {
			$factory = new CustomerFactory($db);
			$customerObject = $factory->getCustomer($email);
			$_SESSION['customer'] = $customerObject;
			return true;
		} else {
			die("Wrong password entered!");
			return false;
		}
	}
}