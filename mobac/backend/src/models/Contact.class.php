<?php
	/**
	 * Object represents table 'contacts'
	 *
     	 * @author: rajnish
     	 * @date: 2015-03-22 01:44	 
	 */
	class Contact{
		
		private $id;
		private $name;
		private $phoneNo;
		
		function __construct ($name, $phoneNo, $id = null) {
			$this -> id = $id;
			$this -> name = $name;
			$this -> phoneNo = $phoneNo;
		}

		function setId ($id) {
			$this -> id = $id;
		}
		function getId () {
			return $this -> id;
		}

		function setName ($name) {
			$this -> name = $name;
		}
		function getName () {
			return $this -> name;
		}

		function setPhoneNo ($phoneNo) {
			$this -> phoneNo = $phoneNo;
		}
		function getPhoneNo () {
			return $this -> phoneNo;
		}

		function toString() {
			return $this -> id . ", " . $this -> name . ", " . $this -> phoneNo;
		}

		function toArray() {
			return array (
				id => $this -> id,
				name => $this -> name,
				phoneNo => $this -> phoneNo
			);
		}
	}
?>