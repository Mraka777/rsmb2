<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>League Statistic</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">					
							<table class="table-striped table-bordered table-condensed">
								<tr style="font-weight:bold;text-align:center;">
										<td align=center>#</td>
										<td align=center>Name</td>
										<td align=center>Team</td>
										<td align=center>Races</td>
										<td align=center>Winner</td>
										<td align=center>TOP3</td> <!-- 1-3 place in race -->
										<td align=center>TOP8</td> <!-- flowerc ceremony -->
										<td align=center>Points</td>
										<td align=center>AV P</td>
										<td align=center>Top speed</td>
										<td align=center>Hits/Shots</td>
										
										<td align=center>P %</td>
										<td align=center>S %</td>
										<td align=center>SH %</td>
								</tr>
						
						<?php 
						$i = 0;
						//echo("<pre>");
						//print_r($player_statistic);
						//echo("</pre>");
						if (isset($player_statistic)){
							foreach($player_statistic as $string)
							{?><tr><?php 
								//$string[$i]=(array)$player_statistic[$i];
								//print_r($string[$i]);
								
								print('<td align=center>'.($i+1).'</td>');
						
								print('<td align=center><a href="/'.$rsm_base_url.'/player/view/'.$string['sportsman_id'].'">'.$string['name1'].' '.$string['name2'].' id='.$string['sportsman_id'].'</a></td>');
								print('<td align=center>'.$string['team_name'].'</td>');
								print('<td align=center>'.$string['races_num'].'</td>');
								if ($string['races_num'] == 0) $string['races_num']=1;
								print('<td align=center>'.$string['races_win'].'</td>');
								print('<td align=center>'.$string['podiums'].'</td>');
								print('<td align=center>'.$string['top8'].'</td>');
								print('<td align=center>'.$string['points'].'</td>');
								$av_p=round(($string['points']/$string['races_num']),2);
								print('<td align=center>'.$av_p.'</td>');
								print('<td align=center>'.$string['top_speed'].'</td>'); 
								print('<td align=center>'.$string['hits'].'/'.$string['shots'].' </td>');
								
								print('<td align=center>'.($string['shooting_lay_stat']*100).'</td>');
								print('<td align=center>'.($string['shooting_stand_stat']*100).'</td>');
								print('<td align=center>'.($string['shooting_stat']*100).'</td>');
								
								$i++;
								?></tr><?php 
							}
						}
						
						?>
							
						</table> 
						</div>
					</div>
					<!-- /Content -->				

<?php include $rsm['th_path']."/_common/general-footer.php";?>