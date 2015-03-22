<?php
	/**
	 * Object represents table 'messages'
	 *
     	 * @author: http://phpdao.com
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
	
	function __construct($userId, $fromTo, $messageText, $time, $type, $status, $id = null){
			$this -> id = $id;
			$this -> userId = $userId;
			$this -> fromTo = $fromTo;
			$this -> messageText = $messageText;
			$this -> time = $time;
			$this -> type = $type;
			$this -> status = $status;

			
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

		function toString (){
			return $this -> id . ", " . $this -> userId . ", " . $this -> fromTo. ", " . $this -> messageText. ", " . $this -> time. ", " . $this -> typeid . ", " . $this -> status;
		}
		
		function toArray() {
			return array (
						id => $this-> id,
						userId => $this-> userId,
						fromTo => $this-> fromTo,
						messageText => $this-> messageText,
						time => $this-> time,
						type => $this-> type,
						status => $this-> status
				);
		}	
	}
?>