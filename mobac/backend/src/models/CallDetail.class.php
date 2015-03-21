<?php
	/**
	 * Object represents table 'call_details'
	 *
     	 * @author: rajnish
     	 * @date: 2015-03-18 23:07	 
	 */
	class CallDetail{
		
		private $id;
		private $userId;
		private $secondParty;
		private $callDuration;
		private $time;
		private $type;
		private $status;
		private $callerName;

		function __construct($userId, $secondParty, $callDuration, $time, $type, $status, $callerName, $id = null){
			$this -> id = $id;
			$this -> userId = $userId;
			$this -> secondParty = $secondParty;
			$this -> callDuration = $callDuration;
			$this -> time = $time;
			$this -> type = $type;
			$this -> status = $status;
			$this -> callerName = $callerName;
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

		function setStatus($status){
			$this -> status = $status;
		}
		function getStatus(){
				return $this-> status;
		}

		function setCallerName($callerName){
			$this -> callerName = $callerName;
		}
		function getCallerName(){
			return $this -> callerName;
		}

		function toString (){
			return $this -> id . ", " . $this -> userId . ", " . $this -> secondParty. ", " . $this -> callDuration. ", " . $this -> time. ", " . $this -> type. ", " . $this -> status. ", " . $this -> callerName;
		}
		
		function toArray() {
			return array (
						id => $this -> id,
						userId => $this -> userId,
						secondParty => $this -> secondParty,
						callDuration => $this -> callDuration,
						time => $this -> time,
						type => $this -> type,
						status => $this -> status,
						callerName => $this -> callerName
				);
		}
		
	}
?>