<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class En1 extends CI_Controller {


	public function index()
	{
		$this->load->model('General_model');
		$this->load->database();
		$this->load->helper('form');
		$this->load->helper('language');
		$data['general']=$this->General_model->get_general('eng');
		$data['updates']=$this->General_model->get_updates('eng');
		$data['todo']=$this->General_model->get_todo('eng');
		$this->load->view('templates/startup/header_main', $data);
		$this->load->view('templates/startup/button_en');
		$this->load->view('templates/startup/footer_main', $data);
	}
}
