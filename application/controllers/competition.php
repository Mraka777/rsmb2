<?php
class Competition extends RSM_Controller {


	//Class properties - common vars ($this->var_name)
	private $data;
	private $user_bm_id;
	private $header_data;
	//Class properties end
	
	//Constructor
	public function __construct()
  {
    parent::__construct();
		$this->output->enable_profiler(FALSE);
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->database();
		
		if ( $this->ion_auth->logged_in() ) 
		{
			//GET TEAM ID BY AUTH ID
			$this->load->model('Next_model');
			$user = $this->ion_auth->user()->row();
			$rsm_user = $this->Next_model->get_rsm_team_id($user);
			$this->user_bm_id=$rsm_user;

			//END GET TEAM ID BY AUTH ID
			
			$this->load->model('League_model');
			$this->load->model('Team_model');
			$menu1 = $this->uri->segment(2);
			$menu2 = $this->uri->segment(3);
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
		$this->load->helper('form');
		
		if ( $this->ion_auth->logged_in() ) 
			{
				redirect($this->data['rsm_base_url'].'/competition/league/', 'refresh');
			}
	}	
	
	public function league()
	{
		$this->load->helper('form');
		
		if ( $this->ion_auth->logged_in() ) 
			{
			$this->data['team']=$this->Team_model->get_team_info($this->user_bm_id);

			$team_n=(array)$this->data['team'];
			$team_n=(array)$team_n[0];
			$this->data['league_id']=$team_n['league_id'];
			//print("LEAGUE_ID = ".$data['league_id']);
			$this->data['country_id']=$team_n['country_id'];
			//print_r($data);			
			$this->data['team_stand']=$this->League_model->get_league_standings($this->data['league_id']);
			//get current league data lvl & num
			$this->data['league_data']=$this->League_model->get_league_data($this->data['league_id']);
			//get avial lvl & num 4 current country
			$this->data['league_lvl']=$this->League_model->get_avial_league_lvl($this->data['country_id']);
			$this->data['league_num']=$this->League_model->get_avial_league_num($this->data['country_id']);
			//get list aff all leagues
			$this->data['league_avial']=$this->League_model->get_avial_leagues();
			//get num of finished races in league
			$this->data['league_races']=$this->League_model->get_league_races($this->data['league_id']);
			
			$this->data['league']=$this->League_model->get_team_league($this->user_bm_id);
			//print("<pre>");
			//print_r($this->data);
			//print("</pre>");
		//print_r($data);
			$this->load->view($this->data['current_theme'].'/competition/league_table_view.php', $this->data);

		}
	}
	

	
	public function sp_statistic()
	{
		if ( $this->ion_auth->logged_in() ) 
		{

		$this->data['team']=$this->Team_model->get_team_info($this->user_bm_id);

			
		$team_n=(array)$this->data['team'];
		$team_n=(array)$team_n[0];
		$this->data['league_id']=$team_n['league_id'];

		$this->data['player_statistic']=$this->League_model->get_sportsman_statistic($this->data['league_id']);
		$this->load->view($this->data['current_theme'].'/competition/league_sportsman_statistic_view.php', $this->data);

		}
	}

	public function stat_club()
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
			$this->load->view('templates/header', $header_data);
			$this->load->view('templates/left');			
			$user_team_id=$user_bm_id;
		
		$this->load->model('Team_model');
		$this->load->model('League_model');
		
		//get league_id in var
		$data['team']=$this->Team_model->get_team_info($user_team_id);
		//print_r($data['team']);
			
		$team_n=(array)$data['team'];
		$team_n=(array)$team_n[0];
		$data['league_id']=$team_n['league_id'];

		$data['league_stat']=$this->League_model->get_league_rating($data['league_id']);
		//print_r($data['player_statistic']);
		
		$this->load->view('/templates/league/stat_club', $data);
		
		
		$this->load->view('templates/body_end');
		}
	}
	
		public function view()
	{

		$this->load->helper('form');
		
		if ( $this->ion_auth->logged_in() ) 
		{
			$data['team']=$this->Team_model->get_team_info($this->user_bm_id);
			$team_n['country_id']=1;
			//$data['league_id']=15;

			if ($this->input->post()) {
					$league_var=$this->input->post();//Get training update in POST
					//print_r($league_var);
					//print("LVAR=".$league_var['country']);print(" LLVL=".$league_var['lvl']);print(" LNUM=".$league_var['num']);
				$this->data['view_league_id']=$this->League_model->get_league_id($league_var['country'],$league_var['lvl'],$league_var['num']);
				//print_r($this->data['view_league_id']);
				//print("XXX=".$this->data['view_league_id']->league_id."<br>");
				//print("<pre>");
				//print_r($data);
				//print_r($data['team'][0]->team_id);
				//print("</pre>");
				$team_n['country_id']=$league_var['country'];
				$this->data['league_id']=$this->data['view_league_id']->league_id;
				//$this->data['league_id']=10;
					
					//print("LEAGUE_ID = ".$this->data['league_id']);
					$this->data['country_id']=$team_n['country_id'];
					//print_r($data);			
					$this->data['team_stand']=$this->League_model->get_league_standings($this->data['league_id']);
					//print_r($data['team_stand']);
					//get current league data lvl & num
					$dthis->data['league_data']=$this->League_model->get_league_data($this->data['league_id']);
					//get avial lvl & num 4 current country
					$this->data['league_lvl']=$this->League_model->get_avial_league_lvl($this->data['country_id']);
					$this->data['league_num']=$this->League_model->get_avial_league_num($this->data['country_id']);
					//get list aff all leagues
					$this->data['league_avial']=$this->League_model->get_avial_leagues();
					//get num of finished races in league
					//print("XXX=".$this->data['league_id']."XXX");
					//$this->data['league_races']=$this->League_model->get_league_races($this->data['league_id'], $data['team'][0]->team_id);
					//$this->data['league_races']=0;
					$this->data['league_races']=$this->League_model->get_league_races($this->data['league_id']);
					$this->data['league'][0]['country_id']=$league_var['country'];
					$this->data['league'][0]['league_lvl']=$league_var['lvl'];
					$this->data['league'][0]['league_num']=$league_var['num'];
				
				$this->load->view($this->data['current_theme'].'/competition/league_table_view.php', $this->data);
			}
		}
	}
	
	public function play_off()
	{
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->data['team']=$this->Team_model->get_team_info($this->user_bm_id);
			//print_r($data['team']);
			//get league_id in var
			$team_n=(array)$this->data['team'];
			$team_n=(array)$team_n[0];
			$this->data['league_id']=$team_n['league_id'];
			//print("LEAGUE_ID = ".$data['league_id']);
			$this->data['country_id']=$team_n['country_id'];
			//print_r($data);			
			$this->data['team_stand']=$this->League_model->get_league_standings($this->data['league_id']);
			//get current league data lvl & num
			$this->data['league_data']=$this->League_model->get_league_data($this->data['league_id']);
			//get avial lvl & num 4 current country
			$this->data['league_lvl']=$this->League_model->get_avial_league_lvl($this->data['country_id']);
			$this->data['league_num']=$this->League_model->get_avial_league_num($this->data['country_id']);
			//get list aff all leagues
			$this->data['league_avial']=$this->League_model->get_avial_leagues();
			//get num of finished races in league
			$this->data['league_races']=$this->League_model->get_league_races($this->data['league_id']);
			
			$this->data['league']=$this->League_model->get_team_league($this->user_bm_id);
			

			
			if ($this->input->post()) {
				//print_r($this->input->post());
				$league_var=$this->input->post();
				$this->data['league_id']=$this->League_model->get_league_id($league_var['country'],$league_var['lvl'],$league_var['num']);
				$this->data['league_id']=$this->data['league_id']->league_id;
				}

			//get playoff data
			$this->data['top_playoff']=$this->League_model->get_top_playoff($this->data['league_id']);
			$this->data['jump_playoff']=$this->League_model->get_jump_playoff($this->data['league_id']);
			
		$this->load->view($this->data['current_theme'].'/competition/league_playoff_view.php', $this->data);

		}
	}
	
	}
?>