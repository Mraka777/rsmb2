<?php
$string=(array)$race_info[0];
//print_r($string);
?><div class="col-sm-9">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Race #<?php echo($string['race_id']); ?> on <?php echo($string['name_en']); ?> | Weather:
      <?php
      //print_r($race_weather);
      foreach($race_weather as $weather) {
        //echo("<img src=\"/images/track/weather/snow_g.png\" height=\"50\" width=\"50\">");
        echo("".$weather['temperature']." ºC | ");
        //echo("<img src=\"/images/track/weather/wind_g.png\" height=\"50\" width=\"50\">");
        echo("".$weather['wind_speed']." m/s");
      }
      
      
      ?></h3>
  </div>
  <div class="panel-body">
    <!-- race start data 
    <table class="table-striped table-bordered table-condensed">
    <tr style="font-weight:bold;text-algin:center;">
      <td colspan=4><?php //echo($string['mode']); ?></td>
    </tr>
    <tr style="font-weight:bold;text-algin:center;">
      <td>#</td>
      <td>Name</td>
      <td>Team</td>
      <td>OR</td>
    </tr>
       <?php
        
        $i=0;
        foreach($race_sportsman_list as $sportsman_list)
        {
        echo("<tr><td>".$sportsman_list['sportsman_id']."</td><td><img src=\"/images/flag/".$sportsman_list['logo']."\">  <a href=\"/player/view/".$sportsman_list['sportsman_id']."\">".$sportsman_list['name1']." ".$sportsman_list['name2']."</a></td><td>".$sportsman_list['team_name']."</td><td>".$sportsman_list['overall_rating']."</td></tr>");
        $i++;
        }
        
        
        ?>
    </table> 
  end start data -->
  <p class="lead">Race results <a href="/race/view/1">Watch race</a></p>
  
  <div ><!-- style="overflow-y: scroll;    height: 250px;" -->
  <table class="table-striped table-bordered table-condensed">
    <tr>
      <td colspan="8">
      </td>
    </tr>
    <tr>
      <td>Place</td>
      <td>Name</td>
      <td>Team</td>
      <td>Result</td>
      <td>Deficit</td>
      <td>Shooting</td>
      <td>Total</td>
      <td>Points</td>
    </tr>
    <?php
    //echo("<pre>");
    //print_r($race_result_shooting);
    //echo("</pre>");
    //echo('ZZZ'.$race_result_shooting[0]['race_points'].'XXX<br>');
    $i=0;  
    foreach ($race_result as $key => $value) {
      $time=$value['time']/60;
      $minutes=floor($time);
      $hours=floor($minutes/60);
      $minutes=$minutes-$hours*60;
      $seconds=floor(($time-$hours*60-$minutes)*60);
      $mlseconds=round(($value['time']-$hours*60*60-$minutes*60-$seconds)*100,2);
      
      $result[$i]=$value['time'];$delta[$i]=0;
      if ($i>0) {
        
        $delta[$i]=$result[$i]-$result[0];
      }
      
      $time_delta=$delta[$i]/60;
      $minutes_delta=floor($time_delta);
      $hours_delta=floor($minutes_delta/60);
      $minutes_delta=$minutes_delta-$hours_delta*60;
      $seconds_delta=floor(($time_delta-$hours_delta*60-$minutes_delta)*60);
      $mlseconds_delta=round(($delta[$i]-$hours_delta*60*60-$minutes_delta*60-$seconds_delta)*100,2);
      
      
      
      echo '<tr style="font-weight:bold;text-algin:center;">';
      echo '<td>'.($i+1).'';
      echo '<td><img src=/images/flag/'.$value['logo'].'> '.$value['name1'].' '.$value['name2'].' id='.$value['sportsman_id'].'</td>';
      echo '<td>'.$value['team_name'].'</td>';
      echo '<td>'.$hours.':'.$minutes.':'.$seconds.','.$mlseconds.'</td>';
      //echo '<td>'.$delta[$i].'</td>';
      echo '<td>+ '.$hours_delta.':'.$minutes_delta.':'.$seconds_delta.','.$mlseconds_delta.'</td>';
      echo '<td>'.$race_result_shooting[$i]['race_shots_stand'].' + '.$race_result_shooting[$i]['race_shots_lay'].'</td>';
      echo '<td>'.$race_result_shooting[$i]['race_shots_missed'].'</td>';
      echo '<td>'.$race_result_shooting[$i]['race_points'].'</td>';
      echo '</tr>';
      $i++;
      }
    ?>
  </table>
  </div>

