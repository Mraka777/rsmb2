        <div class="col-sm-9">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">League player statistic</a></h3>
            </div>
            <div class="panel-body">
<?php 
print("<pre>");
//print_r($league_stat['top_training']);
print("</pre>");

?>
<table class="table-striped table-bordered table-condensed" witdh=100%>
  <tr>
    <td colspan=2>TOP 5 RATING</td>  
  </tr>
<?php 
$i=1;
foreach ($league_stat['team_rating'] as $string) {
  if ($i<=5){
  //print("<pre>");
  //print_r($string);
  //print("</pre>");
  echo("<tr>");
  echo("<td><a href=\"/team/view/".$string['team_id']."\">".$string['team_name']."</a></td>");
  echo("<td>".$string['rating_overall']."</td>");
  echo("</tr>");
  }
  $i++;
}
?>
</table><br>
<table class="table-striped table-bordered table-condensed" witdh=100%>
  <tr>
    <td colspan=2>TOP 5 TRAINING</td>  
  </tr>
<?php 
$i=1;
foreach ($league_stat['top_training'] as $string) {
  if ($i<=5){
  //print("<pre>");
  //print_r($string);
  //print("</pre>");
  echo("<tr>");
  echo("<td><a href=\"/team/view/".$string['team_id']."\">".$string['team_name']."</a></td>");
  echo("<td>".$string['delta']."</td>");
  echo("</tr>");
  }
  $i++;
}

?>
  
  
</table> 