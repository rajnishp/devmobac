<?php
	/**
	 * Object represents table 'call_details'
	 *
     	 * @author: rajnish
     	 * @date: 2015-03-18 23:07	 
	 */
	class CallDetail{
		
		private $id;
		private $secondParty;
		private $callDuration;
		private $time;
		private $type;

		function __construct($secondParty, $callDuration, $time, $type, $id = null){
			$this->id = $id;
			$this->secondParty = $secondParty;
			$this->callDuration = $callDuration;
			$this->time = $time;
			$this->type = $type;
			
		}
		
		function setId($id){
			$this -> id = $id;
		}
		function getId(){
			return $this->id;
		}

		function setSecondParty($secondParty){
			$this -> secondParty = $secondParty;
		}
		function getSecondParty(){
			return $this-> secondParty;
		}

		function setCallDuration($callDuration){
			$this -> callDuration = $callDuration;
		}
		function getCallDuration(){
			return $this-> callDuration;
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
			return $this -> id . ", " . $this -> chId. ", " . $this -> secondParty. ", " . $this -> callDuration. ", " . $this -> time. ", " . $this -> type;
		}
		
		function toArray() {
			return array (
						id => $this->id,
						secondParty => $this->secondParty,
						callDuration => $this->callDuration,
						time => $this->time,
						type => $this->type
				);
		}
		
	}
?>