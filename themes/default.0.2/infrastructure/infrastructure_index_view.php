<?php include $rsm['th_path']."/_common/general-header.php";?>
					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Infrastructure overview</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">
							<div class="row clearfix">
								<div class="col-md-6 column">
									<img src="/assets/images/track/sample_track.gif" style="width:100%;margin-bottom:1em;">
									<div class="panel panel-default">
										<div class="panel-heading">Stadium 
										<a href="/en/infrastructure/stadium" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-chevron-right"></span></a>
										</div>
										<table class="table-striped table-bordered table-condensed table-td1strong" style="width:100%">
											<tbody>
												<tr>
													<td>Title</td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/<?php print $track_info['logo']; ?>" title="Russia"></a>
														<a href=""><?php print $track_info['name_en']; ?></a>
													</td>
													</td>
												</tr>
												<tr>
													<td>Owner</td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/<?php print $track_info['logo']; ?>" title="Russia"></a>
														<a hreff=""><?php print $track_info['username']; ?></a>
													</td>
												</tr>
												<tr>
													<td>Home club</td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/<?php print $track_info['logo']; ?>" title="Russia"></a>
														<a href="<?php get_permalink(array('lng'=>$language_link, 'object'=>'team', 'id'=>$track_info['team_id'])); ?>"><?php print $track_info['team_name']; ?></td>
													</td>
												</tr>
												<tr>
													<td>Capacity</td>
													<td><?php print $track_info['track_capacity']; ?></td> 
												</tr>
												<tr>
													<td>General type</td>
													<td><?php print $track_info['track_type']; ?></td>
												</tr>
												<tr>
													<td>Pl / Ri / Des</td>
													<td><?php print $track_info['track_plain']; ?>% / <?php print $track_info['track_rise']; ?>% / <?php print $track_info['track_descent']; ?>%</td>
												</tr>
												<tr>
													<td>Difficulty</td>
													<td>-</td>
												</tr>
												<tr>
													<td colspan="2" class="rsm-table-row-naming" style="text-align:center;">Quality & PR</td>
												</tr>
												<?php for ($i = 3; $i<=7; $i++) {?>
												<tr>
													<td><?php print $stadium[$i]['namef_en']; ?></td>
													<td><?php rate_stars($th_url,$stadium[$i]['stadium_building_level'],1);?></td>
												</tr>
												<?php } ?>												
												<tr>
													<td colspan="2" class="rsm-table-row-naming" style="text-align:center;">Comfort & Commercial</td>
												</tr>
												<?php for ($i = 8; $i<=12; $i++) {?>
												<tr>
													<td><?php print $stadium[$i]['namef_en']; ?></td>
													<td><?php rate_stars($th_url,$stadium[$i]['stadium_building_level'],1);?></td>
												</tr>
												<?php } ?>	
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-md-6 column">
									<img src="/assets/images/track/sample_track.gif" style="width:100%;margin-bottom:1em;">
									<div class="panel panel-default">
										<div class="panel-heading">Facilities 
										<a href="/en/infrastructure/facilities" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-chevron-right"></span></a>
										</div>
										<table class="table-striped table-bordered table-condensed table-td1strong" style="width:100%">
											<thead>
												<tr>
													<th>Facility</th>
													<th>Rate</th>
													<th>Lvl</th>
													<th>E1</th>
													<th>E2</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td colspan="5" class="rsm-table-row-naming" style="text-align:center;">Sport departments</td>
												</tr>
												<tr>
													<td style="width:40%"><span class="glyphicon glyphicon-education"></span> Training base</td>
													<td style="width:80px;"><?php rate_stars($th_url,$infrastructure[0]['building_level'],1);?></td>
													<td><?php echo $infrastructure[0]['building_level']; ?></td>
													<td><?php echo $infrastructure[0]['building_e1']; ?></td>
													<td><?php echo $infrastructure[0]['building_e2']; ?></td>
												</tr>
												<tr>
													<td><span class="glyphicon glyphicon-home"></span> Service Dept.</td>
													<td style="width:80px;"><?php rate_stars($th_url,$infrastructure[1]['building_level'],1);?></td>
													<td><?php echo $infrastructure[1]['building_level']; ?></td>
													<td><?php echo $infrastructure[1]['building_e1']; ?></td>
													<td><?php echo $infrastructure[1]['building_e2']; ?></td>
												</tr>
												<tr>
													<td><span class="glyphicon glyphicon-home"></span> Youth Academy</td>
													<td style="width:80px;"><?php rate_stars($th_url,$infrastructure[6]['building_level'],1);?></td>
													<td><?php echo $infrastructure[6]['building_level']; ?></td>
													<td><?php echo $infrastructure[6]['building_e1']; ?></td>
													<td><?php echo $infrastructure[6]['building_e2']; ?></td>
												</tr>
												
												<tr>
													<td colspan="5" class="rsm-table-row-naming" style="text-align:center;">Club departments</td>
												</tr>
												<tr>
													<td><span class="glyphicon glyphicon-home"></span> Club Office</td>
													<td style="width:80px;"><?php rate_stars($th_url,$infrastructure[2]['building_level'],1);?></td>
													<td><?php echo $infrastructure[2]['building_level']; ?></td>
													<td><?php echo $infrastructure[2]['building_e1']; ?></td>
													<td><?php echo $infrastructure[2]['building_e2']; ?></td>
												</tr>
												<tr>
													<td><span class="glyphicon glyphicon-search"></span> Scouting dept.</td>
													<td style="width:80px;"><?php rate_stars($th_url,$infrastructure[4]['building_level'],1);?></td>
													<td><?php echo $infrastructure[4]['building_level']; ?></td>
													<td><?php echo $infrastructure[4]['building_e1']; ?></td>
													<td><?php echo $infrastructure[4]['building_e2']; ?></td>
												</tr>
												<tr>
													<td><span class="glyphicon glyphicon-plus-sign"></span> Medical Complex</td>
													<td style="width:80px;"><?php rate_stars($th_url,$infrastructure[5]['building_level'],1);?></td>
													<td><?php echo $infrastructure[5]['building_level']; ?></td>
													<td><?php echo $infrastructure[5]['building_e1']; ?></td>
													<td><?php echo $infrastructure[5]['building_e2']; ?></td>
												</tr>
												
												<tr>
													<td colspan="5" class="rsm-table-row-naming" style="text-align:center;">Economic departments</td>
												</tr>
												<tr>
													<td><span class="glyphicon glyphicon-usd"></span> Economy dept.</td>
													<td style="width:80px;"><?php rate_stars($th_url,$infrastructure[7]['building_level'],1);?></td>
													<td><?php echo $infrastructure[7]['building_level']; ?></td>
													<td><?php echo $infrastructure[7]['building_e1']; ?></td>
													<td><?php echo $infrastructure[7]['building_e2']; ?></td>
												</tr>
												<tr>
													<td><span class="glyphicon glyphicon-wrench"></span> Maintaince dept.</td>
													<td style="width:80px;"><?php rate_stars($th_url,$infrastructure[3]['building_level'],1);?></td>
													<td><?php echo $infrastructure[3]['building_level']; ?></td>
													<td><?php echo $infrastructure[3]['building_e1']; ?></td>
													<td><?php echo $infrastructure[3]['building_e2']; ?></td>
												</tr>

											</tbody>
										</table>
									</div>
								</div>
								</div>
							</div>
						
						</div>
					</div>
					<!-- /Content -->				

<?php include $rsm['th_path']."/_common/general-footer.php";?>