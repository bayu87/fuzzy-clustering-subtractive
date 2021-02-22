<?php
$rs = $a->olahQuery("select*from kapal");
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
$kapal = array();
$bawah = array();
$atas = array();
$normal = array();
$d = array();
$e = array();
$PAwal = array();
$f = 0.0;
$PAwal2 = 0.0;
$pusat = array();
$naik = 1;
$s = 0.0;
$st = array();
$dc = array();
$lo = 0;
$li = 0;
$sama = 0.0;
$g=0.0;
$letak = array();
$total = array();
$sigma = array();
$hasil = 0.0;
$derajat = array();
while($data = mysqli_fetch_array($rs)){
	?><tr><td><?php echo $data['nama']; ?></td><?php
	?><td><?php echo $data['hp']; ?></td><?php
	?><td><?php echo $data['fp']; ?></td><?php
	?><td><?php echo $data['aa']; ?></td><?php
	?><td><?php echo $data['tp']; ?></td><?php
	?><td><?php echo $data['eva']; ?></td><?php
	?><td><?php echo $data['reload']; ?></td><?php
	?><td><?php echo $data['kelompok']; ?></td></tr><?php
	$kapal[] = $data;
	$jumlah = $jumlah+1;
}
echo $jumlah;
?>
</table>
<form method="post" action="#">
<input type="submit" name="hitung" value="Hitung">
</form>
<?php
if (isset($_POST['hitung'])) {
		for ($x=0; $x < $jumlah; $x++) { 
			$hp[$x] = $kapal[$x][2];
		}
		for ($x=0; $x < $jumlah; $x++) { 
			$fp[$x] = $kapal[$x][3];
		}
		for ($x=0; $x < $jumlah; $x++) { 
			$aa[$x] = $kapal[$x][4];
		}
		for ($x=0; $x < $jumlah; $x++) { 
			$tp[$x] = $kapal[$x][5];
		}
		for ($x=0; $x < $jumlah; $x++) { 
			$eva[$x] = $kapal[$x][6];
		}
		for ($x=0; $x < $jumlah; $x++) { 
			$reload[$x] = $kapal[$x][7];
		}

	$rasio = 0.0;
	$r = 0.3;
	$accept = 0.5;
	$reject = 0.15;
	$q = 1.25;
	$bawah[]=['a','a',0,0,0,0,0,0];
	$atas[] = ['a','a',max($hp),max($fp),max($aa),max($tp),max($eva),max($reload)];
	for ($i=0; $i < $jumlah; $i++) { 
		for ($x=2; $x < 8; $x++) { 
			$normal[$i][$x-2] = ($kapal[$i][$x] - $bawah[0][$x])/$atas[0][$x];
		}
	}
	?><table border="1">
	Data Ternormalisasi
	<?php
	for ($i=0; $i < $jumlah; $i++) { 
		?><tr><?php
		for ($x=0; $x < 6; $x++) {
			?><td><?php
			echo $normal[$i][$x];
			?></td><?php	
		}
		?></tr>
		<?php
	}
	?></table>
	<?php
		for($v=0; $v < $jumlah; $v++){
			for ($i=0; $i < $jumlah; $i++) { 
				for ($x=0; $x < 6; $x++) { 
					$f = pow((($normal[$v][$x] - $normal[$i][$x])/$r), 2) + $f;
				}
				$e[$i] = $f;
				$f = 0.0;
			}
			for($y=0; $y < $jumlah; $y++){
				$PAwal2 = exp((-4*$e[$y]))+$PAwal2;
			}
			$PAwal[$v] = $PAwal2;
			$PAwal2 = 0.0; 
		}
	
	while ($lo < $jumlah) {
		$m = max($PAwal);
		$c = array_search($m, $PAwal);
		if($li <= 0){
			$z = $m;
			$rasio = $m/$z;
		}else{
			$m = $m;
			$rasio = $m/$z;
		}
		if($rasio > $accept){
			for ($i=0; $i < 6; $i++) {
				$pusat[$naik][$i] = $normal[$c][$i];
			}
			$sama = $PAwal[$c];
			$letak[$naik] = $c;
			$naik = $naik+1;
			$z = $m;
			for ($i=0; $i < $jumlah; $i++) { 
				for ($x=0; $x < 6; $x++) { 
						$s = $s+pow((($normal[$c][$x]-$normal[$i][$x])/($r*$q)),2);
					}	
				$st[$i] = $s; 
				$s = 0.0;
			}
			for ($i=0; $i < $jumlah; $i++) { 
				$dc[$i] = $m*exp((-4*$st[$i]));
			}
			for ($i=0; $i < $jumlah; $i++) { 
				if($PAwal[$i]==$sama){
					$PAwal[$i] = 0;
				}
				$PAwal[$i] = ($PAwal[$i]-$dc[$i]);
				if($PAwal[$i]<=0){
					$PAwal[$i] = 0;
				}
			
			}
		}else if($reject < $rasio && $rasio <= $accept){
			$md = -1;
			for ($i=0; $i < $naik-1; $i++) { 
				for ($x=0; $x < 6; $x++) { 
					$g = pow((($normal[$c][$x]-$pusat[$i+1][$x])/$r),2)+$g;
				}
				$sd[$i] = $g;
				$g=0.0;
				if($md < 0){
					$md = $sd[$i];
				}else if($sd[$i] < $md){
					$md = $sd[$i];
				}
			}
			$smd = sqrt($md);
			if($rasio+$smd >= 1){
				for ($i=0; $i < 6; $i++) {
					$pusat[$naik][$i] = $normal[$c][$i];
				}
				$PAwal[$c] = 0;
				$letak[$naik] = $c;
				$naik = $naik+1;

				$z = $m;
				for ($i=0; $i < $jumlah; $i++) { 
					for ($x=0; $x < 6; $x++) { 
							$s = $s+pow((($normal[$c][$x]-$normal[$i][$x])/($r*$q)),2);
						}	
					$st[$i] = $s; 
					$s = 0.0;
				}
				for ($i=0; $i < $jumlah; $i++) { 
					$dc[$i] = $m*exp((-4*$st[$i]));
				}
				for ($i=0; $i < $jumlah; $i++) { 
					$PAwal[$i] = $PAwal[$i]-$dc[$i];
					if($PAwal[$i] < 0){
						$PAwal[$i] = 0;
					}
				}
				
			}else{
				$PAwal[$c] = 0;
			}
		}else{
			break;
		}
		$li = $li+1;
	}
	?>
	Cluster
	<table border="1">
		<?php 
			for ($i=1; $i < $naik; $i++) {
				echo "<tr>"; 
				for ($x=0; $x < 6; $x++) { 
					echo "<td>";
					echo $pusat[$i][$x];
					echo "</td>";
				}
				echo "</tr>";
			}
		?>
		
	</table>
<?php
?>
	De-normalisasi
	<table border="1">
		<?php 
			for ($i=0; $i < $naik-1; $i++) {
				echo "<tr>";
				for ($x=2; $x < 8; $x++) { 					
				 	echo "<td>";
					echo $pusat[$i+1][$x-2] = $pusat[$i+1][$x-2]*($atas[0][$x]-$bawah[0][$x]);
					echo "</td>";
				 } 
				echo "<tr>";				
			}
		?>
		
	</table>
Sigma
	<table border="1">
		<?php 
				for ($x=2; $x < 8; $x++) { 		
					$sigma[0][$x-2] = $r*($atas[0][$x]-$bawah[0][$x])/sqrt(8);
				 }			
			
		?>
	<tr><?php for ($i=0; $i < 6; $i++) { 
		echo "<td>";
		echo $sigma[0][$i];
		echo "</td>";
	}?></tr>
	</table>
	Gauss Function
<?php
for($x=0;$x < $naik-1;$x++){
	for ($i=0; $i < $jumlah; $i++) { 
		for ($z=2; $z < 8; $z++) {
			$hasil=pow(($kapal[$i][$z]-$pusat[$x+1][$z-2])/(sqrt(2)*$sigma[0][$z-2]),2)+$hasil;
		}	
		$derajat[$x][$i] = exp($hasil);
		$hasil = 0.0;
	}
}?>
<table border="1">
<?php
for ($i=0; $i < $jumlah; $i++) { 
	echo "<tr>";
	for ($x=0; $x < $naik-1; $x++) { 
		echo "<td>";
		echo "Data ke-"; echo $i+1;
		echo "</td>";
		echo "<td>";
		echo $derajat[$x][$i];
		echo "</td>";
	}
	echo "</tr>";
}
?>
</table>
Data per cluster
<?php
for ($i=1; $i <= $jumlah; $i++) { 
	for ($x=0; $x < $naik-1; $x++) { 
		$akhir[$x]=$derajat[$x][$i-1];
	}
	$akhirnya=min($akhir);
	$haha = array_search($akhirnya, $akhir)+1;
	$tambah = $a->olahQuery("update kapal set kelompok='$haha' where id='$i'");
}
}
?>