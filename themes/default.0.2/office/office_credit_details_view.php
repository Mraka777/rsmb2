<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Credit Details</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>						
						</div>
						<div class="panel-body">					
							<table class="table-striped table-bordered table-condensed">
									<tr style="font-weight:bold;text-align:center;">
											<td colspan=2>Current loan</td>
									</tr>	
							
									</tr>
									<tr><td>
									<table class="table-striped table-bordered table-condensed">
										<tr>
									<?php 
									
									$i = 0;
									//print_r($club_info);
									foreach($current_credit as $string)
									{?><?php 
											echo form_open("".$rsm_base_url."/office/credit_repay/");
											$string=(array)$current_credit[$i];
											print("<td>");
												print("<table class=\"table-striped table-bordered table-condensed\">");
												print('<tr><td>Sum</td><td>'.$string['credit_sum'].'</td></tr>');
												print('<tr><td>Interest rate</td><td>'.$string['interest'].'%</td></tr>');
												print('<tr><td>Term</td><td>'.$string['credit_term'].' Weeks</td></tr>');
												print('<tr><td>Weekly</td><td>'.$string['weekly'].'</td></tr>');
												print('<tr><td>Paid</td><td>'.$string['paid'].'</td></tr>');
												print('<tr><td>Weeks left</td><td>'.$string['weeks_left'].'</td></tr>');
												print('<tr><td>Credit repay sum</td><td>'.($string['credit_sum']-$string['paid']).'</td></tr>');
												print('<tr><td colspan=2><input type=\'submit\' value=\'Repay\'></td></tr>');
												print("</table>");
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