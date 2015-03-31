<?php
	/**
	 * Object represents table 'messages'
	 *
     	 * @author: rajnish
     	 * @date: 2015-03-18 23:07	 
	 */

	class Message{
		
		private $id;
		private $userId;
		private $fromTo;
		private $messageText;
		private $time;
		private $type;
		private $status;
		private $count;
		private $name;
	
	function __construct($userId, $fromTo, $messageText, $time, $type, $status, $id = null, $count, $name){
			$this -> id = $id;
			$this -> userId = $userId;
			$this -> fromTo = $fromTo;
			$this -> messageText = $messageText;
			$this -> time = $time;
			$this -> type = $type;
			$this -> status = $status;
			$this -> count = $count;
			$this -> name = $name;

			
		}
		
		function setId($id){
			$this -> id = $id;
		}
		function getId(){
				return $this-> id;
		}

		function setUserId($userId){
			$this -> userId = $userId;
		}
		function getUserId(){
				return $this-> userId;
		}

		function setFromTo($fromTo){
			$this -> fromTo = $fromTo;
		}
		function getFromTo(){
				return $this-> fromTo;
		}

		function setMessageText($messageText){
			$this -> messageText = $messageText;
		}
		function getMessageText(){
				return $this-> messageText;
		}

		function setTime($time){
			$this -> time = $time;
		}
		function getTime(){
				return $this-> time;
		}

		function setType($type){
			$this -> type = $type;
		}
		function getType(){
				return $this-> type;
		}

		function setStatus($status){
			$this -> status = $status;
		}
		function getStatus(){
				return $this-> status;
		}

		function setCount ($count) {
			$this -> count = $count;
		}
		function getCount () {
			return $this -> count;
		}

		function setName ($name) {
			$this -> name = $name;
		}
		function getName () {
			return $this -> name;
		}

		function toString (){
			return $this -> id . ", " . 
					$this -> userId . ", " . 
					$this -> fromTo. ", " . 
					$this -> messageText. ", " . 
					$this -> time. ", " . 
					$this -> type . ", " . 
					$this -> status . ", " .
					$this -> count . ", " .
					$this -> name;
		}
		
		function toArray() {
			return array (
						id => $this-> id,
						userId => $this-> userId,
						fromTo => $this-> fromTo,
						messageText => $this-> messageText,
						time => $this-> time,
						type => $this-> type,
						status => $this-> status,
						count => $this-> count,
						name => $this-> name
				);
		}	
	}
?>