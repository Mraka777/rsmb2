<?php
class Transfers_model extends CI_Model {

  function __construct()
  {
    parent::__construct();
  }
  
  function get_player_transfer_list() //show FAKE
  {
    $sql = "SELECT * FROM `rsm_sportsman_transfer_list`
    LEFT OUTER JOIN rsm_sportsman ON rsm_sportsman_transfer_list.sportsman_id = rsm_sportsman.sportsman_id
    LEFT OUTER JOIN rsm_country ON rsm_sportsman.country_id = rsm_country.country_id ORDER BY datetime_end ASC
    ";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    return $query;
  }

}
?>