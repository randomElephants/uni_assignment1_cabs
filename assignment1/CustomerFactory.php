<?php
require_once("MySQLDatabase.php");
require_once("MySQLResult.php");
require_once("Customer.php");

class CustomerFactory {
	private $db;
	
	public function __construct(MySQLDatabase $db) {
		$this->db = $db;
	}
	
	public function registerNewCustomer() {
		return new Customer("TestEmailtest.com", "TestPW", "TestName", "000000000");
	}
	
	public function getCustomer() {
		return new Customer("TestEmailtest.com", "TestPW", "TestName", "000000000");
	}
}