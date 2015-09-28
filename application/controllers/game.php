<?php
class Game extends RSM_Controller {

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
			$this->load->model('Game_model');
			$user = $this->ion_auth->user()->row();
			$rsm_user = $this->Next_model->get_rsm_team_id($user);
			$this->user_bm_id=$rsm_user;
			//END GET TEAM ID BY AUTH ID
			$menu1 = $this->uri->segment(2);
			$menu2 = $this->uri->segment(3);
			$this->data = $this->Next_model->get_general_data($rsm_user, $menu1, $menu2, $this->rsm_base_url);
			//$this->data['header_menu'] = $this->Game_model->get_header_menu($menu2);
			$this->header_data['team']=$this->user_bm_id;
		
			$this->data['current_theme'] = 'default.0.2'; // GET FROM BASE
			$this->data['rsm_base_url'] = $this->rsm_base_url;
		}
	}
	//Constructor ends
	
	//Class methods	


	public function index()
	{
		if ( $this->ion_auth->logged_in() ) 
		{
			
			//$this->data['active_menu']=$this->Board_model->get_board_sections(0);
			//$this->load->view($this->data['current_theme'].'/board/board_sections_view.php', $this->data);
		}
	}

	public function about()
	{
		if ( $this->ion_auth->logged_in() ) 
		{
			//$this->data['active_menu']=$this->Board_model->get_board_sections(0);
			//print_r($this->data['header_menu']);
			$this->load->view($this->data['current_theme'].'/game/game_about_view.php', $this->data);
		}
	}

	public function help()
	{
		if ( $this->ion_auth->logged_in() ) 
		{
			//$this->data['active_menu']=$this->Board_model->get_board_sections(0);
			//print_r($this->data['header_menu']);
			$this->load->view($this->data['current_theme'].'/game/game_help_view.php', $this->data);
		}
	}	

	public function reminder()
	{
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->data['reminder_list']=$this->Game_model->get_reminders($this->user_bm_id, $this->data['rsm_base_url']);
			//print_r($this->data['header_menu']);
			$this->load->view($this->data['current_theme'].'/game/game_reminder_view.php', $this->data);
		}
	}
	
}
?>