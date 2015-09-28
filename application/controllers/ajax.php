<?php
// main ajax back end
class Ajax extends CI_Controller {
  // just returns time
  public function get_league($country_id, $league_lvl)
  {
  	//echo ('12');
    $this->load->database();
    $this->load->model('Ajax_model');
    $data=$this->Ajax_model->get_league_num($country_id, $league_lvl);
    print($data);
  } 
}
?>