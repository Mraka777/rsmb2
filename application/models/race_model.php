<?php
class Race_model extends CI_Model {

        function __construct()
        {
            parent::__construct();
        }
    
		function get_race_status ($race_id) { //if result=0 race is not simulated
			$sql = 'SELECT * FROM rsm_logr WHERE race_id='.$race_id;
			$query = $this->db->query($sql);
			return $query->num_rows();
		
		
		}
		

		
		function get_race_result_shooting ($race_id) {
			//echo $last_mark_row['mark'];
			$sql = 'SELECT * FROM `rsm_race_sportsman_list` WHERE `race_id` = '.$race_id.' AND race_place > 0 ORDER BY `race_place` ASC'; 
			$query = $this->db->query($sql);
			return $query->result_array();
		}
    
		function get_race_sportsman_list ($race_id) {
		$sql = 'SELECT * FROM `rsm_race_sportsman_list` 
LEFT OUTER JOIN rsm_sportsman ON rsm_race_sportsman_list.sportsman_id = rsm_sportsman.sportsman_id 
LEFT OUTER JOIN rsm_team ON rsm_sportsman.team_id = rsm_team.team_id
LEFT OUTER JOIN rsm_country ON rsm_sportsman.country_id = rsm_country.country_id
WHERE race_id='.$race_id.' ORDER BY rsm_race_sportsman_list.team_id';
    $query = $this->db->query($sql);
    return $query->result_array();
		}
		
		function get_next_race_id ($day_id, $user_id) {
			$sql = "SELECT race_id FROM `rsm_race`
							LEFT OUTER JOIN rsm_team ON rsm_race.league_id = rsm_team.league_id
							LEFT OUTER JOIN rsm_league ON rsm_race.league_id = rsm_league.league_id
							WHERE rsm_team.user_id = ".$user_id." AND `race_status` = 0 LIMIT 0,1";
			//print($sql);
			$query = $this->db->query($sql);
			$query = $query->result_array();
			$query = $query[0]['race_id'];
			//print($query);
			return $query;
		}
		
		function get_race_sportsman_result_list ($race_id) {
		$sql = 'SELECT * FROM `rsm_race_sportsman_list` 
LEFT OUTER JOIN rsm_sportsman ON rsm_race_sportsman_list.sportsman_id = rsm_sportsman.sportsman_id 
LEFT OUTER JOIN rsm_team ON rsm_sportsman.team_id = rsm_team.team_id
LEFT OUTER JOIN rsm_country ON rsm_sportsman.country_id = rsm_country.country_id
WHERE race_id='.$race_id.' ORDER BY rsm_race_sportsman_list.race_place ASC';
    $query = $this->db->query($sql);
		$query=$query->result_array();
		
		$count = count($query);
		//print($count);
		for ($i = 0; $i < $count; $i++) {
			//print($query[$i]['overall_time']."<br>");
			if ($i>0) {
				//$query[$i]['behind'] = "+ ";
				$query[$i]['behind'] = $query[$i]['overall_time']-$query[0]['overall_time'];
			}
			else {
				$query[$i]['behind'] = '0';
			}
		}
		
		
    return $query;
		}

		function get_race_result ($race_id) {
			$sql='SELECT DISTINCT mark FROM rsm_logr WHERE race_id = '.$race_id.' ORDER BY logr_id';
			//echo($sql);
			$query = $this->db->query($sql);
			$last_mark_row = $query->last_row('array'); //get last row -> last mark
			//echo $last_mark_row['mark'];
			$sql = 'SELECT * FROM `rsm_logr`
			LEFT OUTER JOIN rsm_sportsman ON rsm_logr.sportsman_id = rsm_sportsman.sportsman_id
			LEFT OUTER JOIN rsm_team ON rsm_sportsman.team_id = rsm_team.team_id
			LEFT OUTER JOIN rsm_country ON rsm_sportsman.country_id = rsm_country.country_id
			WHERE `race_id` = '.$race_id.' AND `mark` = '.$last_mark_row['mark'].' ORDER BY `time` ASC'; //first logr_id -> first place
			//echo($sql);
			$query = $this->db->query($sql);
			//print("<pre>");
			//print_r($query->result_array());
			//print("</pre>");
			return $query->result_array();
		}		
		

