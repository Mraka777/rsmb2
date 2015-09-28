<?php include $rsm['th_path']."/_common/general-header.php";?>
<?php
	$train_arr=array('Nothing','Ph. Strength','Ph. Endurance', 'Sh. Technic', 'Sh. Calm', 'Sh. Accuracy', 'Ski Technic', 'Ski Speed');
?>
					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Team Training</h1> | 
							<img style="margin-bottom:0.25em;" src="/assets/images/flag/<?php print($user_country['logo']);?>" />
							<strong><?php print($user_country['team_name']);?></strong>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">
							<?php  echo form_open($rsm_base_url.'/team/training/'); //Form 4 training save?>
								<p align="right"><button type='submit' name='send' class='btn btn-success btn-sm'>Save practice</button></p>
								<table class="table-striped table-bordered table-condensed table-training" style="width:100%;margin-bottom:10px;">
									<thead style="background-color:#F5F5F5">
										<tr>
											<th rowspan="2">Name</th>
											<th rowspan="2">Age</th>
											<th rowspan="2">Sco</th>
											<th rowspan="2">Pro</th>
											<th colspan="2">Physical</th>
											<th colspan="2">Ski</th>
											<th colspan="3">Shooting</th>
											<th rowspan="2">Last</th>
											<th rowspan="2">Train</th>
										</tr>
	
										<tr>
											<!-- Skills -->
											<th>Str</th>
											<th>End</th>
											
											<th>Spd</th>
											<th>Tec</th>
											
											<th>Acc</th>
											<th>Tec</th>
											<th>Clm</th>
										</tr>
									</thead>
									
									<tbody>
										<tr></tr>
										</tr>
									<?php foreach($team_practice as $sman) : ?>
										<tr>
											<!-- Country link&Flag Icon + Surmane, Firstname + Sportsman Link -->
											<td style="text-align:left;">
												<a href="" title="<?php echo $sman['nameb_en'];?>"><img class="flag" src="/assets/images/flag/<?php echo $sman['logo'];?>" title="<?php echo $sman['nameb_en'];?>" /></a>
												<a href="/<?php echo($rsm_base_url); ?>/player/view/<?php echo $sman['sportsman_id'];?>" title="<?php echo $sman['name1']." ".$sman['name2'];?>"><?php echo $sman['name2'];?>, <?php echo $sman['name1'];?></a>
											</td>
											<!-- Age -->
											<td><?php echo $sman['age'];?></td>
											<td><?php if ($sman['status'] == '1') {?>
											<img src="/assets/images/clipart/yes-icon.png" />
											<?php } else { ?>
											<img src="/assets/images/clipart/no-icon.png" />
											<?php }?>
											</td>
											<td><?php echo $sman['sportsman_prof'];?></td>
											
											<!-- Skills -->
											<td><?php echo $sman['phys_strength'];?><sup style="color:<?php echo $sman['phys_strength_mvu_color'];?>"><?php echo $sman['phys_strength_mvu'];?></sup></td>
											<td><?php echo $sman['phys_endur'];?><sup style="color:<?php echo $sman['phys_endur_mvu_color'];?>"><?php echo $sman['phys_endur_mvu'];?></sup></td>
											<td><?php echo $sman['track_spd'];?><sup style="color:<?php echo $sman['track_speed_mvu_color'];?>"><?php echo $sman['track_speed_mvu'];?></sup></td>
											<td><?php echo $sman['track_tech'];?><sup style="color:<?php echo $sman['track_tech_mvu_color'];?>"><?php echo $sman['track_tech_mvu'];?></sup></td>
											<td><?php echo $sman['shoot_acc'];?><sup style="color:<?php echo $sman['shoot_acc_mvu_color'];?>"><?php echo $sman['shoot_acc_mvu'];?></sup></td>
											<td><?php echo $sman['shoot_tech'];?><sup style="color:<?php echo $sman['shoot_tech_mvu_color'];?>"><?php echo $sman['shoot_tech_mvu'];?></sup></td>
											<td><?php echo $sman['shoot_calm'];?><sup style="color:<?php echo $sman['shoot_calm_mvu_color'];?>"><?php echo $sman['shoot_calm_mvu'];?></sup></td>
											<td><a href="/<?php echo($rsm_base_url);?>/player/view/<?php echo $sman['sportsman_id'];?>#training"><?php echo $sman['last_training'];?></a></td>
											<td>
												<select name="<?php echo $sman['sportsman_id'];?>" class="form-control">
													<?php foreach($train_arr as $key=>$value) : ?>
													<option <?php if($key==intval($sman['rsm_sportsman_training_type_id'])){?>selected="selected"<?}?> value="<?php echo $key;?>"><?php echo $value;?></option>
													<?php endforeach;?>
												</select>
											</td>
										</tr>
									<?php endforeach;?>
									</tbody>
								</table>
								<p style="float:right;"><button type='submit' name='send' class='btn btn-success btn-sm'>Save training</button></p>
								</form>
								<p>
									<strong>Legend:</strong>
									
								</p>
						</div> <!-- /.panel-body -->
					</div>					
					<!-- /Content -->
					
<?php include $rsm['th_path']."/_common/general-footer.php";?>
