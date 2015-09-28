    <?php
    
      $string=(array)$race_info[0];
      //print_r($string);
    ?><div class="col-sm-9">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Race #<?php echo($string['race_id']); ?> on <?php echo($string['name_en']); ?></h3>
    </div>
    <div class="panel-body">
      <p class="lead"><?php echo($string['mode']); ?></p>
      <div style="overflow-y: scroll;    height: 250px;">
        <table class="table-striped table-bordered table-condensed">
        <tr style="font-weight:bold;text-algin:center;">
            <td>#</td>
            <td>Name</td>
            <td>Team</td>
            <td>OR</td>
        </tr>
        <?php
        $i=0;
        foreach($race_sportsman_list as $sportsman_list)
        {
        echo("<tr><td>".$sportsman_list['sportsman_id']."</td><td><img src=\"/images/flag/".$sportsman_list['logo']."\">  <a href=\"/player/view/".$sportsman_list['sportsman_id']."\">".$sportsman_list['name1']." ".$sportsman_list['name2']."</a></td><td>".$sportsman_list['team_name']."</td><td>".$sportsman_list['overall_rating']."</td></tr>\n");
        $i++;
        }
        ?>
        </table>
    </div>
