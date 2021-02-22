<?php
include_once"koneksi.php";
	class crud extends koneksi{
		public function __construct(){
			parent::__construct();
		}
		public function olahQuery($query){
			return $result = mysqli_query($this->konek,"$query");
		}
	}
?>