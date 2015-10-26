<div class="col-sm-9">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Core settings</h3>
    </div>
    <div class="panel-body">

      <?php echo form_open("en/next/core/"); ?>
      <table class="table-striped table-bordered table-condensed table-td1strong" style="width:100%">
        <tr>
          <td colspan=3>Общая тактика</td>
        </tr>
      <?php
        //print("<pre>");
        //print_r($core_settings);
        //print("</pre>");
        $i = 0;
        $comment = array(1=>'Тактика -> Low -> Все показатели', 'Тактика -> Medium -> Все показатели', 'Тактика -> High -> Все показатели', 'Ski plain Low -> Точность', 'Ski plain Medium -> Точность', 'Ski plain High -> Точность', 'Ski plain Low -> КД', 'Ski plain Medium -> КД', 'Ski plain High -> КД', 'Ski hill Low -> Точность', 'Ski hill Medium -> Точность', 'Ski hill High -> Точность', 'Ski hill Low -> КД', 'Ski hill Medium -> КД', 'Ski hill High -> КД', 'Low shooting speed -> Точность', 'Medium shooting speed -> Точность', 'High shooting speed -> Точность', 'Low shooting speed -> Подготовка к стрельбе', 'Medium shooting speed -> Подготовка к стрельбе', 'High shooting speed -> Подготовка к стрельбе', 'Low shooting speed -> КД', 'Medium shooting speed -> КД', 'High shooting speed -> КД');
        foreach ($core_settings as $key=>$setting) {
          if ($i>0) {
            //print($setting);
            //print($key);
            switch ($i) {
              case 4:
                ?>
                <tr>
                 <td colspan=3>Тактика - Прохождение равнинных участков</td>
               </tr>
                <?php 
                break;
              case 10:
                ?>
                <tr>
                 <td colspan=3>Тактика - Прохождение холмистых участков</td>
               </tr>
                <?php 
                break;
              case 16:
                ?>
                <tr>
                 <td colspan=3>Тактика - Стрельба</td>
               </tr>
                <?php 
                break;
            }
            ?>
            <tr>
              <td><input name="<?php echo $key; ?>" type="text" value="<?php echo $setting; ?>"></td>
              <td><?php echo $key;?></td>
              <td><?php echo $comment[$i];?></td>
            </tr>
        <?php
            }
          $i++;
          }
        ?>
   
          <tr>
            <td colspan=3><input type="submit" value="Save core"></td>
          </tr>
        <?php
        echo form_close();
      ?>
      </table>
    </div>