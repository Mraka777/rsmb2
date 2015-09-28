<?php
class Board extends RSM_Controller {

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
			$this->load->model('Board_model');
			$user = $this->ion_auth->user()->row();
			$rsm_user = $this->Next_model->get_rsm_team_id($user);
			$this->user_bm_id=$rsm_user;
			//END GET TEAM ID BY AUTH ID
			

			$menu1 = $this->uri->segment(2);
			$menu2 = $this->uri->segment(3);
			
			$this->data = $this->Next_model->get_general_data($rsm_user, $menu1, $menu2, $this->rsm_base_url);
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
			$this->data['board_sections']=$this->Board_model->get_board_sections(0);
			$this->load->view($this->data['current_theme'].'/board/board_sections_view.php', $this->data);
		}
	}

	public function section($section_id)
	{
		$this->load->helper('form');
		if ( $this->ion_auth->logged_in() ) 
		{
			if ($this->input->post()) {
				$data_update=$this->input->post();//Get training update in POST
				//print_r($data_update);
				$this->Board_model->change_favorite($data_update['topic'], $this->user_bm_id);
			}
			$this->data['board_topics']=$this->Board_model->get_board_topics($section_id, $this->user_bm_id);
			$this->load->view($this->data['current_theme'].'/board/board_topics_view.php', $this->data);
		}
	}
	public function topic($topic_id)
	{
		$this->load->helper('form');
		
		if ( $this->ion_auth->logged_in() ) 
		{
			if ($this->input->post()) {
				$data_update=$this->input->post();//Get training update in POST
				//print_r($data_update);
				$date_time = date('Y-m-d h:i:s', time());
				$this->Board_model->insert_message($data_update['topic'], $data_update['message'], $this->user_bm_id, $date_time);  //($topic_id, $message, $user_id, $date_time) 
				//redirect($path, 'refresh');
			}
			$this->data['topic_messages']=$this->Board_model->get_board_topic_messages($topic_id);
			$this->Next_model->reminder_check_favorites($topic_id, $this->user_bm_id);
			$this->load->view($this->data['current_theme'].'/board/board_messages_view.php', $this->data);
		}
	}

	public function favorite($topic_id)
	{
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->Board_model->change_favorite($topic_id, $this->user_bm_id);
			//$this->data['board_topics']=$this->Board_model->get_board_topics($section_id, $this->user_bm_id);
			//$this->load->view($this->data['current_theme'].'/board/board_topics_view.php', $this->data);
			redirect($this->data['rsm_base_url']."/board/", 'refresh');
		}
	}

	
}
?>