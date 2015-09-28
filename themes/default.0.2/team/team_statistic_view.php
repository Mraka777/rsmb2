<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Team Statistic</h1> | 
							<img style="margin-bottom:0.25em;" src="/assets/images/flag/<?php print($user_country['logo']);?>" />
							<strong><?php print($user_country['team_name']);?></strong>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>						
						</div>
						<div class="panel-body">					
							<table class="table-striped table-bordered table-condensed ">
									<tr style="font-weight:bold;text-align:center;">
											<td colspan=7>Brief statistic</td>
									</tr>
									<tr>
											<td>Avg shooting</td>
											<td>Avg speed</td>
											<td>Avg player rating</td>
											<td>Avg age</td>
											<td>Building level</td>
											<td>Stadium capacity</td>
											<td>Avg attendance</td>
									</tr>
							
							<?php 
							
							
							$i = 0;
							//print_r($team_statistic);
							foreach($team_statistic as $string)
							
							{?><tr><?php 
							
									$string=(array)$team_statistic[$i];
								
									print('<td>'.$string['team_shooting_stat'].' %</td>');
									print('<td>'.$string['team_avg_speed_stat'].' Km/h</a></td>');
									print('<td>'.$string['team_rating_stat'].'</td>');
									print('<td>'.$string['team_avg_age'].'</td>');
									print('<td>'.$string['team_avg_bld_lvl'].'</td>');
									print('<td>'.$string['team_capacity_stadium'].'</td>');
									print('<td>'.$string['team_avg_attendance'].'</td>');
									$i++;
									?></tr><?php 
							}
							
							?>
							
							</table>
						</div>
					</div>
					<!-- /Content -->				
					
<?php include $rsm['th_path']."/_common/general-footer.php";?>