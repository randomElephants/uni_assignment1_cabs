<?php
class Controller {
	private $db;
	private $validator;
	private $customerFactory;
	private $bookingFactory;
	
	public function __construct(MySQLDatabase $db, $validator) {
		$this->db = $db;
		$this->validator = $validator;
		$this->customerFactory = new CustomerFactory($db);
		$this->bookingFactory = new BookingFactory($db);
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
					break;
				default:
					break;
			}
		}
		
		if (isset($_POST['email'])) {
			$email = $_POST['email'];
		}
		
		require "template.php";
	}
	
	public function registerPage() {
		$content = "register.php";
		$heading = "Register at CabsOnline";
		$pageTitle = "Register at CabsOnline";
		
		if ((isset($_POST['name'])) && (isset($_POST['email'])) && (isset($_POST['phone']))){
			$custName = $_POST['name'];
			$custEmail = $_POST['email'];
			$custPhone = $_POST['phone'];
		}

		if(isset($_SERVER['QUERY_STRING'])) {
			$query = $_SERVER['QUERY_STRING'];
				
			switch ($query) {
				case "process":
					$this->processRegistration();
					break;
				default:
					break;
			}
		}
		
		require "template.php";
	}
	
	public function bookingPage() {
		
		if (!isset($_SESSION['customer'])) {
			header('location:login');
		}
		
		$content = "booking.php";
		$heading = "Booking a cab";
		$pageTitle = "Book with CabsOnline";
		
		if(isset($_SERVER['QUERY_STRING'])) {
			$query = $_SERVER['QUERY_STRING'];
		
			switch ($query) {
				case "process":
					if ((isset($_POST['pName'])) && (isset($_POST['pPhone'])) && (isset($_POST['unit'])) &&
							(isset($_POST['streetNo'])) && (isset($_POST['street'])) && (isset($_POST['pickupSuburb'])) &&
							(isset($_POST['destSuburb'])) && (isset($_POST['date'])) && (isset($_POST['time']))
							) {
								$passName = $_POST['pName'];
								$passPhone = $_POST['pPhone'];
								$unit = $_POST['unit'];
								$streetNo = $_POST['streetNo'];
								$street = $_POST['street'];
								$pickupSub = $_POST['pickupSuburb'];
								$destSuburb = $_POST['destSuburb'];
								$pickupDate = $_POST['date'];
								$pickupTime = $_POST['time'];
					
								$customer = $_SESSION['customer'];
								$customerEmailId = $customer['email'];
								$customerName = $customer['name'];
								
								$this->processBooking($passName, $passPhone, $unit, $streetNo, $street, $pickupSub, $pickupDate, $pickupTime, $destSuburb, $customerEmailId, $customerName);
					}
					break;
				default:
					break;
			}
		}
		
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
	
	public function logout() {
		session_destroy();
		header('location:login');
	}
	
	//TODO: break down the validation errors more
	private function processRegistration() {
		if ((isset($_POST['email'])) &&
				(isset($_POST['name'])) &&
				(isset($_POST['phone'])) &&
				(isset($_POST['password'])) &&
				(isset($_POST['confirmPassword']))) {
			$email = trim($_POST['email']);
			$name = trim($_POST['name']);
			$phone = trim($_POST['phone']);
			$password = trim($_POST['password']);
			$confirm = trim($_POST['confirmPassword']);
		
			if ($this->validator->registrationFormIsValid($email, $name, $phone, $password, $confirm)) {
				if ($this->validator->isPasswordConfirmMatch($password, $confirm)) {
					if ($this->customerFactory->registerNewCustomer($email, $name, $password, $phone)) {
						//Registration successful!
						$customer = $this->customerFactory->getCustomer($email);
						if ($customer) {
							$_SESSION['customer'] = $customer;
							header('location:booking');
						} else{
							$_SESSION['error'] = "Sorry, something went wrong! But you are registered, try logging in!";
							header('location:login');
						}
					} else {
						//If registration not successful here, error messages already set
					}
				} else {
					$_SESSION['error'] = "The two passwords you entered did not match";
				}
			} else {
				$_SESSION['error'] = "Please make sure you have filled out all the form fields form correctly";
			}
		}
	}
	
	private function processBooking($passName, $passPhone, $unit, $streetNo, $street, $pickupSub, $pickupDate, $pickupTime, $destSuburb, $customerEmailId, $customerName) {						
			if ($this->validator->bookingFormIsValid($passName, $passPhone, $destSuburb, $pickupDate, $pickupTime, $unit, $streetNo, $street, $pickupSub)) {
				
				if ($this->validator->isTimeInFuture($pickupDate, $pickupTime)) {
					$bookingID = $this->bookingFactory->insertNewBooking($customerEmailId, $passName, $passPhone, $destSuburb, $pickupDate, $pickupTime, $unit, $streetNo, $street, $pickupSub);
					if ($bookingID !== false) {
						$_SESSION['bookingID'] = $bookingID;
						$_SESSION['pickupTime'] = $pickupTime;
						$_SESSION['pickupDate'] = $pickupDate;
						$this->bookingFactory->sendConfirmMail($customerEmailId, $customerName, $bookingID, $pickupDate, $pickupTime);
						header("location:confirmation");
					} else {
						$_SESSION['error'] = "(Booking didn't work) Sorry! Something went wrong";
					}
				} else {
					$_SESSION['error'] = "The pick up time must be at least 1 hour away";
				}
			} else {
				//Message displayed already
			}
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
						$customer = $this->customerFactory->getCustomer($email);
						if ($customer) {
							$_SESSION['customer'] = $customer;
							header("location:booking");
						} else {
							$_SESSION['error'] = "Sorry, something went wrong. Please try again!";
						}
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

