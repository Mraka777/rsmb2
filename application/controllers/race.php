<?php
class Race extends RSM_Controller {


	//Class properties - common vars ($this->var_name)
	private $data;
	private $user_bm_id;
	private $header_data;
	//Class properties end
	
	//Constructor
	public function __construct()
  {
    parent::__construct();
		$this->output->enable_profiler(TRUE);
		$this->load->library('ion_auth');
		
		$this->load->library('session');
		$this->load->database();
		
		if ( $this->ion_auth->logged_in() ) 
		{
			//GET TEAM ID BY AUTH ID
			$this->load->model('Next_model');
			
			$this->load->model('General_model');
			$user = $this->ion_auth->user()->row();
			$rsm_user = $this->Next_model->get_rsm_team_id($user);
			$this->user_bm_id=$rsm_user;
			//END GET TEAM ID BY AUTH ID
			
			//
			$this->load->helper('rsm_link');
			
			$this->load->model('Race_model');
			//$this->load->model('Office_model');
			$menu1 = $this->uri->segment(2);
			$menu2 = $this->uri->segment(3);
			
			//!!! - заменить this->rsm_base_url на $this->rsm['base_url'] во всех контроллерах, пока поставил дублирующую времянку в RSM_controller
			$this->data = $this->Next_model->get_general_data($rsm_user, $menu1, $menu2, $this->rsm['base_url']);
			$this->header_data['team']=$this->user_bm_id;
		
			//print_r($this->rsm);
			//Времянка - нужно в шаблонах всё перевести на использование массива $rsm ($this->rsm)
			$this->data['language_link'] = $this->rsm['language_link'];
			$this->data['current_theme'] = $this->rsm['current_theme'];
			$this->data['rsm_base_url'] = $this->rsm['base_url'];
			/*?><pre><?php print_r($this->data);?></pre><?php*/
			
			$this->data['rsm'] = $this->rsm;
		}
	}
	//Constructor ends
	
	//Class methods
	
	public function index()
	{
		//$this->load->library('my_lang');
		//print($this->config->item('language_abbr')."<br><br>");
		//print($this->session->userdata('language')."<br><br>");
		//print_r($data);
		$this->load->helper('form');
		$this->load->helper('rsm_link');
		
		if ( $this->ion_auth->logged_in() ) 
		{
			
			$current_day=$this->General_model->get_current_season_date();
			//print_r($current_day);
			//получим данные - есть ли гонка сегодня
			$this->data['race_info']=$this->Race_model->get_next_race_info('day_id', $current_day['day_id'], $this->user_bm_id);
			//print_r($this->data['race_info']);
			if ($this->data['race_info'][0]['race_status'] == '0') {
				$this->data['race_prev_track_info']=$this->Race_model->get_race_preview_track_info($this->data['race_info'][0]['race_id']);
				$this->data['race_weather_forecast']=$this->Race_model->get_race_weather_foreacast($this->data['race_info'][0]['race_id']);
				$this->data['race_team_sportsman_list']=$this->Race_model->get_team_race_sportsman_list($this->data['race_info'][0]['race_id'], $this->user_bm_id);
				$this->load->view($this->data['current_theme'].'/race/race_index_view.php', $this->data);
			}
			elseif ($this->data['race_info'][0]['race_status'] == '1') {
				$this->data['race_prev_track_info']=$this->Race_model->get_race_preview_track_info($this->data['race_info'][0]['race_id']);
				$this->data['race_result']=$this->Race_model->get_race_result($this->data['race_info'][0]['race_id']);
				$this->data['race_result_shooting']=$this->Race_model->get_race_result_shooting($this->data['race_info'][0]['race_id']);
				$this->load->view($this->data['current_theme'].'/race/race_result_view.php', $this->data);
			}
			elseif ($this->data['race_info'][0]['race_status'] == '99') {
				$this->data['race_info']=$this->Race_model->get_next_race_info(($current_day['day_id']+1), $this->user_bm_id);
				$this->data['race_weather_forecast']=$this->Race_model->get_race_weather_foreacast($this->data['race_info'][0]['race_id']);
				$this->data['race_team_sportsman_list']=$this->Race_model->get_team_race_sportsman_list($this->data['race_info'][0]['race_id'], $this->user_bm_id);
				$this->load->view($this->data['current_theme'].'/race/race_index_view.php', $this->data);
			}
		}
	}
	
