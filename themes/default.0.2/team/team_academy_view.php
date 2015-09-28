<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Team Academy</h1> | 
							<img style="margin-bottom:0.25em;" src="/assets/images/flag/<?php print($user_country['logo']);?>" />
							<strong><?php print($user_country['team_name']);?></strong>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>						
						</div>
						<div class="panel-body">
							<!-- Information about youth and scout deps -->
							<div class="row clearfix">
								<div class="col-md-6 column">
									<div class="panel panel-primary">
										<div class="panel-heading" style="font-weight:bold;text-align:center;"><span class="glyphicon glyphicon-user"></span> Youth department</div>
										<table class="table-bordered table-condensed" style="width:100%;text-align:center;margin:0px;">
											<thead style="background-color:#F5F5F5">
												<tr>
													<th>Inrastructure</th>
													<th>Director</th>
													<th>Overall</th>
												</tr>
											</thead>
											<tbody>
											<tr>
												<td>5 lvl, 90%</td>
												<td>
											<a href="#" title="<?php echo($academy_staff['nameb_en']);?>"><img class="flag" src="/assets/images/flag/<?php echo($academy_staff['logo']);?>" title="<?php echo($academy_staff['nameb_en']);?>"></a>
											<a href="#" title="<?php echo($academy_staff['name1']." ".$academy_staff['name2'])?>"><?php echo($academy_staff['name1']." ".$academy_staff['name2'])?></a>, <?php echo($academy_staff['skill1']);?>%
												</td>
												<td>81%</td>
											</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-md-6 column">
									<div class="panel panel-primary">
										<div class="panel-heading" style="font-weight:bold;text-align:center;"><span class="glyphicon glyphicon-search"></span> Scout department</div>
										<table class="table-bordered table-condensed" style="width:100%;text-align:center;margin:0px;">
											<thead style="background-color:#F5F5F5">
												<tr>
													<th>Inrastructure</th>
													<th>Director</th>
													<th>Overall</th>
												</tr>
											</thead>
											<tbody>
											<tr>
												<td>?</td>
												<td>?</td>
												<td>?</td>
											</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- /Information about youth and scout deps -->
							
							<!-- Academy -->							
							<table class="table-striped table-bordered table-condensed table-academy" style="width:100%">
								<thead style="background-color:#F5F5F5">
									<tr>
										<th rowspan="2">Name</th>
										<th rowspan="2">Age</th>
										<th colspan="2">Common</th>
										<th colspan="3">Potential</th>
										<th rowspan="2" title="Size of bonus that your team give young player for sign contract">Sign<br/>fee</th>
										<th rowspan="2" title="Days left in the acedemy, than 0 - player go away tomorrow">Days<br/>left</th>
										<th rowspan="2" title="Scout advise. Based on combination of Proffesionalism potential and talant combinations for different sman speciality profiles">Scout<br/>opinion</th>
										<th rowspan="2" title="Sign new star or kick him out yeahhh!">Action</th>
									</tr>

									<tr>
										<!-- Common -->
										<th>Pro</th>
										<th>OR</th>										
										
										<!-- Potential -->
										<th>Physical</th>
										<th>Ski</th>
										<th>Shooting</th>
										
									</tr>
								</thead>
								
								<tbody>
									<tr></tr>
									<!-- Тестовый игрок 
									<tr>
										<td style="text-align:left;">
											<a href="" title="Russia"><img class="flag" src="/assets/images/flag/icons-flag-ru.png" title="Russia"></a>
											<a href="/player/view/7" title="Arkadiy Mikhaylov">Mikhaylov, Arkadiy</a>
										</td>
										<td>15</td>
										<td><?php rate_stars($th_url,50,10);?></td>
										<td>450</td>
										<td><?php rate_stars($th_url,50,10);?></td>
										<td><?php rate_stars($th_url,50,10);?></td>
										<td><?php rate_stars($th_url,50,10);?></td>
										<td>200k</td>
										<td>10</td>
										<td><strong>Take him!</strong></td>
										<td>
											<a href=""><img src="/assets/images/clipart/yes-icon.png" /></a>
											<a href=""><img src="/assets/images/clipart/no-icon.png" /></a>
										</td>
									</tr>-->
								<?php
									$academy_num = count($academy);
									print_r($academy_staff);
									//print("<pre>");
									//print_r($academy);
									//print("</pre>");
									if ($academy_num > 0) {
									foreach($academy as $sman) : ?>
									<tr>
										<!-- Country link&Flag Icon + Surmane, Firstname + Sportsman Link -->
										<td>
											<a href="/<?php echo($rsm_base_url); ?>/country/<?php echo $sman['country_id'];?>" title="<?php echo $sman['nameb_en'];?>">
												<img class="flag" src="/assets/images/flag/<?php echo $sman['logo'];?>" title="<?php echo $sman['nameb_en'];?>" />
											</a>
											<?php echo $sman['name2'];?>, <?php echo $sman['name1'];?>
										</td>
										<!-- Age -->
										<td><?php echo $sman['age'];?></td>										
										<!-- Common -->
										<td><?php rate_stars($th_url,$sman['sportsman_prof'],10);?></td>
										<td><?php echo $sman['overall_rating'];?></td>										
										<!-- Potential -->
										<td><?php rate_stars($th_url,$sman['p_phys'],10);?></td>
										<td><?php rate_stars($th_url,$sman['p_ski'],10);?></td>
										<td><?php rate_stars($th_url,$sman['p_shoot'],10);?></td>
										<td><?php echo $sman['academy_sign_fee'];?></td>
										<td><?php echo $sman['days_actual'];?></td>
										<td>-</td>
										<td>
											<a href="/<?php echo($rsm_base_url); ?>/team/academy_accept/<?php echo $sman['sportsman_id'];?>"><img src="/assets/images/clipart/yes-icon.png" /></a>
											<a href="/<?php echo($rsm_base_url); ?>/team/academy_reject/<?php echo $sman['sportsman_id'];?>"><img src="/assets/images/clipart/no-icon.png" /></a>
										</td>
									</tr>
								<?php endforeach;
								}
								?>
								</tbody>
							</table>
						</div> <!-- /.panel-body -->
					</div>	
					<!-- /Content -->			
				</div>
				<!-- /SubNav and Content -->
					
<?php include $rsm['th_path']."/_common/general-footer.php";?>