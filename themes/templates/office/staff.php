<div class="col-sm-9">
  <div class="panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title">Staff info</h3>
  </div>
  <div class="panel-body">
<?php  echo form_open('office/staff/'); //Form 4 staff save?>

<table class="table-striped table-bordered table-condensed ">
    <tr style="font-weight:bold;text-align:center;">
        <td>Name</td>
				<td>Age</td>
				<td>Type</td>
				<td>Salary</td>
				<td>Skill</td>
				<td>Management</td>
				<td>Head</td>
    </tr>	

    </tr>
<?php 
$i = 0;
//print_r($staff);
foreach($staff as $string)
{?><tr style="text-align:center;"><?php 

	  $string=(array)$staff[$i];
		
		
		$status_selected=array('','');
		if ($string['staff_status']==0) {$status = "Reserve";$status_selected[0]='checked';}
		else {$status = "Head";$status_selected[1]='checked';}
		
		print('<td><img src="/images/flag/'.$string['logo'].'"> '.$string['name1'].' '.$string['name2'].'</td>');
		print('<td>'.$string['age'].'</td>');
		print('<td>'.$string['role'].'</td>');
		print('<td>'.$string['salary'].'</td>');
		print('<td>'.$string['skill1'].'</td>');
		print('<td>'.$string['skill2'].'</td>');
		print('<td><input type="radio" name="'.$string['role'].'_head" value="'.$string['rsm_staff_id'].'" '.$status_selected[1].'></td>');
		
		$i++;
    ?></tr><?php 
}

?>

</table>
<p align='left'><button type='submit' name='send'>Save staff roles</button></p>
<?php  		echo form_close(); ?>
	</div>