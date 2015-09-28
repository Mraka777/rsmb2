        <div class="col-sm-9">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><a href="/team/view/<?php  echo $team_id; ?>"><img src="/images/flag/<?php  echo $logo; ?>">  <?php  echo $team_name;?></a></h3>
            </div>
            <div class="panel-body">

<table>
  <tr>
    <td><table class="table-striped table-bordered table-condensed">
    <tr style="font-weight:bold;text-algin:center;">
        <td colspan=2>Team rating</td>
    </tr>
    <tr>
      <td>rating_str</td><td>
      							<?php print("<div class=\"progress\">
											<div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"".$rating[0]['rating_str']."\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: ".$rating[0]['rating_str']."%;\">
												".$rating[0]['rating_str']."
											</div>
										</div>"); ?>
      
      <?php //echo($rating[0]['rating_str']);?></td>
    </tr>
    <tr>
      <td>Endurance</td><td><?php echo($rating[0]['rating_endur']);?></td>
    </tr>
    <tr>
      <td>Shooting tech</td><td><?php echo($rating[0]['rating_sh_tech']);?></td>
    </tr>
    <tr>
      <td>Shooting calm</td><td><?php echo($rating[0]['rating_sh_calm']);?></td>
    </tr>
    <tr>
      <td>Shooting acc</td><td><?php echo($rating[0]['rating_sh_acc']);?></td>
    </tr>
    <tr>
      <td>Track tech</td><td><?php echo($rating[0]['rating_tr_tech']);?></td>
    </tr>
    <tr>
      <td>Track Speed</td><td><?php echo($rating[0]['rating_tr_spd']);?></td>
    </tr>
    <tr>
      <td>Overall</td><td><?php echo($rating[0]['rating_overall']);?></td>
    </tr>
</table><br></td>
    <td><!-- <div id="chart" width=450></div> --></td>
  </tr>
</table>




  <script>
  var chart = c3.generate({
    bindto: '#chart',
    data: {
      columns: [
        ['Strength', <?php  echo($rating[0]['rating_str']);?> ],
				['Endurance', <?php  echo($rating[0]['rating_endur']);?>],
				['Shoot technique', <?php  echo($rating[0]['rating_sh_tech']);?>],
				['Shoot calm', <?php  echo($rating[0]['rating_sh_calm']);?>],
				['Shoot accuracy', <?php  echo($rating[0]['rating_sh_acc']);?>],
				['Track technique', <?php  echo($rating[0]['rating_tr_tech']);?>],
				['Track speed', <?php  echo($rating[0]['rating_tr_spd']);?>],
        ['Overall', <?php  echo($rating[0]['rating_overall']);?>],
      ],
      type: 'bar'
    },
		size: {
			width: 700
		}

});
</script>