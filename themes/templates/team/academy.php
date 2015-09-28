<div class="col-sm-9">
  <div class="panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title">Academy</h3>
  </div>
  <div class="panel-body">

<table class="table-striped table-bordered table-condensed ">
    <tr style="font-weight:bold;text-algin:center;">
        <td colspan=14>Players from academy</td>
    </tr>
		<tr>
				<td>Age</td>
				<td>Name</td>
				<td>Stength</td>
				<td>Endurance</td>
				<td>Shoot tech</td>
				<td>Shoot calm</td>
				<td>Shoot acc</td>
				<td>Track tech</td>
				<td>Track spd</td>
				<td>Prof</td>
				<td>Pop</td>
				<td>OR</td>
				<td>Salary</td>
				<td>Days actual</td>
				
		</tr>

<?php 


$i = 0;
//print_r($academy);
foreach($academy as $string)

{?><tr><?php 

	  $string=(array)$academy[$i];
	
		print('<td>'.$string['age'].'</td>');
		print('<td>'.$string['name1'].' '.$string['name2'].'</a></td>');
		print('<td>'.$string['phys_strength'].'</td>');
		print('<td>'.$string['phys_endur'].'</td>');
		print('<td>'.$string['shoot_tech'].'</td>');
		print('<td>'.$string['shoot_calm'].'</td>');
		print('<td>'.$string['shoot_acc'].'</td>');
		print('<td>'.$string['track_tech'].'</td>');
		print('<td>'.$string['track_spd'].'</td>');
		print('<td>'.$string['sportsman_prof'].'</td>');
		print('<td>'.$string['popularity'].'</td>');
		print('<td>'.$string['overall_rating'].'</td>');
		print('<td>'.$string['salary'].'</td>');
		print('<td>'.$string['days_actual'].'</td>');
		
		$i++;
    ?></tr><?php 
}

?>

</table>
	</div>