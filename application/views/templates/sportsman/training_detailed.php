<div class="col-sm-9">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo('<b>'.$source_param[0]['name1'].' '.$source_param[0]['name2'].'</b>, ID='.$source_param[0]['sportsman_id'].', OR='.$source_param[0]['overall_rating']);?></h3>
            </div>
            <div class="panel-body">
<?php  print($menu); ?>
<table class="table-striped table-bordered table-condensed ">
    <tr style="font-weight:bold;text-align:center;">
        <td colspan=6>Training log</td>
    </tr>	
    <tr style="font-weight:bold;text-align:center;">
        <td>Season</td>
				<td>Day</td>
				<td>Training</td>
				<td>Old Value</td>
				<td>Delta</td>
				<td>New Value</td>
    </tr>
<?php 
$i = 0;
//print("<pre>");
//print_r($source_param);
//print_r($training_log);
//print("</pre>");
$training_type=array();

//chart param

				$sql = "SELECT * FROM `rsm_live` WHERE `id` = 1";
				$res=mysql_query($sql) or die(mysql_error());
				While ($data = mysql_fetch_row($res))
				{
								$current_day=$data[1];
				}

$chart_day_start = 0;
$chart_day_end = $current_day;
$chart_day_diap = $chart_day_end - $chart_day_start;

//start param


$chart[1][0] = $source_param[0]['phys_strength'];
$chart[2][0] = $source_param[0]['phys_endur'];
$chart[3][0] = $source_param[0]['shoot_tech'];
$chart[4][0] = $source_param[0]['shoot_calm'];
$chart[5][0] = $source_param[0]['shoot_acc'];
$chart[6][0] = $source_param[0]['track_tech'];
$chart[7][0] = $source_param[0]['track_spd'];

for ($i=1; $i<=7; $i++) {
	$ch_start[$i] = $chart[$i];
	//print("TR TYPE=".$i."=".$chart[$i]."<br>");
}

$i = 0;

if (empty($training_log)) {echo('Please select player of your team');}
else {
	$total_training = count($training_log); //было X тренировок - Х+1 сегментов
	
	
	for ($j=1;$j<=7;$j++){
		$sql = "SELECT SUM(delta_value) FROM `rsm_sportsman_training_log` WHERE `sportsman_id` = ".$source_param[0]['sportsman_id']." AND `training_type` = ".$j." ";
		//print($sql);
		$query = $this->db->query($sql);
		$query=$query->result_array();
		//print_r($query);
		//echo("CH=".$chart[$j]." ");
		$chart[$j][0] = $chart[$j][0] - $query[0]['SUM(delta_value)'];
		//echo("SUM=".($query[0]['SUM(delta_value)'])." ".$chart[$j][0]."<br>");
		
		
		$sql = "SELECT * FROM `rsm_sportsman_training_log` WHERE `day_id` <= ".$chart_day_end." AND `sportsman_id` = ".$source_param[0]['sportsman_id']." AND `training_type` = ".$j." ";
		$query = $this->db->query($sql);
		$train_param = $query->result_array();

		foreach ($train_param as $temp){
			$training_data[$source_param[0]['sportsman_id']][$j][$temp['day_id']]=$temp['new_value'];
			//print($temp['day_id']);
		}
		$chart_data[$j] = $chart[$j][0];
	}
	
	 //print_r($chart_data);
	
	for ($k=1;$k<=$chart_day_diap;$k++) {
		for ($j=1;$j<=7;$j++){
			if (isset($training_data[$source_param[0]['sportsman_id']][$j][$k])){
				//echo("TR TYPE=".$j." DAY=".$k." ".$training_data[$source_param[0]['sportsman_id']][$j][$k]."<br>");
				$chart[$j][$k] = $training_data[$source_param[0]['sportsman_id']][$j][$k];
			}
			else {
				$chart[$j][$k] = $chart[$j][$k-1];
			}
			$chart_data[$j] .= ', ' .$chart[$j][$k];
		}
	}
	//print("<pre>");
	//print_r($chart_data);
	//print("</pre>");

	foreach($training_log as $string)
		{
			echo('<tr>');
			$string=(array)$training_log[$i];
			print('<td align=center>'.$string['season_id'].'</td>');
			print('<td align=center>'.$string['day_num'].'</td>');
			print('<td align=center>'.$string['description'].'</td>');
			print('<td align=center>'.$string['old_value'].'</td>');
			print('<td align=center>'.$string['delta_value'].'</td>');
			print('<td align=center>'.$string['new_value'].'</td>');
			$i++;
			echo('</tr>');
		}
}

?>


  
</table><br>
  <div id="chart"></div>
  <script>
  var chart = c3.generate({
    bindto: '#chart',
    data: {
      columns: [
        ['Physic strength', <?php  echo($chart_data[1]);?> ],
				['Physic endurance', <?php  echo($chart_data[2]);?>],
				['Shoot technique', <?php  echo($chart_data[3]);?>],
				['Shoot calm', <?php  echo($chart_data[4]);?>],
				['Shoot accuracy', <?php  echo($chart_data[5]);?>],
				['Track technique', <?php  echo($chart_data[6]);?>],
				['Track speed', <?php  echo($chart_data[7]);?>],
      ]
			
    },
		size: {
			width: 400
		}

});
</script>