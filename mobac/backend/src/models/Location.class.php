<?php
	/**
	 * Object represents table 'locations'
	 *
     	 * @author: rajnish
     	 * @date: 2015-03-18 23:07	 
	 */
	class Location{
		
		private $id;
		private $userId;
		private $latitude;
		private $longitude;
		private $fromTime;
		private $toTime;
		private $status;
		

		function __construct($userId, $latitude, $longitude, $fromTime, $toTime, $status, $id = null) {
			$this -> id = $id;
			$this -> userId = $userId;
			$this -> latitude = $latitude;
			$this -> longitude = $longitude;
			$this -> fromTime = $fromTime;
			$this -> toTime = $toTime;
			$this -> status = $status;
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

		function setLatitude($latitude){
			$this -> latitude = $latitude;
		}
		function getLatitude(){
			return $this -> latitude;
		}

		function setLongitude($longitude){
			$this -> longitude = $longitude;
		}
		function getLongitude(){
			return $this-> longitude;
		}

		function setFromTime($fromTime){
			$this -> fromTime = $fromTime;
		}
		function getFromTime(){
			return $this-> fromTime;
		}

		function setToTime($toTime){
			$this -> toTime = $toTime;
		}
		function getToTime(){
			return $this-> toTime;
		}

		function setStatus($status){
			$this -> status = $status;
		}
		function getStatus(){
				return $this-> status;
		}


		function toString (){
			return $this -> id . ", " . $this -> userId . ", " . $this -> latitude. ", " . $this -> longitude. ", " . $this -> fromTime . ", " .  $this -> toTime . ", " . $this -> status;
		}
		
		function toArray() {
			return array (
						id => $this->id,
						userId => $this->userId,
						latitude => $this->latitude,
						longitude => $this->longitude,
						fromTime => $this->fromTime,
						toTime => $this->toTime,
						status => $this->status
					);
		}	
	}
?>