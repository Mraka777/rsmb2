<div class="col-sm-9">
  <div class="panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title">Loan</h3>
  </div>
  <div class="panel-body">

<table class="table-striped table-bordered table-condensed">
    <tr style="font-weight:bold;text-algin:center;">
        <td colspan=2>Credit offers</td>
    </tr>	

    </tr>
		<tr><td>
		<table class="table-striped table-bordered table-condensed">
			<tr>
		<?php 
		
		$i = 0;
		//print_r($club_info);
		foreach($club_credit as $string)
		{?><?php 
		
				$string=(array)$club_credit[$i];
				print("<td>");
				  echo form_open('office/credit/'); //Form 4 stadium build save 
					print("<table class=\"table-striped table-bordered table-condensed\">");
					print('<tr><td>Sum</td><td>'.$string['credit_sum'].'</td></tr>');
					print('<tr><td>Interest rate</td><td>'.$string['interest'].'%</td></tr>');
					print('<tr><td>Term</td><td>'.$string['credit_term'].'</td></tr>');
					print('<tr><td>Weekly</td><td>'.$string['weekly'].'</td></tr>');
					print("<input type='hidden' name='credit' value='".$string['rsm_team_credit_offer_id']."'>");
					print('<tr><td colspan=2 align=center><button type=\'submit\' name=\'borrow\' value=\'1\'>Borrow</button></td></tr>');
					print("</table>");
					
					echo form_close();
				print("</td>");
				
				$i++;
				?><?php 
		}
		
		?></tr>
		</table>
		</td></tr>
		</table>
			</div>