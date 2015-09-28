<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Club Spponsors</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>						
						</div>
						<div class="panel-body">					
										<?php 
										$pop_img_general="/images/pop/".$general_sponsor[0]['rating'].".gif";
										$pop_img_media="/images/pop/".$media_sponsor[0]['rating'].".gif";
										?>
							<div class="row clearfix">
								<div class="col-md-6">
										<!-- General sponsor -->
										<table class="table-striped table-bordered table-condensed "  style="width:100%">
											<tr style="font-weight:bold;text-algin:center;">
												<td colspan=2>General sponsor</td>
											</tr>
											<tr style="font-weight:bold;text-algin:center;">
												<td><?php  echo($general_sponsor[0]['sponsor_name']); ?></td>
												<td>Contract details</td>
											</tr>
											<tr style="font-weight:bold;text-algin:center;">
												<td><img src="<?php  echo($general_sponsor[0]['sponsor_img']);?>"></td>
												<td>Contract daily: <?php  echo(number_format( $general_sponsor[0]['sponsor_daily'], 0, ',', ' ' )); ?><br>Contract total: <?php  echo(number_format( $general_sponsor[0]['sponsor_total'], 0, ',', ' ' )); ?></td>
											</tr>
											<tr style="font-weight:bold;text-align:center;">
												<td colspan=2><?php  rate_stars($rsm['th_url'],$general_sponsor[0]['rating'],1);?></td>
											</tr>
										</table>
								</div>

										<!-- Media sponsor -->
								<div class="col-md-6">
										<table class="table-striped table-bordered table-condensed " style="width:100%">
											<tr style="font-weight:bold;text-algin:center;">
												<td colspan=2>Media sponsor</td>
											</tr>
											<tr style="font-weight:bold;text-algin:center;">
												<td><?php  echo($media_sponsor[0]['sponsor_name']); ?></td>
												<td>Contract details</td>
											</tr>
											<tr style="font-weight:bold;text-algin:center;">
												<td><img src="<?php  echo($media_sponsor[0]['sponsor_img']);?>"></td>
												<td>Contract daily: <?php  echo(number_format( $media_sponsor[0]['sponsor_daily'], 0, ',', ' ' )); ?><br>Contract total: <?php  echo(number_format( $media_sponsor[0]['sponsor_total'], 0, ',', ' ' )); ?></td>
											</tr>
											<tr style="font-weight:bold;text-align:center;">
												<td colspan=2><?php  rate_stars($rsm['th_url'],$media_sponsor[0]['rating'],1);?></td>
											</tr>
										</table>
								</div>
							</div>
			
						</div>
					</div>
					<!-- /Content -->				

<?php include $rsm['th_path']."/_common/general-footer.php";?>