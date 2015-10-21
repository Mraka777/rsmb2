<?php
class Infrastructure_model extends CI_Model {

        function __construct()
        {
            parent::__construct();
        }
    function get_infrastructure_info($team_id)
    {
        $query = $this->db->query('SELECT * FROM rsm_infrastructure
        LEFT OUTER JOIN rsm_infrastructure_building ON rsm_infrastructure.building_id=rsm_infrastructure_building.building_id
        LEFT OUTER JOIN rsm_infrastructure_building_level ON rsm_infrastructure.building_level_id=rsm_infrastructure_building_level.building_level_id
        WHERE `team_id` = '.$team_id.' ORDER BY  `infr_id` ASC');
        $query = $query->result_array();
        $i = 0;
        foreach ($query as $infr) {
          //print_r($infr);
          if ($infr['days_next'] != '0') {
            //echo ("ZZZ");
            $query[$i]['under_construction'] = '1';
          }
          else {
            $query[$i]['under_construction'] = '0';
          }
          $i++;
        }

        return $query;
    }
    function get_stadium_info($team_id)
    {
        $sql = "SELECT * FROM rsm_stadium
        LEFT OUTER JOIN rsm_stadium_building ON rsm_stadium.stadium_building_id=rsm_stadium_building.rsm_stadium_building_id
        LEFT OUTER JOIN rsm_stadium_building_level ON rsm_stadium.stadium_building_level_id=rsm_stadium_building_level.rsm_stadium_building_level_id
        WHERE `team_id` = ".$team_id." ORDER BY  `rsm_stadium_id` ASC";
        //print($sql);
        $query = $this->db->query($sql);
        $query = $query->result_array();
        $i = 0;
        foreach ($query as $temp) {
          if ($temp['stadium_building_days_next'] > 0 ) { //under construction
            $query[$i]['status'] = "Under construction, ".$temp['stadium_building_days_next']." day(s)";
            $query[$i]['building_effect'] = "<i>Construction ".$temp['stadium_building_days_next']." day(s)</i>";
          }
          else {
            if ($temp['stadium_building_level_id'] > 0) {
              $query[$i]['status'] = "In use";  
            }
            else {
              $query[$i]['status'] = "Not Available";
            }
            
          }
          $i++;
        }
        
        //$query = $query[0];
        //print("<pre>");
        //print_r($query);
        //print("</pre>");
        return $query;
    }
    //detailed view
    function get_infrastructure_detailed($facility_level_id){
      $sql = "SELECT * FROM `rsm_infrastructure_building_level`
      LEFT OUTER JOIN rsm_infrastructure_building ON rsm_infrastructure_building.building_id = rsm_infrastructure_building_level.building_level_id
      WHERE rsm_infrastructure_building_level.building_level_id =  ".$facility_level_id." ";
      $query = $this->db->query($sql);
      $query = $query->result_array();
      $query = $query[0];
      return $query;
    }
 
    function get_track_info($team_id){
      $sql = "SELECT rsm_track.*, rsm_team.*, rsm_country.*, users.username FROM rsm_track
						LEFT OUTER JOIN rsm_track_type ON rsm_track.track_type = rsm_track_type.rsm_track_type_id
            LEFT OUTER JOIN rsm_team ON rsm_track.user_id = rsm_team.team_id
						LEFT OUTER JOIN rsm_country ON rsm_team.country_id = rsm_country.country_id
            LEFT OUTER JOIN rsm_user ON rsm_team.team_id = rsm_user.rsm_id
          	LEFT OUTER JOIN users ON rsm_user.ion_id = users.id            
						WHERE rsm_track.user_id=".$team_id;" ";
            //print($sql);
      $query = $this->db->query($sql);
      $query = $query->result_array();
      $query = $query[0];
			switch ($query['track_type']) {
					case 1:
							$query['track_type'] = 'Plain';
							$query['track_plain']=60;
							$query['track_rise']=20;
							$query['track_descent']=20;
							break;

					default:
							$query['track_type'] = 'Unknown';
							$query['track_plain']=0;
							$query['track_rise']=0;
							$query['track_descent']=0;
							break;
			}      
      return $query;
    }   
    
    function build_stadium_choice($team_id, $stadium_id)
    {
     //echo($facility_id);
     //get current level of facility
    $sql="SELECT * FROM `rsm_stadium` 
    LEFT OUTER JOIN rsm_stadium_building_level ON rsm_stadium.stadium_building_level_id=rsm_stadium_building_level.rsm_stadium_building_level_id WHERE `team_id` = ".$team_id." AND `rsm_stadium`.`stadium_building_id` = ".$stadium_id;
    //echo($sql);
    $query = $this->db->query($sql);
    if($query->num_rows == 1)
      {
        $cur_level_obj=$query->row();
        $current_stadium_level_id=$cur_level_obj->stadium_building_level_id;
        $current_stadium_level=$cur_level_obj->stadium_building_level;
        $days_left=$cur_level_obj->stadium_building_days_next;
      }
    
    //get next stadium_level_id for this facility_id
    if ($days_left > 0 ) echo('Can\'t build!');
    else {
      $next_stadium_level=$current_stadium_level+1;
      $sql="SELECT * FROM `rsm_stadium_building_level` WHERE `stadium_building_id` = ".$stadium_id." AND `stadium_building_level` = ".$next_stadium_level;
      //echo($sql);
      $query = $this->db->query($sql);
      if ($query->num_rows() > 0)
      {
         //$row = $query->row(); 
         //print_r($row);
         //echo $row->building_id;
      }
      //print_r($query);
      return $query->result_array();
      //echo($sql);
      }
    }
 
    function build_stadium($data)
    {
      //print_r($data);
      //building_level_id = rsm_stadium_building_level_id (!)
      $sql="SELECT stadium_building_id, stadium_building_build_days, stadium_building_level FROM `rsm_stadium_building_level` WHERE `rsm_stadium_building_level_id` = ".$data['building_level_id'];
      //echo($sql);
      $query = $this->db->query($sql);
      if ($query->num_rows() > 0)
      {
         $row = $query->row();
         $stadium_building_id=$row->stadium_building_id;
         $build_days=$row->stadium_building_build_days;
         $old_level=$row->stadium_building_level;
      }
      $sql="UPDATE `rsm_stadium` SET `stadium_building_level_id` = '".$data['building_level_id']."', `stadium_building_days_next` = '".$build_days."' WHERE `team_id` = ".$data['team_id']." AND `stadium_building_id` = ".$stadium_building_id.";";
      $query = $this->db->query($sql);
      //print_r($query);
      //echo($sql);

    }   
    
    function build_facility_choice($team_id, $facility_id)
    {
     //echo($facility_id);
     //get current level of facility
    $sql="SELECT * FROM `rsm_infrastructure` 
    LEFT OUTER JOIN rsm_infrastructure_building_level ON rsm_infrastructure.building_level_id=rsm_infrastructure_building_level.building_level_id WHERE `team_id` = ".$team_id." AND `rsm_infrastructure`.`building_id` = ".$facility_id;
    //echo($sql);
    $query = $this->db->query($sql);
    if($query->num_rows == 1)
      {
        $cur_level_obj=$query->row();
        $current_building_level_id=$cur_level_obj->building_level_id;
        $current_building_level=$cur_level_obj->building_level;
        $days_left=$cur_level_obj->days_next;
      }
    //echo($current_building_level);
    //get next building_level_id for this facility_id
    if ($days_left > 0 ) { }
    else {
      $next_building_level=$current_building_level+1;
      $sql="SELECT * FROM `rsm_infrastructure_building_level` WHERE `building_id` = ".$facility_id." ";
      //print($sql."<br>");
      $query = $this->db->query($sql);
      if ($query->num_rows() > 0)
      {
         $row = $query->row(); 
         //print_r($row);
         //echo $row->building_id;
      }
      //print_r($query);
      return $query->result_array();
      //echo($sql);
      }
    }

    function build_facility($data)
    {
      //print_r($data);
      $sql="SELECT building_id, build_days, building_level FROM `rsm_infrastructure_building_level` WHERE `building_level_id` = ".$data['Building_level_id'];
      $query = $this->db->query($sql);
      if ($query->num_rows() > 0)
      {
         $row = $query->row();
         $building_id=$row->building_id;
         $build_days=$row->build_days;
         $old_level=$row->building_level;
      }
      $sql="UPDATE `rsm_infrastructure` SET `building_level_id` = '".$data['Building_level_id']."', `days_next` = '".$build_days."' WHERE `team_id` = ".$data['team_id']." AND `building_id` = ".$building_id.";";
      $query = $this->db->query($sql);
      //print_r($query);
      //echo($sql);

    }
    

}
?>