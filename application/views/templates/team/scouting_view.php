<div class="col-sm-9">
  <div class="panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title">Scouting</h3>
  </div>
  <div class="panel-body">

<table class="table-striped table-bordered table-condensed ">
    <tr style="font-weight:bold;text-algin:center;">
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