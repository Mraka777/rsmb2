<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Stadium</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">
							<!-- Stadium -->
							<div class="row clearfix">
								<div class="col-md-8">
									<img src="/assets/images/track/sample_track.gif" style="width:100%;margin-bottom:1em;">
								</div>
								<div class="col-md-4">
									<div class="panel panel-primary">
										<div class="panel-heading">Stadium info</div>
										<table class="table-striped table-bordered table-condensed table-td1strong" style="width:100%">
											<tbody>
												<tr>
													<td style="width:7em;">Title</td>
													<td>
														<a href="#"><img class="flag" src="/assets/images/flag/<?php print $track_info['logo']; ?>" title="<?php print $track_info['nameb_en']; ?>"></a>
														<a href=""><?php print $track_info['name_en']; ?></a>
													</td>
													</td>
												</tr>
												<tr>
													<td>Owner</td>
													<td>
														<a href="#"><img class="flag" src="/assets/images/flag/<?php print $track_info['logo']; ?>" title="<?php print $track_info['nameb_en']; ?>"></a>
														<a href="#"><?php print $track_info['username']; ?></a>
													</td>
												</tr>
												<tr>
													<td>Home club</td>
													<td>
														<a href="#"><img class="flag" src="/assets/images/flag/<?php print $track_info['logo']; ?>" title="<?php print $track_info['nameb_en']; ?>"></a>
														<a href="<?php get_permalink(array('lng'=>$language_link, 'object'=>'team', 'id'=>$track_info['team_id'])); ?>"><?php print $track_info['team_name']; ?></td>
													</td>
												</tr>
												<tr>
													<td>Capacity</td>
													<td><?php print $track_info['track_capacity']; ?></td> 
												</tr>
												<tr>
													<td>Type</td>
													<td><?php print $track_info['track_type']; ?></td>
												</tr>
												<tr>
													<td>Pl / Ri / Des</td>
													<td><?php print $track_info['track_plain']; ?>% / <?php print $track_info['track_rise']; ?>% / <?php print $track_info['track_descent']; ?>%</td>
												</tr>
												<tr>
													<td>Difficulty</td>
													<td><?php //print_r($track_info);?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- /Stadium -->
							
							<!-- Stands -->
							<div class="row clearfix">
								<div class="col-md-12 column">
									<div class="panel panel-default">
										<div class="panel-heading">Stadium</div>
										<table class="table-striped table-bordered table-condensed table-td1strong" style="width:100%">
											<thead>
												<tr>
													<th>Name</th>
													<th style="width:80px;">Level</th>
													<th style="width:5em;">Capacity</th>
													<th>Description</th>
													<th>Preview</th>
													<th style="width:11em;">Status</th>
													<th style="width:5em;">Action</th>												
												</tr>
											</thead>
											<tbody>
												<?php for ($i = 0; $i<=2; $i++) {?>
												<tr>
													<td><?php print $stadium[$i]['namef_en']; ?></td>
													<td><?php rate_stars($th_url,$stadium[$i]['stadium_building_level'],1);?></td>
													<td><?php print $stadium[$i]['stadium_building_param']; ?></td>
													<td><?php print $stadium[$i]['stadium_building_description']; ?></td>
													<td></td>
													<td><?php print $stadium[$i]['status']; ?></td>
													<td><a href="<?php get_permalink(array('lng'=>$language_link, 'object'=>'build_stadium', 'id'=>$stadium[$i]['stadium_building_id'])); ?>" class="btn btn-success btn-xs" role="button">Build <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
 												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- /Stands -->
							
							<!-- Extra -->
							<div class="row clearfix">
								<!-- Quality and PR -->
								<div class="col-md-6 column">
									<div class="panel panel-default">
										<div class="panel-heading">Quality & PR</div>
										<table class="table table-condensed table-bordered table-striped table-td1strong" style="width:100%">
												<tr></tr>
												<?php for ($i = 3; $i<=7; $i++) {?>
												<tr>
													<td style="width:8em;"><nobr><?php print $stadium[$i]['namef_en']; ?></nobr></td>
													<td style="width:80px;"><?php rate_stars($th_url,$stadium[$i]['stadium_building_level'],1);?></td>
													<td><?php print $stadium[$i]['building_effect']; ?></td>
													<td style="width:5em;"><a href="<?php get_permalink(array('lng'=>$language_link, 'object'=>'build_stadium', 'id'=>$stadium[$i]['stadium_building_id'])); ?>" class="btn btn-success btn-xs" role="button">Build <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
												<?php } ?>
										</table>	
									</div>
								</div>
								<!-- /Quality and PR -->
								
								<!-- Comfort & Commercial -->
								<div class="col-md-6 column">
									<div class="panel panel-default">
										<div class="panel-heading">Comfort & Commercial</div>
										<table class="table table-condensed table-bordered table-striped table-td1strong" style="width:100%">
												<tr></tr>
												<?php for ($i = 8; $i<=12; $i++) {?>
												<tr>
													<td style="width:8em;"><nobr><?php print $stadium[$i]['namef_en']; ?></nobr></td>
													<td style="width:80px;"><?php rate_stars($th_url,$stadium[$i]['stadium_building_level'],1);?></td>
													<td><?php print $stadium[$i]['building_effect']; ?></td>
													<td style="width:5em;"><a href="<?php get_permalink(array('lng'=>$language_link, 'object'=>'build_stadium', 'id'=>$stadium[$i]['stadium_building_id'])); ?>" class="btn btn-success btn-xs" role="button">Build <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
												<?php } ?>										
										</table>
									</div>
								</div>
								<!-- /Comfort & Commercial -->
							</div>
							<!-- /Extra -->
						</div>
					</div>
					<!-- /Content -->				

<?php include $rsm['th_path']."/_common/general-footer.php";?>