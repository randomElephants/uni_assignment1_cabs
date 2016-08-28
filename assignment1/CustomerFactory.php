<?php
require_once("MySQLDatabase.php");
require_once("MySQLResult.php");
require_once("Customer.php");

class CustomerFactory {
	private $db;
	
	public function __construct(MySQLDatabase $db) {
		$this->db = $db;
	}
	
	//TODO: this function is in progress
	public function registerNewCustomer($email, $password, $name, $phone) {
		
		if (!($this->doesCustomerExist($email))) {
			$result = $this->db->insertNewCustomer($email, $name, $password, $phone);
			if ($result) {
				$customer = $this->getCustomer($email);
				if ($customer) {
					return $customer;
				} else {
					die("<p>Error in reg cust: customer null when getting!</p>");
				}
			}
		} else {
			die ("<p>Error: Trying to create a customer that already exists!</p>");
			return false;
		}
	}
	
	public function getCustomer($email) {
		$customerResult = $this->searchDBForCustomer($email);
		
		if ($customerResult->getRowCount() < 1) {
			die("<p>Error: Customer not found</p>");
			return false;
		} else if ($customerResult->getRowCount() > 1) {
			die("<p>Error: More than 1 customer found!<p>");
			return false;
		} else {
			//make customer object
			$row = $customerResult->getFirstRow();
			$email = $row['email_address'];
			$name = $row['name'];
			$phone = $row['phone_number'];
			$pw = $row['password'];
			$customer = new Customer($email, $pw, $phone, $name);
			return $customer;
		}
	}
	
	private function doesCustomerExist($email) {
		$result = $this->searchDBForCustomer($email);
		if ($result->getRowCount() !== 0) {
			return true;
		} else {
			return false;
		}
	}
	
	private function searchDBForCustomer($email) {
		$result = $this->db->findCustomer($email);
		return $result;
	}
}