        <div class="col-sm-9">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Competitions</a></h3>
            </div>
            <div class="panel-body">

<?php  //echo form_open('/league/'); //Form 4 league ?>
<form action="http://biathlon-manager.com/league/playoff/" method="post" accept-charset="utf-8">
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
<?php
if (isset($top_playoff)) {
  //print_r($top_playoff);
  $count = count($top_playoff);
  if ($count > 0) {
    echo("<hr><table class=\"table-striped table-bordered table-condensed\">");
    echo("<tr><td colspan=4>TOP PLAYOFF</td>");
    echo("<tr><td>POS</td><td>TEAM</td><td>League</td><td>PTS</td></tr>");
    $i=1;
    foreach ($top_playoff as $string) {
      echo("<tr><td>".$i."</td><td>".$string['team_name']."</td><td>".$string['league_lvl'].".".$string['league_num']."</td><td>".$string['team_points']."</td></tr>");
      $i++;
    }
    echo("</table>");
  }
}

if (isset($jump_playoff)) {
  //print_r($top_playoff);
  $count = count($jump_playoff);
  //print($count);
  if ($count > 0) {
    echo("<hr><table class=\"table-striped table-bordered table-condensed\">");
    echo("<tr><td colspan=4>JUMP PLAYOFF</td>");
    echo("<tr><td>POS</td><td>TEAM</td><td>League</td><td>PTS</td></tr>");
    $i=1;
    foreach ($jump_playoff as $string) {
      echo("<tr><td>".$i."</td><td>".$string['team_name']."</td><td>".$string['league_lvl'].".".$string['league_num']."</td><td>".$string['team_points']."</td></tr>");
      $i++;
    }
    echo("</table>");
  }
}
?>