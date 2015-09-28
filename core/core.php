<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
global $bir;

require_once('base.php');
$race_id=htmlspecialchars($_GET["race"]);
//ОЧИСТКА MYSQL
$sql_1='TRUNCATE rsm_logs';
//mysql_query($sql_1);
$sql_1='TRUNCATE rsm_logr';
//mysql_query($sql_1);

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

$global['shooting_accuracy']=0.8;
$global['shooting_technique']=0.2;

$global['weight']=70; //пока вес статичен для всех :)



function penalty ($bid) { //считает пенальти после стрельбы
  global $bir;
  global $global;
  
  //echo('CALCULATING PENALTY <br>');
  for($i=1; $i<=5; $i++) {
    if ($bir[$bid]['shooting_log'][$bir[$bid]['lap']][$i]=='1') {
      //echo('Shot id='.$i.' NO PENALTY <br>');
    }
    else {
      //echo('Shot id='.$i.' <font color=red>PENALTY</font> <br>');
      $penalty_count=$penalty_count+1;
    
    } 
  if ($i=='5') { //подсчитали общее количество штрафных кругов
    //echo('<font color=red>TOTAL PENALTY='.$penalty_count.'</font><br>');
  }
  }
    //$bir[$bid]['status']='race_end';
    //$bir[$bid]['shooting_status']='race_end';  
   return $penalty_count;
}

$sql_1='TRUNCATE rsm_logs';
//mysql_query($sql_1);
$sql_1='TRUNCATE rsm_logr';
//mysql_query($sql_1);


//ВСТАВКА РЕЗУЛЬТАТОВ В БАЗУ
function mysql_addshot($bid, $lap, $shot, $res) { //добавляет в таблицу rsm_logs лог стрельбы 
  global $bir;
  $race_id=htmlspecialchars($_GET["race"]);
  $sql_shot_insert = "INSERT INTO `rsm_logs` (`logs_id`, `race_id`, `sportsman_id`, `lap`, `shot`, `res`) VALUES (NULL, '$race_id', '$bid', '$lap', '$shot', '$res')";
  mysql_query($sql_shot_insert);
  echo('WARNING: MYSQL ACTIVE <br>');
  echo($sql_shot_insert.'<br>');
}

function mysql_addmark($bid, $mark, $time) { //добавляет отметку в базу
  global $bir;
  $race_id=htmlspecialchars($_GET["race"]);
  //echo('SQL CHECK='.$sql_delete_race_log);
  $sql_mark_insert = "INSERT INTO `rsm_logr` (`logr_id`, `race_id`, `sportsman_id`, `mark`, `time`) VALUES (NULL, '$race_id', '$bid', '$mark', '$time');";
  //echo('WARNING: MYSQL ACTIVE <br>');
  //echo($sql_mark_insert.'<br>');
  mysql_query($sql_mark_insert);
}                                   

