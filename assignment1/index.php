<?php
require_once 'MySQLDatabase.php';
require_once 'MySQLResult.php';
require_once 'settings.php';
require_once 'CustomerFactory.php';
require_once 'Customer.php';
require_once 'BookingFactory.php';
require_once 'Validator.php';
require_once 'controller.php';
require_once 'settings.php';

session_start();

$db = new MySQLDatabase($databaseHost, $databaseUsername, $databasePassword, $databaseName);
$validator = new Validator();
$controller = new Controller($db, $validator);

if (isset($_SERVER['PATH_INFO'])) {
	$pageRequested = $_SERVER['PATH_INFO'];
		
	switch ($pageRequested){
		case "/login":
			$controller->loginPage();
			break;
		case "/register":
			$controller->registerPage();
			break;
		case "/admin":
			$controller->adminPage();
			break;
		case "/confirmation":
			$controller->confirmationPage();
			break;
		case "/booking":
			$controller->bookingPage();
			break;
		case "/process":
			if (isset($_SERVER['QUERY_STRING'])) {
				$query = $_SERVER['QUERY_STRING'];
				
				switch ($query) {
					case "login":
						require 'processLogin.php';
						break;
					case "register":
						require "processRegister.php";
						break;
					case "booking":
						require 'processBooking.php';
						break;
				}
			}
			break;
		default:
			header('HTTP/1.1 404 Not Found');
    		$heading = "Page not found";
			$content = null;
			$pageTitle = "Page not found - CabsOnline";
			require "template.php";
	}
} else {
	//Default to showing the login page
	header("location:index.php/login");
}


