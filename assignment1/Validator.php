<?php
class Validator {
	private $validNameMatch = "/^[a-zA-Z '-]{1,255}$/";
	private $validPhoneNumber = "/[0-9 +()]{8,15}/";
	private $validPassword = "/.{8,}/";

public	function isValidEmailFormat($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		else {
			return false;
		}
	}

public function isValidName($name) {
		if (preg_match($this->validNameMatch, $name)) {
			return true;
		} else {
			return false;
		}
	}
	
public function isValidPhone($number) {
	if (preg_match($this->validPhoneNumber, $number)) {
		return true;
	} else {
		return false;
	}
}

//making up a password rule: must be longer than 8 characters
//Placeholder for possibly more complex functions
public function isValidPassword($pw) {
	if (preg_match($this->validPassword, $pw)) {
		return true;
	} else {
		return false;
	}
}

public function isPasswordConfirmMatch($pw, $confirm) {
	if ($pw === $confirm) {
		return true;
	} else {
		return false;
	}
}

}