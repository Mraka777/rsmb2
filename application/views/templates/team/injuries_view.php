<div class="col-sm-9">
  <div class="panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title">Injuries</h3>
  </div>
  <div class="panel-body">

<table class="table-striped table-bordered table-condensed ">
    <tr style="font-weight:bold;text-algin:center;">
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