<?php
class League_model extends CI_Model {

        function __construct()
        {
            parent::__construct();
        }
    function get_league_standings($league_id)
    {
        //print_r($league_id);
        $sql="SELECT rsm_league_standings.*, rsm_team.*, rsm_league_promotion.league_from, rsm_league_promotion.league_to, rsm_league_playoff.rsm_playoff_league_id, rsm_league_playoff.team_points, rsm_league_playoff.playoff_type FROM rsm_league_standings
                                  LEFT OUTER JOIN rsm_team ON rsm_league_standings.team_id = rsm_team.team_id
                                  LEFT OUTER JOIN rsm_league_promotion ON rsm_team.team_id = rsm_league_promotion.team_id
                                  LEFT OUTER JOIN rsm_league_playoff ON rsm_team.team_id = rsm_league_playoff.team_id 
                                  WHERE rsm_league_standings.league_id=".$league_id." ORDER BY `rsm_league_standings`.`standings_points` DESC";
        
        //print($sql);
        $query = $this->db->query($sql);
        //print_r($query->result());
        return $query->result();
    }
    
    function get_league_data($league_id) {
        $query = $this->db->query('SELECT rsm_league.league_lvl, rsm_league.league_num, rsm_country.nameb_en, rsm_country.logo, rsm_country.country_id FROM `rsm_league` 
LEFT OUTER JOIN rsm_country ON rsm_league.country_id = rsm_country.country_id WHERE `league_id` = '.$league_id.' ');
        return $query->result_array();
    }
    
    function get_league_id($country_id, $league_lvl, $league_num) {
      $sql = "SELECT league_id FROM `rsm_league` WHERE `country_id` = ".$country_id." AND `league_lvl` = ".$league_lvl." AND `league_num` = ".$league_num."";
      //print($sql);
      $query = $this->db->query($sql);
      return $query->row();
    }
    
    function get_avial_league_num($country_id) {
        $query = $this->db->query('SELECT DISTINCT league_num FROM `rsm_league` WHERE country_id = '.$country_id.' ');
        return $query->result_array();
    }
    
    function get_avial_league_lvl($country_id) {
        $query = $this->db->query('SELECT DISTINCT league_lvl FROM `rsm_league` WHERE country_id = '.$country_id.' ');
        return $query->result_array();
    }
    
    function get_avial_leagues() {
        $query = $this->db->query('SELECT rsm_league.league_lvl, rsm_league.league_num, rsm_country.nameb_en, rsm_country.logo, rsm_country.country_id FROM `rsm_league` 
LEFT OUTER JOIN rsm_country ON rsm_league.country_id = rsm_country.country_id GROUP BY rsm_country.country_id');
        return $query->result_array();
    }
    
    function get_league_races($league_id)//get num of simulated races in season
    {
        //print_r($league_id);
        $sql = "SELECT * FROM `rsm_team` WHERE `league_id` = ".$league_id." LIMIT 0,1";
        
        $query = $this->db->query($sql);
        $data = $query->last_row('array');
        
        $sql = "SELECT DISTINCT `race_id` FROM `rsm_race_team_list` WHERE `race_points` > 0 AND `team_id` = ".$data['team_id']." ";
        //print($sql);
        $query = $this->db->query($sql);
        return $query->num_rows();
        
    }
    
    function get_team_league($team_id){
      $sql = "SELECT rsm_league.country_id, rsm_league.league_lvl, rsm_league.league_num FROM `rsm_team` LEFT OUTER JOIN rsm_league ON rsm_team.league_id = rsm_league.league_id WHERE rsm_team.team_id = ".$team_id." ";
      $query = $this->db->query($sql);
      //print_r($query->result_array());
      return $query->result_array();
    }
    
    
    function get_sportsman_statistic($league_id)
    {
    $sql_select_sportsmans = "SELECT *  FROM `rsm_sportsman` WHERE";
    
    $sql = "SELECT * FROM `rsm_sportsman_statistic` 
      LEFT OUTER JOIN rsm_sportsman ON rsm_sportsman_statistic.sportsman_id = rsm_sportsman.sportsman_id
      LEFT OUTER JOIN rsm_team ON rsm_sportsman.team_id = rsm_team.team_id
      LEFT OUTER JOIN rsm_league ON rsm_team.league_id = rsm_league.league_id
      WHERE rsm_league.country_id = 1 AND rsm_league.league_lvl = 1 AND rsm_league.league_num = 1 ORDER BY rsm_sportsman_statistic.points DESC";//select 
    //print($sql);
    $query = $this->db->query($sql);

     return $query->result_array();
     
     }
     
     function get_league_rating($league)
    {
      //print($league);
      $sql = "SELECT * FROM `rsm_team_basic_rating` 
LEFT OUTER JOIN rsm_team ON rsm_team_basic_rating.team_id = rsm_team.team_id
WHERE rsm_team.league_id = ".$league." ORDER BY `rsm_team_basic_rating`.`rating_overall` DESC ";
      $query = $this->db->query($sql);//
      $query = $query->result_array();
      $data['team_rating']=$query;
      
      $sql = "SELECT MAX(day_id) FROM `rsm_sportsman_training_log`";
      $query = $this->db->query($sql);
      $query = $query->result_array();
      //print_r($query);
      $day_max = $query[0]['MAX(day_id)'];
    
      $sql = "SELECT rsm_sportsman_training_log.sportsman_id, rsm_sportsman_training_log.delta_value, rsm_sportsman_training_log.day_id, rsm_team.team_id, rsm_team.team_name FROM `rsm_sportsman_training_log` 
LEFT OUTER JOIN rsm_sportsman ON rsm_sportsman_training_log.sportsman_id = rsm_sportsman.sportsman_id
LEFT OUTER JOIN rsm_team ON rsm_sportsman.team_id = rsm_team.team_id
LEFT OUTER JOIN rsm_league ON rsm_team.league_id = rsm_league.league_id
WHERE rsm_league.league_id = ".$league." AND rsm_sportsman_training_log.day_id = ".$day_max." ";
      $query = $this->db->query($sql);
      $query = $query->result_array();
      //print("<pre>");
      //print_r($query);
      //print("</pre>");
      $i=1;
      foreach ($query as $string){
        if (!isset($top_training[$string['team_id']]['delta'])) {$top_training[$string['team_id']]['delta']=0;}
        //print("top_training=".$top_training[$string['team_id']]."<br>");
        $top_training[$string['team_id']]['delta'] = $top_training[$string['team_id']]['delta'] + $string['delta_value'];
        $top_training[$string['team_id']]['team_name'] = $string['team_name'];
        $top_training[$string['team_id']]['team_id'] = $string['team_id'];
        //$top_training[$string['team_id']]
        //print_r($string);
        $i++;
      }
      arsort($top_training);
      $data['top_training']=$top_training;
      //print_r($top_training);
      return $data;
    }
    
    function get_top_playoff($league_id) {
      $sql = "SELECT rsm_league_playoff.*, rsm_team.team_name, rsm_league.league_lvl, rsm_league.league_num  FROM `rsm_league_playoff`
      LEFT OUTER JOIN rsm_team ON rsm_league_playoff.team_id = rsm_team.team_id
      LEFT OUTER JOIN rsm_league ON rsm_team.league_id = rsm_league.league_id
      WHERE `rsm_playoff_league_id` = ".$league_id." AND `playoff_type` = 1 ORDER BY `rsm_league_playoff`.`team_points` DESC";
      //сделать if points = 0 sort by team_id
      $query = $this->db->query($sql);
      $query = $query->result_array();
      {
        //print_r($query);
      }
      return $query;
    }
    
    function get_jump_playoff($league_id) {
      $sql = "SELECT rsm_league_playoff.*, rsm_team.team_name, rsm_league.league_lvl, rsm_league.league_num  FROM `rsm_league_playoff`
      LEFT OUTER JOIN rsm_team ON rsm_league_playoff.team_id = rsm_team.team_id
      LEFT OUTER JOIN rsm_league ON rsm_team.league_id = rsm_league.league_id
      WHERE `rsm_playoff_league_id` = ".$league_id." AND `playoff_type` = 2 ORDER BY `rsm_league_playoff`.`team_points` DESC";
      //сделать if points = 0 sort by team_id
      $query = $this->db->query($sql);
      $query = $query->result_array();
      {
        //print_r($query);
      }
      return $query;
    }
}
?>