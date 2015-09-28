<?php
class Team extends RSM_Controller {

	//Class properties - common vars ($this->var_name)
	private $data;
	private $user_bm_id;
	private $header_data;
	//Class properties end
	
	//Constructor
	public function __construct()
  {
    parent::__construct();
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
			$this->user_bm_id=$rsm_user;
			//END GET TEAM ID BY AUTH ID
			
			$this->load->model('Team_model');
			//$this->load->model('Office_model');
			$menu1 = $this->uri->segment(2);
			$menu2 = $this->uri->segment(3);
			//$this->data = $this->Next_model->get_general_data($rsm_user, $menu1, $menu2);
			//print_r($this->data);
			$this->data = $this->Next_model->get_general_data($rsm_user, $menu1, $menu2, $this->rsm_base_url);
			$this->data['page_help']=$this->Next_model->get_page_help($rsm_user, $menu1, $menu2);
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
		//$this->load->helper('url');
		
		if ( $this->ion_auth->logged_in() ) 
		{
			redirect($this->data['rsm_base_url'].'/team/overview/', 'refresh');
		}
	}
	
	public function academy() //показываем окно скаута
	{
    if ( $this->ion_auth->logged_in() )
		{
				$this->data['academy']=$this->Team_model->get_team_academy($this->user_bm_id);
				$this->data['academy_staff']=$this->Team_model->get_staff_info($this->user_bm_id, 7);
				$this->load->view($this->data['current_theme'].'/team/team_academy_view.php', $this->data);
		}
	}

	public function academy_accept($sportsman_id) //показываем окно скаута
	{
    if ( $this->ion_auth->logged_in() )
		{
				$this->load->model('Office_model');
				//print($sportsman_id);
				$data=$this->Team_model->academy_accept($this->user_bm_id, $sportsman_id);
				//print_r($data);
				//print($academy_sum);
				$this->Next_model->change_balance($this->user_bm_id, 13, $data['sign_fee']);
				$this->Office_model->create_news('1', '1', $this->user_bm_id, $data['news_title'], $data['preview'], $data['content']);
				//$this->load->view($this->data['current_theme'].'/team/team_academy_view.php', $this->data);
				redirect($this->data['rsm_base_url'].'/team/academy/', 'refresh');
		}
	}

	public function academy_reject($sportsman_id) //показываем окно скаута
	{
    if ( $this->ion_auth->logged_in() )
		{
				$this->Team_model->academy_reject($this->user_bm_id, $sportsman_id);
				redirect($this->data['rsm_base_url'].'/team/academy/', 'refresh');
		}
	}
	
	public function injuries() //травмы
	{
    if ( $this->ion_auth->logged_in() )
		{
			$this->data['team_injury']=$this->Team_model->get_team_injury($this->user_bm_id);
			$this->load->view($this->data['current_theme'].'/team/team_injuries_view.php', $this->data);
		}
	}
	
  public function overview()
	{
		//echo($team_id);
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->data['query']=$this->Team_model->get_sportsman_list($this->user_bm_id);
			$this->data['team']=$this->Team_model->get_team_info($this->user_bm_id);
			$team_n=(array)$this->data['team'];
			$team_n=(array)$team_n[0];
			$this->data['team_name']=$team_n['team_name'];
			$this->data['logo']=$team_n['logo'];
			$this->data['team_id']=$team_n['team_id'];
			$this->load->view($this->data['current_theme'].'/team/team_view.php', $this->data);
		}
	}

	public function scouting() //показываем окно скаута
	{
    if ( $this->ion_auth->logged_in() )
		{

				$this->data['team_scouting']=$this->Team_model->get_team_scouting($this->user_bm_id);
				$this->load->view($this->data['current_theme'].'/team/team_scouting_view.php', $this->data);
		}
	}
	
	public function statistic() //статистика
	{
    if ( $this->ion_auth->logged_in() )
		{
			$this->data['team_statistic']=$this->Team_model->get_team_statistic($this->user_bm_id);
			$this->load->view($this->data['current_theme'].'/team/team_statistic_view.php', $this->data);
		}
	}	
	
	public function training() //получает список тренировок всей команды
	{
		$this->load->helper('url');
		$this->load->helper('form');
		
    if ( $this->ion_auth->logged_in() )
		{
			$this->load->model('Player_model');

			$this->data['team_practice']=$this->Player_model->get_sportsman_training($this->user_bm_id);
				
				//print_r($data);
			if ($this->input->post()) {
				$data_update=$this->input->post();//Get training update in POST
				$this->Player_model->update_sportsman_training($data_update);
				redirect($this->data['rsm_base_url'].'/team/training/', 'refresh');
			}
			$cur_uri = uri_string();
			$this->data['url']=$cur_uri;
				
			$this->load->view($this->data['current_theme'].'/team/team_training_view.php', $this->data);
		}
	}

  public function view($team_id)
	{
		if(!isset($team_id)) {
			$team_id=$this->user_bm_id;
		}
		//echo($team_id);
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->data['query']=$this->Team_model->get_sportsman_list($team_id);
			$this->data['team']=$this->Team_model->get_team_info($team_id);
			$team_n=(array)$this->data['team'];
			$team_n=(array)$team_n[0];
			$this->data['team_name']=$team_n['team_name'];
			$this->data['logo']=$team_n['logo'];
			$this->data['team_id']=$team_n['team_id'];
			$this->load->view($this->data['current_theme'].'/team/team_view.php', $this->data);
		}
	}

	
}
?>