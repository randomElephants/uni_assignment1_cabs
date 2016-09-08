<?php
class Controller {
	private $db;
	private $validator;
	
	public function __construct(MySQLDatabase $db, $validator) {
		$this->db = $db;
		$this->validator = $validator;
	}
	
	public function loginPage() {
		$content = "login.php";
		$heading = "Login to CabsOnline";
		$pageTitle = "Login to CabsOnline";
		
		if(isset($_SERVER['QUERY_STRING'])) {
			$query = $_SERVER['QUERY_STRING'];
			
			switch ($query) {
				case "process":
					$this->processLogin();
				default:
					break;
			}
		}
		
		require "template.php";
	}
	
	public function registerPage() {
		$content = "register.php";
		$heading = "Register at CabsOnline";
		$pageTitle = "Register at CabsOnline";
		require "template.php";
	}
	
	public function bookingPage() {
		$content = "booking.php";
		$heading = "Booking a cab";
		$pageTitle = "Book with CabsOnline";
		require "template.php";
	}
	
	public function confirmationPage() {
		$content = "confirmation.php";
		$heading = "Booking Confirmed";
		$pageTitle = "Booking confirmed - CabsOnline";
		require "template.php";
	}
	
	public function adminPage() {
		$content = "admin.php";
		$heading = "Cabs Online - Admin";
		$pageTitle = "Admin page - CabsOnline";
		
		if(isset($_SERVER['QUERY_STRING'])) {
			$query = $_SERVER['QUERY_STRING'];
			
			switch ($query) {
				case "list-all":
					$result = $this->db->listAllBookings();
					break;
				case "update":
					if (isset($_POST['refNumber'])) {
						$refNumber = $_POST['refNumber'];
						$updateResult = $this->adminUpdateBooking($refNumber);
					}
					$result = $this->db->listAllBookings();
					break;
				default:
					break;
			}
		}
		
		require 'template.php';
	}
	
	private function adminUpdateBooking($refNumber){	
		if ($this->validator->isValidNumber($refNumber)) {
		
			$toUpdate = $this->db->getBooking($refNumber);
			
			if ($toUpdate->getRowCount() === 1) {
				$this->db->assignBooking($refNumber);
				return $this->db->getBooking($refNumber);
			} else if ($toUpdate->getRowCount() === 0){
				$_SESSION['error'] = "No booking with that reference number was found";
			} else {
				$_SESSION['error'] = "Sorry, something went wrong!";
			}
		} else {
			$_SESSION['error'] = "Please enter a valid number to try and update";
		}
	}
	
	private function processLogin() {
		if (isset($_POST['email']) && isset($_POST['password'])) {
			$email = $_POST['email'];
			$password = $_POST['password'];
						
			if ($this->validator->loginFormIsValid($email, $password)) {
				
				$customerResult = $this->db->findCustomer($email);
				
				if ($customerResult->getRowCount() == 1) {
					$customer = $customerResult->getFirstRow();
					$correctPassword=$customer['password'];
					if ($correctPassword === $password) {
						header("location:booking");		
					} else {
						$_SESSION['error'] = "(Wrong password) You have entered the wrong email or password. Please check your typing.";
					}
				} else {
					$_SESSION['error'] = "(Customer not found) You have entered the wrong email or password. Please check your typing.";
				}
			} else {
				$_SESSION['error'] = "Please check you have filled out the form correctly.";
			}
		}
	}
}

