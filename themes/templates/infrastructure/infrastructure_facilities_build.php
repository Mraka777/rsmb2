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
//print_r($infrastructure);
foreach($infrastructure as $string)
{?><tr><?php 

	  $string=(array)$infrastructure[$i];
		echo form_open('infrastructure/build_facility/'.$string['building_level_id']); //Form 4 facility build save
		echo('<input type="hidden" name="Building_level_id" value="'.$string['building_level_id'].'">');
		print('<tr><td>Type:</td><td align=center>'.$string['building_descr'].'</td></tr>');
		print('<tr><td>Level:</td><td align=center>'.$string['building_level'].'</td></tr>');
		echo('<input type="hidden" name="cost" value="'.$string['building_cost'].'">');
		print('<tr><td>Cost:</td><td align=center>'.$string['building_cost'].'</td></tr>');
		print('<tr><td>Days:</td><td align=center>'.$string['build_days'].'</td></tr>');
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