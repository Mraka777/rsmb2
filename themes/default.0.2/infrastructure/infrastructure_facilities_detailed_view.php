<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Facility info</h1> 
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">
						<?php
							print("<pre>");
							print_r($facility_detailed);
							print("</pre>");
						?>
						</div>
					</div>							
							
					<!-- /Content -->			

<?php include $rsm['th_path']."/_common/general-footer.php";?>