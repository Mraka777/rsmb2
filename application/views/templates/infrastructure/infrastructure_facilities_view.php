<div class="col-sm-9">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo('<b>Infrastructure</b>');?></a></h3>
            </div>
            <div class="panel-body">

<table class="table-striped table-bordered table-condensed ">
    <tr style="font-weight:bold;text-algin:center;">
        <td colspan=12>Infrastructure MENU</td>
    </tr>	
    <tr style="font-weight:bold;text-align:center;">
        <td>Facility Name</td>
        <td>Facility Level</td>
				<td>Facility Level Name</td>
				<td>Next level</td>
				<td>Demolish</td>
				<td>Days left</td>
				<td>Maintenance</td>
    </tr>

<?php 
$i = 0;
//print_r($infrastructure);
foreach($infrastructure as $string)
{?><tr><?php 

	  $string=(array)$infrastructure[$i];

    print('<td align=center>'.$string['namef_en'].'</td>');
		print('<td align=center>'.$string['building_level'].'</td>');
		print('<td align=center>'.$string['building_descr'].'</td>');
		if (($string['days_next']) > 0) { //can't build under construction
			print('<td align=center>Build</td>');
		}
		else print('<td align=center><a href="/infrastructure/build_facility/'.($string['building_id']).'">Build</a></td>');
		if (($string['building_level']) == 1) { //can't demolish level 1 
			print('<td align=center>X</td>');
		}
		else print('<td align=center><a href="">X</a></td>');
		
		print('<td align=center>'.$string['days_next'].'</td>');
		print('<td align=center>'.$string['maintenance_cost'].'</td>');
    $i++;
    ?></tr><?php 
}

//$array = (array)$query[0];
//print($array['name1']);
//print($array['name2']);
//print_r($array);

?>
  
</table> 