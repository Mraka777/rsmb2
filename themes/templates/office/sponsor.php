<div class="col-sm-9">
  <div class="panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title">Team sponsors</h3>
  </div>
  <div class="panel-body">
		
<?php 
$pop_img_general="/images/pop/".$general_sponsor[0]['rating'].".gif";
$pop_img_media="/images/pop/".$media_sponsor[0]['rating'].".gif";

?>
<!-- General sponsor -->
<table>
<tr><td>
<table class="table-striped table-bordered table-condensed ">
	<tr style="font-weight:bold;text-algin:center;">
		<td colspan=2>General sponsor</td>
	</tr>
	<tr style="font-weight:bold;text-algin:center;">
		<td><?php  echo($general_sponsor[0]['sponsor_name']); ?></td>
		<td>Contract details</td>
	</tr>
	<tr style="font-weight:bold;text-algin:center;">
		<td><img src="<?php  echo($general_sponsor[0]['sponsor_img']);?>"></td>
		<td>Contract daily: <?php  echo(number_format( $general_sponsor[0]['sponsor_daily'], 0, ',', ' ' )); ?><br>Contract total: <?php  echo(number_format( $general_sponsor[0]['sponsor_total'], 0, ',', ' ' )); ?></td>
	</tr>
	<tr style="font-weight:bold;text-algin:center;">
		<td align=center colspan=2><img src="<?php  echo($pop_img_general);?>"></td>
	</tr>
</table>
</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td>
<!-- Media sponsor -->
<table class="table-striped table-bordered table-condensed ">
	<tr style="font-weight:bold;text-algin:center;">
		<td colspan=2>Media sponsor</td>
	</tr>
	<tr style="font-weight:bold;text-algin:center;">
		<td><?php  echo($media_sponsor[0]['sponsor_name']); ?></td>
		<td>Contract details</td>
	</tr>
	<tr style="font-weight:bold;text-algin:center;">
		<td><img src="<?php  echo($media_sponsor[0]['sponsor_img']);?>"></td>
		<td>Contract daily: <?php  echo(number_format( $media_sponsor[0]['sponsor_daily'], 0, ',', ' ' )); ?><br>Contract total: <?php  echo(number_format( $media_sponsor[0]['sponsor_total'], 0, ',', ' ' )); ?></td>
	</tr>
	<tr style="font-weight:bold;text-algin:center;">
		<td align=center colspan=2><img src="<?php  echo($pop_img_media);?>"></td>
	</tr>
</table>
</td></tr>
</table>
	</div>