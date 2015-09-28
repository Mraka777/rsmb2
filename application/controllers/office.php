<?php
class Office extends RSM_Controller {

	//Class properties - common vars ($this->var_name)
	private $data;
	private $user_bm_id;
	private $header_data;
	//Class properties end
	
	//Constructor
	public function __construct()
  {
    parent::__construct();
		
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->database();
		if ($this->ion_auth->logged_in() ) {
			
		}
		else { //DEMO ACCOUNT ID = 336
			$this->ion_auth->login('demo@biathlon-manager.com', 'password', '');
		}
		
		if ( $this->ion_auth->logged_in() ) 
		{
			//GET TEAM ID BY AUTH ID
			$this->load->model('Next_model');
			$user = $this->ion_auth->user()->row();
			$rsm_user = $this->Next_model->get_rsm_team_id($user);
			$this->user_bm_id=$rsm_user;
			//print("this=".$this->user_bm_id." rsm_u=".$rsm_user);
			//END GET TEAM ID BY AUTH ID
			
			$this->load->model('Office_model');
			//$this->load->model('Office_model');
			//$language=$this->uri->segment(1);
			$menu1 = $this->uri->segment(2);
			$menu2 = $this->uri->segment(3);
			//print("M1=".$menu1." M2=".$menu2." L=".$language."<br>");
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
			//echo($this->ion_auth->logged_in());
			$this->load->helper('form');
		if ( $this->ion_auth->logged_in() ) 
		{
			if ($this->input->post()) {
				$data_update=$this->input->post();//Get training update in POST
				//print_r($data_update);
				$this->Office_model->team_first_rename($this->user_bm_id, $data_update);
				
				$this->data['club_info']=$this->Office_model->get_team_info($this->user_bm_id);
				$this->load->view($this->data['current_theme'].'/office/office_club_view.php', $this->data);
			}
			else {
				$is_team_renamed=$this->data['check_team_rename']=$this->Office_model->check_team_rename($this->user_bm_id);
				if ($is_team_renamed == '0') {
					//print('111');
					$this->data['data_team_renamed'] ='1';
				}
				$is_track_renamed=$this->data['check_track_rename']=$this->Office_model->check_track_rename($this->user_bm_id);
				if ($is_track_renamed == '0') {
					$this->data['data_track_renamed'] ='1';
				}
				$this->data['club_info']=$this->Office_model->get_team_info($this->user_bm_id);
				if (($is_team_renamed =='0') AND ($is_track_renamed == '0')) {
				$this->load->view($this->data['current_theme'].'/office/office_first_run_view.php', $this->data);
				}
				else {
					$this->load->view($this->data['current_theme'].'/office/office_club_view.php', $this->data);

				}
			}
		}
		}
	}
	
	public function calendar()
	{
		if ( $this->ion_auth->logged_in() ) 
		{
		$user_league_id = $this->Next_model->get_rsm_team_league_id($this->user_bm_id);
		$this->data['calendar']=$this->Office_model->show_calendar($this->uri->segment(3), $this->uri->segment(4), $user_league_id, $this->user_bm_id);
		$this->load->view($this->data['current_theme'].'/office/office_calendar_view.php', $this->data);
		}
	}
	public function club()
	{
		$this->load->helper('form');
		if ( $this->ion_auth->logged_in() ) 
		{

				$this->data['club_info']=$this->Office_model->get_team_info($this->user_bm_id);
				$this->load->view($this->data['current_theme'].'/office/office_club_view.php', $this->data);

		}
	}

	public function credit()
	{

		$this->load->helper('form');

		if ( $this->ion_auth->logged_in() ) 
		{
			$this->data['current_credit']=$this->Office_model->get_team_credit_info($this->user_bm_id);
	
			if ($this->input->post()) {//IF EXIST POST DATA (CREDIT INFO)
				$data_update=$this->input->post();
	
				if (isset($data_update['borrow'])) {
					$this->Office_model->accept_credit_offer($this->user_bm_id, $data_update['credit']);	
					$redirect_url = $this->data['rsm_base_url']."/office/credit/";
					redirect($redirect_url, 'refresh');
				}
			}
			else {
				if (!isset($this->data['current_credit'][0])) {//Show credit offers
					$this->data['club_credit']=$this->Office_model->get_team_credit_offer($this->user_bm_id);
					$this->load->view($this->data['current_theme'].'/office/office_credit_offers_view.php', $this->data);
				}
				
				else {//Show credit details
					$this->load->view($this->data['current_theme'].'/office/office_credit_details_view.php', $this->data);
				}

			}

		}
	}
	
	public function credit_repay(){
		$this->Office_model->credit_repay($this->user_bm_id);
		redirect($this->data['rsm_base_url'].'/office/staff/', 'refresh');
	}
	
	
	public function finance()
	{
		$this->load->model('General_model');
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->data['finance']=$this->Office_model->get_current_balance($this->user_bm_id);
			$this->data['finance_types']=$this->Office_model->get_finance_types();
			$current_day=$this->General_model->get_current_season_date();
			$this->data['today_transactions']=$this->Office_model->get_transaction($current_day['day_id'], $current_day['day_id'] ,$this->user_bm_id);
			$this->data['yesterday_transactions']=$this->Office_model->get_transaction(($current_day['day_id']-1),'',$this->user_bm_id);
			$this->data['week_transactions']=$this->Office_model->get_transaction(($current_day['day_id']),($current_day['day_id']-6),$this->user_bm_id);
			$this->data['season_transactions']=$this->Office_model->get_transaction(($current_day['day_id']),($current_day['day_id']-34),$this->user_bm_id);
			$this->load->view($this->data['current_theme'].'/office/office_finance_view.php', $this->data);
		}
	}
	
	public function news()
	{
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->data['news']=$this->Office_model->get_team_news($this->user_bm_id);
			$this->load->view($this->data['current_theme'].'/office/office_news_view.php', $this->data);
		}
	}

	public function sponsors()
	{
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->load->model('Team_model');
			$this->data['general_sponsor']=$this->Team_model->get_general_sponsor_info($this->user_bm_id);
			$this->data['media_sponsor']=$this->Team_model->get_media_sponsor_info($this->user_bm_id);
			$this->load->view($this->data['current_theme'].'/office/office_sponsors_view.php', $this->data);
		}
	}

public function staff()
	{
		$this->load->helper('form');
		
		if ( $this->ion_auth->logged_in() ) 
		{
			if ($this->input->post()) { //Get training update in POST
				$data_update=$this->input->post();
				$this->Office_model->update_staff_role($data_update);
				redirect($this->data['rsm_base_url'].'/office/staff/', 'refresh');
			}
			else { //main view
				$this->data['staff']=$this->Office_model->get_staff_info($this->user_bm_id);
				$this->load->view($this->data['current_theme'].'/office/office_staff_view.php', $this->data);
			}

		}
	}
	
	public function transactions()
	{
		if ( $this->ion_auth->logged_in() ) 
		{
			$this->data['transactions']=$this->Office_model->get_transaction_list($this->user_bm_id);
			$this->load->view($this->data['current_theme'].'/office/office_transactions_view.php', $this->data);
		}
	}
	
}
?>