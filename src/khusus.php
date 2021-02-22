<?php
$rs = $a->olahQuery("select*from kapal order by kelompok");
$jumlah = 0;
?><table border="1">
<th>Nama</th>
<th>Hit Point</th>
<th>Fire Power</th>
<th>Anti-Air</th>
<th>Torpedo</th>
<th>Evasion</th>
<th>Reload</th>
<th>Kelompok</th>
<?php
while($data = mysqli_fetch_array($rs)){
	?><tr><td><?php echo $data['nama']; ?></td><?php
	?><td><?php echo $data['hp']; ?></td><?php
	?><td><?php echo $data['fp']; ?></td><?php
	?><td><?php echo $data['aa']; ?></td><?php
	?><td><?php echo $data['tp']; ?></td><?php
	?><td><?php echo $data['eva']; ?></td><?php
	?><td><?php echo $data['reload']; ?></td><?php
	?><td><?php echo $data['kelompok']; ?></td></tr><?php
}
?>