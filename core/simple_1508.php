<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
global $bir;

require_once('base.php');


$race_day=htmlspecialchars($_GET["race"]);
for ($z=1;$z<=2;$z++){ //количество гонок 42
  $total_points=array();
  $race_id = $race_day + ($z-1)*16;
  $sql_check='SELECT * FROM `rsm_logr` WHERE `race_id` = '.$race_id;
  //echo($sql_check);
  $check=mysql_num_rows(mysql_query($sql_check));
  $sql_delete_race_log='DELETE FROM rsm_logr WHERE race_id = '.$race_id;
  if ($check > 1) { mysql_query($sql_delete_race_log);}
  
  $sql_check='SELECT * FROM `rsm_logs` WHERE `race_id` = '.$race_id;
  //echo($sql_check);
  $check=mysql_num_rows(mysql_query($sql_check));
  $sql_delete_race_log='DELETE FROM rsm_logs WHERE race_id = '.$race_id;
  if ($check > 1) { mysql_query($sql_delete_race_log);}


  $sql = "SELECT day_id FROM `rsm_race` WHERE `race_id` = ".$race_id." ";
  $result = mysql_query($sql) or die(mysql_error());
  while ($day_race = mysql_fetch_assoc($result)) {
    $delete_day=$day_race['day_id'];
    }

  $sql = "SELECT team_id FROM `rsm_race_team_list` WHERE `race_id` = ".$race_id." ";
  $result = mysql_query($sql) or die(mysql_error());
  while ($team_race = mysql_fetch_assoc($result)) {
    $sql = "DELETE FROM `cp308402_bm`.`rsm_team_basic_rating_log` WHERE team_id = ".$team_race['team_id']." AND day_id = ".$delete_day." ";
    //print($sql."<br>");
    mysql_query($sql);
    //print($team_race['team_id']."<br>");

  }
  
  
  //Глобальные параметры
  $race_circuit_length=3000; //длина круга в метрах
  $race_penalty_circuit_length=150; //длина штрафного круга
  $race_mark=500; //отметка на которой смотрим результат в метрах
  $lap_total=5; //количество кругов в гонке
  
  $global['limit_technique']=50; //отсечка значения  техники
  $global['technique_inc']=0.05; //Положительное влияние техники на прямой
  $global['technique_dec']=0.1;  //Отрицательное влияние техники на прямой
  
  $global['limit_strength']=50; //отсечка значения силы
  $global['strength_inc']=0.01; //Положительное влияние силы на прямой
  $global['strength_dec']=0.05; //Отрицательное влияние силы на прямой
  
  $global['positioning_technique']=0.7;//влияние техники СТРЕЛЬБЫ на изготовку
  $global['positioning_calm']=0.3;//влияние хладнокровия на изготовку
  $global['positioning_min']=15;//мин 15 сек изготовка
  $global['positioning_max']=25;
  
  $global['shooting_fires']=5;
  $global['shooting_stand']=2;
  $global['shooting_lay']=2;
  $global['shooting_total']=4;
  $global['shooting_accuracy']=0.9;
  $global['shooting_technique']=0.1;
  
  $global['weight']=70; //пока вес статичен для всех :)
  
  echo('************************************************************<br>');
  echo('Track #'.$race_id.'<br>');
  echo('************************************************************<br>');
  
  //Математика отметок
  
  $race_mark_qt=$race_circuit_length/$race_mark;
  for($j=1; $j<=5; $j++) {
    for ($k=1; $k<=6; $k++)  {
      $race_marks[$j][$k]=500*$k;
      //echo('Отметки. Круг #'.$j.' '.$race_marks[$j][$k].'<br>');
    }
  
  }
  
  //Weather start
  $sql_weather_forecast = "SELECT * FROM `rsm_race_weather_forecast` WHERE `rsm_race_id` = $race_id";
  //echo($sql_weather);
  $weather_forecast_res=mysql_query($sql_weather_forecast) or die(mysql_error());
  
  While ($weather_forecast = mysql_fetch_assoc($weather_forecast_res))
  {
    //echo("Temp=".$weather_forecast['temperature']."<br>");
    //echo("Wind type=".$weather_forecast['wind_type']."<br>");
    //echo("Wind_speed=".$weather_forecast['wind_speed']."<br>");
    //echo("Fog_type=".$weather_forecast['fog_type']."<br>");
    //echo("Sun_type=".$weather_forecast['sun_type']."<br>");
    //echo("Rain_type=".$weather_forecast['rain_type']."<br>");
    //echo("Snow_type=".$weather_forecast['snow_type']."<br>");
    //echo("Humidity=".$weather_forecast['humidity']."<br>");
    //delete if exist
    $sql_weather_delete = "DELETE FROM `rsm_race_weather` WHERE `rsm_race_id` = ".$race_id."";
    mysql_query($sql_weather_delete);
    //randomize weather
    $new_temperature=$weather_forecast['temperature'];
    $new_wind_type=$weather_forecast['wind_type'];
    $new_wind_speed=$weather_forecast['wind_speed'];
    $new_fog_type=$weather_forecast['fog_type'];
    $new_sun_type=$weather_forecast['sun_type'];
    $new_rain_type=$weather_forecast['rain_type'];
    $new_snow_type=$weather_forecast['snow_type'];
    $new_humidity=$weather_forecast['humidity'];
    //insert weather
    $sql_weather_insert = "INSERT INTO `rsm_race_weather` (`rsm_race_weather_id`, `rsm_race_id`, `rsm_race_weather_forecast_id`, `temperature`, `wind_type`, `wind_speed`, `fog_type`, `sun_type`, `rain_type`, `snow_type`, `humidity`) VALUES (NULL, '".$race_id."', '".$weather_forecast['rsm_race_weather_forecast_id']."', '".$new_temperature."', '".$new_wind_type."', '".$new_wind_speed."', '".$new_fog_type."', '".$new_sun_type."', '".$new_rain_type."', '".$new_snow_type."', '".$new_humidity."');";
    //echo($sql_weather_insert);
    mysql_query($sql_weather_insert);
  }
  echo('************************************************************<br>');
  //Weather influence
  $weather_k=0.03;
  $weather_max=7;
  $weather_optimum=-2;
  $weather_min=-16;
  $weather_delta_plus=9;
  $weather_delta_minus=14;
  
  if ($new_temperature>=0) {
    //echo ("+++++<br>");
    $weather_total=round(($weather_k*($new_temperature-$weather_optimum)/$weather_delta_plus),3);
    //echo("K_weather=".$weather_total."<br>");
  }
  else {
    //echo("-------<br>");
    $weather_total=round(($weather_k*(abs($new_temperature-$weather_optimum))/$weather_delta_minus),3);
    //echo("K_weather=".$weather_total."<br>");
  }
  
  $weather_total=(1-$weather_total);
  //echo("K_weather=".$weather_total."<br>");
  
  //End weather influence
  //Weather end
  echo('************************************************************<br>');
  $jj=0;
  $sql = "SELECT `track_type`, `track_tech` FROM `rsm_track` WHERE `track_id` = $race_id";
  //echo($sql);
  $res=mysql_query($sql) or die(mysql_error());
  While ($track = mysql_fetch_row($res))
  {
    switch ($track[0]) {
      case 1:
          $track_type=1;
          $track_type_name='Plain';
          $track_plain=0.6;
          $track_rise=0.2;
          $track_descent=0.2;
          break;
      case 2:
          $track_type=2;
          $track_type_name='Hills';
          $track_plain=0.2;
          $track_rise=0.4;
          $track_descent=0.4;
          break;
      case 3:
          $track_type=3;
          $track_type_name='Mixed';
          $track_plain=0.4;
          $track_rise=0.3;
          $track_descent=0.3;
          break;
    }
    
  }
  //echo('************************************************************<br>');
  echo('Track '.$track_type_name.'<br>');
  //echo('************************************************************<br>');
  
  $penalty='';
  
  $sql = 'SELECT * FROM `rsm_race_sportsman_list`
  LEFT OUTER JOIN rsm_sportsman ON rsm_race_sportsman_list.sportsman_id = rsm_sportsman.sportsman_id
  LEFT OUTER JOIN rsm_team ON rsm_sportsman.team_id = rsm_team.team_id
  LEFT OUTER JOIN rsm_country ON rsm_sportsman.country_id = rsm_country.country_id
  WHERE race_id='.$race_id.' ';//LIMIT 0, 3
  
  $res=mysql_query($sql) or die(mysql_error());
  //echo($sql);
    While ($b_data = mysql_fetch_array($res))
      {//наполняем массив
        $penalty_time[$i]=array();
        //$b_data['phys_energy']=$b_data['phys_energy']/10;
        $b_data['phys_strength']=$b_data['phys_strength'];
        $b_data['phys_endur']=$b_data['phys_endur'];
        $b_data['shoot_tech']=$b_data['shoot_tech']/10;
        $b_data['shoot_acc']=$b_data['shoot_acc']/10;
        $b_data['shoot_calm']=$b_data['shoot_calm']/10;
        $b_data['track_tech']=$b_data['track_tech'];
        $b_data['track_spd']=$b_data['track_spd'];
        //$penalty=0;
        //$b_data[$b_data['sportsman_id']]['shooting']=array();
      //добавляем состояние
        //echo('************************************************************<br>');
        //echo('*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //     Sportsman_id '.$b_data['sportsman_id'].' '.$b_data['name1'].' '.$b_data['name2'].'<br>');
        //echo('************************************************************<br>');
        //echo('<b>Shooting</b><br>');
        $i=1; $j=1;
        for($i=1; $i<=$global['shooting_total']; $i++) {
        //echo('<b>Lap '.$i.'</b><br>');
          for($j=1; $j<=$global['shooting_fires']; $j++) {
            // echo('Shot '.$j.'<br>');
            $var=rand(0,100);
            $shooting_acc=$b_data['shoot_tech']*$global['shooting_technique']+$b_data['shoot_acc']*$global['shooting_accuracy'];
            //echo("SH_ACC=".$b_data['shoot_tech']."<br>");
            if ($var<$shooting_acc) {  //записываем в массив лога стрельбы попал или нет - $bir[$bid]['shooting_log'][$lap][$shoot_num]
              $sql_shot_insert = 'INSERT INTO `rsm_logs` (`logs_id`, `race_id`, `sportsman_id`, `lap`, `shot`, `res`) VALUES (NULL, '.$race_id.', '.$b_data['sportsman_id'].', '.$i.', '.$j.', 1)';
              mysql_query($sql_shot_insert);
              //echo('1 '); //Попадание
            } 
            else {
              $sql_shot_insert = 'INSERT INTO `rsm_logs` (`logs_id`, `race_id`, `sportsman_id`, `lap`, `shot`, `res`) VALUES (NULL, '.$race_id.', '.$b_data['sportsman_id'].', '.$i.', '.$j.', 0)';
              mysql_query($sql_shot_insert);
              $penalty[$i]=$penalty[$i]+1;
              $misses=$misses+1;
              if (($i=='1') or ($i=='3')) {
                $misses_lay=$misses_lay+1;
                //echo('LAY MISS<br>');
              }
              else $misses_stand=$misses_stand+1;
              //echo($penalty[$i]);
              //echo('0 '); //Промах
            }
            
          }
          //echo('Total miss 1='.$misses_lay);
          //echo('|');
        }
        echo('<br>');
     //print_r($penalty);echo('<br>');
     //echo('************************************************************<br>');
     if (!isset($misses)) $misses=0;
     if (!isset($misses_lay)) $misses_lay=0;
     if (!isset($misses_stand)) $misses_stand=0;
     
     //echo('MISSES='.$misses);echo('<br>');
     //echo('MISSES_LAY='.$misses_lay);echo('<br>');
     //echo('MISSES_STAND='.$misses_stand);echo('<br>');
     $sql = 'UPDATE `rsm_race_sportsman_list` SET `race_shots_missed` = '.$misses.', `race_shots_stand` = '.$misses_stand.', `race_shots_lay` = '.$misses_lay.' WHERE `sportsman_id` = '.$b_data['sportsman_id'].' AND `race_id` = '.$race_id.' ';
     mysql_query($sql);
     //echo($sql.'<br>');
      //echo('************************************************************<br>'); 
      //time 4 shooting
  
        $positioning_k=($b_data['shoot_tech']*0.6+$b_data['shoot_calm']*0.3+$b_data['phys_endur']*0.1)/100;         
        //echo('POS K='.$positioning_k.'<br>');
        $positioning_time=$global['positioning_min']+($global['positioning_max']-$global['positioning_min'])*(1-$positioning_k);
        $positioning_time=round($positioning_time,2); //КОСТЫЛЬ 
        //echo('POS TIME='.$positioning_time.'<br>');
  
   
        //echo('************************************************************<br>'); 
      
  
        $kd_min=4;  $kd_max=8;  $kd_technique=0.5;  $kd_calm=0.5;    //влияние параметров на КД, начало просчета КД
        $kd_k=$b_data['shoot_tech']*$kd_technique+$b_data['shoot_calm']*$kd_calm;
        $kd_time=$kd_min+($kd_max-$kd_min)*(1-$kd_k/100);  
        //echo('KD TIME='.$kd_time.'<br>');
      
      //echo('************************************************************<br>');    
          
      //Technician influence
      $sql_select_technician = "SELECT * FROM `rsm_staff` WHERE `rsm_staff_type_id` = 4 AND `team_id` = ".$b_data['team_id']." AND `staff_status` = 1 ORDER BY `rsm_staff_type_id` ASC";
      mysql_query($sql_select_technician);
      $res_select_technician=mysql_query($sql_select_technician) or die(mysql_error());
      While ($technichian = mysql_fetch_array($res_select_technician)) {
      $main_skill = $technichian['skill1'];
      $second_skill = $technichian['skill2'];
      //echo($main_skill.'<br>');
      //echo($second_skill.'<br>');
      }
      //0.00027*(x+1)^2 - левая половина оочень близко 
      //End technician influence
      
      //Speed start
      //speed constants for plain
      $Vmax=26;
      $Vmin=14;
      $Vdelta=12;
      //speed constants for up
      $Vup=0.5;
      $Vupmax=13;
      $Vupmin=7;
      $Vupdelta=6;
      //speed constants for down
      $Vdown=1.5;
      $Vdownmax=39;
      $Vdownmin=21;
      $Vdowndelta=18;
      //Constants for speed
      $Kv_plain=83;
      $Kv_up=142;
      $Kv_down=50;
      //end of speed constants 
      //parameters start
      //plain
      $phys_strength_plain=0;
      $phys_endurance_plain=0;
      $track_speed_plain=0.95;
      $track_tech_plain=0.05;
      //up
      $phys_strength_up=0.4;
      $phys_endurance_up=0.4;
      $track_speed_up=0.1;
      $track_tech_up=0.1;
      //down
      $phys_strength_down=0.05;
      $phys_endurance_down=0;
      $track_speed_down=0.45;
      $track_tech_down=0.5;
      //parameters end
      $sportsman_speed_plain=round(($Vmin+($track_speed_plain*$b_data['track_spd']+$track_tech_plain*$b_data['track_tech'])/$Kv_plain),3);
      //echo("Speed_plain=".$sportsman_speed_plain."<br>");
      $sportsman_speed_up=round(($Vupmin+($phys_strength_up*$b_data['phys_strength']+$phys_endurance_up*$b_data['phys_endur']+$track_speed_up*$b_data['track_spd']+$track_tech_up*$b_data['track_tech'])/$Kv_up),3);
      //echo("Speed_up=".$sportsman_speed_up."<br>");
      $sportsman_speed_down=round(($Vdownmin+($phys_strength_down*$b_data['phys_strength']+$phys_endurance_down*$b_data['phys_endur']+$track_speed_down*$b_data['track_spd']+$track_tech_down*$b_data['track_tech'])/$Kv_down),3);
      //echo("Speed_down=".$sportsman_speed_down."<br>");
      
      $speed_result = $sportsman_speed_plain*$track_plain+$sportsman_speed_up*$track_rise+$sportsman_speed_down*$track_descent;
      //add weather influence
      //echo("Speed_result= ".$speed_result."<br>");
      $speed_result=$weather_total*$speed_result;
      //echo("Speed_result + weather = ".$speed_result."<br>");
      //$speed_result = 1;
      
      //echo('SPD SRC='.$b_data['track_spd'].' SPD_Total='.$speed_result.' Km/h <br>');
  
      //echo('SPD_RISE='.$sportsman_speed_down.' Km/h SPD_DESCENT='.$sportsman_speed_up.' Km/h <br>');
      $sql_update_top_speed = "UPDATE `rsm_race_sportsman_list` SET `top_speed` = '".$sportsman_speed_down."' WHERE `race_id` = ".$race_id." AND `sportsman_id` = ".$b_data['sportsman_id'].";";
      //echo($sql_update_top_speed."<br>");
      mysql_query($sql_update_top_speed);
      //echo('SPD_Type='.$speed_result.' Km/h <br>');
      
      $i=1;
      for($i=1; $i<=$lap_total; $i++) {
        $lap_time[$i]=round(($race_circuit_length)/(($speed_result*1000)/3600),2);
        for($j=1; $j<=6; $j++){
          $mark_time[$i][$j]=round(($lap_time[$i]/6),2);
          //echo('Mark time '.$j.' ='.$mark_time[$i][$j].' sec<br>');
        }
        //echo('Lap time '.$i.' ='.$lap_time[$i].' sec<br>');
        //echo('Penalty laps = '.$penalty[$i].'<br>');
        $penalty_time[$i]=round(($race_penalty_circuit_length*$penalty[$i])/(($speed_result*1000)/3600),2);
        //echo('Penalty time '.$i.' ='.$penalty_time[$i].' sec<br>');
        //echo('************************************************************<br>'); 
      }
      //print_r($penalty_time);
      //Запись времени в базу
      $i=1;
      for($i=1; $i<=$lap_total; $i++) {
        
        for($j=1; $j<=6; $j++){
          $mark=500*$j-500+$i*3000-3000;
          if ($mark>0){
          $sql_mark_insert = 'INSERT INTO `rsm_logr` (`logr_id`, `race_id`, `sportsman_id`, `mark`, `time`) VALUES (NULL, '.$race_id.', '.$b_data['sportsman_id'].', '.$mark.', '.$abs_time.')';
          //echo("R=".$sql_mark_insert."<br>");
          mysql_query($sql_mark_insert);
          }
          //echo($sql_mark_insert.'<br>');
          //echo('ABS-1 TIME='.$abs_time.' ');
          $abs_time=$mark_time[$i][$j]+$abs_time;
          //echo('DELTA= '.$mark_time[$i][$j].' ');
          //echo('ABS TIME= '.$abs_time.'<br>');
        }
        
        if ($i<5) {
          //echo('PEN '.$i.' TIME=  '.$penalty_time[$i].'<br>');
          $shooting_time=$positioning_time+$kd_time*4;
          //echo('SHOOT '.$i.' TIME=  '.$shooting_time.'<br>');
          //echo('AB TIME='.$abs_time.'<br>');
          
          $s_mark = 3000*$i - 1;
          $sql_mark_insert = 'INSERT INTO `rsm_logr` (`logr_id`, `race_id`, `sportsman_id`, `mark`, `time`) VALUES (NULL, '.$race_id.', '.$b_data['sportsman_id'].', '.$s_mark.', '.$abs_time.')';
          mysql_query($sql_mark_insert);
          //echo("S=".$sql_mark_insert."<br>");
          
          
          
          $abs_time=$abs_time+$penalty_time[$i]+$shooting_time;
          //echo('AB TIME NEW='.$abs_time.'<br>');
          //echo('************************************************************<br>'); 
        }
      }
      $sql_mark_insert = 'INSERT INTO `rsm_logr` (`logr_id`, `race_id`, `sportsman_id`, `mark`, `time`) VALUES (NULL, '.$race_id.', '.$b_data['sportsman_id'].', 15000, '.$abs_time.')';
      //echo($sql_mark_insert.'<br>');
      mysql_query($sql_mark_insert);
    
    
    //echo('TOTAL RACE TIME= '.$abs_time.'<br>');
    unset($abs_time);
    unset($penalty);
    unset($misses);
    unset($misses_lay);
    unset($misses_stand);
    
    }
    //echo('TOTAL RACE TIME= '.$abs_time.'<br>');
  //print_r($mark_time);
  //print_r($penalty_time);
  
  //Calculating RACE POINTS
  
  $race_points=array(1=>60, 54, 48, 43, 40, 38, 36, 34, 32, 31, 30, 29, 28, 28, 27, 27, 27, 26, 26, 26, 25, 25, 25, 24, 24, 24, 22, 21, 20, 19, 18, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1);
  
  //echo('************************************************************<br>'); 
  $sql = "SELECT * FROM `rsm_logr` LEFT OUTER JOIN rsm_sportsman ON rsm_logr.sportsman_id = rsm_sportsman.sportsman_id LEFT OUTER JOIN rsm_team ON rsm_sportsman.team_id = rsm_team.team_id WHERE `race_id` = $race_id AND `mark` = 15000 ORDER BY `time` ASC";
  $res=mysql_query($sql) or die(mysql_error());
  ////echo($sql);
    $i=1;
    While ($result_data = mysql_fetch_array($res)) {
      //echo($result_data[2].' '.$i.' '.$race_points[$i].'<br>');
      //UPDATE `cp308402_bm`.`rsm_race_sportsman_list` SET `race_place` = '1', `race_points` = '55' WHERE `rsm_race_sportsman_list`.`rsm_race_sportsman_list_id` = 1;
      $sql="UPDATE `rsm_race_sportsman_list` SET `race_place` = $i, `race_points` = $race_points[$i] WHERE `sportsman_id` = $result_data[2] AND `race_id` = $race_id";
      mysql_query($sql);
      if ($i<=3) { //Winner update
        $sql="UPDATE `rsm_race_sportsman_list` SET `top3` = 1 WHERE `sportsman_id` = $result_data[2] AND `race_id` = $race_id";  
        mysql_query($sql);
      }
      if ($i<=8) { //Winner update
        $sql="UPDATE `rsm_race_sportsman_list` SET `top8` = 1 WHERE `sportsman_id` = $result_data[2] AND `race_id` = $race_id";  
        mysql_query($sql);
      }
      //echo($sql.'<br>');
      $i++;
    }
  
    
  $sql = "SELECT * FROM `rsm_race_sportsman_list` WHERE `race_id` = $race_id";
  //echo($sql.'<br>');
  $i=1;$team_points=array();
  $res=mysql_query($sql) or die(mysql_error());
  While ($result_data = mysql_fetch_array($res)) {
    //2 - team_id
    //3 - sportsman_id
    //5 - points
    
    //9 Top3
    //10 Top8
    //11 Top_spd
    $team_points[$result_data[2]]=$team_points[$result_data[2]]+$result_data[5];
    //echo($result_data[2].'<br>');
      $sql="UPDATE `rsm_race_team_list` SET `race_points` = ".$team_points[$result_data[2]]." WHERE `race_id` = $race_id AND `team_id` = $result_data[2];";
      mysql_query($sql);
    $i++;
  }
  
  $sql = "SELECT `team_id`, `race_points` FROM `rsm_race_team_list`";
  $res=mysql_query($sql) or die(mysql_error());
  While ($result_data = mysql_fetch_array($res)) {
    switch ($result_data[0]) {
      case 1:
          $total_points[1]=$total_points[1]+$result_data[1];
          break;
      case 2:
          $total_points[2]=$total_points[2]+$result_data[1];
          break;
      case 3:
          $total_points[3]=$total_points[3]+$result_data[1];
          break;
      case 4:
          $total_points[4]=$total_points[4]+$result_data[1];
          break;
      case 5:
          $total_points[5]=$total_points[5]+$result_data[1];
          break;
      case 6:
          $total_points[6]=$total_points[6]+$result_data[1];
          break;
      case 7:
          $total_points[7]=$total_points[7]+$result_data[1];
          break;
      case 8:
          $total_points[8]=$total_points[8]+$result_data[1];
          break;
      case 9:
          $total_points[9]=$total_points[9]+$result_data[1];
          break;
      case 10:
          $total_points[10]=$total_points[10]+$result_data[1];
          break;
      case 11:
          $total_points[11]=$total_points[11]+$result_data[1];
          break;
      case 12:
          $total_points[12]=$total_points[12]+$result_data[1];
          break;
      case 13:
          $total_points[13]=$total_points[13]+$result_data[1];
          break;
      case 14:
          $total_points[14]=$total_points[14]+$result_data[1];
          break;
      case 15:
          $total_points[15]=$total_points[15]+$result_data[1];
          break;
      case 16:
          $total_points[16]=$total_points[16]+$result_data[1];
          break;
    }
   
    //echo('NP='.$new_points.'<br>');
    //$sql2 = "UPDATE `rsm_league_standings` SET `standings_points` = $new_points WHERE `team_id` = $result_data[0]";
    //mysql_query($sql2);
    //echo($sql2.'<br>');
  }
  
  //$team_id = $race_day + ($z-1)*16;
  
  for ($i=1; $i<=16; $i++){
    $team_update=$i+($z-1)*16;
    $sql = "UPDATE `rsm_league_standings` SET `standings_points` = $total_points[$i] WHERE `team_id` = $team_update";
    //echo($sql.'<br>');
    mysql_query($sql);
    
  }
  
  //print_r($total_points);
  
  $sql = "UPDATE `rsm_race` SET `race_status` = '1' WHERE `race_id` = $race_id";
  //echo($sql.'<br>');
  mysql_query($sql);
  
  //stat_update
  $sql = "SELECT * FROM `rsm_sportsman_statistic` ";//WHERE `sportsman_id` = 1
  $res=mysql_query($sql) or die(mysql_error());
  While ($data = mysql_fetch_array($res)) {
    //echo($data[0]."<br>");
    $sql2 = "SELECT * FROM `rsm_race_sportsman_list` WHERE `race_id` = ".$race_id." AND `sportsman_id` = ".$data[1]." ";
    //echo($sql2."<br>");
    $res2=mysql_query($sql2) or die(mysql_error());
    While ($data2 = mysql_fetch_array($res2)) {
    $stat_num_race=$data[3]+1;
    $stat_points=$data[4]+$data2[5];
   
   
    
    if ($data2[5] == $race_points[1]) {
      $stat_winner=$data[7]+1;
      //echo("OLD WINNER=".$data[3]." NEW WINNER=".$stat_winner."<br>");
    }
    else {
      $stat_winner=$data[7];
      //echo("".."OLD WINNER=".$data[7]." NEW WINNER=".$stat_winner."<br>");
    }
    
    
    
    if ($data2[5] >= $race_points[3]) $stat_top3=$data[8]+1;
    else $stat_top3=$data[8];
    
    if ($data2[5] >= $race_points[8]) $stat_top8=$data[9]+1;
    else $stat_top8=$data[9];
    
    
    $stat_shots=$data[6]+20;
    
    if ($data2[11]>$data[10]) {
      $stat_top_speed=$data2[11];
    }
    else $stat_top_speed = $data[10];
    
    
    
    $hits_old=$data[5];
    $hits_new=(20-$data2[6]);
    $stat_hits=$hits_old+$hits_new;
    //echo("id=".$data[1]." h_old=".$hits_old." h_new=".$hits_new." h_total=".$stat_hits."<br>");
    
    $stat_shooting=round(($hits_new/20),2);
    $stat_shooting_sum=round((($data[11]*($stat_num_race-1)+$stat_shooting)/$stat_num_race),2);
    
    //echo("prev=".$data[11]."  new=".$stat_shooting." race=".$stat_num_race." total=".$stat_shooting_sum."<br>");
    $old_shooting_l=$data[12];
    //$old_shooting_l=0;
    $stat_shooting_l_new=(10-$data2[8])/10;
    $stat_shooting_l=round((($old_shooting_l*($stat_num_race-1)+$stat_shooting_l_new)/$stat_num_race),2);
  
    $old_shooting_s=$data[13];
    //$old_shooting_s=0;
    $stat_shooting_s_new=(10-$data2[7])/10;
    $stat_shooting_s=round((($old_shooting_s*($stat_num_race-1)+$stat_shooting_s_new)/$stat_num_race),2);
    
    //$stat_shooting_s=($stat_shooting_s+$data[13])/$stat_num_race;
    $sql_update = "UPDATE `cp308402_bm`.`rsm_sportsman_statistic` SET `races_num` = '".$stat_num_race."', `points` = '".$stat_points."', `hits` = '".$stat_hits."', `shots` = '".$stat_shots."', `races_win` = '".$stat_winner."', `podiums` = '".$stat_top3."', `top8` = '".$stat_top8."', `top_speed` = '".$stat_top_speed."', `shooting_stat` = '".$stat_shooting_sum ."', `shooting_lay_stat` = '".$stat_shooting_l."', `shooting_stand_stat` = '".$stat_shooting_s."' WHERE `rsm_sportsman_statistic`.`sportsman_id` = ".$data[1].";";
    mysql_query($sql_update);
    //echo($sql_update."<br>");
    }
    
  }

  $sql_stat = "SELECT `sportsman_id`, `team_id` FROM `rsm_race_sportsman_list` WHERE `race_id` = ".$race_id." ";
  //echo($sql."<br>");
  $result_stat=mysql_query($sql_stat) or die(mysql_error());
  $i=1;
  while ($data_stat = mysql_fetch_assoc($result_stat)) {
    //print("<pre>");
    //print_r($data_stat);
    //print("</pre>");
    $sql_sman = "SELECT team_id, phys_strength, phys_endur, shoot_tech, shoot_calm, shoot_acc, track_tech, track_spd FROM `rsm_sportsman` WHERE sportsman_id = ".$data_stat['sportsman_id']." ";
    //print($sql_sman."<br>");
    $result_sman = mysql_query($sql_sman) or die(mysql_error());
    
    while ($query_sman = mysql_fetch_assoc($result_sman)) {
    //print("<pre>");
    //print_r($query_sman);
    //print("</pre>");
    //print("ID=".$string['team_id']."<br>");
    if (!isset($rating_data[$query_sman['team_id']]['phys_strength'])) {$rating_data[$query_sman['team_id']]['phys_strength']=0;}
    if (!isset($rating_data[$query_sman['team_id']]['phys_endur'])) {$rating_data[$query_sman['team_id']]['phys_endur']=0;}
    if (!isset($rating_data[$query_sman['team_id']]['shoot_tech'])) {$rating_data[$query_sman['team_id']]['shoot_tech']=0;}
    if (!isset($rating_data[$query_sman['team_id']]['shoot_calm'])) {$rating_data[$query_sman['team_id']]['shoot_calm']=0;}
    if (!isset($rating_data[$query_sman['team_id']]['shoot_acc'])) {$rating_data[$query_sman['team_id']]['shoot_acc']=0;}
    if (!isset($rating_data[$query_sman['team_id']]['track_tech'])) {$rating_data[$query_sman['team_id']]['track_tech']=0;}
    if (!isset($rating_data[$query_sman['team_id']]['track_spd'])) {$rating_data[$query_sman['team_id']]['track_spd']=0;}
    if (!isset($rating_data[$query_sman['team_id']]['overall'])) {$rating_data[$query_sman['team_id']]['overall']=0;}
        
    $rating_data[$query_sman['team_id']]['phys_strength'] = $rating_data[$query_sman['team_id']]['phys_strength'] + round($query_sman['phys_strength']/3,2);
    $rating_data[$query_sman['team_id']]['phys_endur'] = $rating_data[$query_sman['team_id']]['phys_endur'] + round($query_sman['phys_endur']/3,2);
    $rating_data[$query_sman['team_id']]['shoot_tech'] = $rating_data[$query_sman['team_id']]['shoot_tech'] + round($query_sman['shoot_tech']/3,2);
    $rating_data[$query_sman['team_id']]['shoot_calm'] = $rating_data[$query_sman['team_id']]['shoot_calm'] + round($query_sman['shoot_calm']/3,2);
    $rating_data[$query_sman['team_id']]['shoot_acc'] = $rating_data[$query_sman['team_id']]['shoot_acc'] + round($query_sman['shoot_acc']/3,2);
    $rating_data[$query_sman['team_id']]['track_tech'] = $rating_data[$query_sman['team_id']]['track_tech'] + round($query_sman['track_tech']/3,2);
    $rating_data[$query_sman['team_id']]['track_spd'] = $rating_data[$query_sman['team_id']]['track_spd'] + round($query_sman['track_spd']/3,2);
    
    $rating_data[$query_sman['team_id']]['overall'] = ($rating_data[$query_sman['team_id']]['phys_strength']+$rating_data[$query_sman['team_id']]['phys_endur']+$rating_data[$query_sman['team_id']]['shoot_tech']+    $rating_data[$query_sman['team_id']]['shoot_calm']+$rating_data[$query_sman['team_id']]['shoot_acc']+$rating_data[$query_sman['team_id']]['track_tech']+$rating_data[$query_sman['team_id']]['track_spd'])/7;
    //print("I=".$i."<br>");
      if (($i % 3)==0){
        $sql = "UPDATE `cp308402_bm`.`rsm_team_basic_rating` SET `rating_str` = '".$rating_data[$query_sman['team_id']]['phys_strength']."', `rating_endur` = '".$rating_data[$query_sman['team_id']]['phys_endur']."', `rating_sh_tech` = '".$rating_data[$query_sman['team_id']]['shoot_tech']."', `rating_sh_calm` = '".$rating_data[$query_sman['team_id']]['shoot_calm']."', `rating_sh_acc` = '".$rating_data[$query_sman['team_id']]['shoot_acc']."', `rating_tr_tech` = '".$rating_data[$query_sman['team_id']]['track_tech']."', `rating_tr_spd` = '".$rating_data[$query_sman['team_id']]['track_spd']."', `rating_overall` = '".$rating_data[$query_sman['team_id']]['overall']."' WHERE `rsm_team_basic_rating`.`team_id` = ".$query_sman['team_id']." ;";
        //print($sql."<br>");
        mysql_query($sql);
        
        $sql = "SELECT day_id FROM `rsm_race` WHERE `race_id` = ".$race_id." ";
        $result = mysql_query($sql) or die(mysql_error());
        while ($day_race = mysql_fetch_assoc($result)) {
          //print_r($day_race);
          $sql = "INSERT INTO `cp308402_bm`.`rsm_team_basic_rating_log` (`basic_rating_log_id`, `team_id`, `day_id`, `rating_str`, `rating_endur`, `rating_sh_tech`, `rating_sh_calm`, `rating_sh_acc`, `rating_tr_tech`, `rating_tr_spd`, `rating_overall`) VALUES (NULL, '".$query_sman['team_id']."', '".$day_race['day_id']."', '".$rating_data[$query_sman['team_id']]['phys_strength']."', '".$rating_data[$query_sman['team_id']]['phys_endur']."', '".$rating_data[$query_sman['team_id']]['shoot_tech']."', '".$rating_data[$query_sman['team_id']]['shoot_calm']."', '".$rating_data[$query_sman['team_id']]['shoot_acc']."', '".$rating_data[$query_sman['team_id']]['track_tech']."', '".$rating_data[$query_sman['team_id']]['track_spd']."', '".$rating_data[$query_sman['team_id']]['overall']."');";
          //print($sql."<br>");
          mysql_query($sql);
        }
        
        
      }
    //mysql_query($sql);
    $i++;
    }
  //print("<pre>");
  //print_r($rating_data);
  //print("</pre>");
  }
}






?><pre><?php //print_r($shooting)?></pre>
<pre><?php //print_r($race_segment)?></pre><?php
?>