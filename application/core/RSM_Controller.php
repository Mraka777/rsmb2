<?php
class RSM_Controller extends CI_Controller
{
 public $rsm;
 
 function __construct()
 {
  parent::__construct();
	$this->output->enable_profiler(FALSE);
	$this->load->helper('url');
	$this->rsm['current_theme'] = 'default.0.2'; // GET FROM BASE
	$this->rsm['base_url'] = $this->rsm_base_url = $this->uri->segment(1);
	//$c=count($this->rsm['base_url']);
	//echo(strlen($this->rsm['base_url']));
	if (strlen($this->rsm['base_url']) > 2) //redirect to the default en page
	{
		$this->rsm['base_url']="en";
		$new_url = $this->rsm['base_url'].'/'.$this->uri->segment(1).'/'.$this->uri->segment(2);
		redirect($new_url, 'refresh');
	}
	//print($this->rsm['base_url']);
	$this->rsm['language_link'] = $this->uri->segment(1);
	
	$this->rsm['th_path'] = $_SERVER['DOCUMENT_ROOT']."/themes/".$this->rsm['current_theme'];
  $this->rsm['bs_url'] = "http://".$_SERVER['SERVER_NAME']."/assets/bootstrap";
	$this->rsm['th_url']= "http://".$_SERVER['SERVER_NAME']."/themes/".$this->rsm['current_theme'];
	$this->rsm['img_url'] = "http://".$_SERVER['SERVER_NAME']."/themes/".$this->rsm['current_theme'];
 }
}
?>