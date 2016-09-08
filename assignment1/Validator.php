<?php
class Validator {
	private $validNameMatch = "/^[a-zA-Z '-]{1,255}$/";
	private $validPhoneNumber = "/[0-9 +()]{8,15}/";
	private $validPassword = "/.{8,}/";
	private $validAlpha = "/^[a-zA-Z ]{1,100}$/";
	private $validNumber = "/^[0-9]+$/";

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
//TODO: entirely in progress!!
public function bookingFormIsValid($passName, $passPhone, $destSub, $pickupDate, $pickupTime, 
								$unitNo, $streetNo, $streetName, $pickupSub) {
	
	$errors = array();
	
	if (!$this->isValidName($passName)) {
		$errors[] = "passenger name";
	}
	
	if (!$this->isValidPhone($passPhone)) {
		$errors[] = "passenger phone";
	}
	
	if (!$this->isValidAlpha($destSub)) {
		$errors[] = "destination suburb";
	}
	
	if ((!$this->isValidAlpha($pickupSub)) || (!$this->isValidNumber($streetNo)) || (!$this->isValidAlpha($streetName))) {
		$errors[] = "pickup address";
	}
	
	if (!($this->isValidNumber($unitNo)) && ($unitNo !== "")) {
		$errors[] = "unit number";
	}

	if (!$this->isValidPickupDatetime($pickupDate, $pickupTime)) {
		$errors[] = "pickup date and time";
	}
	
	
	
	if (count($errors) == 0) {
		return true;
	} else {
		$this->formatErrors($errors);
		return false;
	}
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
	
		if (($pickupDate == "") || ($pickupTime == "")) {
			return false;
		}
	
		date_default_timezone_set("Australia/Melbourne");
		try {
			$date = new DateTime($pickupDate . " " . $pickupTime);
			return true;		
		} catch (Exception $e) {
			return false;
		}
	} 
	
public function isTimeInFuture($pickupDate, $pickupTime) {
		date_default_timezone_set("Australia/Melbourne");
		try {
			$dateTime = new DateTime($pickupDate . " " . $pickupTime);
			$oneHourAway = new DateTime();
			$oneHourAway->add(new DateInterval('PT1H'));
			
			if ($dateTime < $oneHourAway) {
				return false;
			} else {
				return true;
			}
			
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


private function formatErrors(Array $errors) {
	$error = "Please check the value you entered for the ";
 	$first = true;
	foreach ($errors as $er) {
		if (!$first) {
 			$error = $error . ", ";
 		}
 		$error = $error . $er;
 		$first = false;
 	}
	$_SESSION['error'] = $error;
}
}
