<h2>Punkteabfrage</h2><br />
<div class="shadow-z-1 infobox">
<form action="" method="get">
<div class="form-group">
    <input class="form-control floating-label" id="focusedInput" maxlength="10" name="mat" placeholder="Bitte Pseudonym eingeben"><!--type="number"-->
<input type="hidden" name="p" value="info2">
<input class="btn btn-info" type="submit" value="Absenden ">
</div>
</form>
<br />
<?php
$filename = 'info2/info2.dat';

if (!(isset($_GET['mat']) && ($_GET['mat'])!="" && strlen($_GET['mat'])<16))
{
	$_GET['mat']="Bsp";
}
if (isset($_GET['mat']) && ($_GET['mat'])!="" && strlen($_GET['mat'])<16)
{

//my own function to calculate a gradient
//input: 
// actual value p1 and maximum p2 ==> (percentage)=p1/p2
// $v specifies which colour part to return (R = 0, G = 1, B = 2) 
function col($p1,$p2,$v) {
$max_col=255;
$factor=1.8;
	if ($p2==0)
		return $max_col;
	if ($v==2)
		return 0;
	$p=$p1/$p2;
	if ($p<0.5)
	{
			$c[0]	=$max_col;
			$c[1]	=$max_col*($p)*$factor;
			if($c[1]<75)
				$c[1]=75;
	}
	else
	{
			$c[0]	=$max_col-($p-(1/($factor+0.15)))*$max_col;
			$c[1]	=$max_col;
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

function findID($key,$row_data)
{
	foreach($row_data as $k => $entry)
	{
		if ($entry==$key)
		{
			return $k;
		}
	}
	return -1;
}


$txt_file    = file_get_contents($filename);
$rows        = explode("\n", $txt_file);
if (isset($_GET['mat']))
{
	$totalpoints=array();
	$mat=$_GET['mat'];
	$found=0;
	$totalexercises=0;
	
	$firstrow=array_shift($rows); // move out first line
	$secondrow=array_pop($rows); // move out last line
	$meanrow=array_pop($rows); // move out last line (MEAN)
	$secondrow=array_pop($rows); // move out last line (points here)
	$firstrow_data = explode(',', $firstrow);
	$secondrow_data = explode(',', $secondrow);
	$meanrow_data = explode(',', $meanrow);
	
	foreach($firstrow_data as $k => $entry)
	{
		$e_arr=explode('_', $entry);
		if (count($e_arr)>1)
			if ((int)$e_arr[1]>$totalexercises)
				$totalexercises=(int)$e_arr[1];
	}
	
	if ($totalexercises != 0)
	{
		foreach($rows as $row => $data)
		{
			
			//get row data
			$row_data = explode(',', $data);

			$info[$row]['Pseudonym'] = $row_data[0];
			if ($mat==$info[$row]['Pseudonym'])
			{
				$found=1;
				
				echo "Abfrage für <b>".$mat."</b>:<br /><br />";
				echo "<table class=\"table table-striped table-hover \">";
				echo "<thead><tr class=\"info\"><th>Übung</th><th>Summe</th><th>Übungsblatt</th><th>Ilias</th></tr></thead><tbody>";
				
				$totalsum=0;
				$totalall=0; //counting the maxsum
				//$totalilias=0;
				$totalex=0;
				for ($i=1;$i<=$totalexercises;$i++)
				{
					$a1=0;$a2=0;$a3=0;$a4=0; //zero everything
					$a_m=array(0,0,0,0);
					$uebung=str_pad($i, 2, "0", STR_PAD_LEFT); //make it beautiful
					$ue=$i;
					$i=$uebung;
					//read out and avoid errors:
					if (findID('UE_'.$i,$firstrow_data) >= 0)
					{
					//echo "LOL AT: ".$i."<br>";
						$a1ID=findID('UE_'.$i,$firstrow_data);
						if ($row_data[$a1ID]!="")
							$a1=$row_data[$a1ID];
						if ($secondrow_data[$a1ID]!="")
							$a_m[0]=$secondrow_data[$a1ID];
					}
					if (findID('P_'.$i,$firstrow_data) >= 0)
					{
						$a2ID=findID('P_'.$i,$firstrow_data);
						if ($row_data[$a2ID]!="")
							$a2=$row_data[$a2ID];
						if ($secondrow_data[$a2ID]!="")
							$a_m[1]=$secondrow_data[$a2ID];
							
					}
					if (findID('I_'.$i,$firstrow_data) >= 0)
					{
						$a3ID=findID('I_'.$i,$firstrow_data);
						if ($row_data[$a3ID]!="")
							$a3=$row_data[$a3ID];
						if ($secondrow_data[$a3ID]!="")
							$a_m[2]=$secondrow_data[$a3ID];
					}
					if (findID('L_'.$i,$firstrow_data) >= 0)
					{
						$a4ID=findID('L_'.$i,$firstrow_data);
						if ($row_data[$a4ID]!="")
							$a4=$row_data[$a4ID];
						if ($secondrow_data[$a4ID]!="")
							$a_m[3]=$secondrow_data[$a4ID];
					}
					
					//oh, you might be using comma instead of point to represent decimals
					//$ilias=str_replace(",",".",$ilias);
		
					$sum	=$a1+$a2+$a3+$a4;
					$total	=$a_m[0]+$a_m[1]+$a_m[2]+$a_m[3];
					$totalall=$totalall+$total;
					$totalsum	=$totalsum+$sum;
					$totalpoints[]=$sum;
					if ($sum>0)
					{
						$totalex=$ue;				
						echo "<tr><td>".$uebung."</td><td style=\"font-weight: bold; background-color: rgb(".(col($sum,$total,0)).",".(col($sum,$total,1)).",".(col($sum,$total,2)).");\">".$sum."/".$total."</td><td style=\"background-color: rgb(".(col($a1,$a_m[0],0)).",".(col($a1,$a_m[0],1)).",".(col($a1,$a_m[0],2)).");\">".$a1."/".$a_m[0]."</td><td style=\"background-color: rgb(".(col($a3,$a_m[2],0)).",".(col($a3,$a_m[2],1)).",".(col($a3,$a_m[2],2)).");\">".$a3."/".$a_m[2]."</td></tr>";				
					}
				}
				
				echo "<tr><td><b>&sum;</b></td><td colspan=3 style='font-weight: bold;'>".$totalsum."/".($totalall)." [".(round($totalsum*100.0/$totalall,2))."%]
				
				<div class=\"progress progress-striped active\">
				<div class=\"progress-bar\" style=\"width: ".(round($totalsum*100.0/$totalall,2))."%\"></div>
				</div>
				
				
				</td>";
				echo "</tbody></table>";
				echo "<div id=\"plot\" style=\"height: 250px;\"></div>";
				echo "<script>
				new Morris.Line({
				  element: 'plot',
				  data: [
				  ";
				for ($i=0;$i<12;$i++)
				{
					$uebung=str_pad($i, 2, "0", STR_PAD_LEFT); //make it beautiful
					if ($i<$totalexercises)
					{
						echo "{ y: '".$uebung."', a: ".$totalpoints[$i].", b: ".$meanrow_data[$i+1].", c: ".$secondrow_data[$i+1]." }";//".$meanrow_data[$i+1]."
					}
					else
					{
						echo "{ y: '".$uebung."', a: 0, b: 0, c:0 }";
					}
					if ($i!=11)
						echo ",";
				}
				echo "
				  ],
				  xkey: 'y',
				  ykeys: ['a', 'b'/*, 'c'*/],
				  xLabelFormat: function (x) {  			return \"\";              },
				  //dateFormat: function(x) { return new Date(x).toString();},
				  dateFormat: function(x) { return \"Übung \"+(1+Math.floor((x+2208992400000)/31536000000));},
				  labels: ['Punkte', 'Durchschnitt'/*, 'Erreichbare Punkte'*/],
				  goals: [50],
				  goalStrokeWidth: 5,
				  goalLineColors: [\"#03F4A9\"],
				  lineColors: [\"#03A9F4\",\"#C0C0C0\",\"#00FF00\"]
				});</script>";
				
			}
		}
		if ($found==0)
			echo "Pseudonym wurde <b>nicht</b> gefunden.<br />";
	}
	else
	{
		echo "Formatierung der Punktetabelle falsch.<br />";
	}
    
}
else
	echo "Keine Pseudonym eingegeben.<br />"; //not executed anymore
}
	
	echo "<br />";
	echo "<h3><i class=\"mdi-action-info-outline\"></i> Hinweise</h3>- Für die Klausurzulassung werden <b>wahrscheinlich</b> 550 Punkte benötigt.<!--<br>- Lon Capa 11 bisher nicht eingetragen.-->";
	if (file_exists($filename))
		echo "<br />- Punktetabelle zuletzt modifiziert am ".date ("d.m.Y", filemtime($filename))." um ".date("H:i:s", filemtime($filename))." Uhr.";

	echo "<br />";
	echo "<br />";

?>
</div>
