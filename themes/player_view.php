<table class="table-striped table-bordered table-condensed ">
    <tr style="font-weight:bold;text-algin:center;">
        <td>Team #</td>
        <td>Name</td>
        <td>Age</td>
        <td>ENE</td>
        <td>POP</td>
        <td>OR</td>   
    </tr>

<?php
$i = 0;
foreach($query as $string)
{?><tr><?php
    $string=(array)$query[$i];
    
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
    
    print('<td align=center>'.$string['team_num'].'</td><td><a href="/player/view/'.$string['b_id'].'"><img src=/images/flag/'.$string['logo'].'> '.$string['name1'].' '.$string['name2'].'</a></td><td>'.$string['age'].'</td><td>'.$string['phys_energy'].'</td><td><img src='.$pop_img.'></td><td>'.$string['overall_rating'].'</td>');
    $i++;
    ?></tr><?php
}

//$array = (array)$query[0];
//print($array['name1']);
//print($array['name2']);
//print_r($array);

?>
  
</table> 