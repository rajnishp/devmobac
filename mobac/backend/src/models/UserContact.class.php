<?php
	/**
	 * Object represents table 'user_contacts'
	 *
     	 * @author: rajnish
     	 * @date: 2015-03-29 06:38	 
	 */
	class UserContact{
		
		private $id;
		private $userId;
		private $name;
		private $phone;
		private $lastUpdateTime;
		private $emailContact;
		private $emailType;
		private $imageLink;


		function __construct($userId, $name, $phone, $lastUpdateTime, $emailContact, $emailType, $imageLink, $id = null){
			$this -> id = $id;
			$this -> userId = $userId;
			$this -> name = $name;
			$this -> phone = $phone;
			$this -> lastUpdateTime = $lastUpdateTime;
			$this -> emailContact = $emailContact;
			$this -> emailType = $emailType;
			$this -> imageLink = $imageLink;
		}
		
		function setId($id){
			$this -> id = $id;
		}
		function getId(){
			return $this -> id;
		}

		function setUserId($userId){
			$this -> userId = $userId;
		}
		function getUserId(){
				return $this-> userId;
		}

		function setName($name){
			$this -> name = $name;
		}
		function getName(){
			return $this-> name;
		}

		function setPhone($phone){
			$this -> phone = $phone;
		}
		function getPhone(){
			return $this-> phone;
		}

		function setLastUpdateTime($lastUpdateTime){
			$this -> lastUpdateTime = $lastUpdateTime;
		}
		function getLastUpdateTime(){
			return $this-> lastUpdateTime;
		}

		function setEmailContact($emailContact){
			$this -> emailContact = $emailContact;
		}
		function getEmailContact(){
			return $this-> emailContact;
		}

		function setEmailType($emailType){
			$this -> emailType = $emailType;
		}
		function getEmailType(){
				return $this-> emailType;
		}

		function setImageLink($imageLink){
			$this -> imageLink = $imageLink;
		}
		function getImageLink(){
			return $this -> imageLink;
		}

		function toString (){
			return $this -> id . ", " . 
					$this -> userId . ", " . 
					$this -> name. ", " . 
					$this -> phone. ", " . 
					$this -> lastUpdateTime. ", " . 
					$this -> emailContact. ", " . 
					$this -> emailType. ", " . 
					$this -> imageLink;
		}
		
		function toArray() {
			return array (
						id => $this -> id,
						userId => $this -> userId,
						name => $this -> name,
						phone => $this -> phone,
						lastUpdateTime => $this -> lastUpdateTime,
						emailContact => $this -> emailContact,
						emailType => $this -> emailType,
						imageLink => $this -> imageLink
				);
		}
		
	}
?>