<?php
class Ajax_model extends CI_Model {

        function __construct()
        {
            parent::__construct();
        }
    
    function get_league_num($country_id, $league_lvl){
			$sql = "SELECT COUNT(DISTINCT league_num) FROM `rsm_league` WHERE country_id = ".$country_id." and league_lvl = ".$league_lvl." ";
			$query = $this->db->query($sql);
			$query=$query->result_array();
			//echo($query[0]['COUNT(DISTINCT league_num)']);
			//print($sql);
			return ($query[0]['COUNT(DISTINCT league_num)']);
		}
    
}
?>