<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
//unset($core_test);

$core_test=htmlspecialchars($_GET["core_test"]);
if (isset($core_test)) {
  if ($core_test == 1){
    echo('ZZZ');
   }
}
print("CT=".$core_test."<br>");

if (!isset($core_test)) {
  print("XXX");
}

$php_start = microtime(true);
global $bir;

require_once('base.php');


//get tactic vars
			$sql_core = "SELECT * FROM rsm_core_settings WHERE `core_settings_id` = 1";
			$result_core = mysql_query($sql_core) or die(mysql_error());
			while ($temp = mysql_fetch_assoc($result_core)) {
				$i = 0;
				foreach ($temp as $key=>$param) {
					//print($key." ".$param."<br>");
					if ($i>0) {
						$core_settings[$key]=$param;
					}
					$i++;
				}
			}
      
      print("<pre>");
      print_r($core_settings);
      print("</pre>");
//$race_day=htmlspecialchars($_GET["race"]);
$num_race_in_day = 0;

//получаем текущий день

$sql_cd = "SELECT day_id FROM `rsm_live` WHERE `id` = 1";
$result_cd = mysql_query($sql_cd) or die(mysql_error());
while ($cur_cd = mysql_fetch_assoc($result_cd)) {
  $race_day = $cur_cd['day_id'];
}


//получаем список гонок в день $race_day
//$race_day=htmlspecialchars($_GET["day"]);
$country_day=htmlspecialchars($_GET["country"]);


$sql = "INSERT INTO `rsm_engine_log` (`rsm_engine_log_id`, `rsm_day_id`, `country_id`, `rsm_race_done`, `rsm_engine_time`, `rsm_engine_end_time`) VALUES (NULL, '".$race_day."', '".$country_day."', '', '', '');";
mysql_query($sql);
$log_id = mysql_insert_id();

$current_time = microtime(true);
$current_time = $current_time - $php_start;
//print("TIME=".$current_time."<br>");

