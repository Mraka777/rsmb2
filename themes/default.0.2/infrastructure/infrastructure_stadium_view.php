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
													<td>Title</td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="Russia"></a>
														<a href="">Test Track</a>
													</td>
													</td>
												</tr>
												<tr>
													<td>Owner</td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="Russia"></a>
														<a hreff="">Mraka</a>
													</td>
												</tr>
												<tr>
													<td>Home club</td>
													<td>
														<a href=""><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="Russia"></a>
														<a href="">Moscow Steel Dragons</td>
													</td>
												</tr>
												<tr>
													<td>Capacity</td>
													<td>10000</td> 
												</tr>
												<tr>
													<td>Type</td>
													<td>Plain</td>
												</tr>
												<tr>
													<td>Pl / Ri / Des</td>
													<td>60% / 20% / 20%</td>
												</tr>
												<tr>
													<td>Difficulty</td>
													<td>10</td>
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
													<th style="width:80px;">Quality</th>
													<th style="width:5em;">Capacity</th>
													<th>Description</th>
													<th>Preview</th>
													<th style="width:11em;">Status</th>
													<th style="width:5em;">Action</th>												
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Main stand</td>
													<td><?php rate_stars($th_url,5,1);?></td>
													<td>10000</td>
													<td>Basic wooden stands</td>
													<td></td>
													<td>In use</td>
													<td><a href="" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
												<tr>
													<td>Left side</td>
													<td><?php rate_stars($th_url,5,1);?></td>
													<td>10000</td>
													<td>Basic wooden stands</td>
													<td></td>
													<td>Construction, 10 days</td>
													<td><a href="" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
												<tr>
													<td>Right side</td>
													<td><?php rate_stars($th_url,5,1);?></td>
													<td>10000</td>
													<td>Basic wooden stands</td>
													<td></td>
													<td>Construction, 90 days</td>
													<td><a href="" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
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
												<tr>
													<td style="width:8em;">Media center</td>
													<td style="width:80px;"><?php rate_stars($th_url,5,1);?></td>
													<td>TV bonus +5%</td>
													<td style="width:5em;"><a href="#" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
												<tr>
													<td>Video panels</td>
													<td><?php rate_stars($th_url,5,1);?></td>
													<td>Attendance +5%</td>
													<td><a href="#" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
												<tr>
													<td>Light</td>
													<td><?php rate_stars($th_url,5,1);?></td>
													<td>Attendance +5%</td>
													<td><a href="#" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
												<tr>
													<td>Track</td>
													<td><?php rate_stars($th_url,5,1);?></td>
													<td>No ski penalty</td>
													<td><a href="#" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
												<tr>
													<td>Shooting-range</td>
													<td><?php rate_stars($th_url,5,1);?></td>
													<td>No shooting penalty</td>
													<td><a href="#" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
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
												<tr>
													<td style="width:8em;">Club Museum</td>
													<td style="width:80px;"><?php rate_stars($th_url,5,1);?></td>
													<td>Trade +5%</td>
													<td style="width:5em;"><a href="#" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
												<tr>
													<td>Shops</td>
													<td><?php rate_stars($th_url,5,1);?></td>
													<td>Trade +5%</td>
													<td><a href="#" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
												<tr>
													<td>Food court</td>
													<td><?php rate_stars($th_url,5,1);?></td>
													<td>Attendance +5%</td>
													<td><a href="#" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
												<tr>
													<td>Parking slots</td>
													<td><?php rate_stars($th_url,5,1);?></td>
													<td>Attendance +5%</td>
													<td><a href="#" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
												<tr>
													<td>Toilets</td>
													<td><?php rate_stars($th_url,5,1);?></td>
													<td>Attendance +5%</td>
													<td><a href="#" class="btn btn-success btn-xs" role="button">Rebuild <span class="glyphicon glyphicon-wrench"></span></a></td>
												</tr>
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