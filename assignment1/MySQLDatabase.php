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
	
	public function __construct($host, $username, $password, $dbName) {
		
		$this->dbHost = $host;
		$this->username = $username;
		$this->password = $password;
		$this->dbName = $dbName;
		
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
	
	public function testQuery($query) {
		$result = $this->mysqli->query($query);
		return $result;
	}
	
	//Will fail if "Inventory" table doesn't exist yet
	public function searchInventoryByMake($make) {
		$stmt = $this->mysqli->prepare("SELECT make, model, price, quantity FROM inventory where make=?");
		$stmt->bind_param("s", $make);
		return $this->getResult($stmt);
	}	
	
	//Will fail if "Inventory" table doesn't exist yet
	public function getAllFromInventory() {
		$stmt = $this->mysqli->prepare("SELECT make, model, price, quantity FROM inventory");
		return $this->getResult($stmt);
	}
	
	public function getMakes() {
		$stmt = $this->mysqli->prepare("SELECT DISTINCT make FROM inventory");
		return $this->getResult($stmt);
	}
	
	public function insertInventoryEntry($make, $model, $price, $quantity) {
		$stmt = $this->mysqli->prepare("INSERT INTO inventory (make, model, price, quantity) VALUES (?, ?, ?, ?)");
 		if ($stmt) {
			$stmt->bind_param("ssdi", $make, $model, $price, $quantity);
			return $stmt->execute();		
 			
 		} else {
 			echo "Could't prepare.";
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