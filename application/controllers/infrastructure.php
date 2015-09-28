<?php
class Infrastructure extends RSM_Controller {

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
			$user = $this->ion_auth->user()->row();
			$rsm_user = $this->Next_model->get_rsm_team_id($user);
			$this->user_bm_id=$rsm_user;
			//END GET TEAM ID BY AUTH ID
			
			$this->load->model('Infrastructure_model');
			//$this->load->model('Office_model');
			$menu1 = $this->uri->segment(2);
			$menu2 = $this->uri->segment(3);
			$this->data = $this->Next_model->get_general_data($rsm_user, $menu1, $menu2, $this->rsm['base_url']);
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
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->load->view($this->data['current_theme'].'/infrastructure/infrastructure_index_view.php', $this->data);
		}
	}	

	
	public function facilities()
	{		
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->data['infrastructure']=$this->Infrastructure_model->get_infrastructure_info($this->user_bm_id);
			$this->load->view($this->data['current_theme'].'/infrastructure/infrastructure_facilities_view.php', $this->data);
		}
	}
	
	public function facility_info($facility_level_id)
	{		
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->data['facility_detailed']=$this->Infrastructure_model->get_infrastructure_detailed($facility_level_id);
			$this->load->view($this->data['current_theme'].'/infrastructure/infrastructure_facilities_detailed_view.php', $this->data);
		}
	}
	
	public function build_facility($facility_id)
	{
		$this->load->helper('form');
			
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->load->model('Office_model');
			
			if ($this->input->post()) {
				$data_update=$this->input->post();//Get training update in POST
				//print_r($data_update);
				$data_update['team_id']=$this->user_bm_id;
		  	$this->Next_model->change_balance($this->user_bm_id, 12, $data_update['cost']);//$team_id, $op_type, $delta
				$this->Infrastructure_model->build_facility($data_update);
			  redirect($this->data['rsm_base_url'].'/infrastructure/facilities/', 'refresh');
				}
			else {
				$this->data['balance']=$this->Office_model->get_current_balance($this->user_bm_id);
				$this->data['infrastructure']=$this->Infrastructure_model->build_facility_choice($this->user_bm_id, $facility_id);
				$this->load->view($this->data['current_theme'].'/infrastructure/infrastructure_facilities_build_view.php', $this->data);
			}
		}
	}
	
	public function build_stadium($stadium_id)
	{
		$this->load->helper('form');
			
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->load->model('Office_model');
			
			if ($this->input->post()) {
				$data_update=$this->input->post();//Get training update in POST
				$data_update['team_id']=$this->user_bm_id;

				$this->Next_model->change_balance($this->user_bm_id, 12, $data_update['cost']);//$team_id, $op_type, $delta
				$this->Infrastructure_model->build_stadium($data_update);
				redirect($this->data['rsm_base_url'].'/infrastructure/stadium/', 'refresh');
				}
			else {
				$this->data['balance']=$this->Office_model->get_current_balance($this->user_bm_id);
				$this->data['stadium']=$this->Infrastructure_model->build_stadium_choice($this->user_bm_id, $stadium_id);
				$this->load->view($this->data['current_theme'].'/infrastructure/infrastructure_stadium_build_view.php', $this->data);
			}
		}
	}
	
	
	public function stadium()
	{
		if ( $this->ion_auth->logged_in() ) 
			{
				$this->data['stadium']=$this->Infrastructure_model->get_stadium_info($this->user_bm_id);
				$this->load->view($this->data['current_theme'].'/infrastructure/infrastructure_stadium_view.php', $this->data);
			}
	}	
}
?>