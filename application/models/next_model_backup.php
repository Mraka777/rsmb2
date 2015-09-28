<?php
class Next_model extends CI_Model {

        function __construct()
        {
            parent::__construct();
            
        }
    
    private function _gen_sportsman($country, $level_or, $level_talent)
      {
        $first_p=50*$level_or;$second_p=75*$level_or;//level
        $t_first=20; $t_second=29+7*$level_talent;//level talent
        $name=$this->Next_model->generate_name($country);

        $param = rand($first_p,$second_p);$param1 = rand($first_p,$second_p);$param2 = rand($first_p,$second_p);$param3 = rand($first_p,$second_p);$param4 = rand($first_p,$second_p);$param5 = rand($first_p,$second_p);$param6 = rand($first_p,$second_p);$param7 = rand($first_p,$second_p);
        $rating=round(($param+$param1+$param2+$param3+$param4+$param5+$param6),0);
        $pop = rand(0,10);
        
        $talent1 = rand($t_first,$t_second);$talent2 = rand($t_first,$t_second);$talent3 = rand($t_first,$t_second);$talent4 = rand($t_first,$t_second);$talent5 = rand($t_first,$t_second);$talent6 = rand($t_first,$t_second);$talent7 = rand($t_first,$t_second);

        $data['country_id']=$country;
        $data['age']=rand(15,17);
        $data['bday']=rand(1,30);
        $data['name1']=$name['first'];
        $data['name2']=$name['last'];                     
        $data['phys_energy']=99;
        $data['phys_strength']=$param;
        $data['phys_endur']=$param1;
        $data['shoot_tech']=$param2;
        $data['shoot_calm']=$param3;
        $data['shoot_acc']=$param4;
        $data['track_tech']=$param5;
        $data['track_spd']=$param6;
        $data['sportsman_prof']=$param7;
        $data['popularity']=$pop;
        $data['overall_rating']=$rating;
        $data['salary']=($rating * 10 + rand(100,300));
        $data['phys_strength_mvu']=$talent1;
        $data['phys_endur_mvu']=$talent2;
        $data['shoot_tech_mvu']=$talent3;
        $data['shoot_calm_mvu']=$talent4;
        $data['shoot_acc_mvu']=$talent5;
        $data['track_tech_mvu']=$talent6;
        $data['track_speed_mvu']=$talent7;
        $data['days_actual']=6;

        return($data);
      }
    
    
    function do_academy() {
      $sql = "SELECT team_id, country_id FROM rsm_team";
      $query = $this->db->query($sql);
      $teams=$query->result_array();
      //print_r($query->result_array());
      foreach ($teams as $team) {
        //print($teams['team_id']);
        $s_a=$this->Next_model->_gen_sportsman($team['country_id'],1,1);
        $sql = "INSERT INTO `rsm_sportsman_academy` (`sportsman_id`, `team_id`, `country_id`, `age`, `bday`, `name1`, `name2`, `team_num`, `phys_energy`, `phys_strength`, `phys_endur`, `shoot_tech`, `shoot_calm`, `shoot_acc`, `track_tech`, `track_spd`, `sportsman_prof`, `popularity`, `overall_rating`, `salary`, `days_actual`, `phys_strength_mvu`, `phys_endur_mvu`, `shoot_tech_mvu`, `shoot_calm_mvu`, `shoot_acc_mvu`, `track_tech_mvu`, `track_speed_mvu`) VALUES (NULL, '".$team['team_id']."', '".$team['country_id']."', '".$s_a['age']."', '".$s_a['bday']."', '".$s_a['name1']."', '".$s_a['name2']."', '', '".$s_a['phys_energy']."', '".$s_a['phys_strength']."', '".$s_a['phys_endur']."', '".$s_a['shoot_tech']."', '".$s_a['shoot_calm']."', '".$s_a['shoot_acc']."', '".$s_a['track_tech']."', '".$s_a['track_spd']."', '".$s_a['sportsman_prof']."', '".$s_a['popularity']."', '".$s_a['overall_rating']."', '".$s_a['salary']."', '".$s_a['days_actual']."', '".$s_a['phys_strength_mvu']."', '".$s_a['phys_endur_mvu']."', '".$s_a['shoot_tech_mvu']."', '".$s_a['shoot_calm_mvu']."', '".$s_a['shoot_acc_mvu']."', '".$s_a['track_tech_mvu']."', '".$s_a['track_speed_mvu']."');";
        $this->db->query($sql);
        
        
        //print("<pre>");
        //print_r($s_a);
        //print("</pre>");
        //print($sql);
      }
    }
    
    function get_rsm_team_id($ion_id) {
      
      //echo($ion_id->user_id);
      $sql = "SELECT rsm_id  FROM `rsm_user` WHERE `ion_id` = ".($ion_id->user_id)." ";
      //print($sql);
      $query = $this->db->query($sql);
    
      $id=$query->result_array();
      $id=$id[0]['rsm_id'];
      //print('RSM ID='.$id);
      return $id;
    }

    function get_rsm_team_league_id($team_id) {
      
      //echo($ion_id->user_id);
      $sql = "SELECT league_id FROM `rsm_team` WHERE `team_id` = ".$team_id." ";
      $query = $this->db->query($sql);
    
      $id=$query->result_array();
      $id=$id[0]['league_id'];
      //print('ID='.$id);
      return $id;
    }    
    
    function get_current_day()
    {
        $query = $this->db->query('SELECT day_id FROM rsm_live');
        return $query->result();
    }

    function get_season_num($day_id)
    {
        $query = $this->db->query('SELECT season_id FROM `rsm_season` WHERE `day_id` = '.$day_id.' ');
        $cur_season = $query->row()->season_id;
        return $cur_season;
    }    
    
    function increase_current_day($next_day)
    {
        $query = $this->db->query('UPDATE `rsm_live` SET `day_id` = '.$next_day.' WHERE `rsm_live`.`id` = 1;');
    }
    
    function change_balance($team_id, $op_type, $delta) {
      
      
      $sql = "SELECT * FROM `rsm_team_balance_operation` WHERE `rsm_team_balance_operation_id` = ".$op_type." "; //SELECT * FROM `rsm_team_balance_operation` WHERE `rsm_team_balance_operation_id` = 1
      //print($sql);
      $query = $this->db->query($sql);
      $query=$query->result_array();
      //echo("K=".$query[0]['op_koef']."<br>");
      $koef_op=$query[0]['op_koef'];
      $delta2=$koef_op*$delta;
      
      $sql = "SELECT rsm_team_balance_current FROM `rsm_team_balance` WHERE rsm_team_balance_team_id = ".$team_id." ";
      $query = $this->db->query($sql);
      foreach ($query->result_array() as $balance){
        $new_balance=$balance['rsm_team_balance_current'] + $delta2;
        //echo("Team=".$team_id." OLD B=".$balance['rsm_team_balance_current']." NEW B=".$new_balance."<br>");
        $sql = "UPDATE `rsm_team_balance` SET `rsm_team_balance_current` = '".$new_balance."' WHERE `rsm_team_balance_id` = ".$team_id." ";
        $query = $this->db->query($sql);
        
        $data['day']=$this->Next_model->get_current_day();
        $day=(array)$data['day'];
        $day=(array)$day[0];
        $current_day=$day['day_id'];
        //$next_day=$data['current_day']+1;
        //$cur_day=1;
        $cur_time = date("H:i:s"); 
        $sql = "INSERT INTO `rsm_team_balance_transaction` (`transaction_id`, `team_id`, `transaction_day`, `transaction_time`, `transaction_type`, `transaction_sum`) VALUES (NULL, ".$team_id.", '".$current_day."', '".$cur_time."', '".$op_type."', '".$delta."');";
        $query = $this->db->query($sql);
        //echo($sql);
        
        if ($op_type==15) { //check credit
          $sql = "SELECT * FROM `rsm_team_credit` WHERE `team_id` = ".$team_id." ";
          $query = $this->db->query($sql);
          //print_r($query->result_array());
          $data=$query->result_array();

          $paid = $data[0]['paid'] + $delta;
          $weeks = $data[0]['weeks_left']-1;
          $sql = "UPDATE `rsm_team_credit` SET `paid` = '".$paid."', `weeks_left` = '".$weeks."' WHERE `rsm_team_credit_id` = ".$data[0]['rsm_team_credit_id'].";";
          $this->db->query($sql);  
          //echo($sql);
          if ($weeks==0) {

            $title = "Loan repaid!";
            $preview = "Loan repaid!";
            $content = "Your loan with total sum ".$paid." repaid!";
            $this->Office_model->create_news('1', '1', $team_id, $title, $preview, $content);
            
            $sql = "DELETE FROM `rsm_team_credit` WHERE `rsm_team_credit_id` = ".$data[0]['rsm_team_credit_id'].";";
            $this->db->query($sql);
          }
          
          //ПРОПИСАТЬ ПРИ 0
        }
        
      }
      
    }
    
    //function get_staff_salary
    function get_team_num () {
      $sql = "SELECT COUNT(*) FROM rsm_team";
      $query = $this->db->query($sql);
      //print_r($query->result_array());
      foreach ($query->result_array() as $row){
        return $row['COUNT(*)'];
      }
    }
    
    function insert_daily_payment($day_id, $team_id, $type_op, $sum) {
      
      $sql = "INSERT INTO `rsm_team_daily_payments` (`daily_payments_id`, `day_id`, `team_id`, `balance_operation_id`, `payment_sum`) VALUES (NULL, '".$day_id."', '".$team_id."', '".$type_op."', '".$sum."');"; 
      $this->db->query($sql);
      //print($sql."<br>");
      
    }
    
    function do_daily_payments() {
      $sql_day = "SELECT day_id FROM `rsm_live` WHERE `id` = 1";
      $query_day = $this->db->query($sql_day);
      $day=$query_day->result_array();
      $day=$day[0]['day_id'];
      
      $sql = "SELECT * FROM `rsm_team_daily_payments` WHERE `day_id` = ".$day." ";
      //print($sql."<br>");
      $query = $this->db->query($sql);
      $data=$query->result_array();
      if (isset($data[0])){
        //print_r($query->result_array());
        $this->Next_model->change_balance($data[0]['team_id'], $data[0]['balance_operation_id'], $data[0]['payment_sum']);
      }
      
      //ADD NEWS FOR DAILY PAYMENT
      //$this->Office_model->create_news('1', '1', $team_id, $title, $preview, $content);
    }
    
    
    function get_staff_salary() {
      $team_num=$this->Next_model->get_team_num();
      for ($i = 1; $i <= $team_num; $i++) {
        $team_id = $i;
        $sql = "SELECT salary FROM `rsm_staff` 
LEFT OUTER JOIN rsm_staff_salary ON rsm_staff.rsm_staff_id = rsm_staff_salary_id
WHERE `team_id` = ".$team_id." ";
        $query = $this->db->query($sql);
        $staff_salary=0;
        foreach ($query->result_array() as $row){
          $staff_salary=$staff_salary + $row['salary'];
        }
        $this->Next_model->change_balance($team_id, 9, $staff_salary);
      }
    }

