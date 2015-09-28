<?php include $rsm['th_path']."/_common/general-header.php";?>
					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Calendar</h1> 
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">
							<div class="row clearfix">
								<div class="col-md-6">
									<div class="panel panel-default">
										<div class="panel-heading">Last Race</div>
										<table class="table table-condensed">
											<tbody style="text-align:center;">
												<tr>
													<td>
														<strong><span class="glyphicon glyphicon-road"></span> Track</strong>
														<br/><img src="/assets/images/track/sample_track.gif" style="width:175px;height:100px;"/>
														<strong>Plain <?php echo($last_race_info['rsm_track_type_plain']*100);?>%, rise <?php echo($last_race_info['rsm_track_type_rise']*100);?>%, slope <?php echo($last_race_info['rsm_track_type_descent']*100);?>%</strong>
													</td>
													<td>
														<strong><span class="glyphicon glyphicon-certificate"></span> Weather</strong>
														<br/><img src="/assets/images/track/forecast_sample.gif" style="width:175px;height:100px;"/>
														<br/><strong><?php echo($last_race_info['temperature']);?><sup>o</sup>, <?php echo($last_race_info['sun_type_descr']);?>, <?php echo($last_race_info['snow_type_descr']);?>, <?php echo($last_race_info['humidity']);?>%</strong>
													</td>
												</tr>
											</tbody>
										</table>
										<table class="table table-condensed">
											<tbody style="text-align:center;">
												<tr>
													<td><?php echo($last_race_info['real_date']);?></td>
													<td><?php echo($last_race_info['day_num']);?>/<?php echo($last_race_info['season_id']);?></td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="Russia"></a>
														<a href=""><?php echo($last_race_info['race_type_text']);?> <?php echo($last_race_info['league_lvl']);?>.<?php echo($last_race_info['league_num']);?></a>
													</td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="Russia"></a>
														<a href="/<?php echo($rsm_base_url); ?>/infrastructure/track/<?php echo($last_race_info['track_id']);?>"><?php echo($last_race_info['name_en']);?></a>
													</td>
													<td><a href="/<?php echo($rsm_base_url); ?>/race/report/<?php echo($last_race_info['race_id']);?>"><span class="glyphicon glyphicon-list-alt"></span> Report</a></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-md-6">
									<!-- Next Race -->
									<div class="panel panel-primary">
										<div class="panel-heading">Next Race</div>
										<table class="table table-condensed">
											<tbody style="text-align:center;">
												<tr>
													<td>
														<strong><span class="glyphicon glyphicon-road"></span> Track</strong>
														<br/><img src="/assets/images/track/sample_track.gif" style="width:175px;height:100px;"/>
														<strong>Plain <?php echo($next_race_info['rsm_track_type_plain']*100);?>%, rise <?php echo($next_race_info['rsm_track_type_rise']*100);?>%, slope <?php echo($next_race_info['rsm_track_type_descent']*100);?>%</strong>
													</td>
													<td>
														<strong><span class="glyphicon glyphicon-certificate"></span> Weather forecast</strong>
														<br/><img src="/assets/images/track/forecast_sample.gif" style="width:175px;height:100px;"/>
														<br/><strong><?php echo($next_race_info['temperature']);?><sup>o</sup>, <?php echo($next_race_info['sun_type_descr']);?>, <?php echo($next_race_info['snow_type_descr']);?>, <?php echo($next_race_info['humidity']);?>%</strong>
													</td>
												</tr>
											</tbody>
										</table>
										<table class="table table-condensed">
											<tbody style="text-align:center;">
												<tr>
													<td><?php echo($next_race_info['real_date']);?></td>
													<td><?php echo($next_race_info['day_num']);?>/<?php echo($next_race_info['season_id']);?></td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="Russia"></a>
														<a href="/competition/view/"><?php echo($next_race_info['race_type_text']);?> <?php echo($next_race_info['league_lvl']);?>.<?php echo($next_race_info['league_num']);?></a>
													</td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="Russia"></a>
														<a href="/<?php echo($rsm_base_url); ?>/infrastructure/track/<?php echo($next_race_info['track_id']);?>"><?php echo($next_race_info['name_en']);?></a>
													</td>
													<td><a href="/<?php echo($rsm_base_url); ?>/race/preview/<?php echo($next_race_info['race_id']);?>"><span class="glyphicon glyphicon-list-alt"></span> Preview</a></td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- /Next Race -->
								</div>
							</div>
							
							<!-- Recent and Future races -->
							<div class="row clearfix">
								<div class="col-md-6">
									<div class="panel panel-default">
										<div class="panel-heading">Previous races</div>
										<table class="table table-bordered table-condensed table-stripped">
											<thead>
												<tr>
													<th>Real Date</th>
													<th>D/S</th>
													<th>Competition</th>
													<th>Track</th>
													<th>Report</th>
												</tr>
											</thead>
											<tbody style="text-align:center;">
												<?php
													if (isset($prev_race_data)) {
													foreach($prev_race_data as $race) {
													//print_r($race);
													?>
												<tr>
													<td><?php echo($race['real_date']);?></td>
													<td><?php echo($race['day_num']);?>/<?php echo($race['season_id']);?></td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/<?php echo($race['logo']);?>" title="Russia"></a>
														<a href="/competition/view/"><?php echo($race['race_type_text']);?> <?php echo($race['league_lvl']);?>.<?php echo($race['league_num']);?></a>
													</td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/<?php echo($race['logo']);?>" title="Russia"></a>
														<a href="/<?php echo($rsm_base_url); ?>/infrastructure/track/<?php echo($race['track_id']);?>"><?php echo($race['name_en']);?></a>
													</td>
													<td><a href="/<?php echo($rsm_base_url); ?>/race/report/<?php echo($race['race_id']);?>"><span class="glyphicon glyphicon-list-alt"></span> Report</a></td>
												</tr>
												<?php } }?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-md-6">
									<div class="panel panel-primary">
										<div class="panel-heading">Future races</div>
										<table class="table table-bordered table-condensed table-stripped" style="margin:0px;">
											<thead>
												<tr>
													<th>Real Date</th>
													<th>D/S</th>
													<th>Competition</th>
													<th>Track</th>
													<th>Preview</th>
												</tr>
											</thead>
											<tbody style="text-align:center;">
												<?php foreach($next_race_data as $race) {
													//print_r($race);
													?>
												<tr>
													<td><?php echo($race['real_date']);?></td>
													<td><?php echo($race['day_num']);?>/<?php echo($race['season_id']);?></td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/<?php echo($race['logo']);?>" title="Russia"></a>
														<a href="/<?php echo($rsm_base_url); ?>/competition/view/"><?php echo($race['race_type_text']);?> <?php echo($race['league_lvl']);?>.<?php echo($race['league_num']);?></a>
													</td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/<?php echo($race['logo']);?>" title="Russia"></a>
														<a href="/<?php echo($rsm_base_url); ?>/infrastructure/track/<?php echo($race['track_id']);?>"><?php echo($race['name_en']);?></a>
													</td>
													<td><a href="/<?php echo($rsm_base_url); ?>/race/preview/<?php echo($race['race_id']);?>"><span class="glyphicon glyphicon-list-alt"></span> Report</a></td>
												</tr>
												<?php } ?>

											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Content -->			
<?php include $rsm['th_path']."/_common/general-footer.php";?>