function shot($bid, $lap, $shoot_num) { //Функция рассчитывает попадение/промах, время КД и записывает значения в массив игрока 
  global $bir;
  global $global;
  $var=rand(0,100);
  $shooting_acc=$bir[$bid]['shoot_technique']*$global['shooting_technique']+$bir[$bid]['shoot_accuracy']*$global['shooting_accuracy'];
  //echo('<b>SHOOTING</b><br>');
  echo('ID '.$bir[$bid]['biatloner_id'].' TOTAL ACC='.$shooting_acc.'<br>');
  echo('ID '.$bir[$bid]['biatloner_id'].' VBR='.$var.'<br>');  
  
  if ($var<$shooting_acc) {  //записываем в массив лога стрельбы попал или нет - $bir[$bid]['shooting_log'][$lap][$shoot_num]
    $bir[$bid]['shooting_log'][$lap][$shoot_num]='1';
    echo('HIT! for shoot num '.$shoot_num.' on the lap num '.$lap.' <br>'); //Попадание
  } 
  else {
    $bir[$bid]['shooting_log'][$lap][$shoot_num]='0';
    //echo('MISSED! for shoot num '.$shoot_num.' on the lap num '.$lap.' <br>'); //Промах
  }  
  //Уходим на КД
  $kd_min=4;  $kd_max=8;  $kd_technique=0.5;  $kd_calm=0.5;    //влияние параметров на КД, начало просчета КД
  $kd_k=$bir[$bid]['shoot_technique']*$kd_technique+$bir[$bid]['shoot_calm']*$kd_calm;
  $kd_time=$kd_min+($kd_max-$kd_min)*(1-$kd_k/100);  
  //конец расчета
  echo('KD='.$kd_time.'<br>');
  $bir[$bid]['hold']=$kd_time;    
  
  //запись стрельбы в MYSQL
  mysql_addshot($bir[$bid]['biatloner_id'], $bir[$bid]['lap'], $shoot_num, $bir[$bid]['shooting_log'][$lap][$shoot_num]);    
                       
  //сделать при $shoot_num=5 уход на лыжню дальше
  if ($shoot_num=='5') {//после 5 стрельбы проверяем штрафы
    $sum_penalty=penalty($bid, $lap);
    echo('<font color=red>TOTAL PENALTY='.$sum_penalty.' laps</font></br>');
    $bir[$bid]['status']='penalty'; 
  } else {
    $bir[$bid]['shooting_status']='shoot';
    $bir[$bid]['shooting_status'].=$shoot_num+1;
  } 
  echo ('For ID='.$bir[$bid]['biatloner_id'].' New shooting status='.$bir[$bid]['shooting_status'].' after '.$kd_time.' sec of KD<br>');   
}

function shooting($bid,$i,$lap) {
  global $bir;
  global $global;
  if ($bir[$bid]['shooting_status']=='prepare') {
    
    $positioning_k=($bir[$bid]['shoot_technique']*$global['positioning_technique']+$bir[$bid]['shoot_calm']*$global['positioning_calm'])/100;         
    $positioning_time=$global['positioning_min']+($global['positioning_max']-$global['positioning_min'])*(1-$positioning_k);
    $positioning_time=ceil($positioning_time/10); //КОСТЫЛЬ 
    echo('ID '.$bir[$bid]['biatloner_id'].' POS TIME='.$positioning_time.'<br>');
    $bir[$bid]['hold']=$positioning_time;         //посчитали изготовку в секундах и устанавливаем холд

    $bir[$bid]['shooting_status']='shoot1'; //перевели статус стрельбы в "первый выстрел, обработка статуса пойдет после холда из предыдущей строки  
  }
  elseif ($bir[$bid]['shooting_status']=='shoot1') {
    shot($bid,$bir[$bid]['lap'],1);
  }
    //2 Стрельба
    elseif ($bir[$bid]['shooting_status']=='shoot2') {

      $current_lap=$bir[$bid]['lap'];//текущий круг
      shot($bid,$current_lap,2);
    }
    //3 Стрельба
    elseif ($bir[$bid]['shooting_status']=='shoot3') {

      $current_lap=$bir[$bid]['lap'];//текущий круг
      shot($bid,$current_lap,3);
    }
    //4 Стрельба     
    elseif ($bir[$bid]['shooting_status']=='shoot4') {

      $current_lap=$bir[$bid]['lap'];//текущий круг
      shot($bid,$current_lap,4);
    }
    //5 Стрельба 
    elseif ($bir[$bid]['shooting_status']=='shoot5') {

      $current_lap=$bir[$bid]['lap'];//текущий круг
      shot($bid,$current_lap,5);
    }  
}

