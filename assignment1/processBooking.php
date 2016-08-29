<?php
require_once 'Validator.php';
require_once 'BookingFactory.php';
require_once 'MySQLDatabase.php';
require_once 'settings.php';
require_once 'Customer.php';

session_start();

if ((isset($_POST['pName'])) && (isset($_POST['pPhone'])) && (isset($_POST['unit'])) && 
		(isset($_POST['streetNo'])) && (isset($_POST['street'])) && (isset($_POST['pickupSuburb'])) &&
		(isset($_POST['destSuburb'])) && (isset($_POST['date'])) && (isset($_POST['time']))
		) {
	$passName = $_POST['pName'];
	$passPhone = $_POST['pPhone'];
	$unit = $_POST['unit'];
	$streetNo = $_POST['streetNo'];
	$street = $_POST['street'];
	$pickupSub = $_POST['pickupSuburb'];
	$destSuburb = $_POST['destSuburb'];
	$pickupDate = $_POST['date'];
	$pickupTime = $_POST['time'];
	
	$customer = $_SESSION['customer'];
	$customerEmailId = $customer->getEmail();
	$customerName = $customer->getName();
	
	$validator = new Validator();
	$db = new MySQLDatabase($databaseHost, $databaseUsername, $databasePassword, $databaseName);
	$factory = new BookingFactory($db);
	
	if ($validator->bookingFormIsValid($passName, $passPhone, $destSuburb, $pickupDate, $pickupTime, $unit, $streetNo, $street, $pickupSub)) {
		$bookingID = $factory->insertNewBooking($customerEmailId, $passName, $passPhone, $destSuburb, $pickupDate, $pickupTime, $unit, $streetNo, $street, $pickupSub);
		$_SESSION['bookingID'] = $bookingID;
		$_SESSION['pickupTime'] = $pickupTime;
		$_SESSION['pickupDate'] = $pickupDate;		
// 		sendConfirmMail($customerEmailID, $customerName, $bookingID, $pickupDate, $pickupTime);
		header("location:confirmation.php");
	} else {
		//redirect back to previous page
		header("location:booking.php");
	}
}

function sendConfirmMail($customerEmailID, $customerName, $bookingID, $pickupDate, $pickupTime) {
	$to = $customerEmailID;
	$subject = "Your booking request with Cabs Online!";
	$message="Dear $customerName,\r\nThanks for booking with Cabs Online!\r\nYour booking reference number is $bookingID.\r\nWe will pick up the passengers in front of your provided address at $pickupTime on $pickupDate";
	$headers="From booking@cabsonline.com.au";
	
	if (!(mail($to, $subject, $message, $headers, "-r 2074575@student.swin.edu.au"))) {
		die("Mail not sent!");
	}
}