		function get_last_race_id ($day_id, $user_id) {
			
			
			$sql = "SELECT MAX(race_id) FROM `rsm_race`
							LEFT OUTER JOIN rsm_team ON rsm_race.league_id = rsm_team.league_id
							LEFT OUTER JOIN rsm_league ON rsm_race.league_id = rsm_league.league_id
							WHERE rsm_team.user_id = ".$user_id." AND `race_status` = 1 LIMIT 0,1";
			//print($sql);
			$query = $this->db->query($sql);
			$query = $query->result_array();
			$query = $query[0]['MAX(race_id)'];
			//print($query);
			return $query;
		}
		
		function get_race_data ($race_id){
			$sql = "SELECT rsm_race.track_id, rsm_race.race_attendance, rsm_season.real_date, rsm_season.day_num FROM `rsm_race`
			LEFT OUTER JOIN rsm_season ON rsm_race.day_id = rsm_season.day_id
			WHERE `race_id` = ".$race_id." ";
			$query = $this->db->query($sql);
			$query = $query->result_array();
			$track_id = $query[0]['track_id'];
			$data['race_attendance'] = $query[0]['race_attendance'];
			$data['race_real_date'] = $query[0]['real_date'];
			$data['race_num_day'] = $query[0]['day_num'];
			
			$sql = "SELECT rsm_track.track_capacity, rsm_track.name_en, rsm_track.track_type, rsm_team.team_name, rsm_team.team_id, rsm_country.logo, rsm_country.nameb_en, rsm_league.league_lvl, rsm_league.league_num FROM `rsm_track`
			LEFT OUTER JOIN rsm_team ON rsm_track.user_id = rsm_team.team_id
			LEFT OUTER JOIN rsm_country ON rsm_team.country_id = rsm_country.country_id
			LEFT OUTER JOIN rsm_league ON rsm_team.league_id = rsm_league.league_id
			WHERE `track_id` =  ".$track_id." ";
			$query = $this->db->query($sql);
			$query = $query->result_array();
			//print_r($query);
			$track_capacity = $query[0]['track_capacity'];
			
			$data['track_capacity'] = $track_capacity;
			$data['track_name'] = $query[0]['name_en'];
			$track_type = $query[0]['track_type'];
			
			switch ($track_type) {
					case 1:
							$data['track_type'] = 'Plain';
							$data['track_plain']=60;
							$data['track_rise']=20;
							$data['track_descent']=20;
							break;

					default:
							$data['track_type'] = 'Unknown';
							$data['track_plain']=0;
							$data['track_rise']=0;
							$data['track_descent']=0;
							break;
			}
			
			$data['track_team_name'] = $query[0]['team_name'];
			$data['track_team_id'] = $query[0]['team_id'];
			$data['logo'] = $query[0]['logo'];
			$data['nameb_en'] = $query[0]['nameb_en'];
			
			$data['league_lvl'] = $query[0]['league_lvl'];
			$data['league_num'] = $query[0]['league_num'];
			//print_r($data);
			return $data;
		}
		
