<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {


	public function index()
	{
		$this->load->helper('form');
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->database();

		if ( ! $this->ion_auth->logged_in() ) 
			{
				//redirect('/auth/', 'refresh');
				echo "ZZZ";
			}
	}
}
?>