<div class="col-sm-9">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo('<b>Infrastructure</b>');?></a></h3>
            </div>
            <div class="panel-body">

<table class="table-striped table-bordered table-condensed ">
    <tr style="font-weight:bold;text-algin:center;">
        <td colspan=2>Build new facility</td>
    </tr>	
<?php 
$i = 0;
//print_r($balance);
//echo($balance[0]['rsm_team_balance_current']);
foreach($stadium as $string)
{?><tr><?php 

	  $string=(array)$stadium[$i];
		echo form_open('infrastructure/build_stadium/'.$string['rsm_stadium_building_level_id']); //Form 4 stadium build save
		echo('<input type="hidden" name="building_level_id" value="'.$string['rsm_stadium_building_level_id'].'">');
		print('<tr><td>Type:</td><td align=center>'.$string['stadium_building_description'].'</td></tr>');
		print('<tr><td>Level:</td><td align=center>'.$string['stadium_building_level'].'</td></tr>');
		print('<tr><td>Cost:</td><td align=center>'.(number_format($string['building_cost'], 0, ',', ' ' )).'</td></tr>');
		echo('<input type="hidden" name="cost" value="'.$string['building_cost'].'">');
		print('<tr><td>Days:</td><td align=center>'.$string['stadium_building_build_days'].'</td></tr>');
    if ($balance[0]['rsm_team_balance_current']>$string['building_cost']){
			print('<tr><td colspan=2><p align=\'center\'><button type=\'submit\' name=\'send\'>Build!</button></p></td></tr>');
		}
		else {
			print('<tr><td colspan=2 align=center><b>Not enough money!</b></td></tr>');
		}
		$i++;
    ?></tr><?php 
}

//$array = (array)$query[0];
//print($array['name1']);
//print($array['name2']);
//print_r($array);

?>
  
</table>
<?php  		echo form_close(); ?>