function run($bid,$id) { // Функция получает id и секунду, на выходе получаем пройденную дистанцию за секунду
  global $bir;
  global $i;
  global $global;
  global $current_lap;
  global $race_segment;
  //echo('***RACE '.$bir[$bid]['name1'].' '.$bir[$bid]['name2'].' CT='.$bir[$bid]['track_technique'].' STR='.$bir[$bid]['phys_strength'].' SPEED='.$bir[$bid]['track_speed'].'<br>');
  
  //Учет сегмента
  echo('I='.$i.' CL='.$current_lap.' bid='.$bid.'<br>');
  echo('TotalR='.$bir[$bid]['race_log'][$current_lap][$i].'<br>');
  echo('Текущий сегмент='.$bir[$bid]['segment_position'].' положение='.$bir[$bid]['race_log'][$current_lap][$i-1].'<br>');
  //Определение текущего сегмента
  //$temp_segm=$bir[$bid]['segment_position'];
  if($bir[$bid]['race_log'][$current_lap][$i-1]>$race_segment['abs'][$bir[$bid]['segment_position']]) {
    echo('СЛЕД СЕГМЕНТ ННАДА<br>');
    $bir[$bid]['segment_position']=$bir[$bid]['segment_position']+1;
    echo('Новый сегмент='.$bir[$bid]['segment_position'].'<br>'); 
  } 

  $k_angle=1; //для ровной поверхности
  

  if (($race_segment['angle'][$bir[$bid]['segment_position']]<0.05) && ($race_segment['angle'][$bir[$bid]['segment_position']]>=0))
  {
    $cur_angle=$race_segment['angle'][$bir[$bid]['segment_position']];
    //$k_angle=70*sin($race_segment['angle'][$bir[$bid]['segment_position']]);
    //$k_angle=$k_angle*$k_angle*0.0033;
    echo('ТИП=1 K='.$cur_angle.'<br>');
  }
  elseif (($race_segment['angle'][$bir[$bid]['segment_position']]>0.05) && ($race_segment['angle'][$bir[$bid]['segment_position']]<0.15))
  {
    //$cur_angle=$race_segment['angle'][$bir[$bid]['segment_position']];
    $k_angle=(1-round((1.25*sin(deg2rad($race_segment['angle'][$bir[$bid]['segment_position']]*100))+0.175)*$global['weight']*0.015,4));
    echo('ТИП=2 K='.$k_angle.'<br>');
  }
  elseif (($race_segment['angle'][$bir[$bid]['segment_position']]<-0.05) && ($race_segment['angle'][$bir[$bid]['segment_position']]>-0.15))
  {
    //$cur_angle=$race_segment['angle'][$bir[$bid]['segment_position']];
    $k_angle=1+round(0.03*$global['weight']*sin(deg2rad(-$race_segment['angle'][$bir[$bid]['segment_position']]*100)),4);
    echo('ТИП=-2 K='.$k_angle.'<br>');
  }
  elseif ($race_segment['angle'][$bir[$bid]['segment_position']]>0.15)
  {
    echo('ТИП=3<BR>');
    //echo('УГОЛ = '.$race_segment['angle'][$bir[$bid]['segment_position']].'<br>');
  }  

  //Рассчет скорости для ровного участка
  if ($bir[$bid]['track_technique']<=$global['limit_technique']) {
    $speed_koef_technique=($global['limit_technique']-$bir[$bid]['track_technique'])*(-1)*$global['technique_dec'];
  }
  elseif ($bir[$bid]['track_technique']>$global['limit_technique']) {
    $speed_koef_technique=($bir[$bid]['track_technique']-$global['limit_technique'])*$global['technique_inc'];
  }
  //echo('TB='.$speed_koef_technique.' km/h<br>');
  if ($bir[$bid]['phys_strength']<=$global['limit_strength']) {$speed_koef_strength=($global['limit_strength']-$bir[$bid]['phys_strength'])*(-1)*$global['strength_dec'];}
  else $speed_koef_strength=($bir[$bid]['phys_strength']-$global['limit_strength'])*$global['strength_inc'];
  echo('SB='.$speed_koef_strength.' km/h<br>');
  //считаем итоговую скорость
  $total_speed=($bir[$bid]['track_speed']+$speed_koef_technique+$speed_koef_strength);
  $total_speed=round($total_speed*$k_angle,2);  //Возможность учета штрафа за подъем/бонуса за спуск
  //echo('I='.$i.'<br>');
  $bir[$bid]['speed'][$i]=$total_speed;
  echo('Speed='.$total_speed.' km/h<br>');
  $passed=round($total_speed*1000/(60*60),4)+(rand(1, 3)/10);
  
  //echo($bir[$bid]['biatloner_id'].' Passed='.$passed.' meters<br>');
  $result[0]=$passed;
  $result[1]=$total_speed;
  return $result;
}


