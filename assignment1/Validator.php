<?php
class Validator {
	private $validNameMatch = "/^[a-zA-Z '-]{1,255}$/";
	private $validPhoneNumber = "/[0-9 +()]{8,15}/";
	private $validPassword = "/.{8,}/";
	
	
	public function __construct() {
		//ntd
	}
	
	public function registrationIsValid() {
		$valid = false;
	
		if ((isset($_POST['email'])) &&
				(isset($_POST['name'])) &&
				(isset($_POST['phone'])) &&
				(isset($_POST['password'])) &&
				(isset($_POST['confirmPassword']))) {
					$email = trim($_POST['email']);
					$name = trim($_POST['name']);
					$phone = trim($_POST['phone']);
					$password = $_POST['password'];
					$confirm = $_POST['confirmPassword'];
	
					if (($this->isValidName($name)) &&
							($this->isValidEmailFormat($email)) &&
							($this->isValidPhone($phone)) &&
							($this->isValidPassword($password)) &&
							($this->doesPasswordMatchConfirm($password, $confirm))) {
								$valid = true;
							}
				}
	
		return $valid;
	}

	private	function isValidEmailFormat($email) {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return true;
			}
			else {
				return false;
			}
		}
	
	private function isValidName($name) {
			if (preg_match($this->validNameMatch, $name)) {
				return true;
			} else {
				return false;
			}
		}
		
	private function isValidPhone($number) {
		if (preg_match($this->validPhoneNumber, $number)) {
			return true;
		} else {
			return false;
		}
	}
	
	//making up a password rule: must be longer than 8 characters
	//Placeholder for possibly more complex functions
	private function isValidPassword($pw) {
		if (preg_match($this->validPassword, $pw)) {
			return true;
		} else {
			return false;
		}
	}
	
	private function doesPasswordMatchConfirm($pw, $confirm) {
		if ($pw === $confirm) {
			return true;
		} else {
			return false;
		}
	}
}