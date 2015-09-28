  <div class="row clearfix">
    <!-- Sportsman Skills -->
    <div class="col-md-5">
      <div class="panel panel-default">
        <div class="panel-heading" style="font-weight:bold;text-transform:uppercase;text-align:center;">Skills</div>
        <table class="table table-condensed  table-bordered">
          <tr>
            <th>Skill</th>
            <th>Value <a href="#" title="test"><span class="glyphicon glyphicon-question-sign"></span></a></th>
            <th>Quality <a href="#" title='Procent of max value (1000) of skill that can be reached "easy" for talented player. All progress after that value need hard work and high professionalism value'><span class="glyphicon glyphicon-question-sign"></span></a></th>
          </tr>
          <tr> <th colspan=3 class="bg-info" style="text-align:center;font-weight:bold;">Temporary</th></tr>
          <tr> <td class="rsm-table-row-naming">Season energy</td> <td colspan=2>-</td> </tr>
          <tr> <td class="rsm-table-row-naming">Form</td> <td colspan=2>-</td> </tr>
          <tr> <td class="rsm-table-row-naming">Average values</td> <td>-</td> <td>-</td> </tr>
          
          <tr> <td colspan=3 class="bg-success" style="text-align:center;font-weight:bold;">Physical</td></tr>
          <tr>
            <td class="rsm-table-row-naming">Strength</td>
            <td><?php echo $sman['phys_strength'];?> <?php rate_stars($th_url,$sman['phys_strength'],100);?></td>
            <td><?php echo $sman['phys_strength_mvu'];?> <?php rate_stars($th_url,$sman['phys_strength_mvu'],10);?></td>
          </tr>
          <tr>
            <td class="rsm-table-row-naming">Endurance</td>
            <td><?php echo $sman['phys_endur'];?> <?php rate_stars($th_url,$sman['phys_endur'],100);?></td>
            <td><?php echo $sman['phys_endur_mvu'];?> <?php rate_stars($th_url,$sman['phys_endur_mvu'],10);?></td>
          </tr>
          
          <tr> <th colspan=3 class="bg-info" style="text-align:center;font-weight:bold;">Ski</th></tr>
          <tr>
            <td class="rsm-table-row-naming">Track speed</td>
            <td><?php echo $sman['track_spd'];?> <?php rate_stars($th_url,$sman['track_spd'],100);?></td>
            <td><?php echo $sman['track_speed_mvu'];?> <?php rate_stars($th_url,$sman['track_speed_mvu'],10);?></td>
          </tr>
          <tr>
            <td class="rsm-table-row-naming">Technic</td>
            <td><?php echo $sman['track_tech'];?> <?php rate_stars($th_url,$sman['track_tech'],100);?></td>
            <td><?php echo $sman['track_tech_mvu'];?> <?php rate_stars($th_url,$sman['track_tech_mvu'],10);?></td>
          </tr>          
          <tr> <td colspan=3 class="bg-warning" style="text-align:center;font-weight:bold;">Shooting</td></tr>
          <tr>
            <td class="rsm-table-row-naming">Accuracy</td>
            <td><?php echo $sman['shoot_acc'];?> <?php rate_stars($th_url,$sman['shoot_acc'],100);?></td>
            <td><?php echo $sman['shoot_acc_mvu'];?> <?php rate_stars($th_url,$sman['shoot_acc_mvu'],10);?></td>
          </tr>
          <tr>
            <td class="rsm-table-row-naming">Technic</td>
            <td><?php echo $sman['shoot_tech'];?> <?php rate_stars($th_url,$sman['shoot_tech'],100);?></td>
            <td><?php echo $sman['shoot_tech_mvu'];?> <?php rate_stars($th_url,$sman['shoot_tech_mvu'],10);?></td>
          </tr>
          <tr>
            <td class="rsm-table-row-naming">Calm</td>
            <td><?php echo $sman['shoot_calm'];?> <?php rate_stars($th_url,$sman['shoot_calm'],100);?></td>
            <td><?php echo $sman['shoot_calm_mvu'];?> <?php rate_stars($th_url,$sman['shoot_calm_mvu'],10);?></td></tr>
          

        </table>
      </div>
    </div>
    <!-- /Sportsman Skills -->
    
    <!-- Sportsman common data -->
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading" style="font-weight:bold;text-transform:uppercase;text-align:center;">Sportsman Data</div>
        <table class="table table-condensed table-bordered">
          <tr>
            <th>Name</th>
            <th>Value <a href="#" title="test"><span class="glyphicon glyphicon-question-sign"></span></a></th>
          </tr>
          <tr> <td colspan=2 class="bg-info" style="text-align:center;font-weight:bold;">Important</td></tr>  
          <tr> <td class="rsm-table-row-naming">Professionalism</td> <td><?php echo $sman['sportsman_prof'];?> <?php rate_stars($th_url,$sman['sportsman_prof'],10);?></td> </tr>
          <tr> <td class="rsm-table-row-naming">Experience</td> <td><?php echo $sman['rsm_sportsman_exp'];?></td> </tr>
          <tr> <td class="rsm-table-row-naming">Popularity</td> <td><?php echo $sman['popularity'];?> <?php rate_stars($th_url,$sman['popularity'],1);?></td> </tr>
          
          <tr> <td colspan=2 class="bg-info" style="text-align:center;font-weight:bold;">Basic</td></tr>
          <tr> <td class="rsm-table-row-naming">RSM ID</td> <td><?php echo $sman['sportsman_id'];?></td></tr>
          <tr> <td class="rsm-table-row-naming">Birthday</td> <td><?php echo $sman['bday'];?></td></tr>
          <tr> <td class="rsm-table-row-naming">Age</td> <td>16</td></tr>
          <tr> <td class="rsm-table-row-naming">OR</td> <td><?php echo $sman['overall_rating'];?></td></tr>
          <tr> <td class="rsm-table-row-naming">Scouting</td> <td>?</td></tr>

          <tr> <td colspan=2 class="bg-info" style="text-align:center;font-weight:bold;">Contract</td></tr>
          <tr> <td class="rsm-table-row-naming">Salary</td> <td><?php echo $sman['salary'];?></td> </tr>
          <tr> <td class="rsm-table-row-naming">Days left</td> <td>-</td> </tr>
          <tr> <td class="rsm-table-row-naming">Transfer value</td> <td><?php echo $sman['sportsman_transfer_value'];?></td> </tr>

        </table>
      </div>
    </div>
    <!-- /Sportsman common data -->
    
    <!-- Sportsman managment and Foto -->
    <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-heading"><strong>Management</strong></div>
        <div class="panel-body" style="padding:7px;">
          <div class="btn-toolbar" role="toolbar" aria-label="..." style="margin-bottom:5px;">
            <a class="btn btn-info btn-sm" href="#" role="button"><span class="glyphicon glyphicon-star" aria-hidden="true"></a>
            <a class="btn btn-info btn-sm" href="#" role="button"><span class="glyphicon glyphicon-star" aria-hidden="true"></a>
            <a class="btn btn-info btn-sm" href="#" role="button"><span class="glyphicon glyphicon-star" aria-hidden="true"></a>
            <a class="btn btn-info btn-sm" href="#" role="button"><span class="glyphicon glyphicon-star" aria-hidden="true"></a>
          </div>
          <div class="btn-toolbar" role="toolbar" aria-label="...">
            <a class="btn btn-info btn-sm" href="#" role="button"><span class="glyphicon glyphicon-star" aria-hidden="true"></a>
            <a class="btn btn-info btn-sm" href="#" role="button"><span class="glyphicon glyphicon-star" aria-hidden="true"></a>
            <a class="btn btn-info btn-sm" href="#" role="button"><span class="glyphicon glyphicon-star" aria-hidden="true"></a>
            <a class="btn btn-info btn-sm" href="#" role="button"><span class="glyphicon glyphicon-star" aria-hidden="true"></a>
          </div>
        </div>
      </div>      
      <!-- <span style="font-size:13em;" class="glyphicon glyphicon-user"></span> -->
      <span style="font-size:13em;" class="glyphicon glyphicon-user"></span>
      <div class="panel panel-default" style="margin-top:10px;height:143px;">
        <div class="panel-heading"><strong>Awards</strong></div>
        <div class="panel-body" style="padding:7px;">
          <?php for($i=1;$i<37;$i++) : ?>
          <span class="glyphicon glyphicon-star"></span>
          <?php endfor;?>
        </div>
      </div>
    </div>
    <!-- /Sportsman managment and Foto -->
  </div>
  
  <div class="row clearfix">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading" style="font-weight:bold;text-transform:uppercase;text-align:center;">ski suit</div>
        <div class="panel-body">
          
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading" style="font-weight:bold;text-transform:uppercase;text-align:center;">ski</div>
        <div class="panel-body">
          
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading" style="font-weight:bold;text-transform:uppercase;text-align:center;">Rifle</div>
        <div class="panel-body">
          
        </div>
      </div>
    </div>
  </div>