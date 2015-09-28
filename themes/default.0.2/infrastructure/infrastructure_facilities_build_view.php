<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Build facility</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">					
							<table class="table-striped table-bordered table-condensed ">
									<tr style="font-weight:bold;text-align:center;">
											<td>Build new facility</td>
									</tr>	
									<tr>
										<td>
											<table class="table-striped table-bordered table-condensed ">
												<tr>
												<?php 
												$i = 0;
												//print_r($balance);
												//print_r($infrastructure);
												if (isset($infrastructure)){
													foreach($infrastructure as $string)
													{?><td><table class="table-striped table-bordered table-condensed ">
														<?php 
													
															$string=(array)$infrastructure[$i];
															echo form_open($rsm_base_url.'/infrastructure/build_facility/'.$string['building_level_id']); //Form 4 facility build save
															echo('<input type="hidden" name="Building_level_id" value="'.$string['building_level_id'].'">');
															print('<tr><td>Type:</td><td align=center>'.$string['building_descr'].'</td></tr>');
															print('<tr><td>Level:</td><td align=center>'.$string['building_level'].'</td></tr>');
															echo('<input type="hidden" name="cost" value="'.$string['building_cost'].'">');
															print('<tr><td>Cost:</td><td align=center>'.$string['building_cost'].'</td></tr>');
															print('<tr><td>Days:</td><td align=center>'.$string['build_days'].'</td></tr>');
															if ($balance[0]['rsm_team_balance_current']>$string['building_cost']){
																print('<tr><td colspan=2><p align=\'center\'><button type=\'submit\' name=\'send\'>Build!</button></p></td></tr>');
															}
															else {
																print('<tr><td colspan=2 align=center><b>Not enough money!</b></td></tr>');
															}
															$i++;
															?>
															</table></td>
															<?php 
													}
												}
												else {
													print("Can't build!");
												}
												?>
												</tr>
											</table>
										</td>
									</tr>
								
							</table>
							<?php  		echo form_close(); ?>
						</div>
					</div>
					<!-- /Content -->				

<?php include $rsm['th_path']."/_common/general-footer.php";?>