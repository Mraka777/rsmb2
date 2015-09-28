<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Build stadium</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">					
							<table class="table-striped table-bordered table-condensed ">
									<tr style="font-weight:bold;text-align:center;">
											<td colspan=2>Build new facility</td>
									</tr>	
							<?php 
							$i = 0;
							//print_r($balance);
							//echo($balance[0]['rsm_team_balance_current']);
							foreach($stadium as $string)
							{?><tr><?php 
							
									$string=(array)$stadium[$i];
									echo form_open($rsm_base_url.'/infrastructure/build_stadium/'.$string['rsm_stadium_building_level_id']); //Form 4 stadium build save
									echo('<input type="hidden" name="building_level_id" value="'.$string['rsm_stadium_building_level_id'].'">');
									print('<tr><td>Type:</td><td align=center>'.$string['stadium_building_description'].'</td></tr>');
									print('<tr><td>Level:</td><td align=center>'.$string['stadium_building_level'].'</td></tr>');
									print('<tr><td>Cost:</td><td align=center>'.(number_format($string['building_cost'], 0, ',', ' ' )).'</td></tr>');
									echo('<input type="hidden" name="cost" value="'.$string['building_cost'].'">');
									print('<tr><td>Days:</td><td align=center>'.$string['stadium_building_build_days'].'</td></tr>');
									if ($balance[0]['rsm_team_balance_current']>$string['building_cost']){
										print('<tr><td colspan=2><p align=\'center\'><button type=\'submit\' name=\'send\'>Build!</button></p></td></tr>');
									}
									else {
										print('<tr><td colspan=2 align=center><b>Not enough money!</b></td></tr>');
									}
									$i++;
									?></tr><?php 
							}
							?>
							</table>
							<?php  		echo form_close(); ?>
						</div>
					</div>
					<!-- /Content -->				

<?php include $rsm['th_path']."/_common/general-footer.php";?>