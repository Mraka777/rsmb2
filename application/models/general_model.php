<?php
class General_model extends CI_Model {

        function __construct()
        {
            parent::__construct();
        }
    
    function get_current_season_date (){
    $sql = 'SELECT * FROM `rsm_live` 
LEFT OUTER JOIN rsm_season ON rsm_live.day_id = rsm_season.day_id
WHERE `id` = 1';
    $query = $this->db->query($sql);
    //print_r($query);
		return $query->row_array();
		}
		
		function get_general($lang) {
			$sql = "SELECT * FROM `rsm_general` WHERE `rsm_lang` LIKE '".$lang."' AND `page` = 1 ORDER BY 'order' DESC";
			$query = $this->db->query($sql);
			$query = $query->result_array();
			//print_r($query);
			return $query;
		}
		
		function get_updates($lang) {
			$sql = "SELECT * FROM `rsm_general_updates` WHERE `lang` LIKE '".$lang."' ORDER BY `rsm_general_updates`.`date` DESC";
			$query = $this->db->query($sql);
			$query = $query->result_array();
			//print_r($query);
			return $query;
		}
		
		function get_todo($lang) {
			$sql = "SELECT * FROM `rsm_general_todo` WHERE `lang` LIKE '".$lang."' ORDER BY 'order' DESC";
			$query = $this->db->query($sql);
			$query = $query->result_array();
			//print_r($query);
			return $query;
		}	
    
}
?>