		function get_next_race_info ($day_id, $user_id) { //получение следующей гонки по текущему дню недели //можно переделать в цикл

		$sql = "SELECT rsm_race.race_id, rsm_race.race_status, rsm_track.track_id, rsm_track.user_id, rsm_track.name_en, rsm_track.track_logo, rsm_track.track_type, rsm_track.track_tech, rsm_track_type.*, rsm_race_weather_forecast.*, rsm_season.season_id, rsm_season.day_num, rsm_season.real_date, rsm_league.league_lvl, rsm_league.league_num, rsm_league.country_id FROM rsm_race 
LEFT OUTER JOIN rsm_track ON rsm_race.track_id = rsm_track.track_id 
LEFT OUTER JOIN rsm_team ON rsm_race.league_id = rsm_team.league_id 
LEFT OUTER JOIN rsm_track_type ON rsm_track.track_type = rsm_track_type.rsm_track_type_id 
LEFT OUTER JOIN rsm_race_weather_forecast ON rsm_race.race_id = rsm_race_weather_forecast.rsm_race_id
LEFT OUTER JOIN rsm_season ON rsm_race.day_id = rsm_season.day_id
LEFT OUTER JOIN rsm_league ON rsm_race.league_id = rsm_league.league_id
WHERE rsm_race.day_id=".$day_id." AND rsm_team.user_id = ".$user_id." AND rsm_race.race_status = 0 LIMIT 0,1";


    //print($sql."<br>");
		$query = $this->db->query($sql);
		//echo $query->num_rows();
		//$race_exist = $query->num_rows();
		//print("NR=".$query->num_rows()."<br>");
		
		//print("<br><br>");
		if (($query->num_rows()) == '1'){
			//print_r($query->result_array());
			$query = $query->result_array();
			//$query = $query->result_array();
			
			$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena` WHERE `rsm_race_weather_phenomena_type` = 1 AND `rsm_race_weather_phenomena_subtype` = ".$query[0]['wind_type']." ";
			//print($sql);
			$q2 = $this->db->query($sql);
			$q2 = $q2->result_array();
			$q2 = $q2[0];
			$query[0]['wind_type_descr']=$q2['descr'];
			$query[0]['wind_type_img']=$q2['img'];
			
			$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena`  WHERE `rsm_race_weather_phenomena_type` = 2 AND `rsm_race_weather_phenomena_subtype` = ".$query[0]['fog_type']." ";
			$q2 = $this->db->query($sql);
			$q2 = $q2->result_array();
			$q2 = $q2[0];
			$query[0]['fog_type_descr']=$q2['descr'];
			$query[0]['fog_type_img']=$q2['img'];
			
			$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena`  WHERE `rsm_race_weather_phenomena_type` = 3 AND `rsm_race_weather_phenomena_subtype` = ".$query[0]['sun_type']." ";
			$q2 = $this->db->query($sql);
			$q2 = $q2->result_array();
			$q2 = $q2[0];
			$query[0]['sun_type_descr']=$q2['descr'];
			$query[0]['sun_type_img']=$q2['img'];
			
			$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena`  WHERE `rsm_race_weather_phenomena_type` = 4 AND `rsm_race_weather_phenomena_subtype` = ".$query[0]['rain_type']." ";
			$q2 = $this->db->query($sql);
			$q2 = $q2->result_array();
			$q2 = $q2[0];
			$query[0]['rain_type_descr']=$q2['descr'];
			$query[0]['rain_type_img']=$q2['img'];
	
			$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena`  WHERE `rsm_race_weather_phenomena_type` = 5 AND `rsm_race_weather_phenomena_subtype` = ".$query[0]['snow_type']." ";
			$q2 = $this->db->query($sql);
			$q2 = $q2->result_array();
			$q2 = $q2[0];
			$query[0]['snow_type_descr']=$q2['descr'];
			$query[0]['snow_type_img']=$q2['img'];
			//print_r($query);
			return $query;
			}
			else {
				$day_id = $day_id+1;
				//echo("NEW DAY=".$day_id."<br>");
				$data=$this->Race_model->get_next_race_info ($day_id, $user_id);
				//print_r($data);
				return $data;
			}
			
		}

		function get_last_race_info($user_id) {
			$sql = "SELECT MAX(race_id) FROM `rsm_race`
							LEFT OUTER JOIN rsm_team ON rsm_race.league_id = rsm_team.league_id
							LEFT OUTER JOIN rsm_league ON rsm_race.league_id = rsm_league.league_id
							WHERE rsm_team.user_id = ".$user_id." AND race_status = 1";
			$query = $this->db->query($sql);
			$query = $query->result_array();
			$query = $query[0]['MAX(race_id)'];
			$last_race_data = $this->Race_model->get_race_info($query);
			//print($query);
			return $last_race_data;
		}
		
		function get_prev_races_list($day_id, $user_id) { //Получение списка предыдущих гонок
			$sql = "SELECT * FROM `rsm_race`
							LEFT OUTER JOIN rsm_team ON rsm_race.league_id = rsm_team.league_id
							LEFT OUTER JOIN rsm_league ON rsm_race.league_id = rsm_league.league_id
							WHERE rsm_team.user_id = ".$user_id." AND `race_status` = 1 AND race_type = 0";
			$query = $this->db->query($sql);
			$query = $query->result_array();
			//print("<pre>");
			//print_r($query);
			//print("</pre>");
			$er_list = count($query);
			$er_list = $er_list -1;
			//print($er_list);
			for ($i=0; $i<($er_list);$i++) {
				//print("<pre>");
				//print_r($query[$i]);
				//print("</pre>");
				$race_list[$i]=$query[$i]['race_id'];
			}
			$sql = "SELECT * FROM `rsm_race_team_list`
			LEFT OUTER JOIN rsm_race ON rsm_race_team_list.race_id = rsm_race.race_id
			WHERE rsm_race_team_list.team_id = ".$user_id." AND rsm_race.race_type = 2 AND rsm_race.race_status = 1";
			//print($sql."<br><br>");
			$query2 = $this->db->query($sql);
			$query2 = $query2->result_array();
			$er_list = count($query2);
			for ($j=$i; $j<($er_list+$i);$j++) {
				$race_list[$j]=$query2[$j-$i]['race_id'];
			}
			
			//1 - TOP PLAYOFF
			$sql = "SELECT * FROM `rsm_race_team_list`
			LEFT OUTER JOIN rsm_race ON rsm_race_team_list.race_id = rsm_race.race_id
			WHERE rsm_race_team_list.team_id = ".$user_id." AND rsm_race.race_type = 1 AND rsm_race.race_status = 1";
			//print($sql."<br><br>");
			$query3 = $this->db->query($sql);
			$query3 = $query3->result_array();
			$er_list = count($query3);
			for ($k=$j; $k<($er_list+$j);$k++) {
				//print("K=".$k." J=".$j."<br>");
				$race_list[$k]=$query3[$k-$j]['race_id'];
			}
			//print_r($race_list);
			if (isset($race_list)) {
				return($race_list);
			}
		}

		function get_next_races_list($day_id, $user_id) { //Получение списка предыдущих гонок
			$sql = "SELECT * FROM `rsm_race`
							LEFT OUTER JOIN rsm_team ON rsm_race.league_id = rsm_team.league_id
							LEFT OUTER JOIN rsm_league ON rsm_race.league_id = rsm_league.league_id
							WHERE rsm_team.user_id = ".$user_id." AND `race_status` = 0 AND race_type = 0";//0 для того, чтобы выбрать только гонки лиги AND race_type = 0
			$query = $this->db->query($sql);
			$query = $query->result_array();
			//print("<pre>");
			//print_r($query);
			//print("</pre>");
			$er_list = count($query);
			//print($er_list);
			for ($i=0; $i<$er_list;$i++) {
				$race_list[$i]=$query[$i]['race_id'];
			}
			//print_r($race_list);
			//
			//if (!isset($race_lost)) {$race_list = array();}
			//get playoff races JUMP
			$sql = "SELECT * FROM `rsm_race_team_list`
			LEFT OUTER JOIN rsm_race ON rsm_race_team_list.race_id = rsm_race.race_id
			WHERE rsm_race_team_list.team_id = ".$user_id." AND rsm_race.race_type = 2 AND rsm_race.race_status = 0";
			//print($sq)
			$query2 = $this->db->query($sql);
			$query2 = $query2->result_array();
			$er_list = count($query2);
			for ($j=$i; $j<($er_list+$i);$j++) {
				$race_list[$j]=$query2[$j-$i]['race_id'];
			}
			
			//1 - TOP PLAYOFF
			$sql = "SELECT * FROM `rsm_race_team_list`
			LEFT OUTER JOIN rsm_race ON rsm_race_team_list.race_id = rsm_race.race_id
			WHERE rsm_race_team_list.team_id = ".$user_id." AND rsm_race.race_type = 1 AND rsm_race.race_status = 0";
			//print($sql."<br><br>");
			$query3 = $this->db->query($sql);
			$query3 = $query3->result_array();
			$er_list = count($query3);
			for ($k=$j; $k<($er_list+$j);$k++) {
				//print("K=".$k." J=".$j."<br>");
				$race_list[$k]=$query3[$k-$j]['race_id'];
			}
			
			//print_r($race_list);
			return($race_list);
		}

    function get_race_info ($race_id){
			//print($race_id);
		if (isset($race_id)){
    $sql = "SELECT * FROM rsm_race
						LEFT OUTER JOIN rsm_track ON rsm_race.track_id = rsm_track.track_id
						LEFT OUTER JOIN rsm_track_type ON rsm_track.track_type = rsm_track_type.rsm_track_type_id 
						LEFT OUTER JOIN rsm_race_weather_forecast ON rsm_race.race_id = rsm_race_weather_forecast.rsm_race_id
						LEFT OUTER JOIN rsm_season ON rsm_race.day_id = rsm_season.day_id
						LEFT OUTER JOIN rsm_league ON rsm_race.league_id = rsm_league.league_id
						LEFT OUTER JOIN rsm_country ON rsm_league.country_id = rsm_country.country_id
						WHERE race_id=".$race_id;
			
			$query = $this->db->query($sql);
			$query = $query->result_array();
						
			$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena` WHERE `rsm_race_weather_phenomena_type` = 1 AND `rsm_race_weather_phenomena_subtype` = ".$query[0]['wind_type']." ";
			//print($sql);
			$q2 = $this->db->query($sql);
			$q2 = $q2->result_array();
			$q2 = $q2[0];
			$query[0]['wind_type_descr']=$q2['descr'];
			$query[0]['wind_type_img']=$q2['img'];
			
			$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena`  WHERE `rsm_race_weather_phenomena_type` = 2 AND `rsm_race_weather_phenomena_subtype` = ".$query[0]['fog_type']." ";
			$q2 = $this->db->query($sql);
			$q2 = $q2->result_array();
			$q2 = $q2[0];
			$query[0]['fog_type_descr']=$q2['descr'];
			$query[0]['fog_type_img']=$q2['img'];
			
			$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena`  WHERE `rsm_race_weather_phenomena_type` = 3 AND `rsm_race_weather_phenomena_subtype` = ".$query[0]['sun_type']." ";
			$q2 = $this->db->query($sql);
			$q2 = $q2->result_array();
			$q2 = $q2[0];
			$query[0]['sun_type_descr']=$q2['descr'];
			$query[0]['sun_type_img']=$q2['img'];
			
			$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena`  WHERE `rsm_race_weather_phenomena_type` = 4 AND `rsm_race_weather_phenomena_subtype` = ".$query[0]['rain_type']." ";
			$q2 = $this->db->query($sql);
			$q2 = $q2->result_array();
			$q2 = $q2[0];
			$query[0]['rain_type_descr']=$q2['descr'];
			$query[0]['rain_type_img']=$q2['img'];
	
			$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena`  WHERE `rsm_race_weather_phenomena_type` = 5 AND `rsm_race_weather_phenomena_subtype` = ".$query[0]['snow_type']." ";
			$q2 = $this->db->query($sql);
			$q2 = $q2->result_array();
			$q2 = $q2[0];
			$query[0]['snow_type_descr']=$q2['descr'];
			$query[0]['snow_type_img']=$q2['img'];
			
			$i=0;
			foreach ($query as $race) {
				if ($race['race_type'] == '0') {
					$query[$i]['race_type_text'] = "League";
				}
				elseif ($race['race_type'] == '1') {
					$query[$i]['race_type_text'] = "TOP PO";
				}
				elseif ($race['race_type'] == '2') {
					$query[$i]['race_type_text'] = "DOWN PO";
				}
				//endif;
			}
    //print($sql);
		
		//print("<pre>");
		//print_r($query);
		//print("</pre>");
    return $query;
			}
    }
		
