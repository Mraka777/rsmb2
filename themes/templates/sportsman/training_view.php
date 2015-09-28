<div class="col-sm-9">
          <div class="panel panel-default">
            <div class="panel-heading">
							<table width=100%>
								<tr>
									<td align="left"><b>Training overview</b></td>
									<td align="right"><a href=""><img src="/images/menu/icon_help.gif" height="32" width="32"></a></td>
								</tr>
							</table>
            </div>
            <div class="panel-body">
<div>
	
</div>
<?php  //print($url);?>
<?php  echo form_open('player/training/'); //Form 4 training save?>
<p align='right'><button type='submit' name='send' class='btn btn-success btn-sm'>Save practice</button></p>

<table class="table-striped table-bordered table-condensed ">
    <tr style="font-weight:bold;text-algin:center;">
        <td colspan=12>Sportsman list</td>
    </tr>	
    <tr style="font-weight:bold;text-align:center;">
        <td>Team #</td>
        <td>Name</td>
        <td>Age</td>
        <td>STR</td>
        <td>ENDUR</td>
        <td>SH TECH</td>
        <td>SH CALM</td>
        <td>SH ACC</td>
        <td>TR TECH</td>
				<td>TR SPEED</td>
				<td>PROGR</td>				
				<td>CUR TRAIN</td>
    </tr>

<?php 
$i = 0;
//print_r($team_practice);
foreach($team_practice as $string)
{?><tr><?php 

	    $string=(array)$team_practice[$i];
  

		//if(!isset($training_type['last_training'])) $string['last_training']='n/a';
    print('<td align=center>'.$string['team_num'].'</td>');
		print('<td align=left><a href="/player/view/'.$string['sportsman_id'].'"><img src=/images/flag/'.$string['logo'].'> '.$string['name1'].' '.$string['name2'].'</a></td>');
		print('<td align=center>'.$string['age'].'</td>');
		print('<td align=center>'.$string['phys_strength'].'</td>');
		print('<td align=center>'.$string['phys_endur'].'</td>');
		print('<td align=center>'.$string['shoot_tech'].'</td>');
		print('<td align=center>'.$string['shoot_calm'].'</td>');		
		print('<td align=center>'.$string['shoot_acc'].'</td>');
		print('<td align=center>'.$string['track_tech'].'</td>');
		print('<td align=center>'.$string['track_spd'].'</td>');
		print('<td align=center><a href=/player/training_details/'.$string['sportsman_id'].'>'.$string['last_training'].'</a></td>');
		//print('<td align=center>'.$string['parametr'].'</td>');
		$training_selected=array('','','','','','','','');
		$training_selected[$string['rsm_sportsman_training_type_id']]=' selected';
		//print_r($training_selected);
		//$training_selected[$string['$rsm_sportsman_training_type_id']]='selected';
		//echo($training_selected[$string['$rsm_sportsman_training_type_id']]);
		echo('<td align=center>');//.$string['parametr']
		//rsm_sportsman_training_type_id //
		echo('<select name="'.$string['sportsman_id'].'">
				 <option'.$training_selected[1].' value="1">phys_strength</option>
				 <option'.$training_selected[2].' value="2">phys_endur</option>
				 <option'.$training_selected[3].' value="3">shoot_tech</option>
				 <option'.$training_selected[4].' value="4">shoot_calm</option>
				 <option'.$training_selected[5].' value="5">shoot_acc</option>
				 <option'.$training_selected[6].' value="6">track_tech</option>
				 <option'.$training_selected[7].' value="7">track_spd</option>
				</select>');
		echo('</td>');
    $i++;

    ?></tr><?php 
}

//$array = (array)$query[0];
//print($array['name1']);
//print($array['name2']);
//print_r($array);

?>
  
</table>
<br>
<p align='right'><button type='submit' name='send' class='btn btn-success btn-sm'>Save practice</button></p>
<?php  		echo form_close(); ?>
