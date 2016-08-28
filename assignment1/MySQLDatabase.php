<?php
//TODO: add the error handling
//TODO: extract inventoru-specific functionality
//TODO: add fuller comments
//TODO: dependency injection?
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
		
		$this->connect();
	}
	
	private function connect() {
		if (empty($this->dbHost)) {
			throw new Exception('No host set.');
		}
		
		$this->mysqli = new mysqli($this->dbHost, $this->username, $this->password, $this->dbName);
		
		if ($this->mysqli->connect_error) {
			echo "Connect error:" . $this->_mysqli->connect_errno . ": " . $this->_mysqli->connect_error;
			throw new Exception("Connect Error " . $this->_mysqli->connect_errno . ": " . $this->_mysqli->connect_error);
		}
	}

	//TODO: add error checking
	//TODO: move specific stuff somewhere else?
	public function findCustomer($email) {
		echo "<p>Entered find customer</p>";
		$stmt = $this->mysqli->prepare("SELECT email_address, name, password, phone_number FROM cabsCustomer WHERE email_address = ?");
		if ($stmt) {
			echo "<p>Statement worked!</p>";
			$stmt->bind_param("s", $email);
			return $this->getResult($stmt);			
		} else {
			echo "<p>Statement didn't work!!</p>";
			$this->reportMysqliErrorToWebpage();
		}

	}		
	
	private function reportMysqliErrorToWebpage() {
		$error = $this->mysqli->errno . " : " . $this->mysqli->error;
		echo "<p>MySQLi error: $error</p>";
	}
	
	public function insertNewCustomer($email, $name, $pw, $phone) {
		$stmt = $this->mysqli->prepare("INSERT INTO cabsCustomer(email_address, name, password, phone_number) VALUES (?, ?, ?, ?)");
		
		if ($stmt) {
			if ($stmt->bind_param("ssss", $email, $name, $pw, $phone)){
				if ($stmt->execute()) {
					return true;
				} else {
					echo "<p>Statement didn't execute!</p>";
					$error = $stmt->error;
					echo "<p>Error: $error";
					return false;
				}
			} else {
				echo "<p>Couldn't bind params</p>";
				$this->reportMysqliErrorToWebpage();
			}
		} else {
			echo "<p>Statement didn't prepare!</p>";
			$this->reportMysqliErrorToWebpage();
		}
	}
	
	private function getResult($stmt) {
		require_once('MySQLResult.php');
		
		$stmt->execute();
		$result = new MySQLResult($stmt);	
		
		return $result;
	}
//Bracket to close class
}