echo('************************************************************<br>');
echo('Получаем данные трассы №1 из базы<br>');
echo('************************************************************<br>');

//Математика отметок

$race_mark_qt=$race_circuit_length/$race_mark;
for($j=1; $j<=5; $j++) {
  for ($k=1; $k<=6; $k++)  {
    $race_marks[$j][$k]=500*$k;
    echo('Отметки. Круг #'.$j.' '.$race_marks[$j][$k].'<br>');
  }

}
echo('************************************************************<br>');
echo('Проверяем длину отрезка трассы в БД<br>'); 

$jj=0;
$sql = "SELECT `length`, `x`, `z` FROM `rsm_track_point` WHERE `lap` = 1 AND `track_id` = 2 ORDER BY `point_order` ASC LIMIT 0, 30 ";
echo($sql);
$res=mysql_query($sql) or die(mysql_error());
While ($track = mysql_fetch_row($res))
{
  $track_length=$track[0]+$track_length;
  $race_segment['length'][$jj]=$track[0];
  $race_segment['x'][$jj]=$track[1];
  $race_segment['z'][$jj]=$track[2];
  $jj=$jj+1;
  
}
echo('Длина в базе='.$track_length.' м<br>');
echo('************************************************************<br>');
echo('Профиль трассы<br>'); 
echo("<img src=\"gd-test.php\"><br>");
echo('Формируем отрезки<br>'); 
//Считаем с 1 элемента, т.к. длина отрезка в начальной точке = 0 
$count = count($race_segment['length'])-1;
echo('Всего отрезков: '.$count.' <br>');

for($j=1; $j<=$count; $j++) {
  $absolute_length[$j]=$race_segment['length'][$j]+$absolute_length[$j-1];
  echo('Длина '.$j.'-го отрезка='.$race_segment['length'][$j].' м ');
  echo('Абс '.$j.'-го отрезка='.$absolute_length[$j].' м <br>');
  $race_segment['abs'][$j]=$absolute_length[$j];
  $race_segment['level'][$j]=$race_segment['z'][$j]-$race_segment['z'][$j-1];
  //$race_segment['angle'][$j]=round(asin($race_segment['level'][$j]/$race_segment['length'][$j]),4);
  $race_segment['angle'][$j]=round(asin($race_segment['level'][$j]/$race_segment['length'][$j]),4);
  $race_segment['angle'][$j]=round($race_segment['angle'][$j]*180/M_PI/100,2);
  echo('Подъем на отрезке='.$race_segment['level'][$j].' Угол подъема ='.$race_segment['angle'][$j].'<br>');
}





//echo('**************************************************<br>');
//echo('QT MARK ='.$race_mark_qt.'<br>');


//ПОКА ПОСТАВИЛ НА ТЕСТ 2 СПОРТСМЕНОВ

//$race_id=htmlspecialchars($_GET["race"]);

$sql = "SELECT `b_id`, `team_id`, `name1`, `name2`, `phys_energy`, `phys_strength`, `phys_endurance`, `shoot_technique`, `shoot_calm`, `shoot_accuracy`, `track_technique`, `track_speed` FROM `rsm_biatloner` LIMIT 10"; //Получение спортсменов из базы



