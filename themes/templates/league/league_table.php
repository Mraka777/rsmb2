<div class="col-sm-9">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?php echo('<b>League Table</b>');?></a></h3>
    </div>
    <div class="panel-body" >
<?php 
//print('<pre>');
//print_r($league_lvl);
//print('</pre>');
?>
<?php  //echo form_open('/league/'); //Form 4 league ?>
<form action="http://biathlon-manager.com/league/view/" method="post" accept-charset="utf-8">
<?php 
//print_r($league);
$leag_data['country_id']=$league[0]['country_id'];
$leag_data['league_lvl']=$league[0]['league_lvl'];
$leag_data['league_num']=$league[0]['league_num'];
//print_r($leag_data);
?>
<script>
$c_country = <?php  echo $league[0]['country_id'] ?>;
$c_lvl = <?php  echo $league[0]['league_lvl'] ?>;
$c_num = <?php  echo $league[0]['league_num'] ?>;

 	$link="/ajax/get_league/" + $c_country + "/" + $c_lvl;
	//alert($link);
	//$("form#form_league").empty();
	$(document).ready(function () {
		$.get($link, function(data){
			//alert("Data Loaded: " + data);
			$string = "<select name=\"num\" >" + "<option value=1>1" + "</option>";
			if (data > 1) {
				//alert('13');
				for (var count = 2; count <= data; count++) {
				
				if ($c_num == count) {
					//alert($c_num);
					$string2 = "<option value=" + count +" selected>" + count +"</option>";
				}
				else {
					$string2 = "<option value=" + count + ">" + count +"</option>";
				}
				$string = $string + $string2;
				}
				
			}
			$("div#league_num").append($string);
			
			$string = "<select id=lvl name=\"lvl\" onchange=\"change_lvl()\">";
			for (var count = 1; count <= 3; count++) {
				
				if ($c_lvl == count) {
					$string2 = "<option value=\"" + count + "\" selected>" + count + "</option>";
				}
				else {
					$string2 = "<option value=\"" + count + "\">" + count + "</option>";
				}
				
				$string = $string + $string2;
			}
			$("div#league_lvl").append($string);
		});
	});
	
function change_lvl() {
	$link="/ajax/get_league/" + $c_country + "/" + $( "#lvl option:selected" ).text();
	$sel_lvl = $( "#lvl option:selected" ).text();
	//alert($sel_lvl);
$.get($link, function(data){
			//alert("Data Loaded: " + data);
			$string = "<select name=\"num\" >" + "<option value=1>1" + "</option>";
			if (data > 1) {
				//alert('13');
				for (var count = 2; count <= data; count++) {
				
				if ($c_num == count) {
					//alert($c_num);
					$string2 = "<option value=" + count +" selected>" + count +"</option>";
				}
				else {
					$string2 = "<option value=" + count + ">" + count +"</option>";
				}
				$string = $string + $string2;
				}
				
			}
			$("div#league_num").empty();
			$("div#league_num").append($string);
			
			$string = "<select id=lvl name=\"lvl\" onchange=\"change_lvl()\">";
			for (var count = 1; count <= 3; count++) {
				
				if ($sel_lvl == count) {
					$string2 = "<option value=" + count +" selected>" + count +"</option>";
				}
				else {
					$string2 = "<option value=\"" + count + "\">" + count + "</option>";
				}
				
				$string = $string + $string2;
			}
			$("div#league_lvl").empty();
			$("div#league_lvl").append($string);
		});
}
</script>
<table class="table-striped table-bordered table-condensed">
	
		<?php 
		echo("<tr>");
		echo("<td>Country:</td>");
		echo("<td><select name=\"country\">");
		foreach($league_avial as $league) {
			echo("<option value=\"".$league['country_id']."\">".$league['nameb_en']."");
		}
		echo("</option></select></td>");
		
		//lvl and league from $league_data
		echo("<td>Level:</td>");
		echo("<td>");
		?>
		<div id="league_lvl">
		</div> <?php 
		echo("</td>");
		
		echo("<td>Num:</td>");
		echo("<td>");
		?>
		<div id="league_num">
		</div> <?php 
		echo("</td>");
		echo("<td>");
		echo("<button type=\"submit\" class=\"btn btn-success\">Submit</button>");
		echo("</td>");
		echo("</tr>");
		?>


</table>
<br>
<table class="table-striped table-bordered table-condensed ">
	  <tr style="font-weight:bold;text-align:center;">
			<td align=center>POS</td>
			<td align=center>TEAM</td>
			<td align=center>RACES</td>
			<td align=center>PTS</td>
		</tr>
<?php 

$i = 0;
foreach($team_stand as $string)
{
    $string=(array)$team_stand[$i];
		//print_r($string);
		if (isset($string['rsm_league_promotion_id'])) {
			$league_change = "(" . $string['league_to'] . ")";
		}
		else $league_change = '';
		if (isset($string['playoff_type'])) {
			if ($string['playoff_type'] == 1)
			{
				$league_playoff = " TOP";
			}
			elseif ($string['playoff_type'] == 2) {
				$league_playoff = " Jump Play-off";
			}
		}
		else $league_playoff = '';
		?>

    <tr style="text-align:center;">
			<td align=center><?php echo($i+1);?></td><?php //print_r($string); ?>
			<td><a href="/team/view/<?php echo($string['team_id']);?>"><?php echo($string['team_name']); echo($league_change); echo($league_playoff);?></a></td>
			<td align=center><?php echo($league_races);?></td>
			<td align=center><?php echo($string['standings_points']);?></td>
		</tr>
<?php 

    $i++;
    ?>
		</tr><?php 
}
?>
</table>