		function get_race_weather_foreacast ($race_id) { //получение информации о погоде
		$sql = "SELECT * FROM rsm_race_weather WHERE rsm_race_id=".$race_id." ";
    $query = $this->db->query($sql);
		return $query->result_array();
		}
		
		function get_race_weather ($race_id) { //получение информации о погоде
		$sql = "SELECT * FROM rsm_race_weather WHERE rsm_race_id=".$race_id." ";
    $query = $this->db->query($sql);
		return $query->result_array();
		}
		
		function get_race_weather_extended ($race_id) { //получение информации о погоде
		$sql = "SELECT * FROM rsm_race_weather WHERE rsm_race_id=".$race_id." ";
    $query = $this->db->query($sql);
		$query = $query->result_array();
		$data = $query[0];
		//print_r($data);
			$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena` WHERE `rsm_race_weather_phenomena_type` = 1 AND `rsm_race_weather_phenomena_subtype` = ".$data['wind_type']." ";
			//print($sql);
			$q2 = $this->db->query($sql);
			$q2 = $q2->result_array();
			$q2 = $q2[0];
			$data['wind_type_descr']=$q2['descr'];
			$data['wind_type_img']=$q2['img'];
			
			if ($data['fog_type'] > 0) {
				$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena`  WHERE `rsm_race_weather_phenomena_type` = 2 AND `rsm_race_weather_phenomena_subtype` = ".$data['fog_type']." ";
				$q2 = $this->db->query($sql);
				$q2 = $q2->result_array();
				$q2 = $q2[0];
				$data['fog_type_descr']=$q2['descr'];
				$data['fog_type_img']=$q2['img'];
				$data['phenomena_descr']=$q2['descr'];
				$data['phenomena_img']=$q2['img'];
				$data['sun_type_descr']='Clouds';
				//$data['sun_type_img']=$q2['img'];
			}
			
