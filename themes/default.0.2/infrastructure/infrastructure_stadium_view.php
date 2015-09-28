<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Stadium</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">					
							<table class="table-striped table-bordered table-condensed ">
									<tr style="font-weight:bold;text-align:center;">
											<td colspan=12>Stadium MENU</td>
									</tr>	
									<tr style="font-weight:bold;text-align:center;">
											<td>Name</td>
											<td>Level</td>
											<td>Capacity</td>
											<td>Description</td>
											<td>Preview</td>
											<td>Next level</td>
											<td>Demolish</td>
											<td>Days left</td>
											<td>Maintenance</td>
									</tr>
							<?php 
							$i = 0;
							//print("<pre>");
							//print_r($stadium);
							//print("</pre>");
							foreach($stadium as $string)
							{?><tr><?php 
							
										$string=(array)$stadium[$i];
								
							
									//if(!isset($training_type['last_training'])) $string['last_training']='n/a';
									print('<td align=center>'.$string['namef_en'].'</td>');
									print('<td align=center>'.$string['stadium_building_level'].'</td>');
									print('<td align=center>'.$string['stadium_building_param'].'</td>');
									print('<td align=center>'.$string['stadium_building_description'].'</td>');
									
									print('<td align=center><img src="'.$string['stadium_building_image'].'"></td>');
									if (($string['stadium_building_days_next']) > 0) { //can't build under construction
										print('<td align=center>Build</td>');
									}
									else print('<td align=center><a href="/'.$rsm_base_url.'/infrastructure/build_stadium/'.($string['stadium_building_id']).'">Build</a></td>');
											if (($string['stadium_building_level']) == 1) { //can't demolish level 1 
										print('<td align=center>X</td>');
									}
									else print('<td align=center><a href="">X</a></td>');
									
									print('<td align=center>'.$string['stadium_building_days_next'].'</td>');
									print('<td align=center>'.$string['maintenance_cost'].'</td>');
									$i++;
									?></tr><?php 
							}
							?>
								
							</table> 
						</div>
					</div>
					<!-- /Content -->				

<?php include $rsm['th_path']."/_common/general-footer.php";?>