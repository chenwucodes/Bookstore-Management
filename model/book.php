<?php
	class Book{		

		private $id;
		private $title;
		private $author;
		private $stock;
		private $publishDate;
		private $picture;
				
		function __construct($id, $title, $author, $stock,$publishDate, $picture){
			$this->setId($id);
			$this->setTitle($title);
			$this->setAuthor($author);
			$this->setStock($stock);
			$this->setPublishDate($publishDate);
			$this->setPicture($picture);
			}		
		
		public function getTitle(){
			return $this->title;
		}
		
		public function setTitle($title){
			$this->title = $title;
		}
		
		public function getAuthor(){
			return $this->author;
		}
		
		public function setAuthor($author){
			$this->author = $author;
		}

		public function getstock(){
			return $this->stock;
		}

		public function setStock($stock){
			$this->stock = $stock;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

		public function setPicture($picture){
			$this->picture = $picture;
		}

		public function getPicture(){
			return $this->picture;
		}

		public function setPublishDate($publishDate){
			$this->publishDate = $publishDate;
		}

		public function getPublishDate(){
			return $this->publishDate;
		}



	}
?>