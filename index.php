<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title></title>
	<link rel="stylesheet" href="resource/css/style.css" media="screen">
</head>
<?php 
include_once"./src/crud.php";
$a = new crud();
?>
<body>
<div id="cover">
    <div class="container4">
    <p><img src="resource/img/cover.png" width="766" height="468"></p>
    </div>
</div>
<div id="header">
    <img src="resource/img/logo_s.png">
    <ul>
    	<li id="pengenalan">
            Pengenalan
        </li>
        <li id="Hasil">
            Hasil Clustering
        </li>
        <li id="hitung">
            Hitung Ulang Cluster
        </li>
        <li id="tambah">
            Tambah Data
        </li>
    </ul>
</div>
<div id="container_introduction">
	<div class="container_text">
		test
	</div>
</div>
<div id="container_hasil">
	<div class="container_text">
	<?php include"./src/view.php" ?>
	</div>
</div>
<div id="container_hitung">
	<div class="container_text">
	</div>
</div>
<div id="container_tambah">
	<div class="container_text">
	</div>
</div>
<a href="#" class="scrollToTop">
    <img src="resource/img/upload.png">
</a>
<script src="resource/js/jquery-3.1.0.js"></script>
<script src="resource/js/noframework.waypoints.min.js"></script>
<script src="resource/js/shelter.js"></script>
</body>
</html>