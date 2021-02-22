<?php
class koneksi{
	public $konek;
	public function __construct(){
		$this->konek = new mysqli("localhost","root","","azurLane");
	}
}
?>