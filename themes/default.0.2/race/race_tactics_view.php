<?php include $rsm['th_path']."/_common/general-header.php";?>
<!-- Changed Race Tactics -->
					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Tactics</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">					
							<?php
								//print_r($race_team_sportsman_list);
									//print_r($race_info);
									//$hidden = array('race_id' => $race_info[0]['race_id']);
									echo form_open($rsm_base_url.'/race/tactics/'); //Form 4 sportsman2race choice
									
									//print($race_team_sportsman_list[$i]['sportsman_id']);
									?>
									<input type="hidden" name="raceid" value="<?php echo($race_info[0]['race_id']);?>">
									<table class="table-striped table-bordered table-condensed">
										<tr style="font-weight:bold;text-align:center;">
												<td colspan=5>Make your choice for tactics</td>
										</tr>
										<tr style="font-weight:bold;text-align:center;">
												<td colspan=>Sportsman</td>
												<td colspan=>Importance</td>
												<td colspan=>Ski plain</td>
												<td colspan=>Ski hill</td>
												<td colspan=>Shooting</td>
										</tr>
										<?php
										//print("<pre>");
										//print_r($race_tactics_types);
										//print("</pre>");
										//print("<pre>");
										//print_r($race_team_sportsman_tactics);
										//print("</pre>");
										$i=0;
										foreach ($race_team_sportsman_list as $sportsman) {
											print("<tr>");
											//importance TD
											print("<td>".$sportsman['name1']." ".$sportsman['name2']."</td>");
											print("<td>");
											print("<select name=\"i_".$sportsman['sportsman_id']."\">");
											foreach ($race_tactics_types as $cur_tactics) {
												if ($cur_tactics['tactics_option'] == '1') { //1 = IMPORTANCE
													print("<option value=\"".$cur_tactics['rsm_race_sportsman_tactics_types_id']."\"");
													//print("sp tact==".$race_team_sportsman_tactics[$i]['rsm_race_sportsman_tactics_importance']."avial  === ".$cur_tactics['rsm_race_sportsman_tactics_types_id']."<BR>");
													if ($race_team_sportsman_tactics[$i]['rsm_race_sportsman_tactics_importance'] == $cur_tactics['rsm_race_sportsman_tactics_types_id']) {
														print(" selected");
													}
													print(">".$cur_tactics['tactics_descr']."</option>");
												}
											}
											print("</select>");	
											print("</td>");
											//SKI PLANE TD
											print("<td>");
											print("<select name=\"sp_".$sportsman['sportsman_id']."\">");
											foreach ($race_tactics_types as $cur_tactics) {
												if ($cur_tactics['tactics_option'] == '2') { //1 = IMPORTANCE
													print("<option value=\"".$cur_tactics['rsm_race_sportsman_tactics_types_id']."\"");
													//print("sp tact==".$race_team_sportsman_tactics[$i]['rsm_race_sportsman_tactics_importance']."avial  === ".$cur_tactics['rsm_race_sportsman_tactics_types_id']."<BR>");
													if ($race_team_sportsman_tactics[$i]['rsm_race_sportsman_tactics_ski_plain'] == $cur_tactics['rsm_race_sportsman_tactics_types_id']) {
														print(" selected");
													}
													print(">".$cur_tactics['tactics_descr']."</option>");
												}
											}
											print("</select>");	
											print("</td>");
											//SKI HILL TD
											print("<td>");
											print("<select name=\"sh_".$sportsman['sportsman_id']."\">");
											foreach ($race_tactics_types as $cur_tactics) {
												if ($cur_tactics['tactics_option'] == '3') { //1 = IMPORTANCE
													print("<option value=\"".$cur_tactics['rsm_race_sportsman_tactics_types_id']."\"");
													//print("sp tact==".$race_team_sportsman_tactics[$i]['rsm_race_sportsman_tactics_importance']."avial  === ".$cur_tactics['rsm_race_sportsman_tactics_types_id']."<BR>");
													if ($race_team_sportsman_tactics[$i]['rsm_race_sportsman_tactics_ski_hill'] == $cur_tactics['rsm_race_sportsman_tactics_types_id']) {
														print(" selected");
													}
													print(">".$cur_tactics['tactics_descr']."</option>");
												}
											}
											print("</select>");	
											print("</td>");	
											//SHOOTING TD
											print("<td>");
											print("<select name=\"s_".$sportsman['sportsman_id']."\">");
											foreach ($race_tactics_types as $cur_tactics) {
												if ($cur_tactics['tactics_option'] == '4') { //1 = IMPORTANCE
													print("<option value=\"".$cur_tactics['rsm_race_sportsman_tactics_types_id']."\"");
													//print("sp tact==".$race_team_sportsman_tactics[$i]['rsm_race_sportsman_tactics_importance']."avial  === ".$cur_tactics['rsm_race_sportsman_tactics_types_id']."<BR>");
													if ($race_team_sportsman_tactics[$i]['rsm_race_sportsman_tactics_shooting'] == $cur_tactics['rsm_race_sportsman_tactics_types_id']) {
														print(" selected");
													}
													print(">".$cur_tactics['tactics_descr']."</option>");
												}
											}
											print("</select>");	
											print("</td>");	
											
											print("</tr>");
											$i++;
										}
										
										
										?>
										
										<tr>
											 <td colspan=5><button type='submit' name='send'>Save choice</button></td>
										</tr>
									</table>
						</div>
					</div>
					<!-- /Content -->				
					</div>
					<!-- /SubNav and Content -->

				</div>
				<!-- MAIN CONTENT .content-main -->

   </div>
			<!-- /THEME SHOWCASE -->

			<!-- FOOTER -->
   <footer class="footer">
				<div class="container"> <?php include "$th_path/_common/footer.php";?>	</div>
   </footer>
			<!-- /FOOTER -->
 
 
   <!-- Bootstrap core JavaScript
   ================================================== -->
   <!-- Placed at the end of the document so the pages load faster -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   <script src="<?php echo $bs_path;?>/js/bootstrap.min.js"></script>
   <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  
 </body>
</html>