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
<th>Rating</th>
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
while($data = mysqli_fetch_array($rs)){
	?><tr><td><?php echo $data['nama']; ?></td><?php
	?><td><?php echo $data['hp']; ?></td><?php
	?><td><?php echo $data['fp']; ?></td><?php
	?><td><?php echo $data['aa']; ?></td><?php
	?><td><?php echo $data['tp']; ?></td><?php
	?><td><?php echo $data['eva']; ?></td><?php
	?><td><?php echo $data['reload']; ?></td><?php
	?><td><?php echo $data['rating']; ?></td></tr><?php
	$kapal[] = $data;
	$jumlah = $jumlah+1;
}
echo $jumlah;
?>
</table>
<form method="post" action="#">
<input type="submit" name="hitung">
</form>
<?php
if (isset($_POST['hitung'])) {
	$r = 0.3;
	$accept = 0.5;
	$reject = 0.15;
	$q = 1.25;
	$bawah[]=['a','a',0,0,0,0,0,0];
	$atas[] = ['a','a',2000,100,200,450,300,250];
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
		echo $c;
		if($li == 0){
			$z = $m;
			$rasio = $z/$m;
		}else{
			$m = $m;
			$rasio = $z/$m;
		}
		if($rasio > $accept){
			for ($i=0; $i < 6; $i++) {
				$pusat[$naik][$i] = $normal[$c][$i];

			}
			$PAwal[$c] = 0;
			$naik = $naik+1;
			$z = $m;
			for ($i=0; $i < $jumlah; $i++) { 
				for ($x=0; $x < 6; $x++) { 
						$s = $s+pow((($normal[$c][$x]-$normal[$i][$x])/($r*$q)),2);
					}	
				$st[$i] = $s; 
			}
			for ($i=0; $i < $jumlah; $i++) { 
				$dc[$i] = $m*exp((-4*$st[$i]));
			}
			for ($i=0; $i < $jumlah; $i++) { 
				$PAwal[$i] = $PAwal[$i]-$dc[$i];
				if($PAwal[$i]<0){
					$PAwal[$i] = 0;
				}
			}
		}else if($reject < $rasio && $rasio <= $accept){
			$md = -1;
			for ($i=0; $i < $naik; $i++) { 
				for ($x=0; $x < 6; $x++) { 
					$g = pow(($normal[$c][$x]-$pusat[$i][$x])/$r,2)+$g;
				}
				$sd[$i] = $g;
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
				$naik = $naik+1;
				$z = $m;
				for ($i=0; $i < $jumlah; $i++) { 
					for ($x=0; $x < 6; $x++) { 
							$s = $s+pow((($normal[$c][$x]-$normal[$i][$x])/($r*$q)),2);
						}	
					$st[$i] = $s; 
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
	?><table>
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
}
?>