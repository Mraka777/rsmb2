<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
global $bir;

require_once('base.php');
$race_id=htmlspecialchars($_GET["race"]);

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
      $b_data['phys_strength']=$b_data['phys_strength']/10;
      $b_data['phys_endur']=$b_data['phys_endur']/10;
      
      $b_data['shoot_tech']=$b_data['shoot_tech']/10;
      $b_data['shoot_acc']=$b_data['shoot_acc']/10;
      $b_data['shoot_calm']=$b_data['shoot_calm']/10;
      
      $b_data['track_tech']=$b_data['track_tech']/10;
      //$b_data['phys_endur']=$b_data['phys_endur']/10;
      
      
      
      //$bir[$b_data[0]]['sportsman_id']=$b_data['sportsman_id'];
      //$bir[$b_data[0]]['biatloner_team_id']=$b_data['team_id'];
      //$bir[$b_data[0]]['name1']=$b_data['name1'];
      //$bir[$b_data[0]]['name2']=$b_data['name2'];
      //$bir[$b_data[0]]['phys_energy']=$b_data['phys_energy'];
      //$bir[$b_data[0]]['phys_strength']=$b_data['phys_strength'];
      //$bir[$b_data[0]]['phys_endurance']=$b_data['phys_endur'];
      //$bir[$b_data[0]]['shoot_technique']=$b_data['shoot_tech'];
      //$bir[$b_data[0]]['shoot_calm']=$b_data['shoot_calm'];
      //$bir[$b_data[0]]['shoot_accuracy']=$b_data['shoot_acc'];
      //$bir[$b_data[0]]['track_technique']=$b_data['track_tech'];
      //$bir[$b_data[0]]['track_speed']=15+10*($b_data['track_spd']/1000);
      $b_data['track_spd']=15+10*($b_data['track_spd']/1000);
      //$penalty=0;
      //$b_data[$b_data['sportsman_id']]['shooting']=array();
    //добавляем состояние
      echo('************************************************************<br>');
      echo('Sportsman_id '.$b_data['sportsman_id'].' '.$b_data['name1'].' '.$b_data['name2'].'<br>');
      echo('************************************************************<br>');
      echo('<b>Shooting</b><br>');
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
            echo('1 '); //Попадание
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
            echo('0 '); //Промах
          }
          
        }
        //echo('Total miss 1='.$misses_lay);
        echo('|');
      }
      echo('<br>');
   print_r($penalty);echo('<br>');
   if (!isset($misses)) $misses=0;
   if (!isset($misses_lay)) $misses_lay=0;
   if (!isset($misses_stand)) $misses_stand=0;
   
   echo('MISSES='.$misses);echo('<br>');
   echo('MISSES_LAY='.$misses_lay);echo('<br>');
   echo('MISSES_STAND='.$misses_stand);echo('<br>');
   //$p_lay=$misses_lay;
   //$p_stand=$misses_stand;
   //
   //$sql="UPDATE `rsm_race_sportsman_list` SET `race_shots_missed` = ".$misses.", `race_shots_p_stand` = ".$p_stand.", `race_shots_p_lay` = ".$p_lay." WHERE `rsm_race_sportsman_list_id` = $b_data['sportsman_id'] AND `race_id` = ".$race_id." ";
   $sql = 'UPDATE `rsm_race_sportsman_list` SET `race_shots_missed` = '.$misses.', `race_shots_stand` = '.$misses_stand.', `race_shots_lay` = '.$misses_lay.' WHERE `sportsman_id` = '.$b_data['sportsman_id'].' AND `race_id` = '.$race_id.'';
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
    $koef_tech=round(($b_data['track_tech']-$global['limit_technique'])/($global['limit_technique']*7)*0.7+($b_data['phys_endur']-$global['limit_technique'])/($global['limit_technique']*7)*0.3,2); //коэффициент от техники
    
    //$koef_tech=round($koef_tech/($track_tech*2/3),2); //Track spec
    
    echo('koef_tech='.$koef_tech.'<br>');
    
    $koef_type=round(($b_data['phys_endur']-$global['limit_strength'])/($global['limit_strength']*7)*0.7+($b_data['phys_strength']-$global['limit_strength'])/($global['limit_strength']*7)*0.2+($b_data['track_tech']-$global['limit_strength'])/($global['limit_strength']*7)*0.1,2);
    
    echo('koef_type='.$koef_type.'<br>');
    
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
    
    $staff_tech_k = ($main_skill/100)/50;

    //HILLS
    
    if ($track_type=2) {
      $koef_hills=(0.5*$b_data['phys_strength']+0.3*$b_data['phys_endur']+0.2*$b_data['track_tech'])/100;
      $koef_hills=-2+2*$koef_hills;
    }
    else $koef_hiils=0;
    echo("HILL=".$koef_hills."<br>");
    
    $speed_result=round($b_data['track_spd']+$koef_tech+$koef_type+$staff_tech_k+$koef_hills,2); //+(rand(100, 300)/1000)
    
    echo('SPD SRC='.$b_data['track_spd'].' SPD_Total='.$speed_result.' Km/h <br>');
        //$track_plain=0.6;
        //$track_rise=0.2;
        //$track_descent=0.2;
        
    echo('Plain='.$track_plain.' Rise='.$track_rise.' Descent='.$track_descent.'<br>');   
    $speed_plain=$speed_result;
    $speed_rise=$speed_result/2;
    $speed_descent=$speed_result*1.5;
    
    $speed_result_type=$track_plain*$speed_plain+$track_rise*$speed_rise+$track_descent*$speed_descent;
    echo('SPD_RISE='.$speed_rise.' Km/h SPD_DESCENT='.(round($speed_descent,2)).' Km/h <br>');
    $sql_update_top_speed = "UPDATE `rsm_race_sportsman_list` SET `top_speed` = '".(round($speed_descent,2))."' WHERE `race_id` = ".$race_id." AND `sportsman_id` = ".$b_data['sportsman_id'].";";
    //echo($sql_update_top_speed."<br>");
    mysql_query($sql_update_top_speed);
    echo('SPD_Type='.$speed_result_type.' Km/h <br>');
    
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
        $abs_time=$abs_time+$penalty_time[$i]+$shooting_time;
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

echo('************************************************************<br>'); 
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

for ($i=1; $i<=16; $i++){
  $sql = "UPDATE `rsm_league_standings` SET `standings_points` = $total_points[$i] WHERE `team_id` = $i";
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









?><pre><?php //print_r($shooting)?></pre>
<pre><?php //print_r($race_segment)?></pre><?php
?>