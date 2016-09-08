<?php
// TODO: add the error handling
// TODO: extract inventoru-specific functionality
// TODO: add fuller comments
// TODO: dependency injection?
class MySQLDatabase {
	private $mysqli;
	private $dbHost;
	private $username;
	private $password;
	private $dbName;
	public function __construct($databaseHost, $databaseUsername, $databasePassword, $databaseName) {
		$this->dbHost = $databaseHost;
		$this->username = $databaseUsername;
		$this->password = $databasePassword;
		$this->dbName = $databaseName;
		
		$this->connect ();
	}
	private function connect() {
		if (empty ( $this->dbHost )) {
			throw new Exception ( 'No host set.' );
		}
		
		$this->mysqli = new mysqli ( $this->dbHost, $this->username, $this->password, $this->dbName );
		
		if ($this->mysqli->connect_error) {
			echo "Connect error:" . $this->_mysqli->connect_errno . ": " . $this->_mysqli->connect_error;
			throw new Exception ( "Connect Error " . $this->_mysqli->connect_errno . ": " . $this->_mysqli->connect_error );
		}
	}
	
	// TODO: Error checking
	function listAllBookings() {
		$stmt = $this->mysqli->prepare ( "SELECT b.reference_number AS 'Reference #', c.name AS 'Customer Name', b.passenger_name AS 'Passenger Name', b.passenger_phone AS 'Passenger Phone', CONCAT(IFNULL(b.unit_number, '-'), '/', b.street_number, ' ', b.street_name, ', ', b.pickup_suburb) AS 'Pickup Address', b.dest_suburb AS 'Destination Suburb', b.pickup_datetime AS 'Pickup Time' FROM cabsCustomer c INNER JOIN cabsBooking b ON c.email_address = b.customer WHERE (b.status = 'UNASSIGNED') AND (b.pickup_datetime <= DATE_ADD(NOW(), INTERVAL 2 HOUR)) AND (b.pickup_datetime >= now())" );
		
		if ($stmt) {
			$stmt->execute ();
			return $this->getResult ( $stmt );
		} else {
			die ( "Couldn't prepare stmt, listallbookings" );
		}
	}
	function getBooking($refNumber) {
		$stmt = $this->mysqli->prepare ( "SELECT reference_number, passenger_name, status, pickup_datetime FROM cabsBooking WHERE reference_number = ?" );
		
		if ($stmt) {
			if ($stmt->bind_param ( 'i', $refNumber )) {
				$stmt->execute ();
				return ($this->getResult ( $stmt ));
			} else {
				die ( "Couldn't bind params, getBooking" );
			}
		} else {
			die ( "Couldn't prepare stmt, getBooking" );
		}
	}
	function assignBooking($refNumber) {
		$stmt = $this->mysqli->prepare ( "UPDATE cabsBooking SET status='ASSIGNED' WHERE reference_number = ?" );
		
		if ($stmt) {
			if ($stmt->bind_param ( 'i', $refNumber )) {
				$stmt->execute ();
			} else {
				die ( "Couldn't bind params, assignBooking" );
			}
		} else {
			die ( "Couldn't prepare stmt, assignBooking" );
		}
	}
	function insertNewBooking($email, $passName, $passPhone, $destSub, $pickupDatetime, $unitNo, $streetNo, $streetName, $pickupSub) {
		// reference number, status & placement time, have defaults set
		$stmt = $this->mysqli->prepare ( "INSERT INTO cabsBooking (customer, passenger_name, passenger_phone, dest_suburb, pickup_datetime, unit_number, street_number, street_name, pickup_suburb) VALUES (?,?,?,?,?,?,?,?,?)" );
		if ($stmt) {
			$insertDatetime = $pickupDatetime->format ( "Y-m-d H-i-s" );
			if ($unitNo == "") {
				$unitNo = NULL;
			}
			if ($stmt->bind_param ( 'sssssssss', $email, $passName, $passPhone, $destSub, $insertDatetime, $unitNo, $streetNo, $streetName, $pickupSub )) {
				$stmt->execute ();
				
				if ($stmt->affected_rows == 1) {
					return $stmt->insert_id;
				} else if ($stmt->affected_rows < 1) {
					die ( "No booking inserted!" );
				} else if ($stmt->affected_rows > 1) {
					die ( "Too many bookings found!" );
				}
			} else {
				die ( "Couldn't bind params, insert booking." );
			}
		} else {
			$this->reportMysqliErrorToWebpage ();
			die ( "Couldn't prepare insert booking" );
		}
	}
	
	// TODO: add error checking
	// TODO: move specific stuff somewhere else?
	public function findCustomer($email) {
		$stmt = $this->mysqli->prepare ( "SELECT email_address, name, password, phone_number FROM cabsCustomer WHERE email_address = ?" );
		if ($stmt) {
			$stmt->bind_param ( "s", $email );
			return $this->getResult ( $stmt );
		} else {
			$this->reportMysqliErrorToWebpage ();
			die ( "Not working!" );
		}
	}
	private function reportMysqliErrorToWebpage() {
		$error = $this->mysqli->errno . " : " . $this->mysqli->error;
		echo "<p>MySQLi error: $error</p>";
	}
	public function insertNewCustomer($email, $name, $pw, $phone) {
		$stmt = $this->mysqli->prepare ( "INSERT INTO cabsCustomer(email_address, name, password, phone_number) VALUES (?, ?, ?, ?)" );
		
		if ($stmt) {
			if ($stmt->bind_param ( "ssss", $email, $name, $pw, $phone )) {
				if ($stmt->execute ()) {
					return true;
				} else {
					echo "<p>Statement didn't execute!</p>";
					$error = $stmt->error;
					echo "<p>Error: $error";
					return false;
				}
			} else {
				echo "<p>Couldn't bind params</p>";
				$this->reportMysqliErrorToWebpage ();
			}
		} else {
			echo "<p>Statement didn't prepare!</p>";
			$this->reportMysqliErrorToWebpage ();
		}
	}
	private function getResult($stmt) {
		require_once ('MySQLResult.php');
		
		$stmt->execute ();
		$result = new MySQLResult ( $stmt );
				
		return $result;
	}
	// Bracket to close class
}