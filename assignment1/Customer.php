<?php
class Customer {	
	//Must be entered each time
	private $email;
	//Wouldn't really do password like this obviously
	private $password;
	
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