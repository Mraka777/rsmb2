<?php
class Player extends RSM_Controller {


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
			$this->load->model('Player_model');
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
		if ( $this->ion_auth->logged_in() ) 
			{
			}
	}	
  public function view($sportsman_id)
	{
    if ( $this->ion_auth->logged_in() )
		{
			$this->data['player']=$this->Player_model->get_sportsman_info($sportsman_id, $this->user_bm_id);
			$this->data['history']=$this->Player_model->get_sportman_history($sportsman_id);
			//player traingin
			$this->data['source_param']=$this->Player_model->get_sportsman_info($sportsman_id, $this->user_bm_id);
			$this->data['training_log']=$this->Player_model->get_sportsman_training_log($sportsman_id, $this->user_bm_id);
			//print_r($this->data);
			$this->load->view($this->data['current_theme'].'/player/player_main_view.php', $this->data);

		}
	}

  public function scout($sportsman_id)
	{
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->helper('form');
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
				
				//$this->load->view('templates/player_start', '');
				
				$this->load->model('Player_model');
				$manager_id = $user_bm_id;
				$data['player']=$this->Player_model->get_sportsman_info($sportsman_id, $manager_id);
				$this->Player_model->add_to_scouting_list($sportsman_id, $manager_id);
				//print_r($data);
				$link = '/player/view/' ;
				$link .= $sportsman_id;
				redirect($link, 'refresh');
				
				$this->load->view('templates/body_end');
		}
	}	
	
  public function training() //получает список тренировок всей команды
	{
		//$this->output->enable_profiler(TRUE);
		$this->load->library('ion_auth');
		$this->load->library('session');
		
		$this->load->helper('form');
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
				$user_team_id=$user_bm_id;
				

				$this->load->view('templates/header', $header_data);
				$this->load->view('templates/left');
								
				$this->load->model('Player_model');
				$data['team_practice']=$this->Player_model->get_sportsman_training($user_team_id);
				
				//print_r($data);
				if ($this->input->post()) {
					$data_update=$this->input->post();//Get training update in POST
					//print_r($data_update);
					$this->Player_model->update_sportsman_training($data_update);
					redirect('/player/training/', 'refresh');
				}
				$this->load->view('templates/sportsman/training_view', $data);
				
				$this->load->view('templates/body_end');
		}
	}
	
  public function training_details($sportsman_id) //получает список тренировок всей команды
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
				$user_team_id=$user_bm_id;
				$this->load->view('templates/header', $header_data);
				$this->load->view('templates/left');
								
				$this->load->model('Player_model');
				$data['source_param']=$this->Player_model->get_sportsman_info($sportsman_id, $this->user_bm_id); //team_id 4 own team
				
				$data['training_log']=$this->Player_model->get_sportsman_training_log($sportsman_id, $this->user_bm_id); //team_id 4 own team
				//print_r($data);
				//echo $this->input->post('name');
				
				//$data['menu']=$this->Next_model->rsm_menu($this->uri->segment(1), $this->uri->segment(3), $this->uri->segment(2));
				
				$this->load->view('templates/sportsman/training_detailed', $data);
				
				$this->load->view('templates/body_end');
		}
	}	
  public function history($sportsman_id)
	{
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
				
				//$this->load->view('templates/player_start', '');
				
				$this->load->model('Player_model');
				$manager_id = $user_bm_id;
				$data['history']=$this->Player_model->get_sportman_history($sportsman_id);
				$data['menu']=$this->Next_model->rsm_menu($this->uri->segment(1), $this->uri->segment(3), $this->uri->segment(2));
				$this->load->view('templates/sportsman/sportsman_history', $data);
				
				$this->load->view('templates/body_end');
		}
	}

}
?>