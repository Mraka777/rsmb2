<?php include $rsm['th_path']."/_common/general-header.php";?>
					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Infrastructure overview</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">					
							<table class="table-striped table-bordered table-condensed ">
									<tr style="font-weight:bold;text-align:center;">
											<td colspan=12>Infrastructure MENU</td>
									</tr>	
									<tr style="font-weight:bold;text-align:center;">
											<td><a href="/<?php echo($rsm_base_url);?>/infrastructure/facilities/">Overview Facilities</a></td>
											<td><a href="/<?php echo($rsm_base_url);?>/infrastructure/stadium/">Overview Stadium</a></td>
									</tr>
									<tr style="font-weight:bold;text-align:center;">
											<td><a href="/<?php echo($rsm_base_url);?>/infrastructure/facilities/"><!-- <img src="/images/track/infrastructure_facilities_view.jpg"> --></a></td>
											<td><a href="/<?php echo($rsm_base_url);?>/infrastructure/stadium/"><!-- <img src="/images/track/infrastructure_stadium_view.jpg"> --></a></td>
									</tr>
							
								
							</table> 
						</div>
					</div>
					<!-- /Content -->				

<?php include $rsm['th_path']."/_common/general-footer.php";?>