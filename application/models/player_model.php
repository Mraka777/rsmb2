<?php
class Player_model extends CI_Model {

        function __construct()
        {
            parent::__construct();
        }
        
    function add_to_scouting_list($sportsman_id, $team_id) {
      
      $query = $this->db->query('SELECT * FROM `rsm_scouting` WHERE `team_id` = '.$team_id.' AND `sportsman_id` = '.$sportsman_id.' ');
      //echo $query->num_rows();
      if ($query->num_rows() == '0') {
        $query = $this->db->query('SELECT `order` FROM `rsm_scouting` WHERE `team_id` = '.$team_id.' ');
        
        $order_num=array();
       
        foreach ($query->result_array() as $row)
        {
           array_push($order_num, $row['order']); 
        }
        $total_orders = count($order_num);
        //print_r($total_orders);
        $next_order = $total_orders + 1;
        
        
        $sql = "INSERT INTO `rsm_scouting` (`scout_id`, `team_id`, `sportsman_id`, `order`, `progress`, `status`) VALUES (NULL, '".$team_id."', '".$sportsman_id."', '".$next_order."', '0', '');";
        $query = $this->db->query($sql);
        
      }
    }
    
    
    function get_sportsman_info($sportsman_id, $manager_id)
    {
        $query = $this->db->query('SELECT status, days_left FROM `rsm_sportsman_talent_scouted` WHERE `sportsman_id` = '.$sportsman_id.' AND `manager_id` = '.$manager_id.'');
				$sql = 'SELECT status, days_left FROM `rsm_sportsman_talent_scouted` WHERE `sportsman_id` = '.$sportsman_id.' AND `manager_id` = '.$manager_id.'';
				//print($sql);
        if ($query->num_rows()>0){
          foreach ($query->result() as $row)
          {
             if ($query->num_rows()== '1' and ($row->days_left == '0') and ($row->status == '1')) //if scouted show normal query
              {
                $query = $this->db->query('SELECT * FROM rsm_sportsman
                                    LEFT OUTER JOIN rsm_country ON rsm_sportsman.country_id = rsm_country.country_id
                                    LEFT OUTER JOIN rsm_team ON rsm_sportsman.team_id = rsm_team.team_id
																		LEFT OUTER JOIN rsm_sportsman_transfer_value ON rsm_sportsman.sportsman_id = rsm_sportsman_transfer_value.sportsman_id
                                    LEFT OUTER JOIN rsm_sportsman_talent ON rsm_sportsman.sportsman_id = rsm_sportsman_talent.rsm_sportsman_id
                                    LEFT OUTER JOIN rsm_sportsman_salary ON rsm_sportsman.sportsman_id = rsm_sportsman_salary.rsm_sportsman_salary_id
																		LEFT OUTER JOIN rsm_sportsman_exp ON rsm_sportsman.sportsman_id = rsm_sportsman_exp.rsm_sportsman_sportsman_id
                                    WHERE rsm_sportsman.sportsman_id='.$sportsman_id.'');
                //print_r($query->result());
                //echo($query->player());
                
            $output=$query->result_array();
            $output[0]['scout_status'] = '1';
            //print_r($output);
            return $output;
              }
          }
        }
        else
          {
                $query = $this->db->query('SELECT * FROM rsm_sportsman
                                    LEFT OUTER JOIN rsm_country ON rsm_sportsman.country_id = rsm_country.country_id
                                    LEFT OUTER JOIN rsm_team ON rsm_sportsman.team_id = rsm_team.team_id
																		LEFT OUTER JOIN rsm_sportsman_transfer_value ON rsm_sportsman.sportsman_id = rsm_sportsman_transfer_value.sportsman_id
                                    LEFT OUTER JOIN rsm_sportsman_talent_fake ON rsm_sportsman.sportsman_id = rsm_sportsman_talent_fake.rsm_sportsman_id
                                    LEFT OUTER JOIN rsm_sportsman_salary ON rsm_sportsman.sportsman_id = rsm_sportsman_salary.rsm_sportsman_salary_id
																		LEFT OUTER JOIN rsm_sportsman_exp ON rsm_sportsman.sportsman_id = rsm_sportsman_exp.rsm_sportsman_sportsman_id
                                    WHERE rsm_sportsman.sportsman_id='.$sportsman_id.'');
            //print_r($query->result_object());
            
            $output=$query->result_array();
            $output[0]['scout_status'] = '0';
						//print_r($output);
            return $output;
          }
        


    }

    function get_sportman_history($sportsman_id) //Get sportsman history
    {
      $i = 0;
      $sql = 'SELECT * FROM `rsm_sportsman_history`
      LEFT OUTER JOIN rsm_sportsman_history_type ON rsm_sportsman_history.history_action_id = rsm_sportsman_history_type.history_action_id
      LEFT OUTER JOIN rsm_season ON rsm_sportsman_history.day_id = rsm_season.day_id
			LEFT OUTER JOIN rsm_sportsman ON rsm_sportsman_history.sportsman_id = rsm_sportsman.sportsman_id
      WHERE rsm_sportsman_history.sportsman_id = '.$sportsman_id.' ';
      $sql_history = mysql_query($sql);
      while ($row = mysql_fetch_assoc($sql_history)) {
            $data[$i]['description'] = $row['description'];
            $data[$i]['real_date'] = $row['real_date'];
            $data[$i]['season'] = $row['season_id'];
            $data[$i]['day'] = $row['day_num'];
            $data[$i]['name1'] = $row['name1'];
            $data[$i]['name2'] = $row['name2'];
            $data[$i]['sportsman_id'] = $row['sportsman_id'];
            $i++;
        }
        //print_r($data);
        return($data);
    }


    function get_sportman_age_days($sportsman_id) //ЗАВИСИТ ОТ НАСТРОЕК СЕЗОНА - ДОБАВИТЬ В БАЗУ
    {
      $sql = 'SELECT age, bday FROM `rsm_sportsman` WHERE `sportsman_id` = '.$sportsman_id.' ';
      $sql_age = mysql_query($sql);
      while ($row = mysql_fetch_assoc($sql_age)) {
            $age=$row['age'];
            $bday=$row['bday'];
        }
        $age_days=($age-15)*35+$bday;
        return($age_days);
    }
    
    function get_sportsman_training($team_id)
    {
      $query = $this->db->query('SELECT rsm_sportsman.*, rsm_country.*, rsm_sportsman_training.*, rsm_sportsman_training_type.*, rsm_sportsman_talent_scouted.status FROM rsm_sportsman
																LEFT OUTER JOIN rsm_country ON rsm_sportsman.country_id = rsm_country.country_id
																LEFT OUTER JOIN rsm_sportsman_training ON rsm_sportsman.sportsman_id = rsm_sportsman_training.sportsman_id
																LEFT OUTER JOIN rsm_sportsman_training_type ON rsm_sportsman_training.training_type = rsm_sportsman_training_type.rsm_sportsman_training_type_id
																LEFT OUTER JOIN rsm_sportsman_talent_scouted ON rsm_sportsman.sportsman_id = rsm_sportsman_talent_scouted.sportsman_id
																WHERE team_id='.$team_id.'');
				
			$query = $query->result_array();
			$i=0;
			foreach ($query as $data) {
				//print("<pre>");
				//print_r($data);
				//print("</pre>");
				//print("S=".$data['status']."<br>");
				//print("S_ID=".$data['sportsman_id']."<br>");
				if ($data['status'] == '1') {//Show scouted MVU
				//print($data['status']);
					$sql_mvu = "SELECT * FROM `rsm_sportsman_talent` WHERE `rsm_sportsman_id` = ".$data['sportsman_id']." ";
				//print_r($mvu_data);
				}
				else {
					$sql_mvu = "SELECT * FROM `rsm_sportsman_talent_fake` WHERE `rsm_sportsman_id` = ".$data['sportsman_id']." ";
				}
				//print($sql_mvu."<br>");
				$mvu_data = $this->db->query($sql_mvu);
				$mvu_data = $mvu_data->result_array();
				$mvu_data = $mvu_data[0];
				//print_r($mvu_data);
				
				//$colors_arr = array();
				
				$mvu_array = array('phys_strength_mvu_color'=>$mvu_data['phys_strength_mvu'], 'phys_endur_mvu_color'=>$mvu_data['phys_endur_mvu'], 'shoot_tech_mvu_color'=>$mvu_data['shoot_tech_mvu'], 'shoot_calm_mvu_color'=>$mvu_data['shoot_calm_mvu'], 'shoot_acc_mvu_color'=>$mvu_data['shoot_acc_mvu'], 'track_tech_mvu_color'=>$mvu_data['track_tech_mvu'], 'track_speed_mvu_color'=>$mvu_data['track_speed_mvu']);
				
				foreach ($mvu_array as $key=>$value) {
					//print($key." ".$value."<br>");
					if ($value < 40) {
						$query[$i][$key]='red';
					}
					elseif ($value < 45) {
						$query[$i][$key]='orange';
					}
					elseif ($value < 59) {
						$query[$i][$key]='green';
					}
					elseif ($value < 65) {
						$query[$i][$key]='DodgerBlue';
					}
					else {
						$query[$i][$key]='MediumSlateBlue';
					}
				}

				$query[$i]['phys_strength_mvu']=$mvu_data['phys_strength_mvu'];
				$query[$i]['phys_endur_mvu']=$mvu_data['phys_endur_mvu'];
				$query[$i]['shoot_tech_mvu']=$mvu_data['shoot_tech_mvu'];
				$query[$i]['shoot_calm_mvu']=$mvu_data['shoot_calm_mvu'];
				$query[$i]['shoot_acc_mvu']=$mvu_data['shoot_acc_mvu'];
				$query[$i]['track_tech_mvu']=$mvu_data['track_tech_mvu'];
				$query[$i]['track_speed_mvu']=$mvu_data['track_speed_mvu'];
				
				
				
				$i++;
			}
			//print_r($query);
      return $query;
			
        // print_r($query[result_object]);   
    }
   
    function get_sportsman_training_log($sportsman_id, $team_id)
    {
        $query = $this->db->query('SELECT * FROM `rsm_sportsman_training_log` 
LEFT OUTER JOIN rsm_season ON rsm_sportsman_training_log.day_id = rsm_season.day_id
LEFT OUTER JOIN rsm_sportsman ON rsm_sportsman_training_log.sportsman_id = rsm_sportsman.sportsman_id
LEFT OUTER JOIN rsm_sportsman_training_type ON rsm_sportsman_training_log.training_type = rsm_sportsman_training_type.rsm_sportsman_training_type_id
WHERE rsm_sportsman_training_log.sportsman_id = '.$sportsman_id.' AND rsm_sportsman.team_id = '.$team_id.'
ORDER BY `rsm_sportsman_training_log`.`rsm_sportsman_training_log_id` ASC');

        return $query->result();
			//print_r($query);
        // print_r($query[result_object]);   
    }
    function update_sportsman_training($data)
    {
        //print_r($data);//Array
        foreach ($data as $key=>$value){
          //echo ($key.'='.$data[$key]);
          if ($key!='send'){
          $sql='UPDATE rsm_sportsman_training SET training_type = '.$data[$key].' WHERE rsm_sportsman_training.sportsman_id = '.$key;
          //echo $sql;
          $this->db->query($sql);
          
          }
        }
        //$query = $this->db->query('SELECT * FROM `rsm_sportsman_training_log` LEFT OUTER JOIN rsm_season ON rsm_sportsman_training_log.day_id = rsm_season.day_id WHERE `sportsman_id` = '.$sportsman_id.' ORDER BY `rsm_sportsman_training_log`.`rsm_sportsman_training_log_id` ASC');
        //return $query->result();
        // print_r($query[result_object]);   
    }
    
    function check_sportsman_injury($sportsman_id) // 1 if true, 0 if false
    {
      $sql = 'SELECT * FROM `rsm_sportsman_injury` WHERE `sportsman_id` = '.$sportsman_id.' AND `duration` > 0';
      $true=1;$false=0;
      $query = $this->db->query($sql);
      if ($query->num_rows() > 0) {
        return($true);
      }
      else {
        return($false);
      }
    }
}
?>