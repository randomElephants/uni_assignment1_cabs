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
			return $this->db->insertNewBooking($email, $passName, $passPhone, $destSuburb,
					$datetime, $unitNo, $streetNo, $street, $pickupSuburb);
		} catch (Exception $e) {
			//TODO: better error handling???
			die($e);
		}
	}
}