<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Team Injuries</h1> | 
							<img style="margin-bottom:0.25em;" src="/assets/images/flag/<?php print($user_country['logo']);?>" />
							<strong><?php print($user_country['team_name']);?></strong>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>						
						</div>
						<div class="panel-body">					
						<table class="table-striped table-bordered table-condensed ">
							<tr style="font-weight:bold;text-align:center;">
									<td colspan=5>Injured players  <img src='/images/player/injury.gif' height=16 width=16></td>
							</tr>
							<tr>
									<td>Player</td>
									<td>Injury</td>
									<td>Days left</td>
							</tr>
					
					<?php
					
					
					$i = 0;
					//print_r($team_injury);
					foreach($team_injury as $string)
					
					{?><tr><?php
					
							$string=(array)$team_injury[$i];
						
							print('<td><a href="/player/view/'.$string['sportsman_id'].'">'.$string['name1'].' '.$string['name2'].'</a></td>');
							print('<td>'.$string['description'].'</a></td>');
							print('<td>'.$string['duration'].'</td>');
							$i++;
							?></tr><?php
					}
					
					?>
					
					</table>
						</div>
					</div>
					<!-- /Content -->				
					
<?php include $rsm['th_path']."/_common/general-footer.php";?>