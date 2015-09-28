  <div class="row clearfix">
    <!-- Sportsman History -->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading" style="font-weight:bold;text-transform:uppercase;text-align:center;">Latest movements:</div>
        <table class="table table-condensed  table-bordered table-striped">
          <tr> <th class="bg-info" style="text-align:center;font-weight:bold;">#</th><th class="bg-info" style="text-align:center;font-weight:bold;">Player</th><th class="bg-info" style="text-align:center;font-weight:bold;">Action</th><th class="bg-info" style="text-align:center;font-weight:bold;">GameDate</th><th class="bg-info" style="text-align:center;font-weight:bold;">RealDate</th></tr>
<?php 
$i = 0;
foreach($history as $string)
{?><tr><?php 
	  $string=(array)$history[$i];
		print('<td align="center">'.($i+1).'</td>');
		print('<td align="center">'.$string['name1'].' '.$string['name2'].'</td>');
    print('<td align="center">'.$string['description'].'</td>');
		print('<td align="center">'.$string['season'].'.'.$string['day'].'</td>');
		print('<td align="center">'.$string['real_date'].'</td>');
		$i++;
    ?></tr><?php 
}
?>
        </table>
      </div>
    </div>
    

  </div>