
<?php 
$i = 0;
//print_r($player);

foreach($player as $string)
{
    $string=(array)$player[$i];
		
		switch ($string['scout_status']) {
							case 0:
								$string['scout_status'] = '<font color="red">NO</font>&nbsp;&nbsp;&nbsp;<a href="/player/scout/'.$string['sportsman_id'].'"><img src="/images/player/scout.gif" ALT = "Scout Player"></a>';
								break;
							case 1:
								$string['scout_status'] = '<font color="green">YES</font>';
								break;
							default:
                $string['scout_status'] = 'NO';
		}
		
    switch ($string['popularity']) {
                  case 0:
                      $pop_img="/images/pop/0.gif";
                      break;
                  case 1:
                      $pop_img="/images/pop/1.gif";
                      break;
                  case 2:
                      $pop_img="/images/pop/2.gif";
                      break;
                  case 3:
                      $pop_img="/images/pop/3.gif";
                      break;
                  case 4:
                      $pop_img="/images/pop/4.gif";
                      break;
                  case 5:
                      $pop_img="/images/pop/5.gif";
                      break; 
                  case 6:
                      $pop_img="/images/pop/6.gif";
                      break;
                  case 7:
                      $pop_img="/images/pop/7.gif";
                      break;
                  case 8:
                      $pop_img="/images/pop/8.gif";
                      break;
                  case 9:
                      $pop_img="/images/pop/9.gif";
                      break;
                  case 10:
                      $pop_img="/images/pop/10.gif";
                      break;
                  default:
                     $pop_img="img/pop/0.gif";
              }
						
		
		?><div class="col-sm-9">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo('<b>'.$string['name1'].' '.$string['name2'].'</b>, ID='.$string['sportsman_id'].', OR='.$string['overall_rating']);?></a></h3>
            </div>
            <div class="panel-body">
<?php  print($menu); ?>
<table class="table-striped table-bordered table-condensed ">

	  <tr style="font-weight:bold;text-algin:center;">
			<td colspan=5 align=center><?php echo('<img src=/images/flag/'.$string['logo'].'>  <b>'.$string['name1'].' '.$string['name2'].', '.$string['team_name'].'</b>');?></td>
		</tr>
		<tr style="font-weight:bold;text-algin:center;">
			<td colspan=2 align=center><?php echo('Attribute');?></td>
			<td align=center><?php echo('Talent');?></td>
			<td colspan=2 align=center><?php echo('Other');?></td>
		</tr>
		<tr style="text-algin:center;">
        <td>STR</td>
        <td><?php echo($string['phys_strength']);?></td>
        <td align=center><?php echo($string['phys_strength_mvu']);?></td>
        <td>Age</td>
        <td><?php echo($string['age']);?></td>   
    </tr>
		<tr style="text-algin:center;">
        <td>END</td>
        <td><?php echo($string['phys_endur']);?></td>
        <td align=center><?php echo($string['phys_endur_mvu']);?></td>
        <td>Career</td>
        <td>?</td>   
    </tr>
		<tr style="text-algin:center;">
        <td>SH TECH</td>
        <td><?php echo($string['shoot_tech']);?></td>
        <td align=center><?php echo($string['shoot_tech_mvu']);?></td>
        <td>Professionalism</td> 
        <td><?php echo($string['sportsman_prof']);?></td>   
    </tr>	
		<tr style="text-algin:center;">
        <td>SH CALM</td>
        <td><?php echo($string['shoot_calm']);?></td>
        <td align=center><?php echo($string['shoot_calm_mvu']);?></td>
        <td>Scouted</td>
        <td><?php echo($string['scout_status']);?></td>   
    </tr>
		<tr style="text-algin:center;">
        <td>SH ACC</td>
        <td><?php echo($string['shoot_acc']);?></td>
        <td align=center><?php echo($string['shoot_acc_mvu']);?></td>
        <td>History</td>
        <td><a href="/player/history/<?php echo($string['sportsman_id']);?>">History</a></td>   
    </tr>
		<tr style="text-algin:center;">
        <td>TR TECH</td>
        <td><?php echo($string['track_tech']);?></td>
        <td align=center><?php echo($string['track_tech_mvu']);?></td>
        <td>Salary</td>
        <td><?php echo($string['salary']);?></td>   
    </tr>
		<tr style="text-algin:center;">
        <td>SPEED</td>
        <td><?php echo($string['track_spd']);?></td>
        <td align=center><?php echo($string['track_speed_mvu']);?></td>
        <td>POP</td>
        <td><img src="<?php echo($pop_img);?>"></td>   
    </tr>
	
<?php 

    $i++;
    ?>
		</tr><?php 
}
?>
</table>
