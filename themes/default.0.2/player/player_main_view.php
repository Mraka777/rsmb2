<?php include $rsm['th_path']."/_common/general-header.php";?>
<?php

/*
!!!!Нужно добавить:

Информацию стране команды в которой сейчас игрок (флаг, название)
Информацию о стране лиги-дивизиона команды в которой сейчас игрок (флаг, название)
Информацию о лиге-дивизионе команды в которой сейчас игрок (лига, дивизион)
*/
$sman=$player[0];
?>
					<script>
						$(document).ready(function () {
						var url = document.location.toString();
						//alert(url);
						if (url.match('#')) {
							//alert(url.split('#')[1]);
							$('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
						}
						});
						// Change hash for page-reload
						$('.nav-tabs a').on('shown', function (e) {
								window.location.hash = e.target.hash.replace("#", "#" + prefix);
						});
					</script>
					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<a href=""><img style="height:16px;" src="/assets/images/player/scout.gif" title = "<?php echo ucfirst(strtolower($lng['scout_player']));?>" /></a> 
							<img style="margin-bottom:0.25em;" src="/assets/images/flag/<?php echo $sman['logo'];?>" /> 
							<strong><a href=""><?php echo $sman['name1']." ".$sman['name2'];?></a> </strong>
							| <strong>Age:</strong> <?php echo $sman['age'];?> 
							| <strong>ID:</strong> <?php echo $sman['sportsman_id'];?> 
							| <strong><?php echo $lng['or'];?>:</strong> <?php echo $sman['overall_rating'];?>
							| <strong><?php echo ucfirst(strtolower($lng['team']));?>:</strong> <img style="margin-bottom:0.25em;" src="/assets/images/flag/<?php echo $sman['logo'];?>" /> <?php echo $sman['team_name'];?>
							
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						
						<div class="panel-body">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">Overview</a></li>
								<li role="presentation"><a href="#stat" aria-controls="stat" role="tab" data-toggle="tab">Statistic</a></li>
								<li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab">History</a></li>
								<li role="presentation"><a href="#training" aria-controls="training" role="tab" data-toggle="tab">Training</a></li>
								<li role="presentation"><a href="#transfers" aria-controls="training" role="tab" data-toggle="tab">Transfers</a></li>
							</ul>
						
							<!-- Tab panes -->
							<div class="tab-content" style="padding-top:10px;">
								
								<div role="tabpanel" class="tab-pane active" id="overview"> <?php include "player_overview_view.php";?> </div>
								<div role="tabpanel" class="tab-pane" id="stat"></div>
								<div role="tabpanel" class="tab-pane" id="history"> <?php include "player_history_view.php";?> </div>
								<div role="tabpanel" class="tab-pane" id="training"> <?php include "player_training_view.php";?> </div>
								<div role="tabpanel" class="tab-pane" id="transfers"> <?php include "player_transfers_view.php";?> </div>
							</div>

							<pre><?php print_r($player);?></pre>
						</div>					
					</div>
					<!-- /Content -->				
				</div>
				<!-- /SubNav and Content -->
				
<?php include $rsm['th_path']."/_common/general-footer.php";?>