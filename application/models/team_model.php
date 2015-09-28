<?php
class Team_model extends CI_Model {

        function __construct()
        {
            parent::__construct();
        }
    function get_sportsman_list($team_id)
    {
        $query = $this->db->query('SELECT rsm_sportsman.*, rsm_country.*, rsm_sportsman_talent_scouted.status, rsm_sportsman_injury.rsm_sportsman_injury_id, rsm_sportsman_injury.duration, rsm_sportsman_injury_type.description FROM rsm_sportsman 
LEFT OUTER JOIN rsm_country ON rsm_sportsman.country_id = rsm_country.country_id 
LEFT OUTER JOIN rsm_sportsman_injury ON rsm_sportsman.sportsman_id = rsm_sportsman_injury.sportsman_id 
LEFT OUTER JOIN rsm_sportsman_injury_type ON rsm_sportsman_injury.type_id = rsm_sportsman_injury_type.rsm_sportsman_injury_type_id 
LEFT OUTER JOIN rsm_sportsman_talent_scouted ON rsm_sportsman.sportsman_id = rsm_sportsman_talent_scouted.sportsman_id
WHERE team_id='.$team_id.'');
        
        
        return $query->result();
    }
    
    function get_sportsman_list_no_inj($team_id)
    {
        $query = $this->db->query('SELECT rsm_sportsman.*, rsm_country.*, rsm_sportsman_talent_scouted.status, rsm_sportsman_injury.rsm_sportsman_injury_id, rsm_sportsman_injury.duration, rsm_sportsman_injury_type.description FROM rsm_sportsman 
LEFT OUTER JOIN rsm_country ON rsm_sportsman.country_id = rsm_country.country_id 
LEFT OUTER JOIN rsm_sportsman_injury ON rsm_sportsman.sportsman_id = rsm_sportsman_injury.sportsman_id 
LEFT OUTER JOIN rsm_sportsman_injury_type ON rsm_sportsman_injury.type_id = rsm_sportsman_injury_type.rsm_sportsman_injury_type_id 
LEFT OUTER JOIN rsm_sportsman_talent_scouted ON rsm_sportsman.sportsman_id = rsm_sportsman_talent_scouted.sportsman_id
WHERE team_id='.$team_id.' AND rsm_sportsman_injury.rsm_sportsman_injury_id IS NULL');
        
        //print_r($query->result());
        return $query->result();
    }    

    function get_team_info($team_id)
    { 
        $query = $this->db->query('SELECT * FROM rsm_team
                                  LEFT OUTER JOIN rsm_country ON rsm_team.country_id= rsm_country.country_id
                                  LEFT OUTER JOIN rsm_league ON rsm_team.league_id = rsm_league.league_id
                                  WHERE team_id='.$team_id.'');
        
        //$query = (array)$query;
        return $query->result();
    }
    
    function get_general_sponsor_info($team_id)
    {
        $query = $this->db->query('SELECT * FROM `rsm_team` LEFT OUTER JOIN rsm_sponsor ON rsm_team.sponsor_id = rsm_sponsor.sponsor_id WHERE `team_id` = '.$team_id.' ');
        
        //$query = (array)$query;
        return $query->result_array();
    }

    function get_media_sponsor_info($team_id)
    {
        $query = $this->db->query('SELECT * FROM `rsm_team` LEFT OUTER JOIN rsm_sponsor ON rsm_team.sponsor2 = rsm_sponsor.sponsor_id WHERE `team_id` = '.$team_id.' ');
        
        //$query = (array)$query;
        return $query->result_array();
    }
    
    function get_sportsman_country($b_id)
    {
        $query = $this->db->query('SELECT team_name FROM rsm_team WHERE team_id='.$team_id.'');//
        //$query = (array)$query;
        return $query->result();
    }
    
    function get_team_scouting($team_id)
    {
        $query = $this->db->query('SELECT rsm_scouting.sportsman_id, rsm_scouting.order, rsm_scouting.progress, rsm_scouting.status, rsm_sportsman.name1, rsm_sportsman.name2, rsm_team.team_id, rsm_team.team_name FROM `rsm_scouting` 
LEFT OUTER JOIN rsm_sportsman ON rsm_scouting.sportsman_id = rsm_sportsman.sportsman_id
LEFT OUTER JOIN rsm_team ON rsm_sportsman.team_id = rsm_team.team_id
WHERE rsm_scouting.team_id = '.$team_id.' ORDER BY `rsm_scouting`.`order` ASC');//
        //$query = (array)$query;
        return $query->result_array();
    }

    function get_team_injury($team_id)
    {
        $query = $this->db->query('SELECT rsm_sportsman_injury.*, rsm_sportsman_injury_type.*, rsm_sportsman.name1, rsm_sportsman.name2  FROM rsm_sportsman_injury
LEFT OUTER JOIN rsm_sportsman ON rsm_sportsman_injury.sportsman_id = rsm_sportsman.sportsman_id
LEFT OUTER JOIN rsm_sportsman_injury_type ON rsm_sportsman_injury.type_id = rsm_sportsman_injury_type.rsm_sportsman_injury_type_id
WHERE rsm_sportsman.team_id  = '.$team_id.' AND rsm_sportsman_injury.duration >0');//
        //$query = (array)$query;
        return $query->result_array();
    }  

    function get_team_statistic($team_id)
    {
        $query = $this->db->query('SELECT * FROM `rsm_team_statistic` WHERE `team_id` =  '.$team_id.' ');//
        //$query = (array)$query;
        return $query->result_array();
    }  
    function get_team_academy($team_id)
    {
        $query = $this->db->query('SELECT * FROM `rsm_sportsman_academy` LEFT OUTER JOIN rsm_country ON rsm_sportsman_academy.country_id = rsm_country.country_id WHERE `team_id` =  '.$team_id.' ');//
        //$query = (array)$query;
        $query = $query->result_array();
        //print("<pre>");
        //print_r($query);
        //print("</pre>");
        $i=0;
        foreach ($query as $sman) {
          $query[$i]['p_phys'] = ($sman['phys_strength_mvu'] + $sman['phys_endur_mvu'])/2; 
          $query[$i]['p_shoot'] = ($sman['shoot_tech_mvu'] + $sman['shoot_calm_mvu'] + $sman['shoot_acc_mvu'])/3;
          $query[$i]['p_ski'] = ($sman['track_tech_mvu'] + $sman['track_speed_mvu'])/2; 
          $i++;
        }
        return $query;
    }
    
    function academy_accept($user_id, $sportsman_id) {
      $sql = "SELECT * FROM `rsm_sportsman_academy` WHERE `sportsman_id` = ".$sportsman_id." AND `team_id` = ".$user_id." ";
      $query = $this->db->query($sql);
      $query = $query->result_array();
      $query = $query[0];
      //print_r($query);
      //SPORTSMAN DATA
      //
      $or_rating = ($query['phys_strength'] + $query['phys_endur'] + $query['shoot_tech'] + $query['shoot_calm'] + $query['shoot_acc'] + $query['track_tech'] + $query['track_spd']);
      $sql = "INSERT INTO `rsm_sportsman` (`sportsman_id`, `team_id`, `country_id`, `age`, `bday`, `name1`, `name2`, `team_num`, `phys_energy`, `phys_strength`, `phys_endur`, `shoot_tech`, `shoot_calm`, `shoot_acc`, `track_tech`, `track_spd`, `sportsman_prof`, `popularity`, `overall_rating`) VALUES (NULL, '".$user_id."', '".$query['country_id']."', '".$query['age']."', '1', '".$query['name1']."', '".$query['name2']."', '', '".$query['phys_energy']."', '".$query['phys_strength']."', '".$query['phys_endur']."', '".$query['shoot_tech']."', '".$query['shoot_calm']."', '".$query['shoot_acc']."', '".$query['track_tech']."', '".$query['track_spd']."', '".$query['sportsman_prof']."', '".$query['popularity']."', '".$or_rating."');";
      //print($sql);
      $this->db->query($sql);
      $sql = "SELECT sportsman_id FROM `rsm_sportsman` WHERE `team_id` = ".$user_id." AND `country_id` LIKE '".$query['country_id']."' AND `name1` LIKE '".$query['name1']."' AND `name2` LIKE '".$query['name2']."' AND `phys_strength` = ".$query['phys_strength']." AND `phys_endur` = ".$query['phys_endur']." AND `overall_rating` = ".$or_rating." ";
      //print($sql);
      $this->db->query($sql);
      $sp_added_id = $this->db->query($sql);
      $sp_added_id = $sp_added_id->result_array();
      $sp_added_id = $sp_added_id[0]['sportsman_id'];
      //print($sp_added_id);
      //TALENT FAKE
      $str_mvu = rand(0,99);$end_mvu = rand(0,99);$tech_mvu = rand(0,99);$calm_mvu  = rand(0,99); $acc_mvu = rand(0,99); $tech2_mvu = rand(0,99); $tr_spd = rand(0,99); $prof_mvu = rand(0,99);
      $sql = "INSERT INTO `rsm_sportsman_talent_fake` (`rsm_sportsman_talent_fake_id`, `rsm_sportsman_id`, `phys_strength_mvu`, `phys_endur_mvu`, `shoot_tech_mvu`, `shoot_calm_mvu`, `shoot_acc_mvu`, `track_tech_mvu`, `track_speed_mvu`, `sportsman_prof`) VALUES (NULL, '".$sp_added_id."', '".$str_mvu."', '".$end_mvu."', '".$tech_mvu."', '".$calm_mvu."', '".$acc_mvu."', '".$tech2_mvu."', '".$tr_spd."', '".$prof_mvu."');";
      //print($sql);
      $this->db->query($sql);
      
      $sql = "INSERT INTO `rsm_sportsman_talent` (`rsm_sportsman_talent_id`, `rsm_sportsman_id`, `phys_strength_mvu`, `phys_endur_mvu`, `shoot_tech_mvu`, `shoot_calm_mvu`, `shoot_acc_mvu`, `track_tech_mvu`, `track_speed_mvu`) VALUES (NULL, '".$sp_added_id."', '".$query['phys_strength_mvu']."', '".$query['phys_endur_mvu']."', '".$query['shoot_tech_mvu']."', '".$query['shoot_calm_mvu']."', '".$query['shoot_acc_mvu']."', '".$query['track_tech_mvu']."', '".$query['track_speed_mvu']."');";
      $this->db->query($sql);
      //HISTORY
      $sql = "SELECT * FROM `rsm_live` WHERE `id` = 1";
      $cur_day = $this->db->query($sql);
      $cur_day = $cur_day->result_array();
      $cur_day = $cur_day[0]['day_id'];//чекнуть day_id или day из таблицы rsm_date
      
      $sql = "INSERT INTO `rsm_sportsman_history` (`rsm_sprortsman_history_id`, `sportsman_id`, `day_id`, `history_action_id`) VALUES (NULL, '".$sp_added_id."', '".$cur_day."', '1');";
      //print($sql);
      $this->db->query($sql);
      //training
      $sql = "INSERT INTO `rsm_sportsman_training` (`training_id`, `sportsman_id`, `training_type`, `last_training`) VALUES (NULL, '".$sp_added_id."', '1', '0');";
      $this->db->query($sql);
      //transfer value
      $val_vbr = rand(1,10);
          $s_id_value = round(($or_rating * (100 + $val_vbr)),0);
          $sql = "INSERT INTO `rsm_sportsman_transfer_value` (`rsm_sportsman_transfer_value_id`, `sportsman_id`, `sportsman_transfer_value`) VALUES (NULL, '".$sp_added_id."', '".$s_id_value."');";
          $this->db->query($sql);
      
      $sql = "DELETE FROM `rsm_sportsman_academy` WHERE `rsm_sportsman_academy`.`sportsman_id` = ".$query['sportsman_id']."";
      $this->db->query($sql);
      
      $data['sign_fee']=$query['academy_sign_fee'];
      //$title, $preview, $content);
      $data['news_title']='New player in Team!';
      $data['preview']='New player in Team!';
      $data['content']=mysql_real_escape_string("You've signed new player - ".$query['name1']." ".$query['name2']."  ");
      return $data;
    }

    function academy_reject($user_id, $sportsman_id) {
      $sql = "DELETE FROM `rsm_sportsman_academy` WHERE `sportsman_id` = ".$sportsman_id." AND `team_id` = ".$user_id." ";
      $this->db->query($sql);
      
    }
    function get_team_rating($team_id)
    {
        $query = $this->db->query('SELECT * FROM `rsm_team_basic_rating` WHERE `team_id` = '.$team_id.' ');//
        //$query = (array)$query;
        return $query->result_array();
    }
    
    function get_staff_info($team_id, $staff_type){
      //1 - coach, 2 - service, 3 - general manager, 4 - technician, 5 - scout, 6 - physician (med), 7 - youth coach, 8 - economy manager
      $sql = "SELECT * FROM `rsm_staff`
      LEFT OUTER JOIN rsm_country ON rsm_staff.country_id = rsm_country.country_id
      WHERE `rsm_staff_type_id` = ".$staff_type." AND `team_id` = ".$team_id." AND `staff_status` = 1"; //1 - boss
      $query = $this->db->query($sql);
      $query = $query->result_array();
      $query = $query[0];
      return ($query);
    }
   
}
?>