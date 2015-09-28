<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Credit Offers</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">					
							<table class="table-striped table-bordered table-condensed">
								<tr style="font-weight:bold;text-align:center;">
										<td colspan=2>Credit offers</td>
								</tr>	
						
								</tr>
								<tr><td>
								<table class="table-striped table-bordered table-condensed">
									<tr>
								<?php 
								
								$i = 0;
								//print_r($club_info);
								foreach($club_credit as $string)
								{?><?php 
								
										$string=(array)$club_credit[$i];
										print("<td>");
											$form_path = $rsm_base_url."/office/credit/";
											echo form_open($form_path); //Form 4 stadium build save 
											print("<table class=\"table-striped table-bordered table-condensed\">");
											print('<tr><td>Sum</td><td>'.$string['credit_sum'].'</td></tr>');
											print('<tr><td>Interest rate</td><td>'.$string['interest'].'%</td></tr>');
											print('<tr><td>Term</td><td>'.$string['credit_term'].'</td></tr>');
											print('<tr><td>Weekly</td><td>'.$string['weekly'].'</td></tr>');
											print("<input type='hidden' name='credit' value='".$string['rsm_team_credit_offer_id']."'>");
											print('<tr><td colspan=2 align=center><button type=\'submit\' name=\'borrow\' value=\'1\'>Borrow</button></td></tr>');
											print("</table>");
											
											echo form_close();
										print("</td>");
										
										$i++;
										?><?php 
								}
								
								?></tr>
								</table>
								</td></tr>
							</table>
						</div>
					</div>
					<!-- /Content -->				

<?php include $rsm['th_path']."/_common/general-footer.php";?>