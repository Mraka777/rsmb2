<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ru1 extends CI_Controller {


	public function index()
	{
		$this->load->model('General_model');
		$this->load->database();
		$this->load->helper('form');
		$this->load->helper('language');
		$data['general']=$this->General_model->get_general('ru');
		$data['updates']=$this->General_model->get_updates('ru');
		$data['todo']=$this->General_model->get_todo('ru');
		$this->load->view('templates/startup/header_main', $data);
		$this->load->view('templates/startup/button_ru');
		$this->load->view('templates/startup/footer_main', $data);
	}
}
