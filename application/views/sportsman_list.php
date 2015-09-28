        <div class="col-sm-9">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><a href="/team/view/<?php echo $team_id; ?>"><img src="/images/flag/<?php echo $logo; ?>">  <?php echo $team_name;?></a></h3>
            </div>
            <div class="panel-body">
<table class="table-striped table-bordered table-condensed">
    <tr style="font-weight:bold;text-align:center;">
        <td>Team #</td>
        <td>Name</td>
        <td>Age</td>
        <td>ENE</td>
        <td>POP</td>
        <td>Status</td>  
        <td>OR</td>   
    </tr>

<?php
//print("<pre>");
//print_r($query);
//print("</pre>");
$i = 0;
foreach($query as $string)
{?><tr><?php
    $string=(array)$query[$i];
    
    switch ($string['status']) {
      case 1:
      $pl_status='<font color="green">YES</font>';
      break;
      default:
      $pl_status='<font color="red">NO</font>';
    }
    
    switch ($string['popularity']) {
      case 0:
      $pop_img="/images/pop/0.gif";
      break;
                  case 1:
                      $pop_img="/images/pop/1.gif";
                      break;
                  case 2:
                      $pop_img="/images/pop/2.gif";
                      break;
                  case 3:
                      $pop_img="/images/pop/3.gif";
                      break;
                  case 4:
                      $pop_img="/images/pop/4.gif";
                      break;
                  case 5:
                      $pop_img="/images/pop/5.gif";
                      break; 
                  case 6:
                      $pop_img="/images/pop/6.gif";
                      break;
                  case 7:
                      $pop_img="/images/pop/7.gif";
                      break;
                  case 8:
                      $pop_img="/images/pop/8.gif";
                      break;
                  case 9:
                      $pop_img="/images/pop/9.gif";
                      break;
                  case 10:
                      $pop_img="/images/pop/10.gif";
                      break;
                                                               
                  default:
                     $pop_img="img/pop/0.gif";
              }
    

    
    print('<td align=center>'.$string['team_num'].'</td><td><a href="/player/view/'.$string['sportsman_id'].'"><img src=/images/flag/'.$string['logo'].'> '.$string['name1'].' '.$string['name2'].'</a>');

    
    print('</td><td>'.$string['age'].'</td><td>'.$string['phys_energy'].'</td><td><img src='.$pop_img.'></td><td>');
    
    if ($string['duration'] > 0) {
      //echo('zzzz');
      print("   <img src='/images/player/injury.gif' height=16 width=16 title=\"".$string['description'].", ".$string['duration']." day(s)\">");
      //$injury="";
    }
    else {
      print('<img src=\'/images/player/injury_none.gif\' width=16 height=16>');
    }
    
  print('   ');

    if ($string['status'] == '1') {
      //echo('zzzz');
      print('<img src=\'/images/player/scout.gif\' width=16 height=16 title="Scouted">');
      //$injury="";
    }
    else {
      print('<img src=\'/images/player/scout_none.gif\' width=16 height=16>');
    }
    
   
    
    print('</td><td>'.$string['overall_rating'].'</td>');
    $i++;
    ?></tr><?php
}

//$array = (array)$query[0];
//print($array['name1']);
//print($array['name2']);
//print_r($array);

?>
  
</table> 