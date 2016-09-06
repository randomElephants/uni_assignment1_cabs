<?php
require_once 'MySQLDatabase.php';
require_once 'MySQLResult.php';
require_once 'settings.php';
require_once 'CustomerFactory.php';
require_once 'Customer.php';
require_once 'BookingFactory.php';
require_once 'Validator.php';

session_start();

if (isset($_SERVER['PATH_INFO'])) {
	$pageRequested = $_SERVER['PATH_INFO'];
		
	switch ($pageRequested){
		case "/login":
			$content = "login.php";
			$heading = "Login to CabsOnline";
			$pageTitle = "Login to CabsOnline";
			break;
		case "/register":
			$content = "register.php";
			$heading = "Register at CabsOnline";
			$pageTitle = "Register at CabsOnline";
			break;
		case "/admin":
			$content = "admin.php";
			$heading = "Cabs Online - Admin";
			$pageTitle = "Admin page - CabsOnline";
			break;
		case "/confirm":
			$content = "confirmation.php";
			$heading = "Booking Confirmed";
			$pageTitle = "Booking confirmed - CabsOnline";
			break;
		case "/booking":
			$content = "booking.php";
			$heading = "Booking a cab";
			$pageTitle = "Book with CabsOnline";
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
	}
	//Actual display here
	require "template.php";	
} else {
	//Default to showing the login page
	header("location:index.php/login");
}

