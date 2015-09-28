<div class="col-sm-9">
  <div class="panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title">Team finance</h3>
  </div>
  <div class="panel-body">

<table class="table-striped table-bordered table-condensed ">
    <tr style="font-weight:bold;text-align:center;">
        <td>Income</td>
				<td>Today</td>
				<td>Yesterday</td>
				<td>Week</td>
				<td>Season</td>
    </tr>	

    </tr>

<?php 
$i = 0;

for ($i=0; $i<=15; $i++){
	$today_fin[$i] = 0;
	$yesterday_fin[$i] = 0;
	$week_fin[$i] = 0;
	$season_fin[$i] = 0;
}


//print("<pre>");
//print_r($week_transactions);
//print("</pre>");
//today
foreach ($today_transactions as $today_data) {
	//echo($today_data['transaction_type']);
	$today_fin[$today_data['transaction_type']]=$today_data['transaction_sum'];
}
$today_income_total=$today_fin[1]+$today_fin[2]+$today_fin[3]+$today_fin[4]+$today_fin[5]+$today_fin[6]+$today_fin[7];
$today_expenses_total=$today_fin[8]+$today_fin[9]+$today_fin[10]+$today_fin[11]+$today_fin[12]+$today_fin[13]+$today_fin[14]+$today_fin[15];
$today_total=$today_income_total-$today_expenses_total;
//yesterday
if (isset($yesterday_transactions)){
	foreach ($yesterday_transactions as $yesterday_data) {
		//echo($yesterday_data['transaction_type']);
		$yesterday_fin[$yesterday_data['transaction_type']]=$yesterday_data['transaction_sum'];
	}
	
}
$yesterday_income_total=$yesterday_fin[1]+$yesterday_fin[2]+$yesterday_fin[3]+$yesterday_fin[4]+$yesterday_fin[5]+$yesterday_fin[6]+$yesterday_fin[7];
	$yesterday_expenses_total=$yesterday_fin[8]+$yesterday_fin[9]+$yesterday_fin[10]+$yesterday_fin[11]+$yesterday_fin[12]+$yesterday_fin[13]+$yesterday_fin[14]+$yesterday_fin[15];
	$yesterday_total=$yesterday_income_total-$yesterday_expenses_total;
	
//week	
if (isset($week_transactions)){
	foreach ($week_transactions as $week_data) {
		//echo($week_data['transaction_type']);
		$week_fin[$week_data['transaction_type']]=$week_data['transaction_sum'];
	}
	
}
$week_income_total=$week_fin[1]+$week_fin[2]+$week_fin[3]+$week_fin[4]+$week_fin[5]+$week_fin[6]+$week_fin[7];
	$week_expenses_total=$week_fin[8]+$week_fin[9]+$week_fin[10]+$week_fin[11]+$week_fin[12]+$week_fin[13]+$week_fin[14]+$week_fin[15];
	$week_total=$week_income_total-$week_expenses_total;
	

//season
if (isset($season_transactions)){
	foreach ($season_transactions as $season_data) {
		//echo($season_data['transaction_type']);
		$season_fin[$season_data['transaction_type']]=$season_data['transaction_sum'];
	}
	
}
$season_income_total=$season_fin[1]+$season_fin[2]+$season_fin[3]+$season_fin[4]+$season_fin[5]+$season_fin[6]+$season_fin[7];
	$season_expenses_total=$season_fin[8]+$season_fin[9]+$season_fin[10]+$season_fin[11]+$season_fin[12]+$season_fin[13]+$season_fin[14]+$season_fin[15];
	$season_total=$season_income_total-$season_expenses_total;
	




$i=0;$j=0;
for ($i=0; $i<=6; $i++){
?><tr style="text-align:center;"><?php 
		print('<td align="left">'.$finance_types[$i]['rsm_team_balance_operation_description'].'</td>');
		print('<td>'.(number_format($today_fin[$i+1], 0, ',', ' ' )).'</td>');
		print('<td>'.(number_format($yesterday_fin[$i+1], 0, ',', ' ' )).'</td>');
		print('<td>'.(number_format($week_fin[$i+1], 0, ',', ' ' )).'</td>');
		print('<td>'.(number_format($season_fin[$i+1], 0, ',', ' ' )).'</td>');


    ?></tr>
		<?php 
}

?>
    <tr style="font-weight:bold;text-align:center;">
        <td>Total</td>
				<td><?php  echo(number_format($today_income_total, 0, ',', ' ' ));?></td>
				<td><?php  echo(number_format($yesterday_income_total, 0, ',', ' ' ));?></td>
				<td><?php  echo(number_format($week_income_total, 0, ',', ' ' ));?></td>
				<td><?php  echo(number_format($season_income_total, 0, ',', ' ' ));?></td>
    </tr>	
    <tr style="font-weight:bold;text-align:center;">
        <td>Expenses</td>
				<td>Today</td>
				<td>Yesterday</td>
				<td>Week</td>
				<td>Season</td>
    </tr>	

<?php 
//echo("i=".$i."<br>");
for ($j=$i; $j<=($i+7); $j++){
?><tr style="text-align:center;"><?php 
		print('<td align="left">'.$finance_types[$j]['rsm_team_balance_operation_description'].'</td>');
		print('<td>'.(number_format($today_fin[$j+1], 0, ',', ' ' )).'</td>');
		print('<td>'.(number_format($yesterday_fin[$j+1], 0, ',', ' ' )).'</td>');
		print('<td>'.(number_format($week_fin[$j+1], 0, ',', ' ' )).'</td>');
		print('<td>'.(number_format($season_fin[$j+1], 0, ',', ' ' )).'</td>');


    ?></tr>
		<?php 
}
?>
    <tr style="font-weight:bold;text-align:center;">
        <td>Total</td>
				<td><?php  echo(number_format($today_expenses_total, 0, ',', ' ' ));?></td>
				<td><?php  echo(number_format($yesterday_expenses_total, 0, ',', ' ' ));?></td>
				<td><?php  echo(number_format($week_expenses_total, 0, ',', ' ' ));?></td>
				<td><?php  echo(number_format($season_expenses_total, 0, ',', ' ' ));?></td>
    </tr>	
    <tr style="font-weight:bold;text-align:center;">
        <td>Profit / loss</td>
				<td><?php  echo(number_format($today_total, 0, ',', ' ' ));?></td>
				<td><?php  echo(number_format($yesterday_total, 0, ',', ' ' ));?></td>
				<td><?php  echo(number_format($week_total, 0, ',', ' ' ));?></td>
				<td><?php  echo(number_format($season_total, 0, ',', ' ' ));?></td>
    </tr>
</table>

	</div>