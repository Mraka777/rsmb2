<div class="col-sm-12">
<div class="panel panel-default">
<?php
//print_r($race_log);
//print("<pre>");


foreach ($race_log as $sportsman_log){
  
  //print_r($sportsman_log);
  if (!isset($track_coord[$sportsman_log['sportsman_id']])) {
    $track_coord[$sportsman_log['sportsman_id']]='';
    $first = '';
  }
  else $first = ', ';
  
  $track_log[$sportsman_log['sportsman_id']][$sportsman_log['mark']] = $sportsman_log['time'];
  //$track_log[$sportsman_log['sportsman_id']]['sportsman_id'] = $sportsman_log['sportsman_id'];
  $track_coord[$sportsman_log['sportsman_id']] = $track_coord[$sportsman_log['sportsman_id']] . $first . (string)$sportsman_log['time'] ;
  
}
$count = count($track_log[1]);
//print($count);

//print_r($track_coord);
//print($track_coord[1]);

foreach ($race_marks as $x) {
  //print_r($x);
  if (!isset($coord_x)) {
    $coord_x = '';
    $first = '';
  }
  else {$first = ', ';}
  
  $coord_x = $coord_x .$first. $x['mark'];
}
//print_r($track_log);
$keys = (array_keys($track_log));
$i = 0;

?>
</div>

<div id="chart"></div>
  <script>
  var chart = c3.generate({
    bindto: '#chart',
    size: {
        height: 600,
        width: 1100
    },
    data: {
      x: 'x',
      columns: [
        ['x', <?php print($coord_x); ?>],
        <?php
          foreach ($track_log as $temp) {
            $sp_id = $keys[$i];
            
            print("['id=".$sp_id."', ".$track_coord[$sp_id]."");
            print("],\n");
            $i++;
          };
        ?>
      ]
			
    },

});
</script>