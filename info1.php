<h2><u>Punkteabfrage</u></h2><br/>
<form action="" method="get">
Bitte Matrikelnummer eingeben:<br \><input name="mat" maxlength="10" type="text"\>
<input type="hidden" name="p" value="info1">
<input type="submit" value="Absenden ">
</form>
<br />
<?php
$filename = 'points.dat';
if (isset($_GET['mat']) && ($_GET['mat'])!="" && strlen($_GET['mat'])<11)
{

//my own function to calculate a gradient
//input: 
// actual value p1 and maximum p2 ==> (percentage)=p1/p2
// $v specifies which colour part to return (R = 0, G = 1, B = 2) 
function col($p1,$p2,$v) {
	if ($p2==0)
		return 255;
	if ($v==2)
		return 0;
	$p=$p1/$p2;
	if ($p<0.5)
	{
			$c[0]	=255;
			$c[1]	=255*$p*2;
	}
	else
	{
			$c[0]	=255-($p-0.5)*255;
			$c[1]	=255;
	}
	if ($v==0)
		return floor($c[0]);
	else if ($v==1)
		return floor($c[1]);
}
function style($ue)
{
	if ($ue%2==0)
		return 'outline: thin solid black;';
	else
		return '';
}

$txt_file    = file_get_contents($filename);
$rows        = explode("\n", $txt_file);
array_shift($rows);
if (isset($_GET['mat']))
{
	$mat=$_GET['mat'];
	$found=0;
	foreach($rows as $row => $data)
	{
		//get row data
		$row_data = explode(';', $data);

		$info[$row]['MNr'] = $row_data[0];
		if ($mat==$info[$row]['MNr'])
		{
			$found=1;
			
			//adjust to -your- pointtable. (so just enter the right column numbers) 
			/**MODIFY START**/
			$info[$row]['1_L']	= $row_data[7];
			$info[$row]['1']	= $row_data[8];
			$info[$row]['2_L']	= $row_data[9];
			$info[$row]['2']	= $row_data[10];
			$info[$row]['2_1']	= $row_data[11];
			$info[$row]['2_2']	= $row_data[12];
			$info[$row]['3_L']	= $row_data[13];
			$info[$row]['3']	= $row_data[14];
			$info[$row]['3_1']	= $row_data[15];
			$info[$row]['3_2']	= $row_data[16];
			/**MODIFY END**/
			
			echo "Abfrage für <b>".$mat."</b>:<br /><br />";
			echo "<table>";
			echo "<tr style=\"opacity: 1; font-weight: bold; outline: thin solid black;\"><td>Übung</td><td>Summe<div style='font-size: 50%'>mit Ilias und LonCapa</div></td><td>Ilias+LonCapa</td><td>Summe<div style='font-size: 50%'>ohne Ilias und LonCapa</div></td><td>A1</td><td>A2</td><td>A3</td><td>praktische Übungsaufgabe</td></tr>";
			
			$totalsum=0;
			$totalilias=0;
			$totalex=0;
			for ($i=1;$i<=3;$i++)
			{
				$a1=0;$a2=0;$a3=0;$a4=0; //zero everything
				/**MODIFY START**/
				$a_m=array(0,0,0,92,11,8,0,25,14,23,0,25); //setting maximum for each exercise 
				/**MODIFY END**/
				$uebung=str_pad($i, 2, "0", STR_PAD_LEFT); //make it beautiful
				$ue=$i;
				//read out and avoid errors:
				if (isset($info[$row][$i.'_L']))
					$ilias=$info[$row][$i.'_L'];
				if (isset($info[$row][$i.'_1']))
					$a1=$info[$row][$i.'_1'];
				if (isset($info[$row][$i.'_2']))
					$a2=$info[$row][$i.'_2'];
				if (isset($info[$row][$i.'_3']))
					$a3=$info[$row][$i.'_3'];
				if (isset($info[$row][$i]))
					$a4=$info[$row][$i]; 
				
				//oh, you might be using comma instead of point to represent decimals
				$ilias=str_replace(",",".",$ilias);
	
				$sum	=$a1+$a2+$a3+$a4;
				$total	=$a_m[($i-1)*4 + 0]+$a_m[($i-1)*4 + 1]+$a_m[($i-1)*4 + 2]+$a_m[($i-1)*4 + 3];
				$totalex=$totalex+$total;
				$totalsum	=$totalsum+$sum;
				$totalilias	=$totalilias+$ilias;
				echo "<tr style='".style($ue)."'><td>".$uebung."</td><td>".($sum+$ilias)."</td><td>".$ilias."</td><td style=\"font-weight: bold; background-color: rgb(".(col($sum,$total,0)).",".(col($sum,$total,1)).",".(col($sum,$total,2)).");\">".$sum."/".$total."</td><td style=\"background-color: rgb(".(col($a1,$a_m[($i-1)*4 + 0],0)).",".(col($a1,$a_m[($i-1)*4 + 0],1)).",".(col($a1,$a_m[($i-1)*4 + 0],2)).");\">".$a1."/".$a_m[($i-1)*4 + 0]."</td><td style=\"background-color: rgb(".(col($a2,$a_m[($i-1)*4 + 1],0)).",".(col($a2,$a_m[($i-1)*4 + 1],1)).",".(col($a2,$a_m[($i-1)*4 + 1],2)).");\">".$a2."/".$a_m[($i-1)*4 + 1]."</td><td style=\"background-color: rgb(".(col($a3,$a_m[($i-1)*4 + 2],0)).",".(col($a3,$a_m[($i-1)*4 + 2],1)).",".(col($a3,$a_m[($i-1)*4 + 2],2)).");\">".$a3."/".$a_m[($i-1)*4 + 2]."</td><td style=\"background-color: rgb(".(col($a4,$a_m[($i-1)*4 + 3],0)).",".(col($a4,$a_m[($i-1)*4 + 3],1)).",".(col($a4,$a_m[($i-1)*4 + 3],2)).");\">".$a4."/".$a_m[($i-1)*4 + 3]."</td></tr>";				
			}
			
			echo "<tr style=\"outline: thin solid black;\"><td><b>&sum;</b></td><td>".($totalilias+$totalsum)."</td><td>".$totalilias."</td><td style='font-weight: bold;'>".$totalsum."/".$totalex." [".(round($totalsum*100.0/$totalex,2))."%]</td><td></td><td></td><td></td><td></td>";
			echo "</table>";
		}
	}
	if ($found==0)
		echo "Matrikelnummer wurde nicht gefunden.";
    
}
else
	echo "Keine Matrikelnummer eingegeben."; //not executed anymore
}
	
	echo "<br />";
	echo "Hinweis: <br />Für die Klausurzulassung werden <b>wahrscheinlich</b> 550 Punkte benötigt.";
	echo "<br />";
	echo "<br />";
	echo "";
if (file_exists($filename)) {
    echo "<div style=\"position: absolute; bottom: 5px;\">Punktetabelle zuletzt modifiziert am ".date ("d.m.Y", filemtime($filename))." um ".date("H:i:s", filemtime($filename))." Uhr.</div>";
}
?>