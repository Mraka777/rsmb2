<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php

function sportsman_shooting() {
  $i=1; $j=1;
  $sh_data[1]=0;$sh_data[2]=0;$sh_data[3]=0;$sh_data[4]=0;
  for($i=1; $i<=$global['shooting_total']; $i++) { // $i = КРУГИ 
    for($j=1; $j<=$global['shooting_fires']; $j++) { // $j = № Выстрела
      $var=rand(0,100);
      $shooting_acc=$b_data['shoot_tech']*$global['shooting_technique']+$b_data['shoot_acc']*$global['shooting_accuracy'];
         
      switch ($b_data['rsm_race_sportsman_tactics_shooting']) { //ТАКТИКА СКОРОСТЬ СТРЕЛЬБЫ
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
}


//GET CORE TEST STATUS
$core_test=htmlspecialchars($_GET["core_test"]);
if (isset($core_test)) {
  if ($core_test == 1){
    $core_status = 1; // for testing
   }
   else {
    $core_status = 0; // GENERAL mode
   }
}
//END CORE TEST STATUS

//PRINT TO SCREEN

function rsm_print($data) {
  $print=htmlspecialchars($_GET["print"]);
  if (isset($print)) {
    if ($print == 1){
      echo $data; // print on screen
     }
     else {
            // do nothing
     }
  }
}

//BASIC VARS

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

//END BASIC VARS

//GET DB
require_once('base.php');
//END GET DB

//START TIME LOG

if ($core_status != 1) {//if GENERAL MODE
  $php_start = microtime(true);
}



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
if ($core_status == 1) {//if !GENERAL MODE
  print("<pre>");
  print_r($core_settings);
  print("</pre>");
}

if ($core_status != 1) {
  $num_race_in_day = 0;
  
  //получаем текущий день
  $sql_cd = "SELECT day_id FROM `rsm_live` WHERE `id` = 1";
  $result_cd = mysql_query($sql_cd) or die(mysql_error());
  while ($cur_cd = mysql_fetch_assoc($result_cd)) {
    $race_day = $cur_cd['day_id'];
  }
  //получаем список гонок в стране
  $country_day=htmlspecialchars($_GET["country"]);
  //пишем в лог
  $sql = "INSERT INTO `rsm_engine_log` (`rsm_engine_log_id`, `rsm_day_id`, `country_id`, `rsm_race_done`, `rsm_engine_time`, `rsm_engine_end_time`) VALUES (NULL, '".$race_day."', '".$country_day."', '', '', '');";
  mysql_query($sql);
  $log_id = mysql_insert_id();
  
  $current_time = microtime(true);
  $current_time = $current_time - $php_start;
}



?>