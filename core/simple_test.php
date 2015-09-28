<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php


$php_start = microtime(true);
global $bir;

require_once('base.php');


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

 $sql = "SELECT * FROM `rsm_race` 
LEFT OUTER JOIN rsm_league ON rsm_race.league_id = rsm_league.league_id
WHERE `day_id` = ".$race_day." AND rsm_league.country_id = ".$country_day."";//1 - Russia
//print($sql."<br>");
$result = mysql_query($sql) or die(mysql_error());
while ($races_total = mysql_fetch_assoc($result)) {
  
  $race_id = 1;
  
}
    
    
  $sql = "SELECT * FROM `rsm_race_sportsman_list` WHERE `race_id` = ".$race_id." ORDER BY `race_points` DESC";
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
    
    //experience
    if ($i == '1') {
      $sp_exp = 3;
    }
    elseif ($i == '2') {
      $sp_exp = 2;
    }
    else {
      $sp_exp = 1;
    }
    $exp_delta_type = 1;
    
    $sql = "SELECT rsm_sportsman_exp FROM `rsm_sportsman_exp` WHERE `rsm_sportsman_sportsman_id` = ".$result_data[3]." ";
    //print($sql."<br>");
    $result = mysql_query($sql) or die(mysql_error());
    while ($exp_data = mysql_fetch_assoc($result)) {
      //print_r($exp_data);
      $sp_new_exp = $sp_exp + $exp_data['rsm_sportsman_exp'];
      $sql = "UPDATE `rsm_sportsman_exp` SET `rsm_sportsman_exp` = '".$sp_new_exp."' WHERE `rsm_sportsman_sportsman_id` = ".$result_data[3].";";
      //print($sql."<br>");
      mysql_query($sql);
      $sql = "INSERT INTO `rsm_sportsman_exp_log` (`rsm_sportsman_exp_log_id`, `rsm_sportsman_id`, `exp_log_delta`, `exp_log_delta_type`, `exp_log_date_id`) VALUES (NULL, '".$result_data[3]."', '".$sp_exp."', '".$exp_delta_type."', '".$race_day."');" ;
      mysql_query($sql);
    }

    
    
    $team_points[$result_data[2]]=$team_points[$result_data[2]]+$result_data[5];
    //echo($result_data[2].'<br>');
      $sql="UPDATE `rsm_race_team_list` SET `race_points` = ".$team_points[$result_data[2]]." WHERE `race_id` = $race_id AND `team_id` = $result_data[2];";
      //mysql_query($sql);
    $i++;
  }
  


?>