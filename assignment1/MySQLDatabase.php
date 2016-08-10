<?php
class MySQLDatabase {
	private $mysqliDB;
	
	private $dbName;
	private $host;
	private $username;
	private $password;
	
	function __construct($username, $password, $dbName, $host) {
		$this->dbName = $dbName;
		$this->host = $host;
		$this->password = $password;
		$this->username = $username;		
		
		$this->connect();
	}
	
	function connect() {
		if (empty($this->host)) {
			throw new Exception('MySQL host is not set');
		}
		$this->_mysqli = new mysqli($this->host, $this->username, $this->password, $this->db, $this->port);
		if ($this->_mysqli->connect_error) {
			throw new Exception('Connect Error ' . $this->_mysqli->connect_errno . ': ' . $this->_mysqli->connect_error, $this->_mysqli->connect_errno);
		}
		
		function getMysqli() {
			return $this->mysqliDB;
		}
	}
	
	
	
	
}