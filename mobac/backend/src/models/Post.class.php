<?php
	/**
	 * Object represents table 'posts'
	 *
     	 * @author: rahul lahoria
     	 * @date: 2015-03-15 11:09	 
	 */
	class Post{
		
		private $id;
		private $chId;
		private $title;
		private $hashtag;
		private $shareCount;

		function __construct($chId, $title, $hashtag, $shareCount, $id = null){
			$this->id = $id;
			$this->chId = $chId;
			$this->title = $title;
			$this->hashtag = $hashtag;
			$this->shareCount = $shareCount;

			
		}
		
		function setId($id){
			$this -> id = $id;
		}
		function getId(){
				return $this->id;
		}

		function setChId($chId){
			$this -> chId = $chId;
		}
		function getChId(){
				return $this-> chId;
		}
		// seter geter for hastag sharecount and title needed to be added		
		

		function setTitle($title){
			$this -> title = $title;
		}
		function getTitle(){
				return $this-> title;
		}

		function setHashtag($hashtag){
			$this -> hashtag = $hashtag;
		}
		function getHashtag(){
				return $this-> hashtag;
		}

		function setShareCount($shareCount){
			$this -> shareCount = $shareCount;
		}
		function getShareCount(){
				return $this-> shareCount;
		}


		// seter geter for hastag sharecount and title done.


		function toString (){
			return $this -> id . ", " . $this -> chId. ", " . $this -> title. ", " . $this -> hashtag. ", " . $this -> shareCount;
		}
		
		function toArray() {
			return array (
						id => $this->id,
						chId => $this->chId,
						title => $this->title,
						hashtag => $this->hashtag,
						shareCount => $this->shareCount
				);
		}
		
	}
?>