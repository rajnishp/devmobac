<?php
	/**
	 * Object represents table 'messages'
	 *
     	 * @author: http://phpdao.com
     	 * @date: 2015-03-18 23:07	 
	 */
	class Message{
		
		private $id;
		private $fromTo;
		private $messageText;
		private $time;
		private $type;
	
	function __construct($fromTo, $messageText, $time, $type, $id = null){
			$this-> id = $id;
			$this-> fromTo = $fromTo;
			$this-> messageText = $messageText;
			$this-> time = $time;
			$this-> type = $type;

			
		}
		
		function setId($id){
			$this -> id = $id;
		}
		function getId(){
				return $this->id;
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


		function toString (){
			return $this -> id . ", " . $this -> fromTo. ", " . $this -> messageText. ", " . $this -> time. ", " . $this -> type;
		}
		
		function toArray() {
			return array (
						id => $this->id,
						fromTo => $this->fromTo,
						messageText => $this->messageText,
						time => $this->time,
						type => $this->type
				);
		}	
	}
?>