<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_permalink'))
{
	function get_permalink($data)
	{
		//print_r($data);
		switch ($data['object']) {
			case 'player':
				print("/".$data['lng']."/player/view/".$data['id']);
				break;
			case 'team':
				print("/".$data['lng']."/team/view/".$data['id']);
				break;
			case 'build_stadium':
				print("/".$data['lng']."/infrastructure/build_stadium/".$data['id']);
				break;			
			default:
				print("");
				break;
		}
	}
}