<?php
	$page = $_GET['page'];
	switch ($page) {
		case 'khusus':
			include"./src/khusus.php";
			break;
		case 'view':
			include"./src/view.php";
			break;
		default :
			include"./src/view.php";
			break; 
		}

?>