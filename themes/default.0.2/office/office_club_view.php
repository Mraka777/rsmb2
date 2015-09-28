<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Club info</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">					

							<table class="table-striped table-bordered table-condensed ">
									<tr style="font-weight:bold;text-align:center;">
											<td colspan=2>Club data</td>
									</tr>	
							
									</tr>
							<?php
							//print_r($club_info);
							if (isset($data_team_renamed)) {
								if (($data_team_renamed == '1') and ($data_track_renamed == '1')) {
									//print()
								echo("<b>Welcome!</b><br>Please enter your Team and Stadium name:<br>");
								
									echo form_open("/office/club");
									//echo('<input type="hidden" name="topic" value="'.$message['rsm_board_topic_id'].'">');
									//echo("<textarea name=\"message\" cols=\"40\" rows=\"3\"></textarea></p>");
									echo("New team name:<br>");
									echo("<input name=\"team_name\" type=\"text\" value=\"".$club_info[0]['team_name']."\"><br><br>");
									echo("New track name:<br>");
									echo("<input name=\"track_name\" type=\"text\" value=\"".$club_info[0]['name_en']."\">");
									echo("<br><br>");
									echo('<input type="hidden" name="topic" value="123">');
									echo("<input type=\"submit\" value=\"Send\">");
									echo form_close();
									echo("<br><br>");
								}
							}
							
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
							//echo($xml);
							
							
							$i = 0;
							//print_r($club_info);
							foreach($club_info as $string)
							{?><tr><?php 
							
									$string=(array)$club_info[$i];
								
									print('<tr><td>Team ID</td><td>'.$string['team_id'].'</td></tr>');
									print('<tr><td>Team name</td><td>'.$string['team_name'].'</td></tr>');
									print('<tr><td>User ID</td><td>'.$string['user_id'].'</td></tr>');
									print('<tr><td>User name</td><td>'.$string['username'].'</td></tr>');
									print('<tr><td>User e-mail</td><td>'.$string['email'].'</td></tr>');
									//print('<tr><td>Last IP</td><td>'.$string['ip_address'].'</td></tr>');
									print('<tr><td>Current IP</td><td>'.$ip.'</td></tr>');
									print('<tr><td>Current country</td><td>'.$country.'</td></tr>');
									print('<tr><td>Club country</td><td>'.$string['namef_en'].'</td></tr>');
									print('<tr><td>Country logo</td><td><img src=/images/flag/'.$string['logo'].'></td></tr>');
									print('<tr><td>Club country</td><td>'.$string['namef_en'].'</td></tr>');
									print('<tr><td>Date registered</td><td>'.$string['date'].'</td></tr>');
									print('<tr><td>Manager level</td><td>'.$string['level'].'</td></tr>');
									$i++;
									?></tr><?php 
							}
							
							?>
							
							</table>				
						</div>
					</div>
					<!-- /Content -->				

<?php include $rsm['th_path']."/_common/general-footer.php";?>