$sql = 'SELECT * FROM `rsm_race_sportsman_list` LEFT OUTER JOIN rsm_sportsman ON rsm_race_sportsman_list.sportsman_id = rsm_sportsman.sportsman_id LEFT OUTER JOIN rsm_team ON rsm_sportsman.team_id = rsm_team.team_id LEFT OUTER JOIN rsm_country ON rsm_sportsman.country_id = rsm_country.country_id WHERE race_id='.$race_id.' LIMIT 0,5';
//echo($sql);
$res=mysql_query($sql) or die(mysql_error());
//echo($sql);
  While ($b_data = mysql_fetch_array($res))
    {//наполняем массив
      $bir[$b_data[0]]['biatloner_id']=$b_data['sportsman_id'];
      $bir[$b_data[0]]['biatloner_team_id']=$b_data['team_id'];
      $bir[$b_data[0]]['name1']=$b_data['name1'];
      $bir[$b_data[0]]['name2']=$b_data['name2'];
      $bir[$b_data[0]]['phys_energy']=$b_data['phys_energy'];
      $bir[$b_data[0]]['phys_strength']=$b_data['phys_strength'];
      $bir[$b_data[0]]['phys_endurance']=$b_data['phys_endur'];
      $bir[$b_data[0]]['shoot_technique']=$b_data['shoot_tech'];
      $bir[$b_data[0]]['shoot_calm']=$b_data['shoot_calm'];
      $bir[$b_data[0]]['shoot_accuracy']=$b_data['shoot_acc'];
      $bir[$b_data[0]]['track_technique']=$b_data['track_tech'];
      $bir[$b_data[0]]['track_speed']=$b_data['track_spd'];
    //добавляем состояние
      $bir[$b_data[0]]['status']='start';
      $bir[$b_data[0]]['shooting_status']='prepare';//состояние на стрельбище prepare - пришел на стрельбище, ready - прошла изготовка
      $bir[$b_data[0]]['hold']='0';
      $bir[$b_data[0]]['lap']='1';
      $bir[$b_data[0]]['fatique']='0';
      $bir[$b_data[0]]['mark']='1';
      $bir[$b_data[0]]['segment_position']='1';
    }

    //print_r($bir);