    function get_sportsman_salary() {
      $team_num=$this->Next_model->get_team_num();
      for ($i = 1; $i <= $team_num; $i++) {
        $team_id = $i;
        $sql_salary = "SELECT salary FROM `rsm_sportsman` LEFT OUTER JOIN rsm_sportsman_salary ON rsm_sportsman_salary.rsm_sportsman_salary_id = rsm_sportsman.sportsman_id WHERE `team_id` =  ".$team_id." ";
        //echo($sql_salary);
        $query = $this->db->query($sql_salary);
        $sportsman_salary=0;
        foreach ($query->result_array() as $row){
          $sportsman_salary=$sportsman_salary + $row['salary'];
          //echo($row['salary']);
        }
        //echo($sportsman_salary);
        $this->Next_model->change_balance($team_id, 8, $sportsman_salary);
      }
    }

    function get_stadium_cost() {
      
      $team_num=$this->Next_model->get_team_num();
      for ($i = 1; $i <= $team_num; $i++) {
        $team_id=$i;
        $sql = "SELECT * FROM `rsm_stadium`
        LEFT OUTER JOIN rsm_stadium_building_level ON rsm_stadium.stadium_building_level_id = rsm_stadium_building_level.rsm_stadium_building_level_id
        WHERE team_id = ".$team_id." ";
        $query = $this->db->query($sql);
        //print_r($query->result_array());
        $stadium_cost=0;
        foreach ($query->result_array() as $row){
          if ($row['stadium_building_days_next'] > 0) {//if under construction
            //echo('ZZZ');
            $sql = "SELECT maintenance_cost FROM `rsm_stadium_building_level` WHERE stadium_building_id = ".$row['stadium_building_id']." AND stadium_building_level = ".($row['stadium_building_level']-1)."; ";
            $new_cost_db = $this->db->query($sql);
            //print_r($new_cost_db->result_array());
            foreach ($new_cost_db->result_array() as $new)
            {
              $stadium_cost = $new['maintenance_cost'] + $stadium_cost;
            }
            //echo("ZZZ");
          }
          else $stadium_cost = $row['maintenance_cost'] + $stadium_cost;
        }
        //echo("Stad cost=".$stadium_cost." ");
        $this->Next_model->change_balance($team_id, 11, $stadium_cost);
        //return($stadium_cost);
      }
    }
    
    function get_infra_cost(){
      $team_num=$this->Next_model->get_team_num();
      for ($i = 1; $i <= $team_num; $i++) {
        $team_id=$i;
        $sql = "SELECT * FROM rsm_infrastructure
  LEFT OUTER JOIN rsm_infrastructure_building_level ON rsm_infrastructure_building_level.building_level_id  = rsm_infrastructure.building_level_id
  WHERE team_id = ".$team_id.";";
        $query = $this->db->query($sql);
        //print_r($query->result_array());
        $infra_cost=0;
        foreach ($query->result_array() as $row){
          if ($row['days_next'] > 0) {//if under construction
            //echo('ZZZ');
            $sql = "SELECT `maintenance_cost` FROM `rsm_infrastructure_building_level` WHERE building_id = ".$row['building_id']." AND building_level = ".($row['building_level']-1)." ";
            $new_cost_db = $this->db->query($sql);
            //print_r($new_cost_db->result_array());
            foreach ($new_cost_db->result_array() as $new)
            {
              $infra_cost = $new['maintenance_cost'] + $infra_cost;
            }
            //echo("ZZZ");
          }
          else $infra_cost = $row['maintenance_cost'] + $infra_cost;
        }
        $this->Next_model->change_balance($team_id, 10, $infra_cost);
        //echo($infra_cost);
        //return($infra_cost);
      }
    }
    
    
    //sponsors money
    function get_sponsors_money() {
      //print('zzz<br>');
      $team_num=$this->Next_model->get_team_num();
      for ($i = 1; $i <= $team_num; $i++) {

        $team_id=$i;
        
        //general sponsor
        $sql1 = "SELECT sponsor_daily FROM `rsm_team`
LEFT OUTER JOIN rsm_sponsor ON rsm_sponsor.sponsor_id = rsm_team.sponsor_id
WHERE team_id = ".$team_id." ";
        //print($sql1);
        $query = $this->db->query($sql1);
        //print("<pre>");
        //print_r($query->result_array()); 
        //print("</pre>");
        foreach ($query->result_array() as $row){
          
          //echo('1<br>');
          $this->Next_model->change_balance($team_id, 2, $row['sponsor_daily']);
        }
        //media sponsor
        $sql = "SELECT sponsor_daily FROM `rsm_team`
LEFT OUTER JOIN rsm_sponsor ON rsm_team.sponsor2 = rsm_sponsor.sponsor_id 
WHERE team_id = ".$team_id." ";
        $query = $this->db->query($sql);  
        foreach ($query->result_array() as $row){
          $this->Next_model->change_balance($team_id, 3, $row['sponsor_daily']);
        }
        
      }
    }
    
    
    
