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
		private $duration;
		private $time;
		private $type;
	
	function __construct($fromTo, $duration, $time, $type, $id = null){
			$this->id = $id;
			$this->fromTo = $fromTo;
			$this->duration = $duration;
			$this->time = $time;
			$this->type = $type;

			
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

		function setDuration($duration){
			$this -> duration = $duration;
		}
		function getDuration(){
				return $this-> duration;
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
			return $this -> id . ", " . $this -> chId. ", " . $this -> fromTo. ", " . $this -> duration. ", " . $this -> time. ", " . $this -> type;
		}
		
		function toArray() {
			return array (
						id => $this->id,
						fromTo => $this->fromTo,
						duration => $this->duration,
						time => $this->time,
						type => $this->type
				);
		}	
	}
?>