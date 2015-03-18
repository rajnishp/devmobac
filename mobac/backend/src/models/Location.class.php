<?php
	/**
	 * Object represents table 'locations'
	 *
     	 * @author: rajnish
     	 * @date: 2015-03-18 23:07	 
	 */
	class Location{
		
		private $id;
		private $latitude;
		private $longitude;
		private $time;
		

		function __construct($latitude, $longitude, $time, $id = null){
			$this->id = $id;
			$this->latitude = $latitude;
			$this->longitude = $longitude;
			$this->time = $time;
		}
		
		function setId($id){
			$this -> id = $id;
		}
		function getId(){
				return $this->id;
		}

		function setLatitude($latitude){
			$this -> latitude = $latitude;
		}
		function getLatitude(){
				return $this-> latitude;
		}

		function setLongitude($longitude){
			$this -> longitude = $longitude;
		}
		function getLongitude(){
				return $this-> longitude;
		}

		function setTime($time){
			$this -> time = $time;
		}
		function getTime(){
				return $this-> time;
		}


		function toString (){
			return $this -> id . ", " . $this -> chId. ", " . $this -> latitude. ", " . $this -> longitude. ", " . $this -> time;
		}
		
		function toArray() {
			return array (
						id => $this->id,
						latitude => $this->latitude,
						longitude => $this->longitude,
						time => $this->time
					);
		}	
	}
?>