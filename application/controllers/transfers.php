<?php
class Transfers extends RSM_Controller {

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
			
			$this->load->model('Transfers_model');
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
			redirect($this->data['rsm_base_url'].'/transfers/players/', 'refresh');
		}
	}

	public function players()
	{
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->data['player_transfer_list'] = $this->Transfers_model->get_player_transfer_list();
			$this->load->view($this->data['current_theme'].'/transfers/transfers_index_view.php', $this->data);
		}
	}
	
	
}
?>