for($i=0; $i<=8000; $i++) { //время в с
  echo('************************************************************<br>Time='.$i.' sec<br>'); 
  foreach($bir as $bid=>$b) { //перебираем всех биатлонистов в гонке $b - массив параметров биатлониста в гонке, $bid - id биатлониста для быстрого доступа
    echo('------------------------------------<br>');
    echo('<i>ID='.$bir[$bid]['biatloner_id'].' СЕГМЕНТ='.$bir[$bid]['segment_position'].' СТАТУС=<font color=green>'.$bir[$bid]['status'].'</font> СТР=<font color=green>'.$bir[$bid]['shooting_status'].'</font> </i> КРУГ#'.$bir[$bid]['lap'].'<br>');
    
    if($b['status']=="finish"){} //ФИНИШ ГОНКИ
    else {    
      //если биатлонист в холде больше чем 1 мсекунду, то просто убираем 1 мсекунду с холда + вызов функции обработки холда на будущее
      if($b['hold']>1){$bir[$bid]['hold']--;} 
      
      else{ //если биатлонист не в холде или холд меньше 1 секунды то обрабатываем его действия
        if($b['status']=="shooting"){       //вызов функции стрельбища
          //echo($bir[$bid]['time_delta'].'<br>');
          //echo('CURLAP='.$bir[$bid]['lap'].'<br>');
          if ($bir[$bid]['lap']<5) shooting($bid,$i,$bir[$bid]['lap']);
        } 
        if($b['status']=="start"){
          $current_lap=$bir[$bid]['lap'];
          $result=run($bid,$i,$bir[$bid]['race_log'][$current_lap][$i]);
          $bir[$bid]['dist_log'][$current_lap][$i]=$result[0];
          //print_r($bir[$bid]);
          $bir[$bid]['race_log'][$current_lap][$i]=$result[0]+$bir[$bid]['race_log'][$current_lap][$i-1];
          
          echo('ID '.$bir[$bid]['biatloner_id'].' Passed='.$result[0].' meters Total='.$bir[$bid]['race_log'][$current_lap][$i].'<br>');


          $next_mark[$current_lap]=$bir[$bid]['mark']*$race_mark-($race_circuit_length)*($current_lap-1); //первая отметка в метрах
          $next_mark_mysql=$bir[$bid]['mark']*$race_mark;
          echo('MARK IN '.$next_mark[$current_lap].'<br>');
          if($bir[$bid]['race_log'][$current_lap][$i]>$next_mark[$current_lap]) {   //проверка на отметку
            echo('MARK DONE!</br>');
            $bir[$bid]['mark']=$bir[$bid]['mark']+1;
            //$race_marks[$current_lap][$current_mark]
            $mark_delta=$bir[$bid]['race_log'][$current_lap][$i]-$next_mark[$current_lap];
            $speed_on_mark=$bir[$bid]['speed'][$i]*1000/60/60;
            $time_delta_mark=$mark_delta/$speed_on_mark;
            echo('DELTA ON MARK='.$mark_delta.' meters and speed on mark='.$speed_on_mark.' m/s and time for delta='.$time_delta_mark.' sec<br>');
            //$next_mark_mysql=$next_mark_mysql-$time_delta_mark;
            $mark_time=round($i-$time_delta_mark,5);
            echo('I='.$i.' MT='.$mark_time.'<br>');
            mysql_addmark($bir[$bid]['biatloner_id'], $next_mark_mysql, $mark_time);
          }
          
          if($bir[$bid]['race_log'][$current_lap][$i]>$race_circuit_length) { //проверка на проход круга
            echo ('Finish lap for biatloner_id='.$bir[$bid]['biatloner_id'].'<br>');
            
            $bir[$bid]['status']="shooting"; //перевели на стрельбище после прохода круга
            
          }

        }                                                
        if($b['status']=="race_end"){echo('RACE FINISH! FOR id='.$bir[$bid]['biatloner_id'].'<br>');}
        
        if($b['status']=="penalty"){
            
          $current_lap=$bir[$bid]['lap'];
            if ($current_lap<5){
            $sum_penalty=penalty($bid, $lap);
            $dist_penalty=$race_penalty_circuit_length*$sum_penalty;
            //echo('I= '.$i.' <br>');
            echo('GOING '.$sum_penalty.' PENALTY LAPS / '.$dist_penalty.' meters <br>');
            if ($dist_penalty!=0){ 
              $penalty_result=run($bid,$i);
              //echo('PenRes='.$penalty_result[0].'<br>');
              $bir[$bid]['penalty_dist_log'][$current_lap][$i]=$penalty_result[0];
              $bir[$bid]['penalty_race_log'][$current_lap][$i]=$penalty_result[0]+$bir[$bid]['penalty_race_log'][$current_lap][$i-1];
              
              if($bir[$bid]['penalty_race_log'][$current_lap][$i]>$dist_penalty){ //Проверка на проход всех штрафных кругов
                echo('PENALTY ENDED!<br>');
                //$bir[$b_data[0]]['status']='start';
                //$bir[$bid]['lap']++;
                 echo('LAP ENDED<br>');
                 $bir[$bid]['status']="start";
                 $bir[$bid]['shooting_status']='prepare';
                 $bir[$bid]['lap']++;
                 echo('NEW LAP VALUE='.$bir[$bid]['lap'].'<br>');
              }
            }
            elseif ($dist_penalty=='0'){
                echo('LAP ENDED<br>');
                $bir[$bid]['status']="start";
                $bir[$bid]['shooting_status']='prepare';
                $bir[$bid]['segment_position']='1';
                $bir[$bid]['lap']++;
                echo('NEW LAP VALUE='.$bir[$bid]['lap'].'<br>');
            }
          } else {
          
          }
        }
      }
    }
  }
}






?><pre><?php print_r($bir)?></pre>
<pre><?php print_r($race_segment)?></pre><?php
?>