    function get_trainings_num()
    {
      $query = $this->db->query('SELECT COUNT(*) FROM rsm_sportsman_training;');
      return $query->result();
    }
    
    
    function increase_training()
    {
      function get_sportman_age_days($sportsman_id) //ЗАВИСИТ ОТ НАСТРОЕК СЕЗОНА - ДОБАВИТЬ В БАЗУ
      {
        $sql = 'SELECT age, bday FROM `rsm_sportsman` WHERE `sportsman_id` = '.$sportsman_id.' ';
        $sql_age = mysql_query($sql);
        while ($row = mysql_fetch_assoc($sql_age)) {
              $age=$row['age'];
              $bday=$row['bday'];
          }
          $age_days=($age-15)*35;
          
        $sql_day = 'SELECT day_id FROM `rsm_live`  ';
        $sql_day_live = mysql_query($sql_day);
        while ($row_day = mysql_fetch_assoc($sql_day_live)) {
              $curr_day=$row_day['day_id'];
          }
          
          $age_days=$age_days + $curr_day;
          
          
          return($age_days);
      }
    
      //********************************
          
function rsm_training_test($p)
{
	$day=$p['day']; //возвраст игрока в днях
	$talant=$p['talant']; //талант навыка
	$tmp_v=$p['value']; //текущее значение скилл
	$profi=$p['profi']; //профессионализм
	$sk=$p['building_k']; //коэффициент строений
	
	//Настройки скрипта
	$main=100; //используется в качество основы для возведения в степень на этапе молодости
	$lim=999; //максимальное значение навыка
	$s1k=1; //общий понижающий кэф для первого периода
	$p1k=0.1; //коэффициент влияния профессионализма в молодости
	$p2k=0.15; //коэффициент влияния профессионализма на основной карьере
	$p3k=0.6; //коэффициент влияния профессионализма в расцвете
	$t1k=1-$p1k; //коэффициент для таланта в молодости
	$t2k=0; //коэффициент влияния таланта на основной карьере
	$t3k=0.4; //коэффициент влияния таланта в расцвете
	$vbr=rand(75,125)/100;

	//1. Молодость
	if($day<=300) //Возраст в днях 300 - 6 сезонов - 15-16-17-18-19-20
	{
		$base=1-$tmp_v/(0.01*($p1k*$profi+$t1k*$talant)*$lim); //число на которое умножается талант является фактически ограничителем развития навык в процентах от таланта
		$delta=$s1k*pow($main,$base);
	}
	
	//3. Расцвет
	elseif($day>=400 and $day<=500) //100 дней - два сезона расцвета
	{
		$delta=0.5*($p3k*$profi+$t3k*$talant)*(1-$tmp_v/($lim));
	}
	
	//2. Обычное развитие
	else
	{
		$delta=$p2k*$profi*(1-$tmp_v/($lim)); //добавляем фактор текущего значения навыка
	}

	//4. Стагнация
	//5. Закат
	
	
	$delta=ROUND($sk*$delta*$vbr);
	if(($delta+$tmp_v)>=999) //Если достигнем максимального значения
	{
		$training['value']=999; //устанавливаем новое значение навыка 999
		$training['delta']=$tmp_v-999; //величину тренировки
	}
	else
	{
		$training['value']=$tmp_v+$delta;
		$training['delta']=$delta;
	}
	return($training); //возвращаем массив с новым значением и величиной тренировки
}
//********************************
      
      
      
      //UPDATE SPORTSMAN DATA
      
      $query = $this->db->query('SELECT
                                rsm_sportsman.*,
                                rsm_sportsman_training.*,
                                rsm_sportsman_training_type.*,
                                rsm_infrastructure.*,
                                rsm_infrastructure_building_level.*,
                                rsm_sportsman_talent.*,
                                rsm_sportsman_injury.duration
                                FROM `rsm_sportsman` 
      LEFT OUTER JOIN rsm_sportsman_training ON rsm_sportsman.sportsman_id = rsm_sportsman_training.sportsman_id
      LEFT OUTER JOIN rsm_sportsman_training_type ON rsm_sportsman_training.training_type = rsm_sportsman_training_type.rsm_sportsman_training_type_id
      LEFT OUTER JOIN rsm_infrastructure ON rsm_sportsman.team_id=rsm_infrastructure.team_id AND rsm_infrastructure.building_id = 1
      LEFT OUTER JOIN rsm_infrastructure_building_level ON rsm_infrastructure.building_level_id = rsm_infrastructure_building_level.building_level_id 
      LEFT OUTER JOIN rsm_sportsman_talent ON rsm_sportsman_talent.rsm_sportsman_id = rsm_sportsman_training.sportsman_id
      LEFT OUTER JOIN rsm_sportsman_injury ON rsm_sportsman.sportsman_id = rsm_sportsman_injury.sportsman_id 
      ORDER BY `rsm_sportsman`.`sportsman_id` ASC');
      
      $query->result_array(); 
      //print_r("<pre>".$query."</pre>");
      //echo("<pre>");
      //print_r($query);
      //echo("</pre>");
      $i=0;
      foreach ($query->result_array() as $row)
      {
        if(!isset($row['duration']) OR $row['duration']==0) { //check injury #Не тренируется
     
          //print_r($row);  
          if($row['days_next']>0) { //if construction is in progress -> select previous level
          
            $building_level = $row['building_level']-1;
            //$old_level=$row['building_level']-1;
              //$sql = "SELECT training_up FROM `rsm_infrastructure_building_level` WHERE `building_id` = ".$row['building_id']." AND `building_level` = ".$old_level.";";
              //$query2 = $this->db->query($sql);
              //if ($query2->num_rows() > 0)
              //{
              //   $row2 = $query2->row();
              //   $row['training_up']=$row2->training_up;
              //}
            }
          
          else $building_level = $row['building_level'];
          
          if($row['infr_id']>=1)
          {
            //увеличиваем параметр - это увеличение текущего значения, вставляем функцию Артема
            
            //$delta=1;
            switch ($row['training_type']) {
            case 1:
                $talant_type=$row['phys_strength_mvu'];
                break;
            case 2:
                $talant_type=$row['phys_endur_mvu'];
                break;
            case 3:
                $talant_type=$row['shoot_tech_mvu'];
                break;
            case 4:
                $talant_type=$row['shoot_calm_mvu'];
                break;
            case 5:
                $talant_type=$row['shoot_acc_mvu'];
                break;
            case 6:
                $talant_type=$row['track_tech_mvu'];
                break;
            case 7:
                $talant_type=$row['track_speed_mvu'];
                break;
          }
        
          $building_koef = 0.8+0.02*$building_level;
          
          $age=get_sportman_age_days($row['sportsman_id']);
          
          //print($age."<br>");
          
          $current_player = array("day"=>$age, "talant"=>$talant_type, "value" => $row[$row['parametr']], "profi" => $row['sportsman_prof'], "building_k" => $building_koef);
        //echo("I=".$i."<br>");
        //echo("<pre>");     
             //print_r($current_player);
             //echo("</pre>");
            $new_data=rsm_training_test($current_player);        
            
            $delta = $new_data['delta'];
            //echo("DELTA=".$delta."<br>");
             
            //echo($delta."<br>");
            $new_value=$row[$row['parametr']]+$delta;//увеличение параметра
            //echo("NEW=".$new_value."<br>"); 
            $sportsman_id=$row['sportsman_id'];
            //echo("S_ID=".$sportsman_id."<br>");  
            $change_param=$row['parametr'];
            $sql='UPDATE rsm_sportsman SET '.$change_param.' = '.$new_value.' where sportsman_id='.$sportsman_id;//Update sportsman data
            $query = $this->db->query($sql);
            $sql='UPDATE rsm_sportsman_training SET last_training = '.$delta.' where sportsman_id='.$sportsman_id;//Adding last train value
            $query = $this->db->query($sql);
            //Calculating new OR
            $new_or=floor($row['phys_strength']+$row['phys_endur']+$row['shoot_tech']+$row['shoot_calm']+$row['shoot_acc']+$row['track_tech']+$row['track_spd']);
            $sql='UPDATE rsm_sportsman SET overall_rating = '.$new_or.' where sportsman_id='.$sportsman_id;//Update sportsman data
            $query = $this->db->query($sql);
            
            //получаем текущий день
            $sql_day = 'SELECT * FROM `rsm_live` WHERE `id` = 1';
            $query_day = $this->db->query($sql_day);
            foreach ($query_day->result_array() as $row_day)
            { $current_day=$row_day['day_id'];}
            
            //запись лога
            $sql='INSERT INTO rsm_sportsman_training_log (`rsm_sportsman_training_log_id`, `day_id`, `sportsman_id`, `training_type`, `old_value`, `new_value`, `delta_value`) VALUES (NULL, '.$current_day.', '.$sportsman_id.', '.$row['training_type'].', '.$row[$row['parametr']].', '.$new_value.', '.$delta.')'  ; 
            //echo('sql_log='.$sql.'<br>');
            $query = $this->db->query($sql);
          }
          $i++;
      }
      //} 
        //
      } 
    }
    
    function delete_season() {
      $sql = 'TRUNCATE TABLE rsm_season';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_track';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_race';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_race_sportsman_list';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_sportsman_training_log';
      $this->db->query($sql);
      $sql = 'UPDATE rsm_live SET `day_id` = 1 WHERE `rsm_live`.`id` = 1';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_logr';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_logs';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_race_team_list';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_race_weather';
      $this->db->query($sql);      
      $sql = 'TRUNCATE TABLE rsm_race_weather_forecast';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_team';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_sportsman';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_sportsman_training';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_sportsman_talent';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_sportsman_talent_fake';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_infrastructure';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_stadium';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_sportsman_statistic';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_sponsor';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_team_balance';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_staff';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_team_balance_transaction';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_sportsman_salary';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_staff_salary';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_sportsman_injury';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_team_statistic';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_team_statistic_log';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_sportsman_history';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_scouting';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_sportsman_injury';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_news';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_team_credit';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_team_credit_offer';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_team_daily_payments';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_sportsman_talent_scouted';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_sportsman_academy';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_league';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_league_standings';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_team_basic_rating';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_race_playoff';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_league_playoff';
      $this->db->query($sql);
      $sql = 'TRUNCATE TABLE rsm_league_promotion';
      $this->db->query($sql);      
      $sql = "TRUNCATE TABLE `rsm_race_playoff`";
      $this->db->query($sql);
      $sql = "TRUNCATE TABLE `rsm_league_playoff`";
      $this->db->query($sql);
      
    }
    
    function generate_name($nation) {
      
      $sql="SELECT * FROM `rsm_name_database` WHERE `country_id` = ".$nation." AND `sex` = 1 AND `surname` = 0";
      //echo($sql."<br>");
      $sql_names = mysql_query($sql);
      $count_names = mysql_num_rows($sql_names);
      //get first num of id
      $sql="SELECT * FROM `rsm_name_database` WHERE `country_id` = ".$nation." AND `sex` = 1 AND `surname` = 0 LIMIT 0,1";
      $sql_names_start = mysql_query($sql);
      while ($row = mysql_fetch_assoc($sql_names_start)) {
            $start_name=$row['rsm_name_database_id'];
        }
      $sql = "SELECT * FROM `rsm_name_database` WHERE `country_id` = ".$nation." AND `sex` = 1 AND `surname` = 1";
      $sql_surnames = mysql_query($sql);
      $count_surnames = mysql_num_rows($sql_surnames);
      
      $sql = "SELECT * FROM `rsm_name_database` WHERE `country_id` = ".$nation." AND `sex` = 1 AND `surname` = 1 LIMIT 0,1";
      $sql_surnames_start = mysql_query($sql);
      while ($row = mysql_fetch_assoc($sql_surnames_start)) {
            $start_surname=$row['rsm_name_database_id'];
        }

      $last_name=$start_name+$count_names-1;
      $last_surname=$start_surname+$count_surnames-1;
      //echo("NAME ".$start_name." ".$last_name."<br>");
      //echo("SURNAME ".$start_surname." ".$last_surname."<br>");
      $name1=rand($start_name, $last_name);
      //echo("NAME NUM=".$name1."<br>");
      
      $name2=rand($start_surname, $last_surname);
      //echo("SURNAME NUM=".$name2."<br>");
      
      $sql = "SELECT * FROM `rsm_name_database` WHERE `rsm_name_database_id` = ".($name1).";";
      //echo($sql."<br>");
      $res=mysql_query($sql) or die(mysql_error());
      While ($name = mysql_fetch_row($res))
        {
          $s_name=$name[4];
          //echo($s_name." ");
        }
      
      $sql = "SELECT *  FROM `rsm_name_database` WHERE `rsm_name_database_id` = ".($name2-1).";";
      
      $res=mysql_query($sql) or die(mysql_error());
      While ($name = mysql_fetch_row($res))
        {
          $s_surname=$name[4];
          //echo($s_surname."<br>");
          
        }
        $name['first']=$s_name;
        $name['last']=$s_surname;
        return $name;
        
      }
    function generate_season2($countries)
    {
      foreach ($countries as $season_country) {
        //echo(")
        //print($season_country."<br>");
      }
    }
    
    function generate_season($countries)
    {
      for ($cc=1; $cc<=$countries;$cc++) {

        
        //create teams + create track
        $team_league=16;//teams in league
        $league_num=21; //4 lvl
        //$country_num=1;
        $teams_country=$team_league*$league_num;
        $country_id=$cc;
        $z=1+($cc-1)*$teams_country;
        $team_all=1+($cc-1)*$teams_country;
        //for ($j = 1; $j <= $country_num; $j++) {
          for ($k = 1; $k <= $league_num; $k++) {
            for ($i = 1; $i <= $team_league; $i++) {
            $user_id = $team_all;
            $league_id = $k + ($cc-1)*$league_num;
            $sponsor_id_1 = 2*$team_all-1;
            $sponsor_id_2 = 2*$team_all;
            
            $sql="INSERT INTO `rsm_team` (`team_id`, `user_id`, `country_id`, `league_id`, `team_name`, `sponsor_id`, `sponsor2`, `is_renamed_by_owner`) VALUES (NULL, '".$user_id."', '".$cc."', '".$league_id."', 'Test team #".$team_all."', '".$sponsor_id_1."', '".$sponsor_id_2."', '0');";
            $this->db->query($sql);
            
            //track
            $sql = "INSERT INTO `rsm_track` (`track_id`, `user_id`, `name_en`, `track_logo`, `track_type`, `track_tech`, `track_is_renamed_by_owner`) VALUES (NULL, '".$team_all."', 'Test track ".$team_all."', '', '1', '1', '0');";
            $this->db->query($sql);
              
            $sql = "INSERT INTO `rsm_league_standings` (`standings_id`, `league_id`, `team_id`, `standings_points`) VALUES (NULL, '".$league_id."', '".$team_all."', '0');";
            $this->db->query($sql);
            
            $sql = "INSERT INTO `rsm_team_basic_rating` (`basic_rating_id`, `team_id`, `rating_str`, `rating_endur`, `rating_sh_tech`, `rating_sh_calm`, `rating_sh_acc`, `rating_tr_tech`, `rating_tr_spd`) VALUES (NULL, '".$team_all."', '0', '0', '0', '0', '0', '0', '0');";
            
            $this->db->query($sql);
            
            $team_all++;
            $z++;
            }
          }
        //}
        //echo("Country ID = ".$cc." Team num=".($z-1)."<br>");

        //create leagues

          $sql = "INSERT INTO `rsm_league` (`league_id`, `country_id`, `league_lvl`, `league_num`) VALUES (NULL, '.$cc.', '1', '1');";
          $this->db->query($sql);
          
          for ($j = 1; $j <= 4; $j++) {
            $sql = "INSERT INTO `rsm_league` (`league_id`, `country_id`, `league_lvl`, `league_num`) VALUES (NULL, '".$cc."', '2', '".$j."');";
            $this->db->query($sql);
          }
          for ($j = 1; $j <= 16; $j++) {
            $sql = "INSERT INTO `rsm_league` (`league_id`, `country_id`, `league_lvl`, `league_num`) VALUES (NULL, '".$cc."', '3', '".$j."');";
            $this->db->query($sql);
          }
          //for ($j = 1; $j <= 64; $j++) {
          //  $sql = "INSERT INTO `rsm_league` (`league_id`, `country_id`, `league_lvl`, `league_num`) VALUES (NULL, '".$i."', '4', '".$j."');";
          //  $this->db->query($sql);
          //}

        
        //create sponsors
        
        //print("TEAM NUM=".$team_num."<br>");
        for ($i = 1; $i <= $teams_country; $i++) {
  
          $sponsor_type_general = 1;
          $sponsor_name_general = "General sponsor #"; $sponsor_name_general .= $i + ($cc-1)*$teams_country;
          $sponsor_img_general = "/images/sponsor/sample.gif";
          $sponsor_daily_general = 20000;
          $sponsor_total_general = 700000;
  
          $sponsor_type_media=2;
          $sponsor_name_media = "Media sponsor #"; $sponsor_name_media .= $i + ($cc-1)*$teams_country;
          $sponsor_img_media = "/images/sponsor/media_sample.gif";
          $sponsor_daily_media = 1000;
          $sponsor_total_media = 35000;
  
        $sponsor_rating = rand(1,3);
  
        $sql="INSERT INTO `rsm_sponsor` (`sponsor_id`, `sponsor_type`, `sponsor_name`, `sponsor_img`, `sponsor_daily`, `sponsor_total`, `rating`) VALUES (NULL, '".$sponsor_type_general."', '".$sponsor_name_general."', '".$sponsor_img_general."', '".$sponsor_daily_general."', '".$sponsor_total_general."', '".$sponsor_rating."')";
          $this->db->query($sql);
        $sql="INSERT INTO `rsm_sponsor` (`sponsor_id`, `sponsor_type`, `sponsor_name`, `sponsor_img`, `sponsor_daily`, `sponsor_total`, `rating`) VALUES (NULL, '".$sponsor_type_media."', '".$sponsor_name_media."', '".$sponsor_img_media."', '".$sponsor_daily_media."', '".$sponsor_total_media."', '".$sponsor_rating."')";
          $this->db->query($sql);
          
        }
        
        //create start balance
        $team_start=1 + ($cc-1)*$teams_country;
        $team_end=$teams_country + ($cc-1)*$teams_country;
        
        for ($i = $team_start; $i <= $team_end; $i++) {
        $sql = "INSERT INTO `rsm_team_balance` (`rsm_team_balance_id`, `rsm_team_balance_team_id`, `rsm_team_balance_current`) VALUES (NULL, '".$i."', '1000000');";
          $this->db->query($sql);
        }
        
        //create first transactions 1 000 000 + Other
        for ($i = $team_start; $i <= $team_end; $i++) {
          //general
          $cur_time = date("H:i:s"); 
          $sql = "INSERT INTO `rsm_team_balance_transaction` (`transaction_id`, `team_id`, `transaction_day`, `transaction_time`, `transaction_type`, `transaction_sum`) VALUES (NULL, '".($i+($cc-1)*$teams_country)."', '1', '".$cur_time."', '2', '1000000');";
          $this->db->query($sql);
  
        }
        
        //create random sportsman
        $sportsman_num=6;//in every team
        $i=1;$j=1;
        $s_id=1+($cc-1)*$teams_country*$sportsman_num;
        for ($i = 1; $i <= $teams_country; $i++) {
          for ($j = 1; $j <= $sportsman_num; $j++) {

          $name=$this->Next_model->generate_name($cc);
          $age = rand(15,17);
          $bday = rand(1,35);
          $first_p=50;$second_p=75;
          $param = rand($first_p,$second_p);$param1 = rand($first_p,$second_p);$param2 = rand($first_p,$second_p);$param3 = rand($first_p,$second_p);$param4 = rand($first_p,$second_p);$param5 = rand($first_p,$second_p);$param6 = rand($first_p,$second_p);$param7 = rand($first_p,$second_p);
          $rating=round(($param+$param1+$param2+$param3+$param4+$param5+$param6),0);
  
          $pop = rand(0,3);
          
          $team_id = $i + ($cc-1)*$teams_country;
          
          $sql = "INSERT INTO `rsm_sportsman` (`sportsman_id`, `team_id`, `country_id`, `age`, `bday`, `name1`, `name2`, `team_num`, `phys_energy`, `phys_strength`, `phys_endur`, `shoot_tech`, `shoot_calm`, `shoot_acc`, `track_tech`, `track_spd`, `sportsman_prof`, `popularity`, `overall_rating`) VALUES (NULL, '".$team_id."', '".$country_id."', '".$age."', '".$bday."', '".$name['first']."', '".$name['last']."', '".$j."', '99', '".$param."', '".$param1."', '".$param2."', '".$param3."', '".$param4."', '".$param5."', '".$param6."', '".$param7."', '".$pop."', '".$rating."');";
          $this->db->query($sql);

          
          $t_first=20; $t_second=99;
          $talent1 = rand($t_first,$t_second);$talent2 = rand($t_first,$t_second);$talent3 = rand($t_first,$t_second);$talent4 = rand($t_first,$t_second);$talent5 = rand($t_first,$t_second);$talent6 = rand($t_first,$t_second);$talent7 = rand($t_first,$t_second);
          //talent gen
          
          //$s_id=
          
          $sql = "INSERT INTO `rsm_sportsman_talent` (`rsm_sportsman_talent_id`, `rsm_sportsman_id`, `phys_strength_mvu`, `phys_endur_mvu`, `shoot_tech_mvu`, `shoot_calm_mvu`, `shoot_acc_mvu`, `track_tech_mvu`, `track_speed_mvu`) VALUES ('', '".$s_id."', '".$talent1."', '".$talent2."', '".$talent3."', '".$talent4."', '".$talent5."', '".$talent6."', '".$talent7."');";
          $this->db->query($sql);
          
          //insert fake talent if not scouted
          $talent1 = rand($t_first,$t_second);$talent2 = rand($t_first,$t_second);$talent3 = rand($t_first,$t_second);$talent4 = rand($t_first,$t_second);$talent5 = rand($t_first,$t_second);$talent6 = rand($t_first,$t_second);$talent7 = rand($t_first,$t_second);
          $sql = "INSERT INTO `rsm_sportsman_talent_fake` (`rsm_sportsman_talent_fake_id`, `rsm_sportsman_id`, `phys_strength_mvu`, `phys_endur_mvu`, `shoot_tech_mvu`, `shoot_calm_mvu`, `shoot_acc_mvu`, `track_tech_mvu`, `track_speed_mvu`) VALUES ('', '".$s_id."', '".$talent1."', '".$talent2."', '".$talent3."', '".$talent4."', '".$talent5."', '".$talent6."', '".$talent7."');";
          $this->db->query($sql);
  
          //training_type gen
          $sql = "INSERT INTO `rsm_sportsman_training` (`training_id`, `sportsman_id`, `training_type`, `last_training`) VALUES (NULL, '".$s_id."', '1', '0');";
          $this->db->query($sql);
          
          //insert zero statistic
          
          $sql="INSERT INTO `rsm_sportsman_statistic` (`rsm_sportsman_statistic_id`, `sportsman_id`, `season_id`, `races_num`, `points`, `hits`, `shots`, `races_win`, `podiums`, `top8`, `top_speed`, `shooting_stat`, `shooting_lay_stat`, `shooting_stand_stat`) VALUES (NULL, '".$s_id."', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');";
          $this->db->query($sql);
          
          //insert salary
          $sportsman_salary = $rating * 10 + rand(100,300);
          $sql = "INSERT INTO `rsm_sportsman_salary` (`rsm_sportsman_salary_id`, `salary`) VALUES (NULL, '".$sportsman_salary."');";
          $this->db->query($sql);
          
          $s_id++;
          }
        }
        //create staff
        $staff_num=7; // 7 types
        $j=1;
        for ($j = 1; $j <= $teams_country; $j++){ 
          for ($i = 1; $i <= $staff_num; $i++) {
          //main   
          $staff_age = rand(45,55);
          //$country=array(1=>1, 3, 6, 5, 7);
          //$country_id=rand(1,5);
          
          $name=$this->Next_model->generate_name($cc);
          $staff_p1 = rand(5,15);
          $staff_p2 = rand(5,15);
          
          $team_id = $j + ($cc-1)*$teams_country;
               
          $sql = "INSERT INTO `rsm_staff` (`rsm_staff_id`, `rsm_staff_type_id`, `country_id`, `team_id`, `age`, `bday`, `name1`, `name2`, `skill1`, `skill2`, `staff_status`) VALUES (NULL, '".$i."', '".$country_id."', '".$team_id."', '".$staff_age."', '1', '".$name['first']."', '".$name['last']."', '".$staff_p1."', '".$staff_p2."', '1');";
          $this->db->query($sql);
          $staff_salary=($staff_p1+$staff_p2)*100;
          $sql = "INSERT INTO `rsm_staff_salary` (`rsm_staff_salary_id`, `salary`) VALUES (NULL, '".$staff_salary."')";
          $this->db->query($sql);
          
          //second ON 10.06 //OFF 09.06 ->only 1 staff of 1 type
          $staff_age = rand(45,55);

          $name=$this->Next_model->generate_name($cc);
          $staff_p1 = rand(5,15);
          $staff_p2 = rand(5,15);
          $sql = "INSERT INTO `rsm_staff` (`rsm_staff_id`, `rsm_staff_type_id`, `country_id`, `team_id`, `age`, `bday`, `name1`, `name2`, `skill1`, `skill2`, `staff_status`) VALUES (NULL, '".$i."', '".$country_id."', '".$team_id."', '".$staff_age."', '1', '".$name['first']."', '".$name['last']."', '".$staff_p1."', '".$staff_p2."', '0');";
          $this->db->query($sql);
          $staff_salary=($staff_p1+$staff_p2)*100;
          $sql = "INSERT INTO `rsm_staff_salary` (`rsm_staff_salary_id`, `salary`) VALUES (NULL, '".$staff_salary."')";
          $this->db->query($sql);
          }
          
        }
        //create infrastructure
        $i=1;$j=1;$infr_id = array ( 1=>1, 4, 7, 10, 13, 16, 19);
        for ($i = 1; $i <= $teams_country; $i++) {
          for ($j = 1; $j <= 7; $j++) {
          $sql = "INSERT INTO `rsm_infrastructure` (`infr_id`, `team_id`, `building_id`, `building_level_id`, `days_next`) VALUES (NULL, '".($i+($cc-1)*$teams_country)."', '".$j."', '".$infr_id[$j]."', '0');";  
          $this->db->query($sql);
          } 
        }
        
        //create stadium
        $i=1;$j=1;$stad_id = array ( 1=>1, 7, 8, 9, 10, 12);
        for ($i = 1; $i <= $teams_country; $i++) {
          for ($j = 1; $j <= 6; $j++) {
          $sql = "INSERT INTO `rsm_stadium` (`rsm_stadium_id`, `team_id`, `stadium_building_id`, `stadium_building_level_id`, `stadium_building_days_next`) VALUES (NULL, '".($i+($cc-1)*$teams_country)."', '".$stad_id[$j]."', '".$j."', '0');";
          $this->db->query($sql);
          } 
        }
  
        //FINANCE *** FINANCE
        //sportsman salary
        for ($j = 1; $j <= $teams_country; $j++){
          $salary_total = 0;
          $team_id = $j + ($cc-1)*$teams_country;
          $sql = "SELECT salary FROM `rsm_sportsman` LEFT OUTER JOIN rsm_sportsman_salary ON rsm_sportsman_salary.rsm_sportsman_salary_id = rsm_sportsman.sportsman_id WHERE team_id=".$team_id." ";
          $res=mysql_query($sql) or die(mysql_error());
          While ($salary = mysql_fetch_row($res)){
            $salary_total = $salary_total + $salary[0];
            //
          }
          //echo("total=".$salary_total."<br>");
          $cur_time = date("H:i:s"); 
          $sql = "INSERT INTO `rsm_team_balance_transaction` (`transaction_id`, `team_id`, `transaction_day`, `transaction_time`, `transaction_type`, `transaction_sum`) VALUES (NULL, '".$team_id."', '1', '".$cur_time."', '8', '".$salary_total."');";
          $this->db->query($sql);
          
          //staff salary
          
          $salary_staff_total = 0;
          $team_id = $j + ($cc-1)*$teams_country;
          $sql = "SELECT salary FROM `rsm_staff` LEFT OUTER JOIN rsm_staff_salary ON rsm_staff_salary.rsm_staff_salary_id = rsm_staff.rsm_staff_id WHERE team_id=".$team_id." ";
          $res=mysql_query($sql) or die(mysql_error());
          While ($salary = mysql_fetch_row($res)){
            $salary_staff_total = $salary_staff_total + $salary[0];
            //
          }
          //echo("total=".$salary_total."<br>");
          $cur_time = date("H:i:s");
          $sql = "INSERT INTO `rsm_team_balance_transaction` (`transaction_id`, `team_id`, `transaction_day`, `transaction_time`, `transaction_type`, `transaction_sum`) VALUES (NULL, '".$team_id."', '1', '".$cur_time."', '9', '".$salary_staff_total."');";
          $this->db->query($sql);
          
  
          $stadium_cost = 0;
          $team_id = $j + ($cc-1)*$teams_country;
          
          $sql = "SELECT maintenance_cost FROM `rsm_stadium_building_level` WHERE `stadium_building_level` = 1";
          $res=mysql_query($sql) or die(mysql_error());
          While ($stad_cost = mysql_fetch_row($res)){
            $stadium_cost = $stadium_cost + $stad_cost[0];
          }
          $cur_time = date("H:i:s");
          $sql = "INSERT INTO `rsm_team_balance_transaction` (`transaction_id`, `team_id`, `transaction_day`, `transaction_time`, `transaction_type`, `transaction_sum`) VALUES (NULL, '".$team_id."', '1', '".$cur_time."', '11', '".$stadium_cost."');";
          $this->db->query($sql);        
          
          $infrastructure_cost = 0;
          $team_id = $j + ($cc-1)*$teams_country;
          
          $sql = "SELECT maintenance_cost FROM `rsm_infrastructure_building_level` WHERE `building_level` = 1";
          $res=mysql_query($sql) or die(mysql_error());
          While ($infr_cost = mysql_fetch_row($res)){
            $infrastructure_cost = $infrastructure_cost + $infr_cost[0];
          }
          $cur_time = date("H:i:s");
          $sql = "INSERT INTO `rsm_team_balance_transaction` (`transaction_id`, `team_id`, `transaction_day`, `transaction_time`, `transaction_type`, `transaction_sum`) VALUES (NULL, '".$team_id."', '1', '".$cur_time."', '10', '".$infrastructure_cost."');";
          $this->db->query($sql);    
  
  
          $total_expenses = $salary_total + $salary_staff_total + $stadium_cost + $infrastructure_cost;
          $team_id = $j + ($cc-1)*$teams_country;
          $sql = "SELECT `rsm_team_balance_current` FROM `rsm_team_balance` WHERE `rsm_team_balance_team_id` = ".$team_id." ";
          $res=mysql_query($sql) or die(mysql_error());
          While ($balance = mysql_fetch_row($res)){
            $new_balance=$balance[0]-$total_expenses;
            $sql_update = "UPDATE `rsm_team_balance` SET `rsm_team_balance_current` = '".$new_balance."' WHERE `rsm_team_balance`.`rsm_team_balance_team_id` = ".$team_id." ";
            $this->db->query($sql_update);
            //echo($sql_update);
          }
        }

        //clear last training value
        $query = $this->db->query('SELECT * FROM `rsm_sportsman_training`
        ORDER BY `rsm_sportsman_training`.`training_id` ASC');
        $query->result_array();
        foreach ($query->result_array() as $row)
        {
          $sql='UPDATE rsm_sportsman_training SET last_training = 0 where training_id='.$row['training_id'];
          //echo($sql);
          $query = $this->db->query($sql);
        }  
  
        //get current date
        $current_year=date("Y");
        $current_month=date("m");
        //$current_month=2;//february
        //$current_day=date("j");
        $current_day=1;
        $day=$current_day;
        for($j=1; $j<=5; $j++){
          for ($i=1; $i<=35; $i++) { //35 дней в сезоне
          //echo('i='.$i.' day='.$day.'<br>');
            $date=date("Y-m-j",mktime(0, 0, 0, $current_month, $day, $current_year));
            $sql = 'INSERT INTO rsm_season (`day_id`, `season_id`, `day_num`, `real_date`) VALUES (NULL, '.$j.', '.$i.', \''.$date.'\')';
            //echo($sql);
            $this->db->query($sql);
            
            //echo ($date.'<br>');
            $day=$current_day+$i;
          }
        }
        //race days generation
        //$league_num - num of leagues
        $i=1;
        for ($j=1;$j<=$league_num;$j++) {
          $race_days = array(1 => 1, 2, 4, 5, 7, 8, 9, 11, 12, 14, 15, 16, 18, 19, 21, 22);
          $num_race = 16; //races in season
          //$i=$i+16;
          foreach ($race_days as $race_day) {
            $race_track_id=$i+($cc-1)*$teams_country;
            $league_id=$j+($cc-1)*$league_num;
            $sql = "INSERT INTO rsm_race (`race_id`, `day_id`, `league_id`, `track_id`, `race_type`) VALUES (NULL, '".$race_day."', '".$league_id."', '".$race_track_id."', '0')";
            $this->db->query($sql);
            $i++;
            //echo $sql;
          }
        }
        
        //weather +weather forecast generation
        for ($z=0;$z<$league_num;$z++){
          $i=1;
          for ($i = 1; $i <= $num_race; $i++) {
            
            $weather_race_id = $i + $z*$num_race + ($cc-1)*$teams_country;
            //print("CC=".$cc."<br>");
            //print("teams_c=".$teams_country."<br>");
            //print("WRID=".$weather_race_id."<br>");
            
            //weather
            $temperature = rand(-5,5);
            $wind_type = rand(0,1);
            $wind_speed = rand(0,7);
            $fog = rand(0,1);
            $sun = rand(0,2);
            $rain = rand(0,1);
            $snow = rand(0,3);
            $humidity = rand(70,99);
            
            $sql = "INSERT INTO `rsm_race_weather` (`rsm_race_weather_id`, `rsm_race_id`, `rsm_race_weather_forecast_id`, `temperature`, `wind_type`, `wind_speed`, `fog_type`, `sun_type`, `rain_type`, `snow_type`, `humidity`) VALUES (NULL, '".$weather_race_id."', '".$weather_race_id."', '".$temperature."', '".$wind_type."', '".$wind_speed."', '".$fog."', '".$sun."', '".$rain."', '".$snow."', '".$humidity."');";
            //print($sql."<br>");
            mysql_query($sql);
            $weather_race_id = $i + $z*$num_race + ($cc-1)*$teams_country;
            //forecast
            $temperature = rand(-5,5);
            $wind_type = rand(0,1);
            $wind_speed = rand(0,7);
            $fog = rand(0,1);
            $sun = rand(0,2);
            $rain = rand(0,1);
            $snow = rand(0,3);
            $humidity = rand(70,99);
            
            $sql = "INSERT INTO `rsm_race_weather_forecast` (`rsm_race_weather_forecast_id`, `rsm_race_id`, `temperature`, `wind_type`, `wind_speed`, `fog_type`, `sun_type`, `rain_type`, `snow_type`, `humidity`) VALUES (NULL, '".$weather_race_id."', '".$temperature."', '".$wind_type."', '".$wind_speed."', '".$fog."', '".$sun."', '".$rain."', '".$snow."', '".$humidity."');";
            mysql_query($sql);
            //echo($sql."<br>");
          }
        }
        //sportsman 4 race list generation
        //$league_num - num of leagues
        for ($z=0;$z<$league_num;$z++){
          $i=1;
          for ($i = 1; $i <= $num_race; $i++) {
            $race_sp_team_id=$i+$z*$team_league+($cc-1)*$teams_country;
            $sql = 'SELECT * FROM `rsm_sportsman` WHERE `team_id` = '.$race_sp_team_id.' ORDER BY `team_id` ASC LIMIT 0, 3';
            $query = $this->db->query($sql);
            foreach ($query->result_array() as $row)
            {
              for ($j = 1; $j <= $num_race; $j++) {
                $race_sp_list_id=$j+($z*$num_race)+($cc-1)*$teams_country;
                $sql='INSERT INTO rsm_race_sportsman_list (`rsm_race_sportsman_list_id`, `race_id`, `team_id`, `sportsman_id`) VALUES (NULL, '.$race_sp_list_id.', '.$race_sp_team_id.', '.$row['sportsman_id'].')';
                //echo($sql.'<br>');
                $query = $this->db->query($sql);
              }
              //
            } 
          }
        }
        //team 4 race list generation
        //$league_num=$league_num+($cc-1)* //$team_league=16
        
        $league_start=1 + ($cc-1)*$league_num;
        $league_end=$league_num + ($cc-1)*$league_num;
        //print("TSTART=".$team_start." TEND=".$team_end."<br>");
        for ($z=$league_start;$z<=$league_end;$z++){
          
          for ($i=1;$i<=$team_league;$i++){
            //$team_list_race_id=$i+($z-1)*16;
            $team_id = $i + ($z-1)*$team_league;
            
            for ($j=1;$j<=$team_league;$j++){
              $race_id = $j + ($z-1)*$team_league;
              $sql="INSERT INTO rsm_race_team_list (`rsm_race_team_list_id`, `race_id`, `team_id`, `race_points`) VALUES (NULL, ".$race_id.", ".$team_id.", 0)";
              $query = $this->db->query($sql);
            }
          }
        }
        
        //Add basic statistic
        
        $team_start=1 + ($cc-1)*$teams_country;
        $team_end=$teams_country + ($cc-1)*$teams_country;
        for ($i = $team_start; $i <=$team_end; $i++) {
        
        $sql_age = "SELECT age FROM `rsm_sportsman` WHERE `team_id` = ".$i.";";
        $query_age = $this->db->query($sql_age);
        
        $age=$query_age->result_array();
        //print("<pre>");
        //print_r($age);
        //print("</pre>");
        $avg_age = round(((array_sum($age[0])+array_sum($age[1])+array_sum($age[2])+array_sum($age[3])+array_sum($age[4])+array_sum($age[5]))/6),1);
        //echo("age=".$avg_age."<br>");
        
        $sql_rating = "SELECT overall_rating FROM `rsm_sportsman` WHERE `team_id` = ".$i.";";
        $query_rating = $this->db->query($sql_rating);
        
        $rating=$query_rating->result_array();
        //print("<pre>");
        //print_r($age);
        //print("</pre>");
        $avg_rating = round(((array_sum($rating[0])+array_sum($rating[1])+array_sum($rating[2])+array_sum($rating[3])+array_sum($rating[4])+array_sum($rating[5]))/6),1);
        //echo("rate=".$avg_rating."<br>");
        
        
        $sql = "INSERT INTO `rsm_team_statistic` (`rsm_team_statistic_id`, `team_id`, `team_shooting_stat`, `team_avg_speed_stat`, `team_rating_stat`, `team_avg_age`, `team_avg_bld_lvl`, `team_capacity_stadium`, `team_avg_attendance`) VALUES (NULL, '".$i."', '0', '0', '".$avg_rating."', '".$avg_age."', '1', '100', '0');";
        $query = $this->db->query($sql);
        }
      
        $s_id=1+($cc-1)*$teams_country*$sportsman_num;
        
        $team_start=1 + ($cc-1)*$teams_country;
        $team_end=$teams_country + ($cc-1)*$teams_country;
        
        for ($i = $team_start; $i <=$team_end; $i++) {
          for ($j = 1; $j <= $sportsman_num; $j++) {
            //insert player history
            $sql = "INSERT INTO `rsm_sportsman_history` (`rsm_sprortsman_history_id`, `sportsman_id`, `day_id`, `history_action_id`) VALUES (NULL, '".$s_id."', '1', '1');";
            //echo($s_id."<br>");
            $this->db->query($sql);
            $s_id++;
          }
        }
        
        //credit offers

        $team_start=1 + ($cc-1)*$teams_country;
        $team_end=$teams_country + ($cc-1)*$teams_country;        
        
        for ($i = $team_start; $i <=$team_end; $i++) {
          for ($j = 1; $j <= 3; $j++) {
            
            $credit_sum = 1000000+rand(1,100)*1000;
            $interest=rand(10,12);
            $term=rand(2,3);   // WEEKS!       
              
            $sum_total = $credit_sum * (1+($interest/100));
            
            $weekly = $sum_total / $term;
            
            //$credit_sum = 
            
            $sql = "INSERT INTO `rsm_team_credit_offer` (`rsm_team_credit_offer_id`, `team_id`, `credit_sum`, `credit_term`, `interest`, `weekly`, `day_id`) VALUES (NULL, '".$i."', '".$credit_sum."', '".$term."', '".$interest."', '".$weekly."', '1');";
            //echo($sql);
            $this->db->query($sql);
          }
          
        }
      }
    }
   
   function update_building_days(){
    $sql = "SELECT infr_id, days_next, team_id, building_id, building_level_id FROM `rsm_infrastructure`";
    $query = $this->db->query($sql);
    $query->result_array(); 
      //print("<pre>");
      //print_r($query);
      //print("</pre>");
      foreach ($query->result_array() as $row)
      {
        if($row['days_next']>0)
        {
          $new_days=$row['days_next']-1;
          
          if (($new_days) == 0) {
            $author_id = 1;
            $this->load->model('Office_model');
            $team_id = $row['team_id'];
            $title = "New building level!";
            $previous = "Your building is ready";
            $content = "Your building is ready - ";
            $sql1 = "SELECT `building_descr`, `maintenance_cost`, `building_cost` FROM `rsm_infrastructure_building_level` WHERE `building_level_id` = ".($row['building_level_id'])." ";
            //print($sql1."<br>");
            $query1=$this->db->query($sql1);
            $building['descr']=$query1->row()->building_descr;
            $building['cost1']=$query1->row()->maintenance_cost;
            $building['cost2']=$query1->row()->building_cost;
            
            $content .= $building['descr'];
            $content .= ". <a href=\"/infrastructure/facilities/\">Go check it now!</a>";
            //print($content."<br>");
            $this->Office_model->create_news('1', '1', $team_id, $title, $previous, $content);
            //echo('zzzz');
          }
          
          $sql1="UPDATE `rsm_infrastructure` SET `days_next` = '".$new_days."' WHERE `infr_id` = ".$row['infr_id'].";";
          //echo($sql."<br>");
          $query = $this->db->query($sql1);
        }
      }
   }
   
   function update_scouting(){ //update scouting progress
    $sql = "SELECT DISTINCT `team_id` FROM `rsm_scouting`";
    $query = $this->db->query($sql);
    //print("<pre>");
    $teams=$query->result_array();
    foreach ($teams as $data) {
      $sql = "SELECT * FROM `rsm_scouting` WHERE `team_id` = ".$data['team_id']." AND `status` = 0 ORDER BY `rsm_scouting`.`order` ASC"; //if staus=0 => non scouted
      //print($sql."<br>");
      
      $query2 = $this->db->query($sql);
      if ($query2->num_rows() > 0)
      {
         $row = $query2->row_array(); 
          
         //echo $row['sportsman_id'];
         //echo $row['order'];
         //print($row['team_id']."<br>");
         
         //CALCULATE SCOUTING PROGRESS
         //echo $row['progress'];
         
         $query3 = $this->db->query('SELECT * FROM rsm_infrastructure
          LEFT OUTER JOIN rsm_infrastructure_building ON rsm_infrastructure.building_id=rsm_infrastructure_building.building_id
          LEFT OUTER JOIN rsm_infrastructure_building_level ON rsm_infrastructure.building_level_id=rsm_infrastructure_building_level.building_level_id
          WHERE `team_id` = '.$data['team_id'].' AND `rsm_infrastructure`.`building_id` = 3');
         $infr = $query3->row_array(); 
         //print($infr['building_level']);
         $day_progress=$infr['building_level']*10;
         $new_progress = $row['progress'] + $day_progress;
         //print($new_progress);
         if ($new_progress>=100) {
          $new_progress=100; //if scouted = done
          $new_status = 1;
          $sql_scouted = "INSERT INTO `rsm_sportsman_talent_scouted` (`rsm_sportsman_talent_scouted_id`, `sportsman_id`, `manager_id`, `days_left`, `status`) VALUES (NULL, '".$row['sportsman_id']."', '".$row['team_id']."', '', '1');";
          //print($sql_scouted);
          $this->db->query($sql_scouted);
         }
         else $new_status = 0;
         //print($new_progress.' st='.$new_status.'<br>');
         $sql = "UPDATE `rsm_scouting` SET `progress` = '".$new_progress."', `status` = '".$new_status."' WHERE `rsm_scouting`.`scout_id` = ".$row['scout_id']." ";
         //print($sql);
         $this->db->query($sql);
      }
      //print("<br>");
    }
    //print_r($teams);
    //print("</pre>");
   }
   
   function update_sportsman_age(){ // Update sportsman age if bday = day_live
    $sql = "SELECT sportsman_id, age, bday FROM rsm_sportsman";
    $query = $this->db->query($sql);
    $query->result_array(); 
      //print_r($query);
      foreach ($query->result_array() as $row)
      {
        $sql2 = "SELECT day_id FROM rsm_live";
        $sql_live = mysql_query($sql2);
        while ($row2 = mysql_fetch_assoc($sql_live)) {
              //$row2['day_id'];
            if ($row2['day_id'] == $row['bday']) {
              //echo('ZZZ'."<br>");
              $new_age = $row['age'] + 1;
              $sql_age_update = "UPDATE `rsm_sportsman` SET `age` = '".$new_age."' WHERE `rsm_sportsman`.`sportsman_id` = ".$row['sportsman_id'].";";
              //echo($sql_age_update."<br>");
              mysql_query($sql_age_update);
            }
          }
      }
   }
   
   function update_stadium_days(){
    $sql = "SELECT rsm_stadium_id, stadium_building_days_next, team_id, stadium_building_id, stadium_building_level_id FROM `rsm_stadium`"; 
    $query = $this->db->query($sql);
    $query->result_array(); 
      //print("<pre>");
      //print_r($query);
      //print("</pre>");
      foreach ($query->result_array() as $row)
      {
        if($row['stadium_building_days_next']>0)
        {
          
          $new_days=$row['stadium_building_days_next']-1;
          
          if (($new_days) == 0) {
            $author_id = 1;
            $this->load->model('Office_model');
            $team_id = $row['team_id'];
            $title = "New stadium level!";
            $previous = "Your stadium upgrade is ready";
            $content = "Your stadium upgrade is ready - ";
            $sql1 = "SELECT stadium_building_description FROM `rsm_stadium_building_level` WHERE `rsm_stadium_building_level_id` = ".($row['stadium_building_level_id'])." ";
            //print($sql1."<br>");
            $query1=$this->db->query($sql1);
            $building['descr']=$query1->row()->stadium_building_description;
            //$building['cost1']=$query1->row()->maintenance_cost;
            //$building['cost2']=$query1->row()->building_cost;
            
            $content .= $building['descr'];
            $content .= ". <a href=\"/infrastructure/stadium/\">Go check it now!</a>";
            //print($content."<br>");
            $this->Office_model->create_news('1', '1', $team_id, $title, $previous, $content);
            //echo('zzzz');
          }
          
          
          
          $sql1="UPDATE `rsm_stadium` SET `stadium_building_days_next` = '".$new_days."' WHERE `rsm_stadium_id` = ".$row['rsm_stadium_id'].";";
          //echo($sql1);
          $query = $this->db->query($sql1);
        }
      }
   }
   
   function update_injury(){
    $sql = "SELECT * FROM `rsm_sportsman_injury` WHERE `duration` > 0";
    $query = $this->db->query($sql);
    $query->result_array(); 
      //print_r($query);
      foreach ($query->result_array() as $row)
      {
        $new_days=$row['duration']-1;
        $sql1="UPDATE `rsm_sportsman_injury` SET `duration` = '".$new_days."' WHERE `rsm_sportsman_injury_id` = ".$row['rsm_sportsman_injury_id'].";";
       
        //echo($sql1);
        $query = $this->db->query($sql1);
      }
   }   
   
   function give_rsm_team() {
    $sql = "SELECT users.id, users.ip_address FROM users
            LEFT OUTER JOIN rsm_user ON users.id = rsm_user.ion_id
            WHERE rsm_user.ion_id IS NULL";
            
            //print($sql."<br>");
    $query = $this->db->query($sql);
    $query = $query->result_array();
    
    foreach ($query as $string) {
      $ip_link = "http://api.wipmania.com/";
      $ip_link .= $string['ip_address'];
      $country = file_get_contents($ip_link);
      //print("IP = ".$string['ip_address']." COUNTRY=".$country." ");
      $user_id=$string['id'];
      if ($country == "RU") {
        //echo ("Russia<br>");
        $this->Next_model->_give_country_team(1, $user_id);
      }
      else {
        //echo("OTHER<br>");
      }
    }
    
   }
   
   private function _give_country_team($country, $user_id) {   
    $sql = "SELECT rsm_team.team_id FROM `rsm_team` 
    LEFT OUTER JOIN rsm_user ON rsm_team.team_id = rsm_user.rsm_id
    WHERE rsm_user.ion_id IS NULL AND rsm_team.country_id = ".$country." ";
    //print($sql."<br>");
    $query = $this->db->query($sql);
    $query = $query->result_array();
    //print("<pre>");
    //print_r($query);
    //print("<pre>");
    $free_team_count = count($query)-1;
    //print("FREE TEAMS IN ".$country." = ".$free_team_count."<br>");
    $num = rand(0, $free_team_count);
    //print("RAND=".$num."<br>");
    $new_team = $query[0]['team_id'];
    //print("NEW TEAM = ".$new_team."<br>");
    
    $date = date("Y-m-d");
    
    $sql = "INSERT INTO `rsm_user` (`rsm_user_id`, `ion_id`, `rsm_id`, `date`, `level`) VALUES (NULL, '".$user_id."', '".$new_team."', '".$date."', '1');";
    //print($sql);
    $this->db->query($sql);
   }
   
   function archive_league($season_id) {
    $sql = "SELECT * FROM `rsm_league_standings`";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    //print("<pre>");
    //print_r($query);
    //print("</pre>");
    foreach ($query as $string) {
      //print($string['standings_id']."<br>");
      $sql = "INSERT INTO `rsm_league_standings_history` (`standings_history_id`, `season_id`, `league_id`, `team_id`, `standings_points_history`) VALUES (NULL, '".$season_id."', '".$string['league_id']."', '".$string['team_id']."', '".$string['standings_points']."');";
      $this->db->query($sql);
      //print($sql."<br>");
      $sql = "UPDATE `rsm_league_standings` SET `standings_points` = '0' WHERE `rsm_league_standings`.`standings_id` = ".$string['standings_id'].";";
      //print($sql."<br>");
      $this->db->query($sql);
    }
   }

   function rsm_menu($segment, $param, $active) {
      //print("SEGMENT=".$segment." PARAM=".$param." ACTIVE=".$active."<br>");
      
      $sql = "SELECT * FROM `rsm_menu` WHERE `level1` LIKE '".$segment."'";
      $query = $this->db->query($sql);
      $query = $query->result_array();
      
      
      
      $i = 1;
      $output = "<ul class=\"nav nav-pills\">";
      $output .= "\n";
      //print("<pre>");
      //print_r($query);
      //print("</pre>");
      foreach ($query as $string) {
        //print_r($string);
        $output .= "<li ";
        if ($active == $string['level2']){
          $output .= " class=\"active\"";
        }
        $output .="><a href=\"/".$string['level1']."/".$string['level2']."/".$param."\">".(ucfirst($string['value']))."</a></li>";
        $output .= "\n";
        $i++;
      }
      $output .= "</ul><br>";
      $output .= "\n";
      //print($output);
      return $output;
   }


  function change_season_teams() {
    $sql = "SELECT max(country_id), max(league_lvl) FROM `rsm_league`";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    $query = $query[0];
    $country_max = $query['max(country_id)'];
    $league_level_max = $query['max(league_lvl)'];
    //print_r($query);
  }
  
  function generate_team_jump_playoff() { //race

    //$sql = "TRUNCATE TABLE `rsm_race_playoff`";
    //$this->db->query($sql);
    //$sql = "TRUNCATE TABLE `rsm_league_playoff`";
    //$this->db->query($sql);
  
    $sql = "SELECT * FROM `rsm_league` WHERE `league_lvl`";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    foreach ($query as $league){

      $league_bottom = 3;
      //if ( ($league['league_lvl']) < $league_bottom ) {
        //print_r($league);
        $sql2 = "SELECT * FROM `rsm_league_standings` WHERE `league_id` = ".$league['league_id']." ORDER BY `rsm_league_standings`.`standings_points` DESC";
        $query2 = $this->db->query($sql2);
        $query2 = $query2->result_array();
        for ($i=8; $i<=11; $i++) {
          $sql = "INSERT INTO `rsm_league_playoff` (`rsm_playoff_id`, `rsm_playoff_league_id`, `team_id`, `team_points`, `playoff_type`) VALUES (NULL, '".$league['league_id']."', '".$query2[$i]['team_id']."', '0', '2');";
          //print($sql."<br>");
          //print($query[$i]['team_id']);
          $news_title = "Welcome to Playoff!";
          $news_preview = "Your team have qualified for DOWN Jump Playoff!";
          $news_content = $news_title . " " . $news_preview;
          if ( ($league['league_lvl']) < $league_bottom ) {
            $this->Office_model->create_news('1', '1', $query2[$i]['team_id'], $news_title, $news_preview, $news_content);
            $this->db->query($sql);
          }
          //
        }
      
      
      if ($league['league_lvl'] != 1) {
        for ($i=1; $i<=3; $i++) {
          $sql3 = "SELECT league_lvl, league_num FROM rsm_league WHERE league_id = ".$query2[$i]['league_id']." AND country_id = ".$league['country_id']." ";
          $query3 = $this->db->query($sql3);
          $query3 = $query3->row_array();
          //print_r($query3);
          //print($sql."<br>");
          
          $sql4 = "SELECT rsm_league.* FROM `rsm_league_promotion_rule` 
LEFT OUTER JOIN rsm_league ON rsm_league_promotion_rule.league_level_from = rsm_league.league_lvl AND rsm_league_promotion_rule.league_num_from = rsm_league.league_num
WHERE rsm_league_promotion_rule.league_level_to = ".$query3['league_lvl']." AND rsm_league_promotion_rule.league_num_to = ".$query3['league_num']." AND rsm_league.country_id = ".$league['country_id']." ";
          $query4 = $this->db->query($sql4);
          $query4 = $query4->row_array();
          //print_r($query4);
          //print($sql4."<br>");
          
          $sql = "INSERT INTO `rsm_league_playoff` (`rsm_playoff_id`, `rsm_playoff_league_id`, `team_id`, `team_points`, `playoff_type`) VALUES (NULL, '".$query4['league_id']."', '".$query2[$i]['team_id']."', '0', '2');";
          //print($sql."<br>");
          //print_r($query2[$i]);
          $news_title = "Welcome to Playoff!";
          $news_preview = "Your team have qualified for UP Jump Playoff!";
          $news_content = $news_title . " " . $news_preview;
          $this->Office_model->create_news('1', '1', $query2[$i]['team_id'], $news_title, $news_preview, $news_content);
          $this->db->query($sql);
        }
      }
      
    }
    $sql = "SELECT DISTINCT(rsm_playoff_league_id) FROM `rsm_league_playoff`  WHERE `playoff_type` = 2";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    //print_r($query);
    foreach ($query as $playoff) {
      //print_r($playoff);
      $this->Next_model->insert_race(24, $playoff['rsm_playoff_league_id'], 1, 2);
      $this->Next_model->insert_race(25, $playoff['rsm_playoff_league_id'], 1, 2);
      $this->Next_model->insert_race(26, $playoff['rsm_playoff_league_id'], 1, 2);
      //print("INSERT PLAYOFF FOR LEAGUE =".$playoff['rsm_playoff_league_id']."<br>");
    }
  }
  
  function insert_race($day_id, $league_id, $track_id, $race_type) {
    $sql = "INSERT INTO `rsm_race` (`race_id`, `day_id`, `league_id`, `track_id`, `race_status`, `race_type`) VALUES (NULL, '".$day_id."', '".$league_id."', '".$track_id."', '0', '".$race_type."');";
    $this->db->query($sql);
    $last_id = mysql_insert_id();
    $weather_race_id = $last_id;
    $temperature = rand(-5,5);
    $wind_type = rand(0,1);
    $wind_speed = rand(0,7);
    $fog = rand(0,1);
    $sun = rand(0,2);
    $rain = rand(0,1);
    $snow = rand(0,3);
    $humidity = rand(70,99);
    $sql = "INSERT INTO `rsm_race_weather` (`rsm_race_weather_id`, `rsm_race_id`, `rsm_race_weather_forecast_id`, `temperature`, `wind_type`, `wind_speed`, `fog_type`, `sun_type`, `rain_type`, `snow_type`, `humidity`) VALUES (NULL, '".$weather_race_id."', '".$weather_race_id."', '".$temperature."', '".$wind_type."', '".$wind_speed."', '".$fog."', '".$sun."', '".$rain."', '".$snow."', '".$humidity."');";
    $this->db->query($sql);
    //forecast
    $temperature = rand(-5,5);
    $wind_type = rand(0,1);
    $wind_speed = rand(0,7);
    $fog = rand(0,1);
    $sun = rand(0,2);
    $rain = rand(0,1);
    $snow = rand(0,3);
    $humidity = rand(70,99);
      
    $sql = "INSERT INTO `rsm_race_weather_forecast` (`rsm_race_weather_forecast_id`, `rsm_race_id`, `temperature`, `wind_type`, `wind_speed`, `fog_type`, `sun_type`, `rain_type`, `snow_type`, `humidity`) VALUES (NULL, '".$weather_race_id."', '".$temperature."', '".$wind_type."', '".$wind_speed."', '".$fog."', '".$sun."', '".$rain."', '".$snow."', '".$humidity."');";
    $this->db->query($sql);
  }
  
  function generate_playoff_race_details() { //
    $sql = "SELECT * FROM `rsm_race` WHERE `race_type` > 0";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    foreach ($query as $temp_race) {
      //print("<pre>");
      //print_r($temp_race);
      $sql2 = "SELECT * FROM `rsm_league_playoff` WHERE `rsm_playoff_league_id` = ".$temp_race['league_id']." AND `playoff_type` = ".$temp_race['race_type']."  ";
      $query2 = $this->db->query($sql2);
      $query2 = $query2->result_array();
      foreach ($query2 as $temp_team)
      {
        //print_r($temp_team);
        $sql3 = "INSERT INTO `rsm_race_team_list` (`rsm_race_team_list_id`, `race_id`, `team_id`, `race_points`) VALUES (NULL, '".$temp_race['race_id']."', '".$temp_team['team_id']."', '0');";
        //print($sql3."<br>");
        $this->db->query($sql3);
        $sp_list = $this->Team_model->get_sportsman_list_no_inj($temp_team['team_id']);
        $sp_list_array = (array)$sp_list;
        //print_r($sp_list);
        //$sp_num = count($sp_list);
        
        for ($i=0; $i<3; $i++) {
          //print($sp_list[$i]->sportsman_id."<br>");
          $sql = "INSERT INTO `rsm_race_sportsman_list` (`rsm_race_sportsman_list_id`, `race_id`, `team_id`, `sportsman_id`, `race_place`, `race_points`, `race_shots_missed`, `race_shots_stand`, `race_shots_lay`, `top3`, `top8`, `top_speed`) VALUES (NULL, '".$temp_race['race_id']."', '".$temp_team['team_id']."', '".($sp_list[$i]->sportsman_id)."', '0', '0', '0', '0', '0', '0', '0', '0');";
         // print($sql);
          $this->db->query($sql);
        }
        //
        
        
      }
    }
  }
  
  function generate_team_relegation() { //race
    
    $sql = "TRUNCATE TABLE `rsm_league_promotion`";//rsm_league_promotion
    $this->db->query($sql);
    //$sql = "TRUNCATE TABLE `rsm_league_playoff`";
    //$this->db->query($sql);
    
    //league up
    $sql = "SELECT * FROM `rsm_league` WHERE `league_lvl` > 1";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    foreach ($query as $league){
      
      $sql_team = "SELECT * FROM `rsm_league_standings` WHERE `league_id` = ".$league['league_id']." ORDER BY `rsm_league_standings`.`standings_points` DESC LIMIT 0,1";
      $team = $this->db->query($sql_team);
      $team = $team->row_array();
      //print_r($team);
      
      $sql3 = "SELECT league_level_from, league_num_from FROM `rsm_league_promotion_rule` WHERE `league_level_to` = ".$league['league_lvl']." AND `league_num_to` = ".$league['league_num']."  ";
      $rule = $this->db->query($sql3);
      $rule = $rule->row_array();
      
      $sql_select_new_league = "SELECT league_id FROM `rsm_league` WHERE `country_id` = ".$league['country_id']." AND `league_lvl` = ".$rule['league_level_from']." AND `league_num` = ".$rule['league_num_from']." ";
      //print($sql_select_new_league."<br>");
      $new_league = $this->db->query($sql_select_new_league);
      $new_league = $new_league->row_array();
      //print_r($new_league);
      
      $sql_team_promote = "INSERT INTO `rsm_league_promotion` (`rsm_league_promotion_id`, `team_id`, `league_from`, `league_to`) VALUES (NULL, '".$team['team_id']."', '".$league['league_id']."', '".$new_league['league_id']."');";
      //print($sql_team_promote."<br>");
        $news_title = "League up!";
        $news_preview = "Your will change league in the next season ".$league['league_lvl'].".".$league['league_num']." -> ".$rule['league_level_from'].".".$rule['league_num_from']." ";
        $news_content = $news_title . " " . $news_preview;
        $this->Office_model->create_news('1', '1', $team['team_id'], $news_title, $news_preview, $news_content);
      $this->db->query($sql_team_promote);
      
    }
    //league down
    $sql = "SELECT * FROM `rsm_league` WHERE `league_lvl` < 3";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    foreach ($query as $league){
      //
      $sql2 = "SELECT * FROM `rsm_league_standings` WHERE `league_id` = ".$league['league_id']." ORDER BY `rsm_league_standings`.`standings_points` DESC";
      $query2 = $this->db->query($sql2);
      $query2 = $query2->result_array();

      for ($i=12; $i<=15; $i++) {
      $place = $i + 1;
      //print("PLACE=".$place."<br>");
      $sql3 = "SELECT league_level_to, league_num_to FROM `rsm_league_promotion_rule` WHERE `league_level_from` = ".$league['league_lvl']." AND `league_num_from` = ".$league['league_num']." AND `league_place` = ".$place." ";
      //print($sql3."<br>");
      $rule = $this->db->query($sql3);
      $rule = $rule->row_array();
      //print_r($rule);
      
      $sql_team = "SELECT * FROM `rsm_league_standings` WHERE `league_id` = ".$league['league_id']." ORDER BY `rsm_league_standings`.`standings_points` DESC";
      $team = $this->db->query($sql_team);
      $team = $team->row_array($i);
      //print_r($team);
      
      $sql_select_new_league = "SELECT league_id FROM `rsm_league` WHERE `country_id` = ".$league['country_id']." AND `league_lvl` = ".$rule['league_level_to']." AND `league_num` = ".$rule['league_num_to']." ";
      //print($sql_select_new_league."<br>");
      $new_league = $this->db->query($sql_select_new_league);
      $new_league = $new_league->row_array();
      //print_r($new_league);
      
      $sql_team_relegate = "INSERT INTO `rsm_league_promotion` (`rsm_league_promotion_id`, `team_id`, `league_from`, `league_to`) VALUES (NULL, '".$team['team_id']."', '".$league['league_id']."', '".$new_league['league_id']."');";
      //print($sql_team_relegate."<br>");
      $this->db->query($sql_team_relegate);
      
        $news_title = "League down!";
        $news_preview = "Your will change league in the next season ".$league['league_lvl'].".".$league['league_num']." -> ".$rule['league_level_to'].".".$rule['league_num_to']." ";
        $news_content = $news_title . " " . $news_preview;
        $this->Office_model->create_news('1', '1', $team['team_id'], $news_title, $news_preview, $news_content);
      
      }
    }
  }
  
  function generate_top_playoff() {
    $sql = "SELECT * FROM `rsm_league` WHERE `league_lvl` = 1 AND `league_num` = 1";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    foreach ($query as $playoff) {
      //print_r($playoff);
      $sql = "SELECT * FROM `rsm_league_standings` WHERE `league_id` = ".$playoff['league_id']." ORDER BY `rsm_league_standings`.`standings_points` DESC";
      $query = $this->db->query($sql);
      $query = $query->result_array();
      for ($i=0; $i<4; $i++){
        $sql = "INSERT INTO `rsm_league_playoff` (`rsm_playoff_id`, `rsm_playoff_league_id`, `team_id`, `team_points`, `playoff_type`) VALUES (NULL, '".$playoff['league_id']."', '".$query[$i]['team_id']."', '0', '1');";
        //print($sql."<br>");
        $this->db->query($sql);
        $news_title = "Welcome to Playoff!";
        $news_preview = "Congratulations! Your team have qualified for Top Playoff!";
        $news_content = $news_title . " " . $news_preview;
        $this->Office_model->create_news('1', '1', $query[$i]['team_id'], $news_title, $news_preview, $news_content);
        
      }
    //1 - Top playoff
    for ($i=24; $i<=26; $i++) {
      $this->Next_model->insert_race($i, $playoff['league_id'], 1, 1);
      //$this->db->query($sql);
      }
    }
  }

  function get_general_data($team_id, $menu1, $menu2) {
		//balance
    $sql = "SELECT rsm_team_balance_current FROM `rsm_team_balance` WHERE `rsm_team_balance_id` = $team_id";
		$res=mysql_query($sql) or die(mysql_error());
		While ($temp = mysql_fetch_row($res))
		{  
			$data['current_balance']=$temp[0];
		}
    //country
    $sql = "SELECT rsm_country.logo FROM `rsm_country`
LEFT OUTER JOIN rsm_team ON rsm_country.country_id = rsm_team.country_id
WHERE rsm_team.team_id =  ".$team_id." ";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    $data['user_country'] = $query[0];
    
    $sql = "SELECT * FROM `rsm_menu` WHERE `level1` LIKE '".$menu1."'";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    if (isset($query[0]['rsm_menu_id'])){
      $query = $query[0]['rsm_menu_id'];
    }
    $sql = "SELECT rsm_menu_id, level1, num, glyph FROM `rsm_menu` WHERE visible = 1";
    $query = $this->db->query($sql);
    $data['left_menu'] = $query->result_array();
    
    $sql = "SELECT * FROM `rsm_menu_top` 
  LEFT OUTER JOIN rsm_menu ON rsm_menu_top.rsm_menu_id = rsm_menu.rsm_menu_id
  WHERE rsm_menu.level1 LIKE '".$menu1."' ORDER BY `rsm_menu_top`.`order` ASC";
    $query = $this->db->query($sql);
    $data['top_menu'] = $query->result_array();
    $i=0;
    foreach($data['top_menu'] as $temp) {
      //
      if ($temp['level2'] == $menu2) {
        $data['top_menu'][$i]['active'] = 1;
      }
      else $data['top_menu'][$i]['active'] = 0;
      $i++;
    }
    //$data['top_menu']['active'] = $menu2;
    //print("<pre>");
    //print_r($data['top_menu']);
    //print("</pre>");
    
    $sql = "SELECT rsm_user_avatar.rsm_user_avatar_filename FROM `rsm_user` 
            LEFT OUTER JOIN rsm_user_avatar ON rsm_user.ion_id = rsm_user_avatar.rsm_user_id 
            WHERE `rsm_id` = ".$team_id." ";
    $query = $this->db->query($sql);
    $data['user_avatar'] = $query->result_array();
    //print_r($data);
    
    //header menu
    $sql = "SELECT * FROM `rsm_menu_header`";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    //
    $i=0;
    foreach ($query as $temp) {
      //print_r($temp);
      
      //print($i." ".$temp['rsm_menu_header_level1']." ".$menu2."<br>");
      if ($temp['rsm_menu_header_level1'] == $menu2) {
        $query[$i]['active']=1;
      }
      else {
        $query[$i]['active']=0;
      }
      
      
      $i++;
    }
    $data['header_menu'] = $query;
    //reminders
    //favorite boards
    $sql = "SELECT * FROM `rsm_board_user_favorite_topic` WHERE `rsm_id` = ".$team_id." AND reminder_set = 0";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    //print_r($query);
    foreach ($query as $favorite) {
      //print_r ($query);
      $sql2 = "SELECT MAX(rsm_board_message_id) FROM `rsm_board_message` WHERE `rsm_board_topic_id` = ".$favorite['rsm_board_section_topic_id']." ";
      $query2 = $this->db->query($sql2);
      $query2 = $query2->result_array();
      $query2  = $query2[0]['MAX(rsm_board_message_id)'];
      
      //print($query2); print($favorite['rsm_board_section_last_message_id']);
      if ($favorite['rsm_board_section_last_message_id'] < $query2) {
        $sql3 = "INSERT INTO `rsm_reminder` (`rsm_reminder_id`, `rsm_team_id`, `rsm_reminder_link_id`, `rsm_reminder_type`, `rsm_reminder_num`) VALUES (NULL, '".$team_id."', '".$favorite['rsm_board_user_favorite_topic_id']."', '1', '1');";
        //echo($sql3);
        $this->db->query($sql3);
        $sql4 = "UPDATE `rsm_board_user_favorite_topic` SET `reminder_set` = '1' WHERE `rsm_board_user_favorite_topic`.`rsm_board_user_favorite_topic_id` = ".$favorite['rsm_board_user_favorite_topic_id'].";";
        $this->db->query($sql4);
        
      }
    }
    
    
    $query_r = array();
    $sql_r = "SELECT * FROM `rsm_reminder` WHERE `rsm_team_id` =  ".$team_id." ";
    //print($sql_r);
    $query_r = $this->db->query($sql_r);
    $query_r = $query_r->result_array();
    //print_r($query_r);
    $data['reminder_info'] = $query_r;
    
    $sql = "SELECT * FROM `rsm_live` LEFT OUTER JOIN rsm_season ON rsm_live.day_id = rsm_season.day_id WHERE `id` = 1";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    $query = $query[0];
    $data['current_day'] = $query;
    
    return $data;
  }
  
  function reminder_check_favorites($topic_id, $user_id) {
    $sql = "SELECT * FROM `rsm_board_user_favorite_topic` WHERE `rsm_id` = ".$user_id." AND `rsm_board_section_topic_id` = ".$topic_id." AND `reminder_set` = '1'";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    //print($sql);
    //print_r($query);
    foreach ($query as $temp) {
      //print_r($temp);
      if (isset($temp['rsm_board_user_favorite_topic_id'])){
        //обновили макс айди сообщения в топике в фав
      $sql2 = "SELECT MAX(rsm_board_message_id) FROM `rsm_board_message` WHERE `rsm_board_topic_id` = ".$temp['rsm_board_section_topic_id']." ";
      //print($sql2);
      $query2 = $this->db->query($sql2);
      $query2 = $query2->result_array();
      $query2  = $query2[0]['MAX(rsm_board_message_id)'];
        
        $sql = "UPDATE `rsm_board_user_favorite_topic` SET `rsm_board_section_last_message_id` = '".$query2."' WHERE `rsm_board_user_favorite_topic`.`rsm_board_user_favorite_topic_id` = ".$temp['rsm_board_user_favorite_topic_id'].";";
        $this->db->query($sql);
        $sql = "UPDATE `rsm_board_user_favorite_topic` SET `reminder_set` = '0' WHERE `rsm_board_user_favorite_topic`.`rsm_board_user_favorite_topic_id` = ".$temp['rsm_board_user_favorite_topic_id'].";";
        $this->db->query($sql);
        $sql = "DELETE FROM rsm_reminder WHERE `rsm_team_id` = ".$user_id." AND `rsm_reminder_link_id` = ".$temp['rsm_board_user_favorite_topic_id']." AND `rsm_reminder_type` = 1";
        $this->db->query($sql);
      }
    }
  }
 
}
?>