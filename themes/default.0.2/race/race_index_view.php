<?php include $rsm['th_path']."/_common/general-header.php";?>
<?php
	$race_info=$race_info[0];
	$race_weather_forecast=$race_weather_forecast[0];
	$race_team_sportsman_list=$race_team_sportsman_list;
?>
					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Next Race</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">
											<img src="/assets/images/track/sample_track.gif" style="width:400px;height:200px;"/>
											<img src="/assets/images/track/forecast_sample.gif" style="width:400px;height:200px;float:right;"/>
							<!-- General Info -->
							<div class="row clearfix race-preview-info" style="padding-top:20px;">
								<!-- Visualisation -->
								<div class="col-md-4">
									<div class="panel panel-default">
										<!-- Default panel contents -->
										
										<!-- Race Info -->
										<div class="panel-heading">Race Info</div>
										<table class="table table-condensed"  style="height:195px;">
											<tbody>
												<tr>
													<td><Strong>Game Date</Strong></td>
													<td>Season: <?php echo $race_info['season_id'];?> (<?php echo $race_info['day_num']."/35";?>)</td>
												</tr>
												<tr>
													<td><Strong>Real Date</Strong></td>
													<td><?php echo date('d M Y',strtotime($race_info['real_date']));?></td>
												</tr>
												<tr>
													<td><Strong>Real Time</Strong></td>
													<td>?????</td>
												</tr>
												<tr>
													<td><strong>Type</strong></td>
													<td>League / PO / Cup / ???</td>
												</tr>
												<tr>
													<td><Strong>Competition</Strong></td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="Russia"></a>
														<a href="">???race_type_text <?php echo($race_info['league_lvl']);?>.<?php echo($race_info['league_num']);?></a>
													</td>
												</tr>
												<tr>
													<td colspan="2" style="height:100%;"><strong>Скауты:</strong> рекомендуем использовать сильнейших скоростных спортсменов.
													<!-- Решающее значение будут иметь сила, выносливость и скорость стрельбы -->
													<!-- ??? -->
												</tr>
											</tbody>
										</table>
									</div>									
								</div>
								<!-- /Race Info -->
								
								<!-- Track Info -->
								<div class="col-md-4">
									<div class="panel panel-default">
										<!-- Default panel contents -->
										<div class="panel-heading">Track Info</div>
										<table class="table table-condensed">
											<tbody>
												<tr>
													<td><strong>Owner</strong></td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="Russia"></a>
														<a hreff="">Mraka</a>
													</td>
												</tr>
												<tr>
													<td><strong>Home Club</strong></td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="Russia"></a>
														<a href="">Moscow Steeld Dragons</td>
												</tr>
												<tr>
													<td><strong>Title</strong></td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="Russia"></a>
														<a href="/<?php echo($rsm['base_url']); ?>/infrastructure/track/<?php echo($race_info['track_id']);?>"><?php echo($race_info['name_en']);?></a>
													</td>
												</tr>
												<tr>
													<td><strong>Capacity</strong></td>
													<td>?????</td>
												</tr>
												<tr>
													<td><strong>General type</strong></td>
													<td><?php echo $race_info['rsm_track_type_name'];?></td>
												</tr>
												<tr>
													<td><strong>Pl / Ri / Des</strong></td>
													<td>
													<?php echo $race_info['rsm_track_type_plain']*100;?>%
													 / <?php echo $race_info['rsm_track_type_rise']*100;?>%
													 / <?php echo $race_info['rsm_track_type_descent']*100;?>%
													</td>
												</tr>
												<tr>
													<td><strong>Difficulty</strong></td>
													<td>????</td>
												</tr>
											</tbody>
										</table>
									</div>	
								</div>
								
								<!-- Weather Forecast-->
								<div class="col-md-4">
									<div class="panel panel-default">
										<!-- Default panel contents -->
										<div class="panel-heading">Weather Forecast</div>
										<table class="table table-condensed">
											<tbody>
												<tr>
													<td><strong>Temperature</strong></td>
													<td><?php echo $race_info['temperature'];?><sup>o</sup></td>
													<!--glyphicon glyphicon-tint
													glyphicon glyphicon-certificate
													 glyphicon glyphicon-cloud-download-->
												</tr>
												<tr>
													<td><strong>Humidity</strong></td>
													<td><?php echo $race_info['humidity'];?>%</td>
												</td>
												<tr>
													<td><strong>Wind</strong></td>
													<td><?php echo $race_info['wind_type_descr'];?>, <?php echo $race_weather_forecast['wind_speed'];?> m/s</td>
												</tr>
												<tr>
													<td><strong>Sun</strong></td>
													<td><?php echo $race_info['sun_type_descr'];?></td>
												</td>
												<tr>
													<td><strong>Fog</strong></td>
													<td><?php echo $race_info['fog_type_descr'];?></td>
												</td>
												<tr>
													<td><strong>Snow</strong></td>
													<td><?php echo $race_info['snow_type_descr'];?></td>
												</td>
												<tr>
													<td><strong>Rain</strong></td>
													<td><?php echo $race_info['rain_type_descr'];?></td>
												</td>												
											</tbody>
										</table>
									</div>
								</div>
								
							</div>
							<!-- /General Info -->
							
							<div class="row clearfix race-preview-squad">
								<div class="col-md-12">
									<div class="panel panel-primary">
										<div class="panel-heading">Race Line Up</div>
										<table class="table-striped table-bordered table-condensed table-training" style="width:100%">
											<thead style="background-color:#F5F5F5">
												<tr>
													<th>Name</th>
													<th>Age</th>
													<th>OR</th>
													<th>Form</th>
													<th>Energy</th>
													<th>Experience</th>
													<th>Popularity</th>
													<th>Tactic preset</th>
													<th>Status</th>
												</tr>
											</thead>
									
											<tbody>
												<tr></tr>
												<?php foreach($race_team_sportsman_list as $sman) : ?>
												<tr>
													<!-- Country link&Flag Icon + Surmane, Firstname + Sportsman Link -->
													<td style="text-align:left;">
														<a href="" title=""><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="Russia"></a>
														<a href="/<?php echo($rsm_base_url); ?>/player/view/<?php echo $sman['sportsman_id'];?>" title="<?php echo $sman['name1']." ".$sman['name2'];?>">
														<?php echo $sman['name2'];?>, <?php echo $sman['name1'];?>
														</a>
													</td>
													<td><?php echo $sman['age'];?></td>
													<td><?php echo $sman['overall_rating'];?></td>
													<td><?php echo rate_stars($rsm['th_url'],50,10);?></td>
													<td><?php echo rate_stars($rsm['th_url'],$sman['phys_energy'],10);?></td>
													<td><?php echo rate_stars($rsm['th_url'],50,10);?></td>
													<td><?php echo rate_stars($rsm['th_url'],$sman['popularity'],10);?></td>
													<td><a title="Info about tactic" href="<?php echo $rsm['base_url'];?>/race/tactics">Preset One</a></td>
													<td>
														<img title="Not Listed" src="/assets/images/clipart/transfer-icon-off.png" style="height:16px;"/>
														<img title="Healthy" src="/assets/images/clipart/trauma-icon-off.png" style="height:16px;"/>
														<img title="No NT" src="/assets/images/clipart/nt-icon-off.png" style="height:16px;"/>
													</td>
												</tr>
												<?php endforeach;?>
											</tbody>
										</table>
									</div>
									<div style="float:right;margin-top:-5px;">
										<a class="btn btn-primary" href="/<?php echo $rsm['base_url'];?>/race/line_up/" role="button">Set Line Up</a>
										<a class="btn btn-success" href="/<?php echo $rsm['base_url'];?>/race/tactics/" role="button">Set tactics</a>
										<a class="btn btn-default" href="/<?php echo $rsm['base_url'];?>/board/" role="button">Ask for advice from community</a>
										<a class="btn btn-danger" href="/<?php echo $rsm['base_url'];?>/board/" role="button">
										<span class="glyphicon glyphicon-usd"></span> Ask for help from Guru</a>
									</div>
								</div>
							</div>
						
							
							<?php
							/*
								print_r($race_info);
								print("<br><br>");
								print_r($race_weather_forecast);
								print("<br><br>");
								print_r($race_team_sportsman_list);
								
							*/
							?>
						</div>
					</div>
					<!-- /Content -->				

<?php include $rsm['th_path']."/_common/general-footer.php";?>