<?php include $rsm['th_path']."/_common/general-header.php";?>
					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Line Up</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">					
							<?php
								//print_r($race_team_sportsman_list);
									//print_r($race_team_full_list);
									echo form_open($rsm_base_url.'/race/line_up/'); //Form 4 sportsman2race choice
									//print($race_team_sportsman_list[$i]['sportsman_id']);
									?>
									
									<table class="table-striped table-bordered table-condensed">
										<tr style="font-weight:bold;text-align:center;">
												<td>Make your choice for race</td>
										</tr>
									<?php
										for ($i=0;$i<=2;$i++) {
											print("<tr><td><select name=\"".($i+1)."\">");
											
											//print($race_team_sportsman_list[$i]['sportsman_id']);
											
											
											
											foreach ($race_team_full_list as $sportsman_list){
												//$sportsman_list=(array)$race_team_full_list;
												//print("<pre>");
												//print_r($sportsman_list);
												//print("</pre>");
												
												$sportsman_view_data = $sportsman_list->name1 ." ". $sportsman_list->name2 ." OR=".$sportsman_list->overall_rating;
												//print();
												print("<option value=\"".$sportsman_list->sportsman_id."\"");
												if ($race_team_sportsman_list[$i]['sportsman_id'] == $sportsman_list->sportsman_id) {
													print(" selected");
												}
												
												print(">".$sportsman_view_data."</option>");
												
											}
											//print("<option value=\"".$race_team_sportsman_list[$i]['name1']."\">".$sportsman_view_data."</option>");
											
											print("</select></td></tr>");
										}
										//НУЖНО ВСТАВИТЬ ПРОВЕРКУ НА ВЫБОР СПОРТСМЕНОВ
									?>
										<tr>
											 <td><button type='submit' name='send'>Save choice</button></td>
										</tr>
									</table>
									
									<?php 		echo form_close(); ?>
						</div>
					</div>
					<!-- /Content -->				
<?php include $rsm['th_path']."/_common/general-footer.php";?>