$sql = "SELECT * FROM `rsm_race` 
LEFT OUTER JOIN rsm_league ON rsm_race.league_id = rsm_league.league_id
WHERE `day_id` = ".$race_day." AND rsm_league.country_id = ".$country_day." LIMIT 0,1 ";//1 - Russia
//print($sql."<br>");
$result = mysql_query($sql) or die(mysql_error());
while ($races_total = mysql_fetch_assoc($result)) {
  
  $race_id = $races_total['race_id'];
  //print("Race_id = ".$race_id."<br>");
  $total_points=array();
  
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
  $result2 = mysql_query($sql) or die(mysql_error());
  while ($day_race = mysql_fetch_assoc($result2)) {
    $delete_day=$day_race['day_id'];
    }

  $sql = "SELECT team_id FROM `rsm_race_team_list` WHERE `race_id` = ".$race_id." ";
  $result3 = mysql_query($sql) or die(mysql_error());
  while ($team_race = mysql_fetch_assoc($result3)) {
    $sql = "DELETE FROM `rsm_team_basic_rating_log` WHERE team_id = ".$team_race['team_id']." AND day_id = ".$delete_day." ";
    //print($sql."<br>");
    mysql_query($sql);
    //print($team_race['team_id']."<br>");

  }
  
  //СТАРТ ПРОСЧЕТА ГОНКИ
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
  
  //echo('************************************************************<br>');
  //echo('Track #'.$race_id.'<br>');
  //echo('************************************************************<br>');
  
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
  //echo('************************************************************<br>');
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
  //echo('************************************************************<br>');
  $jj=0;
  //$race_id
  $sql = "SELECT track_id FROM `rsm_race` WHERE `race_id` = ".$race_id." ";
  //echo($sql."<br>");
  $res=mysql_query($sql) or die(mysql_error());
  While ($temp = mysql_fetch_row($res)) {
    $track_id = $temp[0];
  }
  
  
  $sql = "SELECT `track_type`, `track_tech`, `track_capacity` FROM `rsm_track` WHERE `track_id` = $track_id ";
  //echo($sql."<br>");
  $res=mysql_query($sql) or die(mysql_error());
  While ($track = mysql_fetch_row($res))
  {
    //attendance
    $race_attendance = rand(($track[2]/2),$track[2]);
    //print("ATT=".$attendance);
    
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
  //echo('Track '.$track_type_name.'<br>');
  //echo('************************************************************<br>');
  
  $penalty='';
  
  $sql = 'SELECT * FROM `rsm_race_sportsman_list`
  LEFT OUTER JOIN rsm_sportsman ON rsm_race_sportsman_list.sportsman_id = rsm_sportsman.sportsman_id
  LEFT OUTER JOIN rsm_team ON rsm_sportsman.team_id = rsm_team.team_id
  LEFT OUTER JOIN rsm_country ON rsm_sportsman.country_id = rsm_country.country_id
  LEFT OUTER JOIN rsm_race_sportsman_tactics ON (rsm_sportsman.sportsman_id = rsm_race_sportsman_tactics.sportsman_id AND rsm_race_sportsman_list.race_id = rsm_race_sportsman_tactics.race_id)
  WHERE rsm_race_sportsman_list.race_id = '.$race_id.' LIMIT 0,1  ';//LIMIT 0, 3
  
  $res=mysql_query($sql) or die(mysql_error());
  //echo($sql);
    While ($b_data = mysql_fetch_array($res))
      {//наполняем массив
        //print_r($b_data);
        $penalty_time[$i]=array();
        //$b_data['phys_energy']=$b_data['phys_energy']/10;
        $b_data['phys_strength']=$b_data['phys_strength'];
        $b_data['phys_endur']=$b_data['phys_endur'];
        $b_data['shoot_tech']=$b_data['shoot_tech']/10;
        $b_data['shoot_acc']=$b_data['shoot_acc']/10;
        $b_data['shoot_calm']=$b_data['shoot_calm']/10;
        $b_data['track_tech']=$b_data['track_tech'];
        $b_data['track_spd']=$b_data['track_spd'];
        //$b_data['phys_energy']=$b_data['track_spd'];
        //print("SID=".$b_data['sportsman_id']." NRG=".$b_data['phys_energy']." IMP=".$b_data['rsm_race_sportsman_tactics_importance']."<br>");
        //IMPORTANCE
        //УЧЕТ ВАЖНОСТИ ТАКТИКИ
        $d_imp = $b_data['rsm_race_sportsman_tactics_importance']*5;
        $k_nrg = $b_data['phys_energy']/100;
        $new_nrg = $b_data['phys_energy'] - $d_imp;
        //print("T=".$b_data['rsm_race_sportsman_tactics_importance']."<br>");
        switch ($b_data['rsm_race_sportsman_tactics_importance']) {
          case 1:
            $k_imp = $core_settings['tactics_importance_low']; //низкая важность
            break;
          case 2:
            $k_imp = $core_settings['tactics_importance_medium'];; //средняя важность
            break;
          case 3:
            $k_imp = $core_settings['tactics_importance_high'];; //высокая важность
            break;
        }
        //print("K_IMP=".$k_imp."<br>");
        
        //СРАЗУ УБРАЛИ ЭНЕРГИЮ
        $sql = "UPDATE  `rsm_sportsman` SET  `phys_energy` =  '".$new_nrg."' WHERE  `rsm_sportsman`.`sportsman_id` =".$b_data['sportsman_id'].";";
        mysql_query($sql);
        //$penalty=0;
        //$b_data[$b_data['sportsman_id']]['shooting']=array();
      //добавляем состояние
        //echo('************************************************************<br>');
        //echo('*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        //     Sportsman_id '.$b_data['sportsman_id'].' '.$b_data['name1'].' '.$b_data['name2'].'<br>');
        //echo('************************************************************<br>');
        //echo('<b>Shooting</b><br>');
        $i=1; $j=1;
        $sh_data[1]=0;$sh_data[2]=0;$sh_data[3]=0;$sh_data[4]=0;
        for($i=1; $i<=$global['shooting_total']; $i++) {
        //echo('<b>Lap '.$i.'</b><br>');
          for($j=1; $j<=$global['shooting_fires']; $j++) {
            // echo('Shot '.$j.'<br>');
            $var=rand(0,100);
            $shooting_acc=$b_data['shoot_tech']*$global['shooting_technique']+$b_data['shoot_acc']*$global['shooting_accuracy'];
            
            switch ($b_data['rsm_race_sportsman_tactics_shooting']) {
              case 10:
                $k_tactics_acc = $core_settings['tactics_shooting_acc_speed_low']; //низкая важность
                break;
              case 11:
                $k_tactics_acc = $core_settings['tactics_shooting_acc_speed_medium']; //средняя
                break;
              case 12:
                $k_tactics_acc = $core_settings['tactics_shooting_acc_speed_high']; //высокая
                break;
            }
            //print("k_tactics_acc=".$k_tactics_acc."<br>");

              switch ($b_data['rsm_race_sportsman_tactics_ski_plain']) {
                case 4:
                  $k_tactics_shooting_ski_plain = $core_settings['shooting_acc_ski_plain_low'];
                  break;
                case 5:
                  $k_tactics_shooting_ski_plain = $core_settings['shooting_acc_ski_plain_medium'];
                  break;
                case 6:
                  $k_tactics_shooting_ski_plain = $core_settings['shooting_acc_ski_plain_high'];
                  break;
              }
             //print("k_tactics_shooting_ski_plain=".$k_tactics_shooting_ski_plain."<br>");
             
              switch ($b_data['rsm_race_sportsman_tactics_ski_hill']) {
                case 7:
                  $k_tactics_shooting_ski_hill = $core_settings['shooting_acc_ski_hill_low'];
                  break;
                case 8:
                  $k_tactics_shooting_ski_hill = $core_settings['shooting_acc_ski_hill_medium'];
                  break;
                case 9:
                  $k_tactics_shooting_ski_hill = $core_settings['shooting_acc_ski_hill_high'];
                  break;
              }
            //print("k_tactics_shooting_ski_hill=".$k_tactics_shooting_ski_hill."<br>");
            $shooting_acc = $shooting_acc * $k_tactics_acc * $k_tactics_shooting_ski_plain * $k_tactics_shooting_ski_hill;
            
            //echo("SH_ACC=".$shooting_acc."<br>");
            if ($var<$shooting_acc) {  //записываем в массив лога стрельбы попал или нет - $bir[$bid]['shooting_log'][$lap][$shoot_num]
              
              $sql_shot_insert = 'INSERT INTO `rsm_logs` (`logs_id`, `race_id`, `sportsman_id`, `lap`, `shot`, `res`) VALUES (NULL, '.$race_id.', '.$b_data['sportsman_id'].', '.$i.', '.$j.', 1)';
              mysql_query($sql_shot_insert);
              //echo('1 '); //Попадание
            } 
            else {
              //промах
              $sql_shot_insert = 'INSERT INTO `rsm_logs` (`logs_id`, `race_id`, `sportsman_id`, `lap`, `shot`, `res`) VALUES (NULL, '.$race_id.', '.$b_data['sportsman_id'].', '.$i.', '.$j.', 0)';
              mysql_query($sql_shot_insert);
              $penalty[$i]=$penalty[$i]+1;
              $misses=$misses+1;
              
              $sh_data[$i] = $sh_data[$i] + 1;
              
              if (($i=='1') or ($i=='3')) {
                $misses_lay=$misses_lay+1;
                //echo('LAY MISS<br>');
              }
              else $misses_stand=$misses_stand+1;
              //echo($penalty[$i]);
              //echo('0 '); //Промах
            }
            //данные для sportsman_list стрельба на i рубеже
            
          }
          //echo('Total miss 1='.$misses_lay);
          //echo('|');
        }
        //echo('<br>');
     //print_r($penalty);echo('<br>');
     //echo('************************************************************<br>');
     if (!isset($misses)) $misses=0;
     if (!isset($misses_lay)) $misses_lay=0;
     if (!isset($misses_stand)) $misses_stand=0;
     
     //echo('MISSES='.$misses);echo('<br>');
     //echo('MISSES_LAY='.$misses_lay);echo('<br>');
     //echo('MISSES_STAND='.$misses_stand);echo('<br>');
     $sql = 'UPDATE `rsm_race_sportsman_list` SET `race_sh1` = '.$sh_data[1].', `race_sh2` = '.$sh_data[2].', `race_sh3` = '.$sh_data[3].', `race_sh4` = '.$sh_data[4].',`race_shots_missed` = '.$misses.', `race_shots_stand` = '.$misses_stand.', `race_shots_lay` = '.$misses_lay.' WHERE `sportsman_id` = '.$b_data['sportsman_id'].' AND `race_id` = '.$race_id.' ';
     mysql_query($sql);
     //echo($sql.'<br>');
      //echo('************************************************************<br>'); 
      //time 4 shooting
        //расчет времени прицеливания
        $positioning_k=($b_data['shoot_tech']*0.6+$b_data['shoot_calm']*0.3+$b_data['phys_endur']*0.1)/100;         
        //echo('POS K='.$positioning_k.'<br>');
        $positioning_time=$global['positioning_min']+($global['positioning_max']-$global['positioning_min'])*(1-$positioning_k);
        $positioning_time=round($positioning_time,2); //КОСТЫЛЬ
        
        //Учет тактики
        
        //$b_data['rsm_race_sportsman_tactics_ski_plain']
        //$b_data['rsm_race_sportsman_tactics_ski_hill']
        
        
        switch ($b_data['rsm_race_sportsman_tactics_shooting']) {
          case 10:
            $k_tactics_positioning = $core_settings['tactics_shooting_pos_low']; //низкая важность
            break;
          case 11:
            $k_tactics_positioning = $core_settings['tactics_shooting_pos_medium']; //средняя
            break;
          case 12:
            $k_tactics_positioning = $core_settings['tactics_shooting_pos_high']; //высокая
            break;
        }
        $positioning_time = $positioning_time * $k_tactics_positioning;
        //echo('POS TIME='.$positioning_time.'<br>');
  
   
        //echo('************************************************************<br>'); 
      
        //Расчет времени перезарядки
        $kd_min=4;  $kd_max=8;  $kd_technique=0.5;  $kd_calm=0.5;    //влияние параметров на КД, начало просчета КД
        $kd_k=$b_data['shoot_tech']*$kd_technique+$b_data['shoot_calm']*$kd_calm;
        $kd_time=$kd_min+($kd_max-$kd_min)*(1-$kd_k/100);
        switch ($b_data['rsm_race_sportsman_tactics_shooting']) {
          case 10:
            $k_tactics_kd_time = $core_settings['tactics_shooting_kd_low'];
            break;
          case 11:
            $k_tactics_kd_time = $core_settings['tactics_shooting_kd_medium'];
            break;
          case 12:
            $k_tactics_kd_time = $core_settings['tactics_shooting_kd_high'];
            break;
        }
        
              switch ($b_data['rsm_race_sportsman_tactics_ski_plain']) {
                case 4:
                  $k_tactics_shooting_kd_ski_plain = $core_settings['tactics_ski_plain_kd_low'];
                  break;
                case 5:
                  $k_tactics_shooting_kd_ski_plain = $core_settings['tactics_ski_plain_kd_medium'];
                  break;
                case 6:
                  $k_tactics_shooting_kd_ski_plain = $core_settings['tactics_ski_plain_kd_high'];
                  break;
              } 
      
              switch ($b_data['rsm_race_sportsman_tactics_ski_hill']) {
                case 7:
                  $k_tactics_shooting_kd_ski_hill = $core_settings['tactics_ski_hill_kd_low'];
                  break;
                case 8:
                  $k_tactics_shooting_kd_ski_hill = $core_settings['tactics_ski_hill_kd_medium'];
                  break;
                case 9:
                  $k_tactics_shooting_kd_ski_hill = $core_settings['tactics_ski_hill_kd_high'];
                  break;
              }
        
        $kd_time = $kd_time * $k_tactics_kd_time * $k_tactics_shooting_kd_ski_plain * $k_tactics_shooting_kd_ski_hill;
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
      
      //print("")
      //Расчет скоростей на отрезках и результирующей
      $sportsman_speed_plain=round(($Vmin+($track_speed_plain*$b_data['track_spd']+$track_tech_plain*$b_data['track_tech'])/$Kv_plain),3);
      
        switch ($b_data['rsm_race_sportsman_tactics_ski_plain']) {
          case 4:
            $k_tactics_ski_plain = 1;
            break;
          case 5:
            $k_tactics_ski_plain = 1.03;
            break;
          case 6:
            $k_tactics_ski_plain = 1.05;
            break;
        }
      $sportsman_speed_plain = $sportsman_speed_plain * $k_tactics_ski_plain;
      
      //echo("Speed_plain=".$sportsman_speed_plain."<br>");
        //Учет на подъемах и спусках
        switch ($b_data['rsm_race_sportsman_tactics_ski_hill']) {
          case 7:
            $k_tactics_ski_hill = 1;
            break;
          case 8:
            $k_tactics_ski_hill = 1.03;
            break;
          case 9:
            $k_tactics_ski_hill = 1.05;
            break;
        }
      
      
      $sportsman_speed_up=round(($Vupmin+($phys_strength_up*$b_data['phys_strength']+$phys_endurance_up*$b_data['phys_endur']+$track_speed_up*$b_data['track_spd']+$track_tech_up*$b_data['track_tech'])/$Kv_up),3);
      //echo("Speed_up=".$sportsman_speed_up."<br>");
      
      $sportsman_speed_up = $sportsman_speed_up * $k_tactics_ski_hill;
      
      $sportsman_speed_down=round(($Vdownmin+($phys_strength_down*$b_data['phys_strength']+$phys_endurance_down*$b_data['phys_endur']+$track_speed_down*$b_data['track_spd']+$track_tech_down*$b_data['track_tech'])/$Kv_down),3);
      //echo("Speed_down=".$sportsman_speed_down."<br>");
      
      $sportsman_speed_down = $sportsman_speed_down * $k_tactics_ski_hill;
      
      $speed_result = $sportsman_speed_plain*$track_plain+$sportsman_speed_up*$track_rise+$sportsman_speed_down*$track_descent;
      //add weather influence
      //echo("Speed_result= ".$speed_result."<br>");
      //echo("weather_total= ".$weather_total."<br>");
      $speed_result=$weather_total*$speed_result;
      //NRG EFFECT
      $speed_result = $speed_result * $k_nrg * $k_imp; //учет коэффициентов энергии и важности
      
      //echo("SID = ".$b_data['sportsman_id']." Speed_result = ".$speed_result."<br>");
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
    $current_time = microtime(true);
    $current_time = $current_time - $php_start;
    //print("TIME=".$current_time."<br>");
    //echo('TOTAL RACE TIME= '.$abs_time.'<br>');
  //print_r($mark_time);
  //print_r($penalty_time);
  //КОНЕЦ РАСЧЕТА ГОНКИ
  //Calculating RACE POINTS
  
  $race_points=array(1=>60, 54, 48, 43, 40, 38, 36, 34, 32, 31, 30, 29, 28, 28, 27, 27, 27, 26, 26, 26, 25, 25, 25, 24, 24, 24, 22, 21, 20, 19, 18, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1);
  
  //echo('************************************************************<br>'); 
  $sql = "SELECT * FROM `rsm_logr` LEFT OUTER JOIN rsm_sportsman ON rsm_logr.sportsman_id = rsm_sportsman.sportsman_id LEFT OUTER JOIN rsm_team ON rsm_sportsman.team_id = rsm_team.team_id WHERE `race_id` = $race_id AND `mark` = 15000 ORDER BY `time` ASC";
  $res=mysql_query($sql) or die(mysql_error());
  ////echo($sql);
    $i=1;
    While ($result_data = mysql_fetch_array($res)) {
      //echo($result_data[2].' '.$i.' '.$race_points[$i].'<br>');
      //UPDATE `rsm_race_sportsman_list` SET `race_place` = '1', `race_points` = '55' WHERE `rsm_race_sportsman_list`.`rsm_race_sportsman_list_id` = 1;
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
    
  $sql = "SELECT * FROM `rsm_race_sportsman_list` WHERE `race_id` = $race_id ORDER BY `race_points` DESC"  ;
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
    
        //experience start
    if ($i == '1') {
      $sp_exp = 3;
      $sp_exp_type = 3;
    }
    elseif ($i == '2') {
      $sp_exp = 2;
      $sp_exp_type = 4;
    }
    else {
      $sp_exp = 1;
      $sp_exp_type = 1;
    }
    //$exp_delta_type = 1;
    
    $sql2 = "SELECT rsm_sportsman_exp FROM `rsm_sportsman_exp` WHERE `rsm_sportsman_sportsman_id` = ".$result_data[3]." ";
    //print($sql."<br>");
    $result2 = mysql_query($sql2) or die(mysql_error());
    while ($exp_data = mysql_fetch_assoc($result2)) {
      //print_r($exp_data);
      $sp_new_exp = $sp_exp + $exp_data['rsm_sportsman_exp'];
      $sql3 = "UPDATE `rsm_sportsman_exp` SET `rsm_sportsman_exp` = '".$sp_new_exp."' WHERE `rsm_sportsman_sportsman_id` = ".$result_data[3].";";
      //print($sql."<br>");
      mysql_query($sql3);
      $sql3 = "INSERT INTO `rsm_sportsman_exp_log` (`rsm_sportsman_exp_log_id`, `rsm_sportsman_id`, `exp_log_delta`, `exp_log_delta_type`, `exp_log_date_id`) VALUES (NULL, '".$result_data[3]."', '".$sp_exp."', '".$sp_exp_type."', '".$race_day."');" ;
      mysql_query($sql3);
    }
 //experience ends
    
    $team_points[$result_data[2]]=$team_points[$result_data[2]]+$result_data[5];
    //echo($result_data[2].'<br>');
      $sql="UPDATE `rsm_race_team_list` SET `race_points` = ".$team_points[$result_data[2]]." WHERE `race_id` = $race_id AND `team_id` = $result_data[2];";
      mysql_query($sql);
    $i++;
  }
  
  $sql = "SELECT `team_id`, `race_points` FROM `rsm_race_team_list` WHERE `race_id` = $race_id";
  $res=mysql_query($sql) or die(mysql_error());
  While ($result_data = mysql_fetch_assoc($res)) {
    //print_r($result_data);
    $sql2 = "SELECT standings_points FROM `rsm_league_standings` WHERE `team_id` = ".$result_data['team_id']." ";
    $res2=mysql_query($sql2) or die(mysql_error());
    While ($result_data2 = mysql_fetch_assoc($res2)) {
      //print("<pre>");
      //print_r($result_data2);
      //print("</pre>");
      //print("Team=".$result_data['team_id']." PTS RACE=".$result_data['race_points']." PTS LEAGUE=".$result_data2['standings_points']."<br>");
      $sum_points = $result_data['race_points'] + $result_data2['standings_points'];
      $sql3 = "UPDATE `rsm_league_standings` SET `standings_points` = '".$sum_points."' WHERE `team_id` = ".$result_data['team_id']." ;";
      mysql_query($sql3);
      //print($sql3."<br>");
    }
  }
  
  //print_r($total_points);
  
  $sql = "UPDATE `rsm_race` SET `race_status` = '1', `race_attendance` = '".$race_attendance."' WHERE `race_id` = $race_id";
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
    $sql_update = "UPDATE `rsm_sportsman_statistic` SET `races_num` = '".$stat_num_race."', `points` = '".$stat_points."', `hits` = '".$stat_hits."', `shots` = '".$stat_shots."', `races_win` = '".$stat_winner."', `podiums` = '".$stat_top3."', `top8` = '".$stat_top8."', `top_speed` = '".$stat_top_speed."', `shooting_stat` = '".$stat_shooting_sum ."', `shooting_lay_stat` = '".$stat_shooting_l."', `shooting_stand_stat` = '".$stat_shooting_s."' WHERE `rsm_sportsman_statistic`.`sportsman_id` = ".$data[1].";";
    mysql_query($sql_update);
    //echo($sql_update."<br>");
    }
  }
  //$sql_stat
  $sql_stat = "SELECT `sportsman_id`, `team_id` FROM `rsm_race_sportsman_list` WHERE `race_id` = ".$race_id." ";
  //echo("ZZ=".$sql."<br>");
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
        $sql = "UPDATE `rsm_team_basic_rating` SET `rating_str` = '".$rating_data[$query_sman['team_id']]['phys_strength']."', `rating_endur` = '".$rating_data[$query_sman['team_id']]['phys_endur']."', `rating_sh_tech` = '".$rating_data[$query_sman['team_id']]['shoot_tech']."', `rating_sh_calm` = '".$rating_data[$query_sman['team_id']]['shoot_calm']."', `rating_sh_acc` = '".$rating_data[$query_sman['team_id']]['shoot_acc']."', `rating_tr_tech` = '".$rating_data[$query_sman['team_id']]['track_tech']."', `rating_tr_spd` = '".$rating_data[$query_sman['team_id']]['track_spd']."', `rating_overall` = '".$rating_data[$query_sman['team_id']]['overall']."' WHERE `rsm_team_basic_rating`.`team_id` = ".$query_sman['team_id']." ;";
        //print($sql."<br>");
        mysql_query($sql);
        
        $sql = "SELECT day_id FROM `rsm_race` WHERE `race_id` = ".$race_id." ";
        $result5 = mysql_query($sql) or die(mysql_error());
        while ($day_race = mysql_fetch_assoc($result5)) {
          //print_r($day_race);
          $sql = "INSERT INTO `rsm_team_basic_rating_log` (`basic_rating_log_id`, `team_id`, `day_id`, `rating_str`, `rating_endur`, `rating_sh_tech`, `rating_sh_calm`, `rating_sh_acc`, `rating_tr_tech`, `rating_tr_spd`, `rating_overall`) VALUES (NULL, '".$query_sman['team_id']."', '".$day_race['day_id']."', '".$rating_data[$query_sman['team_id']]['phys_strength']."', '".$rating_data[$query_sman['team_id']]['phys_endur']."', '".$rating_data[$query_sman['team_id']]['shoot_tech']."', '".$rating_data[$query_sman['team_id']]['shoot_calm']."', '".$rating_data[$query_sman['team_id']]['shoot_acc']."', '".$rating_data[$query_sman['team_id']]['track_tech']."', '".$rating_data[$query_sman['team_id']]['track_spd']."', '".$rating_data[$query_sman['team_id']]['overall']."');";
          //print($sql."<br>");
          mysql_query($sql);
        }
        
        
      }
    //mysql_query($sql);
    $i++;
    }
  }
  $sql = "SELECT DISTINCT(sportsman_id) FROM rsm_logr WHERE `race_id` = $race_id";
  $res=mysql_query($sql) or die(mysql_error());
  While ($temp_sp_id = mysql_fetch_assoc($res)){
    //print($temp_sp_id['sportsman_id']." ");
    $temp_mark_array = array(3000, 2999, 6000, 5999, 9000, 8999, 12000, 11999, 15000);
    
    for ($i=0;$i<=8;$i++){
      $sql2 = "SELECT time FROM `rsm_logr` WHERE  `race_id` = ".$race_id."  AND  `sportsman_id` = ".$temp_sp_id['sportsman_id']." AND mark = ".$temp_mark_array[$i]." ";
      $res2=mysql_query($sql2) or die(mysql_error());
      While ($temp_time = mysql_fetch_assoc($res2)){
        //print("SP=".$temp_sp_id['sportsman_id']." M=".$temp_mark_array[$i]." ".$temp_time['time']."<br>");
        $temp_ov_time[$i]=$temp_time['time'];
      }

    }
      //print("<pre>");
      //print_r($temp_ov_time);
      //print("</pre>");
     //print($sql."<br>");
     //print_r($temp_ov_time);
     $ski_time = $temp_ov_time[8]-($temp_ov_time[0]-$temp_ov_time[1])-($temp_ov_time[2]-$temp_ov_time[3])-($temp_ov_time[4]-$temp_ov_time[5])-($temp_ov_time[6]-$temp_ov_time[7]);
     //print("SP=".$temp_sp_id['sportsman_id']." SKI TIME=".$ski_time."<br>");
    $sql = "UPDATE  `rsm_race_sportsman_list` SET  `ski_time` =  '".$ski_time."', `overall_time` =  '".$temp_ov_time[8]."' WHERE  `race_id` = ".$race_id." AND `sportsman_id` = ".$temp_sp_id['sportsman_id'].";";
    mysql_query($sql);
    //print($sql."<br>");
  }
  
  $num_race_in_day++;
}


//echo("Total races done = ".$num_race_in_day."<br>");
$php_finish = microtime(true);
$php_delta = $php_finish - $php_start;
//echo("ZZZ=".$php_delta."<br>");

$script_time = date("Y-m-d H:i:s");
//2015-08-26 07:00:00
//$sql = "INSERT INTO `rsm_engine_log` (`rsm_engine_log_id`, `rsm_day_id`, `country_id`, `rsm_race_done`, `rsm_engine_time`, `rsm_engine_end_time`) VALUES (NULL, '".$race_day."', '".$country_day."', '', '', '');";
$sql = "UPDATE `rsm_engine_log` SET `rsm_race_done` = '".$num_race_in_day."', `rsm_engine_time` = '".$php_delta."', `rsm_engine_end_time` = '".$script_time."' WHERE `rsm_engine_log_id` = ".$log_id.";";
//print($sql);

mysql_query($sql);


?>