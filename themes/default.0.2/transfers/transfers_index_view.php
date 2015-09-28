<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Transfers</h1> | 
							<img style="margin-bottom:0.25em;" src="/assets/images/flag/<?php print($user_country['logo']);?>" />
							<strong><?php print($user_country['team_name']);?></strong>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>						
						</div>
						<div class="panel-body">
							<table class="table-bordered table-condensed" style="width:100%;text-align:center;margin:0px;">
								<tr>
									<th>Name</td>
									<th>Sum</td>
									<th>OR</td>
									<th>End date</td>
									<th>Time left</td>
								</tr>
							<?php
							print_r($player_transfer_list);
							foreach ($player_transfer_list as $sportsman) {
								$date1 = date_create($sportsman['datetime_end']);
								$date2 = date_create(date("Y-m-d H:i:s"));
								$interval = date_diff($date1, $date2);
								$dif_days = $interval->d;
								$dif_hours = $interval->h;
								$dif_min = $interval->i;
								$dif_sec = $interval->s;
								$dif_total_hours = $dif_days * 24 + $dif_hours;
								$date_dif = $dif_total_hours.":".$dif_min.":".$dif_sec;
								$date_dif_sec = $dif_total_hours*60*60+$dif_min*60+$dif_sec;
								
								?>
								<tr><td><a href="/<?php echo($language_link);?>/player/view/<?php echo($sportsman['sportsman_id']);?>#transfers"><?php echo($sportsman['name1']." ".$sportsman['name2']);?></a></td><td><?php echo($sportsman['sportsman_transfer_starter_price']);?></td>
									<td><?php echo($sportsman['overall_rating']);?></td>
									<td><?php echo($sportsman['datetime_end']);?></td>
									<td>
										<span id='deadline_<?php echo($sportsman['rsm_sportsman_transfer_list_id']);?>'><?php print($date_dif);?></span>
										<input type='hidden' value='<?php echo($date_dif_sec);?>' id='transfer_<?php echo($sportsman['rsm_sportsman_transfer_list_id']);?>'>
										<script>
											runSeconds('transfer_<?php echo($sportsman['rsm_sportsman_transfer_list_id']);?>', 'deadline_<?php echo($sportsman['rsm_sportsman_transfer_list_id']);?>', "Time end!");
										</script>
									</td></tr>
								<?php 
							}
							?>
							</table>
						</div> <!-- /.panel-body -->
					</div>	
					<!-- /Content -->			
				</div>
				<!-- /SubNav and Content -->
					
<?php include $rsm['th_path']."/_common/general-footer.php";?>