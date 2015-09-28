<?php
echo form_open('race'); //Form 4 sportsman2race choice
?>

<br><table class="table-striped table-bordered table-condensed">
  <tr style="font-weight:bold;text-algin:center;">
      <td>Make your choice for race</td>
  </tr>
  <tr style="font-weight:bold;text-algin:center;"><td>
<?php  echo('<select name="'.$current_choice[0]['rsm_race_sportsman_list_id'].'">');
      
      print_r($race_team_full_list);

//print_r($current_choice);
//echo('==='.$current_choice[0]['sportsman_id']);
$i=0;
foreach($sportsman_list as $string) {
    $string=(array)$sportsman_list[$i];
    
    echo('<option value='.$string['sportsman_id']);
    if ($string['sportsman_id'] == $current_choice[0]['sportsman_id']) echo (' selected');

    echo('>'.$string['name1'].' '.$string['name2'].' '.$string['overall_rating']);
    $i++;
    }
    ?>
    </select>
    </td></tr>
  <tr style="font-weight:bold;text-algin:center;"><td>
<?php  echo('<select name="'.$current_choice[1]['rsm_race_sportsman_list_id'].'">');
$i=0;
foreach($sportsman_list as $string) {
    $string=(array)$sportsman_list[$i];
    
    echo('<option value='.$string['sportsman_id']);
    if ($string['sportsman_id'] == $current_choice[1]['sportsman_id']) echo (' selected');
    echo('>'.$string['name1'].' '.$string['name2'].' '.$string['overall_rating']);
    $i++;
    }
    ?>
    </select>
    </td></tr>
  <tr style="font-weight:bold;text-algin:center;"><td>
<?php  echo('<select name="'.$current_choice[2]['rsm_race_sportsman_list_id'].'">');
$i=0;
foreach($sportsman_list as $string) {
    $string=(array)$sportsman_list[$i];
    
     //print_r($string);
    //echo($string['sportsman_id']);   
    echo('<option value='.$string['sportsman_id']);
    if ($string['sportsman_id'] == $current_choice[2]['sportsman_id']) echo (' selected');
    echo('>'.$string['name1'].' '.$string['name2'].' '.$string['overall_rating']);
    $i++;
    }
    ?>
    </select>
    </td></tr>
  <tr style="font-weight:bold;text-algin:center;">
      <td><button type='submit' name='send'>Save choice</button></td>
  </tr>
</table> 
<?php 		echo form_close(); ?>