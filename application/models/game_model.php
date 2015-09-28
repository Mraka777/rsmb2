<?php
class Game_model extends CI_Model {

  function __construct()
  {
    parent::__construct();
  }
  
   function get_reminders($user_id, $rsm_base_url) {
    $sql = "SELECT * FROM `rsm_reminder` LEFT OUTER JOIN rsm_reminder_type ON rsm_reminder.rsm_reminder_type = rsm_reminder_type.rsm_reminder_type_id WHERE `rsm_team_id` = ".$user_id." ";
    //print($sql);
    $query = $this->db->query($sql);
    $query = $query->result_array();
    //print("<pre>");
    //print_r($query);
    //print("</pre>");
    $i = 0;
    foreach ($query as $temp) {
      if ($temp['rsm_reminder_type_id'] == '1') {
        //echo('zzz');
        $sql2 = "SELECT * FROM `rsm_board_user_favorite_topic` 
                LEFT OUTER JOIN rsm_board_section_topic ON rsm_board_user_favorite_topic.rsm_board_section_topic_id = rsm_board_section_topic.rsm_board_section_topic_id
                WHERE rsm_board_user_favorite_topic.rsm_board_user_favorite_topic_id = ".$temp['rsm_reminder_link_id']." ";
                //print($sql2);
        $query2 = $this->db->query($sql2);
        $query2 = $query2->result_array();
        //print_r()
        $query2 = $query2[0];
        $query[$i]['topic_link'] = "/".$rsm_base_url."/board/topic/".$query2['rsm_board_section_topic_id'];
        $query[$i]['topic_name'] = $query2['rsm_board_section_topic_name'];
        $i++;
      }
      //print_r($query);
    }
    
    return $query;
  }

}
?>