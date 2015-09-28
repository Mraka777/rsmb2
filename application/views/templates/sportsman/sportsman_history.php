<div class="col-sm-9">
  <div class="panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title"><?php echo('<b>'.$history[0]['name1'].' '.$history[0]['name2'].'</b>, ID='.$history[0]['sportsman_id']);?></h3>
  </div>
  <div class="panel-body">
<?php  print($menu); ?>
<table class="table-striped table-bordered table-condensed ">
    <tr style="font-weight:bold;text-algin:center;">
        <td colspan=6>Player history</td>
    </tr>
		<tr>
				<td>#</td>
				<td>Player</td>
				<td>Team</td>
				<td>GameDate</td>
				<td>RealDate</td>
		</tr>

<?php 


$i = 0;
//print("<pre>");

//print("</pre>");
foreach($history as $string)

{?><tr><?php 

	  $string=(array)$history[$i];
		
		print('<td>'.($i+1).'</td>');
		print('<td>'.$string['name1'].' '.$string['name2'].'</td>');
    print('<td>'.$string['description'].'</td>');
		print('<td>'.$string['season'].'.'.$string['day'].'</td>');
		print('<td>'.$string['real_date'].'</td>');
		//print('<td><a href="/player/view/'.$string['sportsman_id'].'">'.$string['name1'].' '.$string['name2'].'</a></td>');
		//print('<td><a href="/team/view/'.$string['team_id'].'">'.$string['team_name'].'</a></td>');
		//print('<td>'.$string['progress'].'%</td>');
		$i++;
    ?></tr><?php 
}

?>

</table>
	</div>