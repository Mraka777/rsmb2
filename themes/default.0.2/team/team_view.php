<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Team Overview</h1> | 
							<img style="margin-bottom:0.25em;" src="/assets/images/flag/<?php print($user_country['logo']);?>" />
							<strong><?php print($user_country['team_name']);?></strong>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>						
						</div>
						<div class="panel-body">
							<table class="table-striped table-bordered table-condensed" style="width:100%">
								<thead style="background-color:#F5F5F5">
									<tr>
										<th rowspan="2">Name</th>
										<th rowspan="2">A<br/>g<br/>e</th>
										<th rowspan="1" colspan="4">Common</th>
										<th colspan="2">Physical</th>
										<th colspan="2">Ski</th>
										<th colspan="3">Shooting</th>
										<th colspan="4">Contract & Status</th>
									</tr>

									<tr>
										<!-- Common -->
										<th>Pop</th>
										<th>Ene</th>
										<th>Exp</th>
										<th>OR</th>
										
										
										<!-- Skills -->
										<th>Str</th>
										<th>End</th>
										<th>Spd</th>
										<th>Tec</th>
										<th>Acc</th>
										<th>Tec</th>
										<th>Clm</th>
										
										<!-- Contract -->
										<th title="Transfer value (approximately)">$,mln</th>
										<th title="Contract days left">L,d</th>
										<th title="Salary">Sal,k</th>
										<th title="Status">Status</th>
									</tr>
								</thead>
								
								<tbody>
									<tr></tr>
									</tr>
								<?php foreach($query as $sman) : ?>
									<tr>
										<!-- Country link&Flag Icon + Surmane, Firstname + Sportsman Link -->
										<td width=160>
											<a href="" title="<?php echo $sman->nameb_en;?>"><img class="flag" src="/assets/images/flag/<?php echo $sman->logo;?>" title="<?php echo $sman->nameb_en;?>" /></a>
											<a href="/<?php echo($rsm_base_url); ?>/player/view/<?php echo $sman->sportsman_id;?>" title="<?php echo $sman->name1." ".$sman->name2;?>"><?php echo $sman->name2;?>, <?php echo $sman->name1;?></a>
										</td>
										<!-- Age -->
										<td><?php echo $sman->age;?></td>
										
										<!-- Common -->
										<td><?php echo $sman->popularity;?></td>
										<td><?php echo $sman->phys_energy;?></td>
										<td>?</td>
										<td><?php echo $sman->overall_rating;?></td>
										
										<!-- Skills -->
										<td><?php echo $sman->phys_strength;?></td>
										<td><?php echo $sman->phys_endur;?></td>
										<td><?php echo $sman->track_spd;?></td>
										<td><?php echo $sman->track_tech;?></td>
										<td><?php echo $sman->shoot_acc;?></td>
										<td><?php echo $sman->shoot_tech;?></td>
										<td><?php echo $sman->shoot_calm;?></td>
										
										<!-- Contract & Status -->
										<td>?</td>
										<td>?</td>
										<td>?</td>
										<td>
											<a href=""><img style="height:16px;" src="/assets/images/player/scout.gif" title = "<?php echo ucfirst(strtolower($lng['scout_player']));?>" /></a>
											<img title="Not Listed" src="/assets/images/clipart/transfer-icon-on.png" style="height:16px;"/>
											<img title="Healthy" src="/assets/images/clipart/trauma-icon-off.png" style="height:16px;"/>
											<img title="No NT" src="/assets/images/clipart/nt-icon-off.png" style="height:16px;"/>
										</td>
									</tr>
								<?php endforeach;?>
								</tbody>
							</table>
						</div> <!-- /.panel-body -->
					</div>	
					<!-- /Content -->
					
<?php include $rsm['th_path']."/_common/general-footer.php";?>
