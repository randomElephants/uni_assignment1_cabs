<?php
require_once 'MySQLDatabase.php';
require_once 'MySQLResult.php';

class BookingFactory {
	private $db;
	
	public function __construct(MySQLDatabase $db) {
		$this->db = $db;
	}
	
	public function insertNewBooking($email, $passName, $passPhone, $destSuburb, $pickupDate, $pickupTime, 
									$unitNo, $streetNo, $street, $pickupSuburb) {
		try {
			date_default_timezone_set("Australia/Melbourne");
			$datetime = new DateTime($pickupDate . " " . $pickupTime);
			$bookingID = $this->db->insertNewBooking($email, $passName, $passPhone, $destSuburb,
					$datetime, $unitNo, $streetNo, $street, $pickupSuburb);
			return $bookingID;
							
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function sendConfirmMail($customerEmailID, $customerName, $bookingID, $pickupDate, $pickupTime) {
		$to = $customerEmailID;
		$subject = "Your booking request with Cabs Online!";
		$message="Dear $customerName,\r\nThanks for booking with Cabs Online!\r\nYour booking reference number is $bookingID.\r\nWe will pick up the passengers in front of your provided address at $pickupTime on $pickupDate";
		$headers="From booking@cabsonline.com.au";
		
		if (!(mail($to, $subject, $message, $headers, "-r 2074575@student.swin.edu.au"))) {
			//In a real application, would log this / email devs
		}
	}
}