<?php
	/**
	 * Object represents table 'user_info'
	 *
     	 * @author: rajnish
     	 * @date: 2015-03-18 23:07	 
	 */
	class UserInfo{
		
		private $id;
		private $firstName;
		private $lastName;
		private $email;
		private $phoneNo;
		private $password;
		private $status;
		

		function __construct($firstName, $lastName, $email, $phoneNo, $password, $status, $id = null) {
			$this-> id = $id;
			$this-> firstName = $firstName;
			$this-> lastName = $lastName;
			$this-> email = $email;
			$this-> phoneNo = $phoneNo;
			$this-> password = $password;
			$this-> status = $status;
		}
		
		function setId($id){
			$this -> id = $id;
		}
		function getId(){
				return $this-> id;
		}

		function setFirstName($firstName){
			$this -> firstName = $firstName;
		}
		function getFirstName(){
				return $this-> firstName;
		}

		function setLastName($lastName){
			$this -> lastName = $lastName;
		}
		function getLastName(){
				return $this-> lastName;
		}

		function setEmail($email){
			$this -> email = $email;
		}
		function getEmail(){
				return $this-> email;
		}

		function setPhoneNo($phoneNo){
			$this -> phoneNo = $phoneNo;
		}
		function getPhoneNo(){
				return $this-> phoneNo;
		}

		function setPassword($password){
			$this -> password = $password;
		}
		function getPassword(){
				return $this-> password;
		}

		function setStatus($status){
			$this -> status = $status;
		}
		function getStatus(){
				return $this-> status;
		}

		function toString (){
			return $this -> id . ", " . $this -> firstName . ", " . $this -> lastName. ", " . $this -> email. ", " . $this -> phoneNo. ", " . $this -> password . ", " . $this -> status;
		}
		
		function toArray() {
			return array (
						id => $this-> id,
						userId => $this-> firstName,
						fromTo => $this-> lastName,
						messageText => $this-> email,
						time => $this-> phoneNo,
						type => $this-> password,
						status => $this-> status
				);
		}
	}
?>