<div class="col-sm-9">
  <div class="panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title">Team transactions</h3>
  </div>
  <div class="panel-body">

<table class="table-striped table-bordered table-condensed ">
    <tr style="font-weight:bold;text-align:center;">
        <td>#</td>
				<td>Date</td>
				<td>Description</td>
				<td>Sum</td>
    </tr>	
<?php 
$i = 0;



//print("<pre>");
//print_r($transactions);
//print("</pre>");
//today
$i=1;
foreach ($transactions as $data) {
	$day = $data['transaction_day'];
	$time = $data['transaction_time'];
	$descr = $data['rsm_team_balance_operation_description'];
	$sum = $data['transaction_sum'];
	if ($data['rsm_team_balance_operation_id']>=8) {
		$sum = (-1) * $sum;
	}
//	$today_fin[$today_data['transaction_type']]=$today_data['transaction_sum'];
	print("<tr>");
	print("<td align=center>".$i."</td>");
	print("<td>Day ".$day."</td>");
	print("<td>".$descr."</td>");
	print("<td>".(number_format($sum, 0, ',', ' ' ))."</td>");
	print("</tr>");
	$i++;
}
	


?>

</table>

	</div>