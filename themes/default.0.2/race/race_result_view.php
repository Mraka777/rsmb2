<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Race Results</h1> | (race info)
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>						
						</div>
						<div class="panel-body">
							<div class="row" style="padding-bottom:1em;">
								<div class="col-md-4 column">
									<img src="/assets/images/track/sample_track.gif" style="height:188px;width:100%;">
								</div>
								<div class="col-md-8 column">
									<table class="table-striped table-bordered table-condensed" style="width:100%;">
										<thead>
											<tr class="bg-primary">
												<th colspan="2">Race</th>
												<th colspan="2">Track&Weather</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td style="font-weight:bold;">Date</td>
												<td><?php echo($track_data['race_num_day']); ?>/35 (<?php echo($track_data['race_real_date']); ?>)</td>
												<td style="font-weight:bold;">Track Type</td> <td><?php echo($track_data['track_type']); ?></td>
											</tr>
											<tr>
												<td style="font-weight:bold;">Competition</td>
												<td>
													<a href=""><img class="flag" src="/assets/images/flag/<?php echo($track_data['logo']); ?>" title="<?php echo($track_data['nameb_en']); ?>"></a>
													<a href="/<?php print($language_link);?>/competition/league">League <?php echo($track_data['league_lvl']); ?>.<?php echo($track_data['league_num']); ?></a> (Round 1)
												</td>
												<td style="font-weight:bold;">Pl/Ri/Des</td> <td><?php echo($track_data['track_plain']); ?>/<?php echo($track_data['track_rise']); ?>/<?php echo($track_data['track_descent']); ?></td>
											</tr>
											<tr>
												<td style="font-weight:bold;">Track</td>
												<td>
													<a href=""><img class="flag" src="/assets/images/flag/<?php echo($track_data['logo']); ?>" title="<?php echo($track_data['nameb_en']); ?>"></a>
													<a href=""><?php echo($track_data['track_name']); ?></a>
												</td>													
												<td style="font-weight:bold;">Temperature</td> <td><?php print($race_weather['temperature']); ?><sup>o</sup>, <?php print($race_weather['sun_type_descr']); ?></td>
											</tr>
											<tr>
												<td style="font-weight:bold;">Home Club</td>
												<td>
													<a href="#"><img class="flag" src="/assets/images/flag/<?php echo($track_data['logo']); ?>" title="<?php echo($track_data['nameb_en']); ?>"></a>
													<a href="/<?php print($language_link);?>/team/view/<?php echo($track_data['track_team_id']); ?>"><?php echo($track_data['track_team_name']); ?></a>
												</td>
												<td style="font-weight:bold;">Humidity&Wind</td> <td><?php print($race_weather['humidity']); ?>%, <?php print($race_weather['wind_speed']); ?> m/s</td>
											</tr>
											<tr>
												<td style="font-weight:bold;">Attendance</td> <td><?php echo($track_data['race_attendance']); ?>/<?php echo($track_data['track_capacity']); ?></td>
												<td style="font-weight:bold;">Precipitation</td> <td><?php print($race_weather['phenomena_descr']);?></td>
											</tr>
										
											<!-- DELETE!!! 
											<tr>
												<td colspan = 4><?php //print_r($race_weather); ?></td>
											</tr>
											DELETE!!! -->
										</tbody>
									</table>
								</div>
							</div>

							<!-- Teams results -->
							<div class="row clearfix" style="margin-bottom:-20px;">
								<!-- Top Teams Column -->
								<div class="col-md-4 column">
									<div class="panel panel-primary">
										<div class="panel-heading">Top 8 Teams Points</div>
										<table class="table-striped table-bordered table-condensed" style="width:100%">
											<thead>
												<tr>
													<th style="width:2em;">P</th>
													<th>Team</th>
													<th>Pts</th>
												</tr>
											</thead>
											<tbody>
												<?php
												//Example: Teams for 1 column
												//print_r($top8_team_pts);
												for($i=0;$i<8;$i++) { ?>
												<tr>
													<td style="font-weight:bold;"><?php echo ($i+1);?></td>
													<td><img src="/images/flag/<?php echo $top8_team_pts[$i]['logo'];?>"> <a href="/<?php print($language_link);?>/team/view/<?php echo $top8_team_pts[$i]['team_id'];?>"><?php echo $top8_team_pts[$i]['team_name'];?></a></td>
													<td><?php echo $top8_team_pts[$i]['race_points'];?></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div><!-- /panel -->
								</div>
								<!-- /Top Teams Column -->
								
								<!-- Bottom Teams Column -->
								<div class="col-md-4 column">
									<div class="panel panel-default">
										<div class="panel-heading">8-16 Team Points</div>
										<table class="table-striped table-bordered table-condensed" style="width:100%">
											<thead>
												<tr>
													<th style="width:2em;">P</th>
													<th>Team</th>
													<th>Pts</th>
												</tr>
											</thead>
											<tbody>
												<?php
												//Example: Teams for 2 column
												for($i=0;$i<8;$i++) { ?>
												<tr>
													<td style="font-weight:bold;"><?php echo ($i+9);?></td>
													<td><img src="/images/flag/<?php echo $next8_team_pts[$i]['logo'];?>"> <a href="/<?php print($language_link);?>/team/view/<?php echo $next8_team_pts[$i]['team_id'];?>"><?php echo $next8_team_pts[$i]['team_name'];?></a></td>
													<td><?php echo $next8_team_pts[$i]['race_points'];?></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div><!-- /panel -->
								</div>
								<!-- /Bottom Column -->
								
								<!-- Awards Column -->
								<div class="col-md-4 column">
									<!-- Hero -->
									<div class="panel panel-default">
										<div class="panel-heading" style="padding:5px 10px 5px 10px;">Hero*</div>
										<table class="table-striped table-bordered table-condensed" style="width:100%;">
											<tbody>
												<tr></tr>
												<tr>
													<td rowspan="2" style="width:3em;">
														<span class="glyphicon glyphicon-user" style="font-size:3em;float:left;"></span>
													</td>
														<td>
														<a href="" title="Russia"><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="Russia"></a>
														<a href="/<?php print($language_link);?>/player/view/12" title="Yaroslav Lebedev">Lebedev, Yaroslav</a>
													</td>
												</tr>
												<tr>
													<td>Run from 10 place to 1</td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- /Hero -->
									
									<!-- Best Sniper -->
									<div class="panel panel-default">
										<div class="panel-heading" style="padding:5px 10px 5px 10px;">Best Sniper</div>
										<table class="table-striped table-bordered table-condensed" style="width:100%;">
											<tbody>
												<tr></tr>
												<tr>
													<td rowspan="2" style="width:3em;">
														<span class="glyphicon glyphicon-user" style="font-size:3em;float:left;"></span>
													</td>
														<td>
														<a href="" title="Russia"><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="<?php print($race_sniper['nameb_en']); ?>"></a>
														<a href="/<?php print($language_link);?>/player/view/<?php print($race_sniper['sportsman_id']); ?>" title="<?php print($race_sniper['name1']." ");print($race_sniper['name2']); ?>"><?php print($race_sniper['name1']." ");print($race_sniper['name2']); ?></a>
													</td>
												</tr>
												<tr>
													<td>Missed <?php print($race_sniper['race_shots_missed']); ?> from 20 targets!</td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- /Best Sniper -->
									
									<!-- Best Ski -->
									<div class="panel panel-default">
										<div class="panel-heading" style="padding:5px 10px 5px 10px;">Best Ski</div>
										<table class="table-striped table-bordered table-condensed" style="width:100%;">
											<tbody>
												<tr></tr>
												<tr>
													<td rowspan="2" style="width:3em;">
														<span class="glyphicon glyphicon-user" style="font-size:3em;float:left;"></span>
													</td>
														<td>
														<a href="" title="<?php print($race_best_ski['nameb_en']); ?>"><img class="flag" src="/assets/images/flag/<?php print($race_best_ski['logo']); ?>" title="<?php print($race_best_ski['nameb_en']); ?>"></a>
														<a href="/<?php print($language_link);?>/player/view/<?php print($race_best_ski['sportsman_id']); ?>" title="<?php print($race_best_ski['name1']." ");print($race_best_ski['name2']); ?>"><?php print($race_best_ski['name1']." ");print($race_best_ski['name2']); ?></a>
													</td>
												</tr>
												<tr>
													<td>Pure Ski result: <?php echo gmdate('H:i:s', $race_best_ski['ski_time']); ?></td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- /Best Ski -->
								</div>
								<!-- /Awards Column -->
							</div>
							<!-- /Teams results -->
						
							<!-- Sportsmans results -->
							<div class="row clearfix" style="padding:1em;">
								<!-- Sportsmans results panel -->
								<div class="panel panel-default">
									<div class="panel-heading">Biathlonists results</div>							
									<table class="table-striped table-bordered table-condensed" style="width:100%">
										<thead>
											<tr>
												<th>P</th>
												<th>Biathlonist</th>
												<th>Team</th>
												<th>Time</th>
												<th>Behind</th>
												<th>Pt</th>
												<th></th>
												<th>Ski Time</th>
												<th>Shooting</th>
												<th>T</th>
												<th></th>
												<th>Exp</th>
												<th>Sh</th>
												<th>Ski</th>
												<th>Ph</th>
												<th>R</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$i=0;
											foreach($race_sportsman_list as $sportsman){ ?>
											<tr>
												<td><strong><?php echo($i+1);?></strong></td>
												<td style="white-space: nowrap;">
													<img src="/images/flag/icons-flag-ru.png">
													<a href="/<?php echo($language_link); ?>/player/view/<?php echo $sportsman['sportsman_id']; ?>"><?php echo $sportsman['name2']; ?> <?php echo $sportsman['name1'][0]; ?>.</a>
												</td>
												<td style="white-space: nowrap;">
													<img src="/images/flag/icons-flag-ru.png">
													<a href="/<?php echo($language_link); ?>/team/view/<?php echo $sportsman['team_id']; ?>"><?php echo $sportsman['team_name']; ?></a>
												</td>
												<td><?php echo gmdate('H:i:s', $sportsman['overall_time']); ?></td>
												<td><?php echo gmdate('H:i:s', $sportsman['behind']);?></td>
												<td><strong><?php echo $sportsman['race_points']; ?></strong></td>
												<th></th>
												<td><?php echo gmdate('H:i:s', $sportsman['ski_time']); ?></td>
												<td><?php echo( $sportsman['race_sh1']);?> + <?php echo( $sportsman['race_sh2']);?> + <?php echo( $sportsman['race_sh3']);?> + <?php echo( $sportsman['race_sh4']);?></td>
												<td><?php echo($sportsman['race_sh1']+$sportsman['race_sh2']+$sportsman['race_sh3']+$sportsman['race_sh4']);?></td>
												<th></th>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
											</tr>
										<?php
										$i++;
										} ?>
										</tbody>
									</table>
								</div>
								<!-- /Sportsman results panel -->
							</div>
							<!-- /Sportsmans results row -->
						</div>
						<!-- /Content panel-body -->
					</div>
					<!-- /Content panel -->				
					
<?php include $rsm['th_path']."/_common/general-footer.php";?>
