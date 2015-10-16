<?php
class Next extends RSM_Controller {
	
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}
	

	public function logout(){
				$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->database();
		$this->ion_auth->logout();
		redirect('/auth/', 'refresh'); //Reload
	}
	
	
	public function index()
	{
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->database();
		
		if ( $this->ion_auth->logged_in() ) 
	{
		
		//GET TEAM ID BY AUTH ID
		$this->load->model('Next_model');
		$user = $this->ion_auth->user()->row();
		//print($user);
		$rsm_user = $this->Next_model->get_rsm_team_id($user);
		$user_bm_id=$rsm_user	;
		//END GET TEAM ID BY AUTH ID
		//echo($user_bm_id);

		$this->load->model('Player_model');
		
	
		$header_data['team']=$rsm_user;
		$this->load->view('templates/header', $header_data);
		$this->load->view('templates/left');

		if ($user_bm_id <= 11){
			$data['training_num']=$this->Next_model->get_trainings_num();
			$data['training_num']=(array)$data['training_num'][0];
			$data['training_num']=$data['training_num']['COUNT(*)'];//получили кол-во записей тренировок
			//$data['training_result']=$this->Next_model->increase_training($data['training_num']);//вызвали ф-ию увеличения параметров  *** ВКЛЮЧИТЬ
				
			$this->load->view('next', $data);
			
			//email test
			//$this->load->library('email');

			//$this->email->from('robot@biathlon-manager.com', 'Your Name');
			//$this->email->to('game@biathlon-manager.com'); 
			
			//$this->email->subject('Тест Email');
			//$this->email->message('Тестирование класса отправки сообщений');	
			
			//$this->email->send();
			
			//echo $this->email->print_debugger();
			
			  //$this->grocery_crud->set_table('rsm_menu');
				//$this->grocery_crud->columns('level1','num','glyph','visible');
		 
				//$output = $this->grocery_crud->render();
		 
				//$this->_example_output($output);
			
		}
		else {}

		$this->load->view('templates/body_end');

	}
	}	

	//CRUD FOR MENU
	
	function crud()
	{
		$this->load->library('grocery_CRUD');
    $crud = new grocery_CRUD();
 
    $crud->set_table('rsm_menu_top');
		$crud->display_as('rsm_menu_id','Left menu');
		$crud->set_relation('rsm_menu_id','rsm_menu','level1');
    $output = $crud->render();
 
    $this->_example_output($output);  
	}

    function _example_output($output = null)
 
    {
        $this->load->view('crud.php',$output);    
    }   

	
	//END OF CRUD FOR MENU
	
	public function increase_day()
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
		$user_bm_id=$rsm_user	;
		//END GET TEAM ID BY AUTH ID
		
		
			$header_data['team']=$user_bm_id;
			$this->load->view('templates/header', $header_data);
		$this->load->view('templates/left');

		
		$data['day']=$this->Next_model->get_current_day();
		
		$day=(array)$data['day'];
		$day=(array)$day[0];
		$data['current_day']=$day['day_id'];
		
		$next_day=$data['current_day']+1;
		
		$this->Next_model->increase_current_day($next_day); 
		$data['training_num']='';		
		$this->Next_model->update_building_days(); //Update building days
		$this->Next_model->update_stadium_days(); //Update stadium days
		$this->load->view('next', $data);		

		$this->load->view('templates/body_end');
		redirect('/next/', 'refresh'); //Reload
		

	}
	}
	
		public function increase_training_day()
	{
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->database();
		
		//if ( $this->ion_auth->logged_in() ) 
	//{
		
		//GET TEAM ID BY AUTH ID
		$this->load->model('Next_model');
		$this->load->model('Office_model');
		$this->load->model('Team_model');
		$user = $this->ion_auth->user()->row();
		//$rsm_user = $this->Next_model->get_rsm_team_id($user);
		$rsm_user = 1;
		$user_bm_id=$rsm_user;
		//END GET TEAM ID BY AUTH ID
		
			$header_data['team']=$user_bm_id;
			$this->load->view('templates/header', $header_data);
		$this->load->view('templates/left');

		
		$data['day']=$this->Next_model->get_current_day();
		
		$day=(array)$data['day'];
		$day=(array)$day[0];
		$data['current_day']=$day['day_id'];
		
		$next_day=$data['current_day']+1;
		//echo($next_day);
		
		$check_season_end = $next_day % 35;
		$check_league_end = $next_day % 22; // расчет плей-офф после 22 дня

		//print("LE=".$check_league_end."<br>");
		if ($check_league_end==1) {
			echo("Season end ".$next_day);
			$this->Next_model->generate_top_playoff();
			$this->Next_model->generate_team_relegation();
			$this->Next_model->generate_team_jump_playoff();
			$this->Next_model->generate_playoff_race_details();
		}
		else {
			
		}
//1.txt

		if ($check_season_end==1) {
			$current_season=$this->Next_model->get_season_num(($next_day-1));
			//$this->Next_model->archive_league($current_season);
			$this->Next_model->change_season_teams();
		}
		else { //выделить в функцию
			$this->Next_model->increase_current_day($next_day); 
		
			$data['training_result']=$this->Next_model->increase_training();//вызвали ф-ию увеличения параметров + энергия 
			$this->Next_model->update_building_days(); //Update building days
			$this->Next_model->update_stadium_days(); //Update stadium days
			$this->Next_model->update_sportsman_age(); //Update sportsman age
			$this->Next_model->update_scouting(); //Update scouting
			$data_cost['stadium']=$this->Next_model->get_stadium_cost(); //stadium cost
			$data_cost['infra']=$this->Next_model->get_infra_cost();//infra cost
			$data_cost['sportsman_salary']=$this->Next_model->get_sportsman_salary(); //player salary
			$data_cost['staff_salary']=$this->Next_model->get_staff_salary(); //staff salary
			$data_cost['sponsor1']=$this->Next_model->get_sponsors_money(); //sponsors
			$this->Next_model->update_injury(); //Update injury
			$this->Next_model->do_daily_payments(); //daily payments
			$this->Next_model->do_academy(); //daily academy
   	}

//end of 1.txt
		$this->load->view('templates/body_end');
		redirect('/next/', 'refresh'); //Reload 

	//}
	}


	public function update_building_days()
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
			$user_bm_id=$rsm_user	;
			//END GET TEAM ID BY AUTH ID
			$this->load->view('templates/header', $header_data);
			$this->load->view('templates/left');
			
			$this->Next_model->update_building_days();
			$data['null']='';
			$this->load->view('next', $data);
			
			$this->load->view('templates/body_end');
		}
	}

	public function update_stadium_days()
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
			$user_bm_id=$rsm_user	;
			//END GET TEAM ID BY AUTH ID
			$this->load->view('templates/header', $header_data);
			$this->load->view('templates/left');
			
			$this->Next_model->update_stadium_days();
			$data['null']='';
			$this->load->view('next', $data);
			
			$this->load->view('templates/body_end');
		}
	}
	
	
	public function generate_season()
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
		$user_bm_id=$rsm_user	;
		//END GET TEAM ID BY AUTH ID
			$header_data['team']=$user_bm_id;
			$this->load->view('templates/header', $header_data);
		$this->load->view('templates/left');
		
		$this->Next_model->delete_season();
		$countries_new_season  = array(
				"0" => "1",
				"1" => "3",
		);
		$this->Next_model->generate_season(2);
		$data['null']='';
		$this->load->view('next', $data);
		
		$this->load->view('templates/body_end');
		redirect('/next/', 'refresh'); //Reload 
		}
	}
	
	function edit_infr()
	{
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->database();
		
		if ( $this->ion_auth->logged_in() ) 
		{
			//$this->load->library('grocery_CRUD');
			$crud = new grocery_CRUD();
	 
			$crud->set_table('rsm_infrastructure_building_level');
			//$crud->display_as('rsm_menu_id','Left menu');
			//$crud->set_relation('rsm_menu_id','rsm_menu','level1');
			$output = $crud->render();
	 
			$this->_example_output($output);  
		}
	}
	
	function edit_help()
	{
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->database();
		
		if ( $this->ion_auth->logged_in() ) 
		{
			//$this->load->library('grocery_CRUD');
			$crud = new grocery_CRUD();
	 
			$crud->set_table('rsm_page_help');
			//$crud->display_as('rsm_menu_id','Left menu');
			//$crud->set_relation('rsm_menu_id','rsm_menu','level1');
			$output = $crud->render();
	 
			$this->_example_output($output);  
		}
	}
	function show_help()
	{
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->database();
		$this->load->model('Next_model');
		if ( $this->ion_auth->logged_in() ) 
		{
			$data['help']=$this->Next_model->show_help();
			$this->load->view('templates/help', $data);
		}
	}
	
	
}
?>