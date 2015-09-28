<?php
class Board_model extends CI_Model {

  function __construct()
  {
    parent::__construct();
  }
    

  function get_board_sections($lang) {
    $sql = "SELECT * FROM `rsm_board_section` WHERE `rsm_board_section_lang` = 0";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    
    return $query;
  }
  
  
   function get_board_topics($section_id, $user_id) {
    $sql = "SELECT rsm_board_section_topic.*, rsm_board_section.*, rsm_board_user_favorite_topic.rsm_board_user_favorite_topic_id FROM `rsm_board_section_topic` 
LEFT OUTER JOIN rsm_board_section ON rsm_board_section_topic.rsm_board_section_id = rsm_board_section.rsm_board_section_id
LEFT OUTER JOIN rsm_board_user_favorite_topic ON rsm_board_section_topic.rsm_board_section_topic_id = rsm_board_user_favorite_topic.rsm_board_section_topic_id AND rsm_board_user_favorite_topic.rsm_id = ".$user_id."
WHERE rsm_board_section_topic.rsm_board_section_id = ".$section_id." ";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    //print_r($query);
    //print($sql);
    return $query;
  }

   function get_board_topic_messages($topic_id) {
    $sql = "SELECT rsm_board_message.*, users.username, rsm_board_section_topic.rsm_board_section_topic_name, rsm_board_section_topic.rsm_board_section_id,  rsm_user_avatar.rsm_user_avatar_filename, rsm_board_section.* FROM `rsm_board_message`
            LEFT OUTER JOIN rsm_user ON rsm_board_message.author_id = rsm_user.rsm_id
            LEFT OUTER JOIN users ON rsm_user.ion_id = users.id
            LEFT OUTER JOIN rsm_board_section_topic ON rsm_board_message.rsm_board_topic_id = rsm_board_section_topic.rsm_board_section_topic_id
            LEFT OUTER JOIN rsm_user_avatar ON rsm_user.ion_id = rsm_user_avatar.rsm_user_id
            LEFT OUTER JOIN rsm_board_section ON rsm_board_section_topic.rsm_board_section_id = rsm_board_section.rsm_board_section_id
            WHERE `rsm_board_topic_id` =  ".$topic_id." ";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    
    return $query;
  }  
    
   function insert_message($topic_id, $message, $user_id, $date_time) {
    $message = mysql_real_escape_string($message);
    $sql = "INSERT INTO `rsm_board_message` (`rsm_board_message_id`, `rsm_board_topic_id`, `author_id`, `rsm_board_message_date_time`, `rsm_board_message_text`) VALUES (NULL, '".$topic_id."', '".$user_id."', '".$date_time."', '".$message."');";
    //print($sql);
    $query = $this->db->query($sql);
    //$query = $query->result_array();
    
    //return $query;
  }
  
  function change_favorite($topic_id, $user_id) {
    //echo("USer=".$user_id." TOP=".$topic_id);
    $sql = "SELECT * FROM `rsm_board_user_favorite_topic` WHERE `rsm_id` = ".$user_id." AND `rsm_board_section_topic_id` = ".$topic_id." ";
    $query = $this->db->query($sql);
    $query = $query->result_array();
    //print_r($query);
    if (!isset($query[0])) {
      $sql = "SELECT MAX(rsm_board_message_id) FROM `rsm_board_message` WHERE `rsm_board_topic_id` = ".$topic_id." ";
      $query = $this->db->query($sql);
      $query = $query->result_array();
      //print_r($query);
      $message_max = $query[0]['MAX(rsm_board_message_id)'];
      $sql = "INSERT INTO `rsm_board_user_favorite_topic` (`rsm_board_user_favorite_topic_id`, `rsm_id`, `rsm_board_section_topic_id`, `rsm_board_section_last_message_id`) VALUES (NULL, '".$user_id."', '".$topic_id."', '$message_max');";
      //print($sql);
      $query = $this->db->query($sql);
      $sql = "INSERT INTO `host1408042_bm`.`rsm_reminder` (`rsm_reminder_id`, `rsm_team_id`, `rsm_reminder_link_id`, `rsm_reminder_type`, `rsm_reminder_num`) VALUES (NULL, '1', '15', '1', '1');";
    }
    else {
      $sql = "DELETE FROM `rsm_board_user_favorite_topic` WHERE `rsm_board_user_favorite_topic`.`rsm_board_user_favorite_topic_id` = ".$query[0]['rsm_board_user_favorite_topic_id']." ";
      $query = $this->db->query($sql);
    }
  }
}
?>