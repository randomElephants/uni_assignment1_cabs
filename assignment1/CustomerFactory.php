<?php
require_once("MySQLDatabase.php");
require_once("MySQLResult.php");
require_once("Customer.php");

class CustomerFactory {
	private $db;
	
	public function __construct(MySQLDatabase $db) {
		$this->db = $db;
	}
	
	public function registerNewCustomer($email, $name, $password, $phone) {
		
		if (!($this->doesCustomerExist($email))) {
			$result = $this->db->insertNewCustomer($email, $name, $password, $phone);
			if ($result) {
				return true;
			} else {
				return false;
			}
		} else {
			$_SESSION['error'] = "A customer with that email address is already registered. Try logging in!";
		}
	}
	
	public function getCustomer($email) {
		$customerResult = $this->searchDBForCustomer($email);
		
		if ($customerResult->getRowCount() < 1) {
			$_SESSION['error'] ="(0 Customer) Sorry, something went wrong!";
			return false;
		} else if ($customerResult->getRowCount() > 1) {
			$_SESSION['error'] ="(more than 1 Customer) Sorry, something went wrong!";
			return false;
		} else {
			//make customer object
			$row = $customerResult->getFirstRow();
			$customer = array();
			$customer['email'] = $row['email_address'];
			$customer['name'] = $row['name'];
			$customer['phone'] = $row['phone_number'];
			$customer['pw'] = $row['password'];
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