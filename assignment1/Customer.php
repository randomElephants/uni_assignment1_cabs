<?php
class Customer {	
	//Must be entered each time
	private $email;
	//Wouldn't really do password like this obviously
	private $password;
	
<<<<<<< HEAD
=======
	
>>>>>>> branch 'master' of https://github.com/randomElephants/uni_assignment1_cabs
	//retrieved from db
	private $phone;
	private $name;
	
	
	public function __construct($email, $password, $phone, $name){
		$this->email = $email;
		$this->password = $password;
		$this->name = $name;
		$this->phone = $phone;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getPassword() {
		return $this->password;
	}
	
	public function getPhone() {
		return $this->phone;
	}
	
	public function getEmail() {
		return $this->email;
	}
}