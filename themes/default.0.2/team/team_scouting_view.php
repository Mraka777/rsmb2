<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Scouting</h1> | 
							<img style="margin-bottom:0.25em;" src="/assets/images/flag/<?php print($user_country['logo']);?>" />
							<strong><?php print($user_country['team_name']);?></strong>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>						
						</div>
						<div class="panel-body">					
						<table class="table-striped table-bordered table-condensed ">
								<tr style="font-weight:bold;text-align:center;">
										<td colspan=5>Scoute progress</td>
								</tr>
								<tr>
										<td>#</td>
										<td>Player</td>
										<td>Team</td>
										<td>Progress</td>
								</tr>
						
						<?php 
						
						
						$i = 0;
						//print_r($team_scouting);
						foreach($team_scouting as $string)
						
						{?><tr><?php 
						
								$string=(array)$team_scouting[$i];
							
								print('<td>'.$string['order'].'</td>');
								print('<td><a href="/player/view/'.$string['sportsman_id'].'">'.$string['name1'].' '.$string['name2'].'</a></td>');
								print('<td><a href="/team/view/'.$string['team_id'].'">'.$string['team_name'].'</a></td>');
								print('<td>'.$string['progress'].'%</td>');
								$i++;
								?></tr><?php 
						}
						
						?>
						
						</table>
						</div>
					</div>
					<!-- /Content -->				
					
<?php include $rsm['th_path']."/_common/general-footer.php";?>