	public function report($race_id) {
		
		
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->data['top8_team_pts']=$this->Race_model->get_top8_team_pts($race_id);
			$this->data['next8_team_pts']=$this->Race_model->get_next8_team_pts($race_id);
			$this->data['race_sniper']=$this->Race_model->get_race_sniper($race_id);
			$this->data['race_best_ski']=$this->Race_model->get_race_best_ski($race_id);
			$this->data['race_sportsman_list']=$this->Race_model->get_race_sportsman_result_list($race_id);
			$this->data['track_data']=$this->Race_model->get_race_data($race_id);
			$this->data['race_weather']=$this->Race_model->get_race_weather_extended($race_id);
			
			//$this->data['race_result'] = $this->Race_model->get_race_result($race_id);
			
			$this->load->view($this->data['current_theme'].'/race/race_result_view.php', $this->data);
		}
	}
	
	public function preview($race_id) {
		$this->load->helper('rsm_link');
		
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->data['race_info']=$this->Race_model->get_next_race_info('race_id', $race_id, $this->user_bm_id);
			$this->data['race_prev_track_info']=$this->Race_model->get_race_preview_track_info($race_id);
			$this->data['race_weather_forecast']=$this->Race_model->get_race_weather_foreacast($race_id);
			$this->data['race_team_sportsman_list']=$this->Race_model->get_team_race_sportsman_list($race_id, $this->user_bm_id);
			
			$this->load->view($this->data['current_theme'].'/race/race_index_view.php', $this->data);
		}
	}	
	
	public function calendar() {
		if ( $this->ion_auth->logged_in() ) 
		{
			$current_day=$this->General_model->get_current_season_date();
			
			$next_race_id = $this->Race_model->get_next_race_id($current_day['day_id'], $this->user_bm_id);
			$this->data['next_race_info']=$this->Race_model->get_race_info($next_race_id);
			$this->data['next_race_info']=$this->data['next_race_info'][0];
			
			$last_race_id = $this->Race_model->get_last_race_id($current_day['day_id'], $this->user_bm_id);
			$this->data['last_race_info']=$this->Race_model->get_race_info($last_race_id);
			$this->data['last_race_info']=$this->data['last_race_info'][0];
			
			
			$prev_races_list=$this->Race_model->get_prev_races_list($current_day['day_id'], $this->user_bm_id);
			$next_races_list=$this->Race_model->get_next_races_list($current_day['day_id'], $this->user_bm_id);
			$count_prev = count($prev_races_list);
			$count_next = count($next_races_list);
			//print("P=".$count_prev." N=".$count_next);
			for ($i=0; $i<$count_prev;$i++){
				//print($prev_races_list[$i]);
				$this->data['prev_race_data'][$i]=$this->Race_model->get_race_info($prev_races_list[$i]);
				$this->data['prev_race_data'][$i]=$this->data['prev_race_data'][$i][0];
			}
			for ($i=0; $i<$count_next;$i++){
				//print($next_races_list[$i]." ");
				$this->data['next_race_data'][$i]=$this->Race_model->get_race_info($next_races_list[$i]);
				$this->data['next_race_data'][$i]=$this->data['next_race_data'][$i][0];
			}
			//print("<pre>");
			//print_r($this->data['next_race_data']);
			//print("</pre>");
			$this->load->view($this->data['current_theme'].'/race/race_calendar_view.php', $this->data);
		}
	}
	
	public function line_up()
	{
		$this->load->helper('form');
		$this->load->model('Team_model');
		
		if ( $this->ion_auth->logged_in() ) 
		{
			$current_day=$this->General_model->get_current_season_date();
			$this->data['race_info']=$this->Race_model->get_next_race_info($current_day['day_id'], $this->user_bm_id);
			if ($this->input->post()) {
				$data_update=$this->input->post();//Get training update in POST
				//print_r($data_update);
				$this->data['race_info']=$this->Race_model->get_next_race_info($current_day['day_id'], $this->user_bm_id);
				if ($this->data['race_info'][0]['race_status'] == '99') {
					$this->data['race_info']=$this->Race_model->get_next_race_info(($current_day['day_id']+1), $this->user_bm_id);
				}
				
				$this->Race_model->update_next_race_sportsman($this->data['race_info'][0]['race_id'], $data_update, $this->user_bm_id);
				}
			
			
			if ($this->data['race_info'][0]['race_status'] == '0') {
				$this->data['race_team_sportsman_list']=$this->Race_model->get_team_race_sportsman_list($this->data['race_info'][0]['race_id'], $this->user_bm_id);
				$this->data['race_team_full_list']=$this->Team_model->get_sportsman_list_no_inj($this->user_bm_id);
				$this->load->view($this->data['current_theme'].'/race/race_line_up_view.php', $this->data);
			}
			elseif ($this->data['race_info'][0]['race_status'] == '99') {
				$current_day=$this->General_model->get_current_season_date();
				//print_r($current_day);
				//$current_day = $current_day + 1;
				$this->data['race_info']=$this->Race_model->get_next_race_info(($current_day['day_id']+1), $this->user_bm_id);
				$this->data['race_team_sportsman_list']=$this->Race_model->get_team_race_sportsman_list($this->data['race_info'][0]['race_id'], $this->user_bm_id);
				$this->data['race_team_full_list']=$this->Team_model->get_sportsman_list_no_inj($this->user_bm_id);
				$this->load->view($this->data['current_theme'].'/race/race_line_up_view.php', $this->data);
				}
			
		}
	}
	
	public function tactics()
	{
		$this->load->helper('form');
		$this->load->model('Team_model');
		
		if ( $this->ion_auth->logged_in() ) 
		{
			$current_day=$this->General_model->get_current_season_date();
			$this->data['race_info']=$this->Race_model->get_next_race_info($current_day['day_id'], $this->user_bm_id);
			if ($this->input->post()) {
				//print_r($this->data['race_info']);
				$data_update=$this->input->post();//Get training update in POST
				//print_r($data_update);
				array_pop($data_update);
				$data_update_keys = array_keys($data_update);
				$i=0;
				foreach ($data_update as $upd_data) {
					//print("<pre>");
					//print_r($upd_data);
					//print("</pre>");
					$param = explode("_",$data_update_keys[$i]);
					//print("Test=".$param[0]."<br>");
					//print("key=".$data_update_keys[$i]." data=".$upd_data."<br>");
					if ($param[0] == 'i') {//importance
						$sql = "UPDATE `rsm_race_sportsman_tactics` SET `rsm_race_sportsman_tactics_importance` = '".$upd_data."' WHERE `sportsman_id` = ".$param[1]." AND race_id = ".$cur_race_id.";";
						$this->db->query($sql);
						//print($sql."<br>");
					}
					elseif ($param[0] == 'sp'){//ski plain
						$sql = "UPDATE `rsm_race_sportsman_tactics` SET `rsm_race_sportsman_tactics_ski_plain` = '".$upd_data."' WHERE `sportsman_id` = ".$param[1]." AND race_id = ".$cur_race_id.";";
						$this->db->query($sql);
						//print($sql."<br>");
					}
					elseif ($param[0] == 'sh'){//ski hill
						$sql = "UPDATE `rsm_race_sportsman_tactics` SET `rsm_race_sportsman_tactics_ski_hill` = '".$upd_data."' WHERE `sportsman_id` = ".$param[1]." AND race_id = ".$cur_race_id.";";
						$this->db->query($sql);
						//print($sql."<br>");
					}
					elseif ($param[0] == 's'){//ski plain
						$sql = "UPDATE `rsm_race_sportsman_tactics` SET `rsm_race_sportsman_tactics_shooting` = '".$upd_data."' WHERE `sportsman_id` = ".$param[1]." AND race_id = ".$cur_race_id.";";
						$this->db->query($sql);
						//print($sql."<br>");
					}
					elseif ($param[0] == 'raceid'){//race_id
						//print_r($upd_data);
						//print("race_id=".$upd_data);
						$cur_race_id=$upd_data;
						}
					$i++;
				}
				//echo key($data_update).'<br />';
				//$this->Race_model->update_next_race_sportsman($this->data['race_info'][0]['race_id'], $data_update, $this->user_bm_id);
				}
			
			
			if ($this->data['race_info'][0]['race_status'] == '0') {
				//показываем окно выбора тактики
				$this->data['race_team_sportsman_list']=$this->Race_model->get_team_race_sportsman_list($this->data['race_info'][0]['race_id'], $this->user_bm_id);
				//get full team list for choice
				$this->data['race_tactics_types']=$this->Race_model->get_race_tactics_types();
				$this->data['race_team_sportsman_tactics']=$this->Race_model->get_race_sportsman_tactics($this->data['race_info'][0]['race_id'], $this->user_bm_id);
				//print_r($this->data['race_team_full_list']);
				
				$this->load->view($this->data['current_theme'].'/race/race_tactics_view.php', $this->data);
			}
			elseif ($this->data['race_info'][0]['race_status'] == '99') {
				//print("ZZZ");
				$this->data['race_info']=$this->Race_model->get_next_race_info(($current_day['day_id']+1), $this->user_bm_id);
				//print($this->data['race_info'][0]['race_id']);
				$this->data['race_team_sportsman_list']=$this->Race_model->get_team_race_sportsman_list($this->data['race_info'][0]['race_id'], $this->user_bm_id);
				$this->data['race_tactics_types']=$this->Race_model->get_race_tactics_types();
				$this->data['race_team_sportsman_tactics']=$this->Race_model->get_race_sportsman_tactics($this->data['race_info'][0]['race_id'], $this->user_bm_id);
				//print_r($this->data['race_team_full_list']);
				
				$this->load->view($this->data['current_theme'].'/race/race_tactics_view.php', $this->data);
			}
		}
	}	
	
		public function show($race_id)
	{	

		
		if ( $this->ion_auth->logged_in() ) 
		{
		//comment 01.10.2015
		$this->data['race_info']=$this->Race_model->get_race_info($race_id);
		//print_r($this->data['race_info']);
		$this->data['race_sportsman_list']=$this->Race_model->get_race_sportsman_list($race_id);
		$this->data['race_weather']=$this->Race_model->get_race_weather($race_id);
		$this->data['race_status']=$this->Race_model->get_race_status($race_id);

		if ($this->data['race_status']==0) { //no log for race_id in logr table
			$this->data['race_info'][0]['mode']='Current line-up';
			//$this->load->view('race/show_race', $data);	
		}
		else {//show race result similiar to index
			$this->data['race_info'][0]['mode']='Results';
			$this->data['race_result']=$this->Race_model->get_race_result($race_id); // get result on last mark from logr table
			$this->data['race_result_shooting']=$this->Race_model->get_race_result_shooting($race_id);
			//print_r($data['race_result']);
			//$this->load->view('race/show_race_result', $data);
			$this->load->view($this->data['current_theme'].'/race/race_result_view.php', $this->data);
			}	
		}
	}

		public function view()
	{
		//$this->output->enable_profiler(TRUE);
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('javascript');
		$this->load->database();
		//$this->load->library('jquery');
		if ( $this->ion_auth->logged_in() ) 
		{
			//GET TEAM ID BY AUTH ID
			$this->load->model('Next_model');
			$user = $this->ion_auth->user()->row();
			$rsm_user = $this->Next_model->get_rsm_team_id($user);
			$user_bm_id=$rsm_user;
			//END GET TEAM ID BY AUTH ID
				$header_data['team']=$user_bm_id;
		$this->load->model('Race_model');

		$this->load->view('templates/header', $header_data);
		$this->load->view('templates/left_race_live');
		
		$this->load->view('race/show_race_live');

		
		$this->load->view('templates/body_end');
		}
	}

		public function analysis($race_id)
	{
		//$this->output->enable_profiler(TRUE);
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('javascript');
		$this->load->database();
		//$this->load->library('jquery');
		if ( $this->ion_auth->logged_in() ) 
		{
			//GET TEAM ID BY AUTH ID
			$this->load->model('Next_model');
			$user = $this->ion_auth->user()->row();
			$rsm_user = $this->Next_model->get_rsm_team_id($user);
			$user_bm_id=$rsm_user;
			//END GET TEAM ID BY AUTH ID
				$header_data['team']=$user_bm_id;
		$this->load->model('Race_model');

		$this->load->view('templates/header', $header_data);
		$this->load->view('templates/left_race_live');
		
		$race_data['race_log'] = $this->Race_model->get_race_sportsman_log($race_id);
		$race_data['race_marks'] = $this->Race_model->get_race_marks($race_id);
		
		$this->load->view('race/show_race_analys', $race_data);

		
		$this->load->view('templates/body_end');
		}
	}	
	
		public function engine($race_id)
	{
		//$this->output->enable_profiler(TRUE);
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->database();
		
		if ( $this->ion_auth->logged_in() ) 
		{
			//GET TEAM ID BY AUTH ID
			$this->load->model('Next_model');
			$user = $this->ion_auth->user()->row();
			$rsm_user = $this->Next_model->get_rsm_team_id($user);
			$user_bm_id=$rsm_user;
			//END GET TEAM ID BY AUTH ID
				$header_data['team']=$user_bm_id;
		$this->load->model('Race_model');

			$this->load->view('templates/header', $header_data);
		$this->load->view('templates/left');
		
		$data['race_info']=$this->Race_model->get_race_info($race_id);
		$data['race_sportsman_list']=$this->Race_model->get_race_sportsman_list($race_id);
		//print_r($data['race_info']);
		
		$this->load->view('race/show_race', $data);
		$this->load->view('race/race_engine', $data);
		
		$this->load->view('templates/body_end');
		}
	}
	
}
?>