<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function index()
	{
		$this->load->helper('url');
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
					$ip = $_SERVER['REMOTE_ADDR'];
			}
			//echo($ip." - ");
			
			$ip_link = "http://api.wipmania.com/";
			$ip_link .= $ip;
			
			$country = file_get_contents($ip_link);
			//echo($country);
			if ($country=='RU') {
			 redirect('/ru1/', 'refresh');
			 //echo($country);
			}
			else
			{
				redirect('/en1/', 'refresh');
				//echo('132');
			}
		//$this->load->view('templates/header_main');
	}
}