			if ($data['sun_type'] > 0) {
				$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena`  WHERE `rsm_race_weather_phenomena_type` = 3 AND `rsm_race_weather_phenomena_subtype` = ".$data['sun_type']." ";
				$q2 = $this->db->query($sql);
				$q2 = $q2->result_array();
				$q2 = $q2[0];
				$data['sun_type_descr']=$q2['descr'];
				$data['sun_type_img']=$q2['img'];
				$data['phenomena_descr']=$q2['descr'];
				$data['phenomena_img']=$q2['img'];
				
			}

			if ($data['rain_type'] > 0) {
				$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena`  WHERE `rsm_race_weather_phenomena_type` = 4 AND `rsm_race_weather_phenomena_subtype` = ".$data['rain_type']." ";
				$q2 = $this->db->query($sql);
				$q2 = $q2->result_array();
				$q2 = $q2[0];
				$data['rain_type_descr']=$q2['descr'];
				$data['rain_type_img']=$q2['img'];
				$data['phenomena_descr']=$q2['descr'];
				$data['phenomena_img']=$q2['img'];
				$data['sun_type_descr']='Clouds';
			}
			if ($data['snow_type'] > 0) {
				$sql = "SELECT img, descr FROM `rsm_race_weather_phenomena`  WHERE `rsm_race_weather_phenomena_type` = 5 AND `rsm_race_weather_phenomena_subtype` = ".$data['snow_type']." ";
				$q2 = $this->db->query($sql);
				$q2 = $q2->result_array();
				$q2 = $q2[0];
				$data['snow_type_descr']=$q2['descr'];
				$data['snow_type_img']=$q2['img'];
				$data['phenomena_descr']=$q2['descr'];
				$data['phenomena_img']=$q2['img'];
				$data['sun_type_descr']='Clouds';
			}
		//print("<pre>");
		//print_r($data);
		//print("</pre>");
		return $data;
		
		}		
		
    
		function get_team_race_sportsman_list ($race_id, $team_id) {
			$sql = "SELECT rsm_sportsman.sportsman_id, rsm_sportsman.name1, rsm_sportsman.name2, rsm_sportsman.age, rsm_sportsman.phys_energy, rsm_sportsman.popularity, rsm_sportsman.overall_rating, rsm_race_sportsman_list.ski_time FROM `rsm_race_sportsman_list` 
LEFT OUTER JOIN rsm_sportsman ON rsm_race_sportsman_list.sportsman_id  = rsm_sportsman.sportsman_id
WHERE rsm_race_sportsman_list.team_id = ".$team_id." AND race_id = ".$race_id." ";
			$query = $this->db->query($sql);
			//echo($sql);
			//echo $query->num_rows();
			return $query->result_array();
		}
		
		function update_next_race_sportsman ($race_id, $data, $user_id) {
			//print_r($data);
			//print("<br>");
      if (($data[1] != $data[2]) AND ($data[1] != $data[3]) AND ($data[2] != $data[3])){
				$sql = "SELECT * FROM `rsm_race_sportsman_list` WHERE `race_id` = ".$race_id." AND `team_id` = ".$user_id." ";
				$query = $this->db->query($sql);
				$query = $query->result_array();
				//print("<pre>");
				//print_r($query);
				//print("</pre>");
				$i = 1;
				foreach ($query as $race_sportsman) {
					$sql="UPDATE rsm_race_sportsman_list SET sportsman_id = ".$data[$i]." WHERE rsm_race_sportsman_list_id = ".$race_sportsman['rsm_race_sportsman_list_id']." ";
					$this->db->query($sql);
					//print($sql."<br>");
					$i++;
				}
			}
			else {
				//echo("Error!");
			}
			//

		}

		function get_race_sportsman_tactics ($race_id, $team_id) { 
		$sql = "SELECT rsm_race_sportsman_tactics.*, rsm_race_sportsman_list.sportsman_id FROM `rsm_race_sportsman_list`
		LEFT OUTER JOIN rsm_race_sportsman_tactics ON rsm_race_sportsman_list.sportsman_id = rsm_race_sportsman_tactics.sportsman_id
		WHERE rsm_race_sportsman_list.race_id = ".$race_id." AND rsm_race_sportsman_list.team_id = ".$team_id." AND rsm_race_sportsman_tactics.race_id = ".$race_id." ";
		
		
    //print($sql."<br>");
		$query = $this->db->query($sql);
		$query = $query->result_array();
		foreach ($query as $check_tactics) {
			if ($check_tactics['rsm_race_sportsman_tactics_id'] == '') {
				//echo("ZZZ");
				//print_r($check_tactics);
				$sql_c ="INSERT INTO `rsm_race_sportsman_tactics` (`rsm_race_sportsman_tactics_id`, `race_id`, `sportsman_id`, `rsm_race_sportsman_tactics_importance`, `rsm_race_sportsman_tactics_ski_plain`, `rsm_race_sportsman_tactics_ski_hill`, `rsm_race_sportsman_tactics_shooting`) VALUES (NULL, '".$race_id."', '".$check_tactics['sportsman_id']."', '1', '4', '7', '10');";
				$this->db->query($sql_c);
			}
		}
		$sql = "SELECT rsm_race_sportsman_tactics.*, rsm_race_sportsman_list.sportsman_id FROM `rsm_race_sportsman_list` LEFT OUTER JOIN rsm_race_sportsman_tactics ON rsm_race_sportsman_list.sportsman_id = rsm_race_sportsman_tactics.sportsman_id WHERE rsm_race_sportsman_list.race_id = ".$race_id." AND rsm_race_sportsman_list.team_id = ".$team_id."  AND rsm_race_sportsman_tactics.race_id = ".$race_id."";
    $query = $this->db->query($sql);
		$query = $query->result_array();
		//print("<pre>");
		//print_r($query);
		//print("</pre>");
		$i=0;
		//КОСТЫЛЬ ПОТОМ ПОМЕНЯТЬ ЗАПРОС
		foreach ($query as $string) {
			$sql2 = "SELECT * FROM `rsm_race_sportsman_tactics_types` WHERE `rsm_race_sportsman_tactics_types_id` = ".$string['rsm_race_sportsman_tactics_importance']." ";
			$query2 = $this->db->query($sql2);
			$query2 = $query2->result_array();
			$query[$i]['rsm_race_sportsman_tactics_importance_descr']=$query2[0]['tactics_descr'];

			$sql2 = "SELECT * FROM `rsm_race_sportsman_tactics_types` WHERE `rsm_race_sportsman_tactics_types_id` = ".$string['rsm_race_sportsman_tactics_ski_plain']." ";
			$query2 = $this->db->query($sql2);
			$query2 = $query2->result_array();
			$query[$i]['rsm_race_sportsman_tactics_ski_plane_descr']=$query2[0]['tactics_descr'];

			$sql2 = "SELECT * FROM `rsm_race_sportsman_tactics_types` WHERE `rsm_race_sportsman_tactics_types_id` = ".$string['rsm_race_sportsman_tactics_ski_hill']." ";
			$query2 = $this->db->query($sql2);
			$query2 = $query2->result_array();
			$query[$i]['rsm_race_sportsman_tactics_ski_hill_descr']=$query2[0]['tactics_descr'];
			
			$sql2 = "SELECT * FROM `rsm_race_sportsman_tactics_types` WHERE `rsm_race_sportsman_tactics_types_id` = ".$string['rsm_race_sportsman_tactics_shooting']." ";
			$query2 = $this->db->query($sql2);
			$query2 = $query2->result_array();
			$query[$i]['rsm_race_sportsman_tactics_shooting_descr']=$query2[0]['tactics_descr'];

			$i++;
		}
		//print("<pre>");
		//print_r($query);
		//print("</pre>");
		return $query;
		}
		
		function get_race_tactics_types() {
			$sql = "SELECT * FROM `rsm_race_sportsman_tactics_types`";
			$query = $this->db->query($sql);
			$query = $query->result_array();
			
			return $query;

		}
		
		function get_race_sportsman_log ($race_id) { 
		$sql = "SELECT * FROM `rsm_logr` WHERE `race_id` = ".$race_id." ";
    $query = $this->db->query($sql);
		$query = $query->result_array();
		return $query;
		}
		
		
		function get_race_marks ($race_id) {
			$sql = "SELECT distinct(mark) FROM `rsm_logr` WHERE race_id = ".$race_id." ";
    $query = $this->db->query($sql);
		$query = $query->result_array();
		return $query;
		}
		
		function get_top8_team_pts($race_id) {
			$sql = "SELECT rsm_race_team_list.team_id, rsm_race_team_list.race_points, rsm_team.team_name, rsm_country.logo FROM rsm_race_team_list 
LEFT OUTER JOIN rsm_team ON rsm_race_team_list.team_id = rsm_team.team_id
LEFT OUTER JOIN rsm_country ON rsm_team.country_id = rsm_country.country_id
WHERE race_id =  ".$race_id." ORDER BY  `rsm_race_team_list`.`race_points` DESC  LIMIT 0,8";
    $query = $this->db->query($sql);
		$query = $query->result_array();
		//print_r($query);
		return ($query);
		}
		
		function get_next8_team_pts($race_id) {
			$sql = "SELECT rsm_race_team_list.team_id, rsm_race_team_list.race_points, rsm_team.team_name, rsm_country.logo FROM rsm_race_team_list 
LEFT OUTER JOIN rsm_team ON rsm_race_team_list.team_id = rsm_team.team_id
LEFT OUTER JOIN rsm_country ON rsm_team.country_id = rsm_country.country_id
WHERE race_id =  ".$race_id." ORDER BY  `rsm_race_team_list`.`race_points` DESC  LIMIT 8,8";
    $query = $this->db->query($sql);
		$query = $query->result_array();
		//print_r($query);
		return ($query);
		}
		
		function get_race_sniper($race_id) {
			$sql = "SELECT rsm_race_sportsman_list.sportsman_id, rsm_race_sportsman_list.race_shots_missed, rsm_sportsman.name1, rsm_sportsman.name2, rsm_country.logo, rsm_country.nameb_en
							FROM  `rsm_race_sportsman_list`
							LEFT OUTER JOIN rsm_sportsman ON rsm_race_sportsman_list.sportsman_id = rsm_sportsman.sportsman_id
							LEFT OUTER JOIN rsm_country ON rsm_sportsman.country_id = rsm_country.country_id
							WHERE  `race_id` = ".$race_id."
							ORDER BY  `rsm_race_sportsman_list`.`race_shots_missed` ASC 
							LIMIT 0 , 1";
    $query = $this->db->query($sql);
		$query = $query->result_array();
		$query=$query[0];
		//print_r($query);
		return ($query);
		}
		
		function get_race_best_ski($race_id) {
		$sql = "SELECT rsm_race_sportsman_list.sportsman_id, rsm_race_sportsman_list.ski_time, rsm_sportsman.*, rsm_country.logo, rsm_country.nameb_en FROM `rsm_race_sportsman_list`
		LEFT OUTER JOIN rsm_sportsman ON rsm_race_sportsman_list.sportsman_id = rsm_sportsman.sportsman_id
		LEFT OUTER JOIN rsm_country ON rsm_sportsman.country_id = rsm_country.country_id
		WHERE  `race_id` = ".$race_id." ORDER BY  `rsm_race_sportsman_list`.`ski_time` ASC LIMIT 0 , 1";
    $query = $this->db->query($sql);
		$query = $query->result_array();
		$query=$query[0];
		return ($query);
		}
		
}



?>