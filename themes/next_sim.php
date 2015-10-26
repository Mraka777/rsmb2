<div class="col-sm-9">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Core settings</h3>
    </div>
    <div class="panel-body">

      <?php echo form_open("en/next/core_sim/"); ?>
      <table class="table-striped table-bordered table-condensed table-td1strong" style="width:100%">
        <tr>
          <td colspan=9>Спортсмен</td>
        </tr>
        <tr>
          <td>Age</td>
          <td>NRG</td>
          <td>STR</td>
          <td>ENDUR</td>
          <td>SH_TECH</td>
          <td>SH_CALM</td>
          <td>SH_ACC</td>
          <td>TR_TECH</td>
          <td>TR_SPD</td>
        </tr>
        <tr>
          <td><input size=2 name="age" type="text" value="<?php echo $test_data['age']; ?>"></td>
          <td><input size=2 name="phys_energy" type="text" value="<?php echo $test_data['phys_energy']; ?>"></td>
          <td><input size=2 name="phys_strength" type="text" value="<?php echo $test_data['phys_strength']; ?>"></td>
          <td><input size=2 name="phys_endur" type="text" value="<?php echo $test_data['phys_endur']; ?>"></td>
          <td><input size=2 name="shoot_tech" type="text" value="<?php echo $test_data['shoot_tech']; ?>"></td>
          <td><input size=2 name="shoot_calm" type="text" value="<?php echo $test_data['shoot_calm']; ?>"></td>
          <td><input size=2 name="shoot_acc" type="text" value="<?php echo $test_data['shoot_acc']; ?>"></td>
          <td><input size=2 name="track_tech" type="text" value="<?php echo $test_data['track_tech']; ?>"></td>
          <td><input size=2 name="track_spd" type="text" value="<?php echo $test_data['track_spd']; ?>"></td>
        </tr>
          <tr>
            <td colspan=9><input type="submit" value="Save sportsman"></td>
          </tr>
      <?php
        //print_r($test_data);
        echo form_close();
      ?>
      </table>
    </div>