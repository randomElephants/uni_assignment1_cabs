<?php
class Validator {
	private $validNameMatch = "/^[a-zA-Z '-]{1,255}$/";
	private $validPhoneNumber = "/[0-9 +()]{8,15}/";
	private $validPassword = "/.{8,}/";
	private $validAlpha = "/^[a-zA-Z ]{1,100}$/";
	private $validNumber = "/^[0-9]*$/";

public function loginFormIsValid($email, $pw) {
		$valid = false;
			
		if ($this->isValidEmailFormat($email) && $this->isValidPassword($pw)) {
			$valid = true;
		}
		return $valid;
	}
	
public function registrationFormIsValid($email, $name, $phone, $password, $confirm) {
	$valid = false;

	if (($this->isValidName($name)) &&
			($this->isValidEmailFormat($email)) &&
			($this->isValidPhone($phone)) &&
			($this->isValidPassword($password)) &&
			($this->isValidPassword($confirm))) {
				$valid = true;
			}

			return $valid;
}

//TODO: how should address be formatted?
public function bookingFormIsValid($passName, $passPhone, $destSub, $pickupDate, $pickupTime, 
								$unitNo, $streetNo, $streetName, $pickupSub) {
	
	$valid = false;
	
	$valid = $this->isValidName($passName);
	if (!$valid) {
		die ("Name not valid");
	}
	
	$valid = $this->isValidPhone($passPhone);
	if (!$valid) {
		die ("Phone not valid");
	}
	
// 	$valid = ($this->isValidName($passName) && $this->isValidPhone($passPhone) && 
// 				$this->isValidAlpha($destSub) && $this->isValidAlpha($pickupSub) &&
// 				$this->isValidPickupDatetime($pickupDate, $pickupSub) && 
// 				($this->isValidNumber($unitNo) || ($unitNo === NULL) || ($unitNo === "")) &&
// 				$this->isValidNumber($streetNo) && $this->isValidAlpha($streetName));
	
	//TODO: check this, make work!
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
	
private	function isValidAlpha($word) {
	if (preg_match($this->validAlpha, $word)) {
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

public function isPasswordConfirmMatch($pw, $confirm) {
	if ($pw === $confirm) {
		return true;
	} else {
		return false;
	}
}

//TODO: handling different date formats?
private function isValidPickupDatetime($pickupDate, $pickupTime) {
		date_default_timezone_set("Australia/Melbourne");
		try {
			$date = new DateTime($pickupDate . " " . $pickupTime);
			return $true;		
		} catch (Exception $e) {
			return false;
		}
	} 
	
public function isValidNumber($num) {
	if (preg_match($this->validNumber, $num)) {
		return true;
	} else {
		return false;
	}	
}
}

