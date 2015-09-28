<?php
class Office_model extends CI_Model {

        function __construct()
        {
            parent::__construct();
        }
    
    function get_current_balance ($team_id) {
      $sql = "SELECT * FROM `rsm_team_balance` WHERE `rsm_team_balance_team_id` = ".$team_id." ";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    function get_finance_types () {
      $sql = "SELECT * FROM `rsm_team_balance_operation`";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    function get_transaction ($day_start, $day_end, $team_id) {
      if ($day_end=='') { //just a day
        $sql = "SELECT * FROM `rsm_team_balance_transaction` WHERE `team_id` = ".$team_id." AND `transaction_day` = ".$day_start." ";
        $query = $this->db->query($sql);
        return $query->result_array();
      }
      else {
        if ($day_end < 0) $day_end=0;
        $sql = "SELECT * FROM `rsm_team_balance_transaction` WHERE `team_id` = ".$team_id." AND `transaction_day` BETWEEN ".$day_end." AND  ".$day_start." ";
        //echo($sql);
        $query = $this->db->query($sql);
        $result=$query->result_array();
        //print_r ($result);
        $transaction_sum = array();
        foreach ($result as $result_array) {
          //echo($result_array['transaction_type']);
          if (isset($transaction_sum[$result_array['transaction_type']])){
            $transaction_sum[$result_array['transaction_type']]=$transaction_sum[$result_array['transaction_type']]+$result_array['transaction_sum'];
          }
          else {
            $transaction_sum[$result_array['transaction_type']]=$result_array['transaction_sum'];
          }

        }
        //print_r($transaction_sum);
				$result2=array();
				$i=0;
				foreach($transaction_sum as $op_type => $op_sum){
					
					//echo($op_type."=".$op_sum." ");
					$result2[$i]['transaction_type']=$op_type;
					$result2[$i]['transaction_sum']=$op_sum;
					$i++;
				}
        
				//print_r($result2);
        //foreach ($transaction_sum as $transaction_result) {
        //  echo(key($transaction_sum)." ");
          
        //}
      
        
        
        //print_r($result);
        
        return $result2;
        
      }
    }
    
    function get_transaction_list($team_id) {
    $sql = 'SELECT * FROM `rsm_team_balance_transaction`
            LEFT OUTER JOIN rsm_team_balance_operation ON rsm_team_balance_transaction.transaction_type = rsm_team_balance_operation.rsm_team_balance_operation_id
            WHERE rsm_team_balance_transaction.team_id = 1';
    $query = $this->db->query($sql);
    return $query->result_array();
    }
    
    function get_calendar_data ($year, $month, $league_id, $team_id){
    
    $sql = 'SELECT * FROM rsm_race LEFT OUTER JOIN rsm_season ON rsm_race.day_id = rsm_season.day_id WHERE league_id='.$league_id.' AND rsm_season.real_date LIKE \''.$year.'-'.$month.'%\'';
    //echo($sql);
    $query = $this->db->query($sql);
    $query = $query->result_array();
    //$i = 0;
    //foreach ($query as $temp) {
    //  $query[$i]['race_type']=1;
    //  $i++;
    //}
    //$num_league_races = count($query);
    //$sql2 = "SELECT * FROM `rsm_league_playoff` LEFT OUTER JOIN rsm_race_playoff ON rsm_league_playoff.rsm_playoff_league_id = rsm_race_playoff.rsm_playoff_league_id LEFT OUTER JOIN rsm_season ON rsm_race_playoff.day_id = rsm_season.day_id WHERE rsm_league_playoff.team_id = ".$team_id." AND rsm_season.real_date LIKE \"".$year."-".$month."%\"";
    //print($sql2);
    //$query2 = $this->db->query($sql2);
    //$query2 = $query2->result_array();
    //$i = $num_league_races;
    //print($i);
    //foreach ($query2 as $temp) {
      //print_r($temp)
      //$query[$i]['race_id']=$temp['rsm_race_playoff_id'];
      //$query[$i]['day_id']=$temp['day_id'];
      //$query[$i]['league_id']=$temp['rsm_playoff_league_id'];
      //$query[$i]['track_id']=$temp['track_id'];
      //$query[$i]['race_status']=$temp['race_status'];
      //$query[$i]['season_id']=$temp['season_id'];
      //$query[$i]['day_num']=$temp['day_num'];
      //$query[$i]['real_date']=$temp['real_date'];
      //$query[$i]['race_type']=$temp['playoff_type'];
      //$i++;
    //}
    //print($sql);
    //print("<pre>");
    //print_r($query);
    //print("</pre>");
    return $query;
    
    }
    
    function show_calendar($year=null, $month=null, $league_id, $team_id)
    {
      $prefs = array (
        'start_day'	=> 'monday',
        'show_next_prev'  => TRUE,
        'next_prev_url'   => base_url() . 'office/calendar/'
        );
      
      $current_year=date("Y");
      $current_month=date("m");
      if (isset($month) AND ($month=='')) $month=$current_month;
      if (isset($year) AND ($year=='')) $year=$current_year;
      
      $data['cal_data']=$this->get_calendar_data($year, $month, $league_id, $team_id);//КОСТЫЛЬ
      //print("<pre>");
      //print_r($data['cal_data']);
      //print("</pre>");
      $cal_data=(array)$data['cal_data'];
  
      $cal_data1= array ();    
       $i=0;
      foreach($cal_data as $string) {
        $string=(array)$cal_data[$i];  
        //echo($string['real_date']);
        $cal_day=explode("-", $string['real_date']);
        //echo($cal_day[2]);
        $cal_data1[(int)$cal_day[2]]='/race/show/'.$string['race_id'];
        
        //if (isset($string['race_type'])) {
          if ($string['race_type']==1) {
            $calendar_data[$string['day_id']]="/race/show_playoff/".$string['race_id'];
          }
        //}
        else {
          $calendar_data[$string['day_id']]="/race/show/".$string['race_id'];
        }
        $i++;
        //print_r($cal_data1);

    }
    
    //print_r($temp);
    
    $prefs['template'] = '

      {table_open}<table border="0" cellpadding="0" cellspacing="0" class="table-striped table-bordered table-condensed">{/table_open}
   
      {heading_row_start}<tr>{/heading_row_start}
   
      {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
      {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
      {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
   
      {heading_row_end}</tr>{/heading_row_end}
   
      {week_row_start}<tr>{/week_row_start}
      {week_day_cell}<td>{week_day}</td>{/week_day_cell}
      {week_row_end}</tr>{/week_row_end}
   
      {cal_row_start}<tr>{/cal_row_start}
      {cal_cell_start}<td>{/cal_cell_start}
   
      {cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
      {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}
   
      {cal_cell_no_content}{day}{/cal_cell_no_content}
      {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}
   
      {cal_cell_blank}&nbsp;{/cal_cell_blank}
   
      {cal_cell_end}</td>{/cal_cell_end}
      {cal_row_end}</tr>{/cal_row_end}
   
      {table_close}</table>{/table_close}
   ';
   
   $this->load->library('calendar', $prefs);
    if (!isset($calendar_data)) {$calendar_data='';};
    return $this->calendar->generate($this->uri->segment(3), $this->uri->segment(4), $calendar_data);
    }

    function get_team_info($team_id){
    
    $sql = 'SELECT * FROM `rsm_team` 
LEFT OUTER JOIN rsm_country ON rsm_team.country_id = rsm_country.country_id
LEFT OUTER JOIN rsm_league ON rsm_team.league_id = rsm_league.league_id
LEFT OUTER JOIN rsm_user ON rsm_team.team_id = rsm_user.rsm_id
LEFT OUTER JOIN users ON rsm_user.ion_id = users.id
LEFT OUTER JOIN rsm_track ON rsm_team.team_id = rsm_track.user_id
WHERE rsm_team.team_id = '.$team_id;
    //echo($sql);
    $query = $this->db->query($sql);
    return $query->result_array();
    
    }
    
    function get_team_credit_offer($team_id){
    
    $sql = 'SELECT * FROM `rsm_team_credit_offer` WHERE `team_id` = '.$team_id;
    //echo($sql);
    $query = $this->db->query($sql);
    return $query->result_array();
    
    }

    function accept_credit_offer($team_id, $offer_id){
    
    $sql = "SELECT * FROM `rsm_team_credit_offer` WHERE `rsm_team_credit_offer_id` = ".$offer_id." AND `team_id` = ".$team_id." ";
    $query = $this->db->query($sql);
    //print_r($query->result_array());
    $temp=$query->result_array();
    //echo($temp[0]['credit_sum']);
    //echo($query->result_array->interest);
    
    //get current day for credit day
    $sql_day = "SELECT day_id FROM `rsm_live` WHERE `id` = 1";
    $query_day = $this->db->query($sql_day);
    $day=$query_day->result_array();
    $day=$day[0]['day_id'];
    //print_r($day);
    //
    $this->Next_model->change_balance($team_id, 7, $temp[0]['credit_sum']);
    $sql = "INSERT INTO `rsm_team_credit` (`rsm_team_credit_id`, `team_id`, `credit_offer_id`, `day_id`, `paid`, `weeks_left`) VALUES (NULL, '".$team_id."', '".$temp[0]['rsm_team_credit_offer_id']."', '".$day."', '0', '".$temp[0]['credit_term']."');";
    //echo($sql);
    $query = $this->db->query($sql);
    //return $query->result_array();
    
    for ($i=1;$i<=($temp[0]['credit_term']);$i++){
      
      //$day_id, $team_id, $type_op, $sum
      //$day=$i*7+1;
      $day_p=$day+$i*7;
      $this->Next_model->insert_daily_payment($day_p, $team_id, 15, $temp[0]['weekly']);
    }
    $title = "Loan accepted";
    $preview = "Loan accepted";
    $content = "The loan per ".$temp[0]['credit_sum']." approved! Your future payments for ".$temp[0]['credit_term']." weeks are: ".$temp[0]['weekly']." ";
    $this->Office_model->create_news('1', '1', $team_id, $title, $preview, $content);
    
    }
		
		function credit_repay($team_id) {
			//print($team_id);
			$sql = "SELECT * FROM `rsm_team_credit`
			LEFT OUTER JOIN rsm_team_credit_offer ON rsm_team_credit.credit_offer_id = rsm_team_credit_offer.rsm_team_credit_offer_id
			WHERE rsm_team_credit_offer.team_id = ".$team_id." ";
			$query = $this->db->query($sql);
			$query = $query->result_array();
			$query = $query[0];
			$sum_to_repay = $query['credit_sum'] - $query['paid'];
			//print_r($query);
			//print("<br>");
			//print("SUM=".$sum_to_repay."<br>");
			//News for repay
			$title = "Loan repaid";
			$preview = "Loan repaid";
			$content = "The loan per ".$query['credit_sum']." repaid! ";	
	    //$this->Office_model->create_news('1', '1', $team_id, $title, $preview, $content);
			$this->Next_model->change_balance($team_id, 15, $sum_to_repay);
		}

    
    function get_team_credit_info($team_id){
      $sql = 'SELECT rsm_team_credit.*, rsm_team_credit_offer.* FROM `rsm_team_credit`
LEFT OUTER JOIN rsm_team_credit_offer ON rsm_team_credit.credit_offer_id = rsm_team_credit_offer.rsm_team_credit_offer_id
WHERE rsm_team_credit.team_id = '.$team_id;
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    function get_staff_info($team_id) {
      $sql = "SELECT * FROM `rsm_staff`
      LEFT OUTER JOIN rsm_staff_type ON rsm_staff.rsm_staff_type_id = rsm_staff_type.rsm_staff_type_id
      LEFT OUTER JOIN rsm_country ON rsm_staff.country_id = rsm_country.country_id
      LEFT OUTER JOIN rsm_staff_salary on rsm_staff.rsm_staff_id = rsm_staff_salary_id
      WHERE `team_id` = ".$team_id." ORDER BY rsm_staff.rsm_staff_type_id ASC";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    function update_staff_role($role) {
      //$sql = "$role";
      if (isset($role)) {
        $i=1;
        foreach ($role as $key => $value) {
          //echo $key.'=>'.$value.'';
          //Coach_head=>1
            if ($i<8){
            $sql ='SELECT * FROM `rsm_staff` WHERE `rsm_staff_type_id` = '.$i.' AND `staff_status` = 1';
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0)
             {
                foreach ($query->result() as $row)
                {
                   //print_r($row);
                   $num=$row->rsm_staff_id;
                   $sql = 'UPDATE rsm_staff SET staff_status = 0 WHERE rsm_staff_id = '.$num.';';
                   $query = $this->db->query($sql);
                }
             }          
            $sql = 'UPDATE rsm_staff SET staff_status = 1 WHERE rsm_staff_id = '.$value.' ';
            $query = $this->db->query($sql);
            $i++;
          }
        }

        }

    }
    
    function get_team_news($team_id)
    {
      $sql = "SELECT rsm_news.*, rsm_season.real_date, rsm_season.season_id, rsm_season.day_num, users.username FROM `rsm_news` 
      LEFT OUTER JOIN users ON rsm_news.author_id = users.id
      LEFT OUTER JOIN rsm_season ON rsm_news.day_id = rsm_season.day_id
      WHERE `team_id` = ".$team_id." OR `team_id` = 0";
      //print($sql);
      $query = $this->db->query($sql);
      $query=$query->result_array();
      //print_r($query->result_array());
      
      foreach ($query as $temp) { //mark as read
        //print_r($temp);
        $news_id = $temp['rsm_news_id'];
        $sql = "UPDATE `rsm_news` SET `status` = '1' WHERE `rsm_news`.`rsm_news_id` = ".$news_id." AND `rsm_news`.`team_id` = ".$team_id.";";
        $this->db->query($sql);
      }
      
      return $query;
    }
 
    function get_current_season_day()
    {
      $sql = "SELECT day_id FROM `rsm_live` WHERE `id` = 1";
      $query = $this->db->query($sql);
      //print($query->row()->day_id);
      $data['day_id']=$query->row()->day_id;
      $sql = "SELECT season_id, day_num, real_date FROM `rsm_season` WHERE `day_id` = 17";
      $query = $this->db->query($sql);
      //print_r($query->row());
      $data['season_id']=$query->row()->season_id;
      $data['day_num']=$query->row()->day_num;
      $data['real_date']=$query->row()->real_date;
      
      //print_r($data);
      
      return $data;
    } 
 
    
    function create_news($author_id, $type, $team_id, $title, $previous, $content)
    {
      $time = date("H:i:s");
      
      $day_id = $this->Office_model->get_current_season_day();
      //print_r($day_id);
      $sql = "INSERT INTO `rsm_news` (`rsm_news_id`, `day_id`, `time`, `author_id`, `news_type_id`, `team_id`, `news_title`, `news_preview`, `news_content`, `status`) VALUES (NULL, ".($day_id['day_id']).", '".$time."', '1', '1', '".$team_id."', '".$title."', '".$previous."', '".$content."', '0');";
      $query = $this->db->query($sql);
      //echo($sql);
    }
		
	    function check_team_rename($user_id)
    {
			$sql = "SELECT is_renamed_by_owner FROM `rsm_team` WHERE `user_id` = ".$user_id."  ";
			$query = $this->db->query($sql);
			$query = $query->row_array();
			$query = $query['is_renamed_by_owner'];
			//print($query);
			return $query;
    }	
    
	    function check_track_rename($user_id)
    {
			$sql = "SELECT track_is_renamed_by_owner FROM `rsm_track` WHERE `track_id` = ".$user_id."  ";
			$query = $this->db->query($sql);
			$query = $query->row_array();
			$query = $query['track_is_renamed_by_owner'];
			//print($query);
			return $query;
    }			
	    function team_first_rename($user_id, $data_update)
    {
			//print_r($data_update);
			//print($user_id);
			$sql = "UPDATE `rsm_team` SET `team_name` = '".$data_update['team_name']."', `is_renamed_by_owner` = '1' WHERE `user_id` = ".$user_id.";";
			$this->db->query($sql);
			$sql = "UPDATE `rsm_track` SET `name_en` = '".$data_update['track_name']."', `track_is_renamed_by_owner` = '1' WHERE `user_id` = ".$user_id.";";
			$this->db->query($sql);
			//print($sql);
			//return $query;
    }			
}
?>