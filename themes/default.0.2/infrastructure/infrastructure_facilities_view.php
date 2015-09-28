<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Facilities</h1> 
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">
							<div class="row clearfix">
								<!-- Sport deps -->
								<div class="col-md-4 column">
									<?php

										unset($f_tmp);
										$building_num=0;//Training base
										$f_tmp['under_construction']=$infrastructure[$building_num]['under_construction'];
										$f_tmp['days_construction']=$infrastructure[$building_num]['days_next'];
										$f_tmp['build_link']=$infrastructure[$building_num]['building_id'];
										$f_tmp['info_link']=$infrastructure[$building_num]['building_level_id'];
										$f_tmp['group']="primary";
										$f_tmp['name']=$infrastructure[$building_num]['namef_en'];
										$f_tmp['desc']=$infrastructure[$building_num]['building_descr'];
										$f_tmp['img']='<span style="font-size:32px;padding-right:10px;" class="glyphicon glyphicon-home"></span>';
										$f_tmp['lvl']=$infrastructure[$building_num]['building_level'];
										$f_tmp['value']=$infrastructure[$building_num]['building_cost'];
										$f_tmp['maintaince']=$infrastructure[$building_num]['maintenance_cost'];
										$f_tmp['e_count']=2;
										$f_tmp['e1']=$infrastructure[$building_num]['building_e1'];
										$f_tmp['e1_desc']=$infrastructure[$building_num]['e1_desc'];
										$f_tmp['e2']=$infrastructure[$building_num]['building_e2'];
										$f_tmp['e2_desc']=$infrastructure[$building_num]['e2_desc'];
										include "tpl-infra-facility.php";
									?>
									<?php
									
										unset($f_tmp);
										$building_num=1;//Regeneration center
										$f_tmp['under_construction']=$infrastructure[$building_num]['under_construction'];
										$f_tmp['days_construction']=$infrastructure[$building_num]['days_next'];
										$f_tmp['build_link']=$infrastructure[$building_num]['building_id'];
										$f_tmp['info_link']=$infrastructure[$building_num]['building_level_id'];
										$f_tmp['group']="primary";
										$f_tmp['name']='<span class="glyphicon glyphicon-flash"></span> '.$f_tmp['desc']=$infrastructure[$building_num]['namef_en'];
										$f_tmp['desc']=$infrastructure[$building_num]['building_descr'];
										$f_tmp['img']='<span style="font-size:32px;padding-right:10px;" class="glyphicon glyphicon-home"></span>';
										$f_tmp['lvl']=$infrastructure[$building_num]['building_level'];
										$f_tmp['value']=$infrastructure[$building_num]['building_cost'];
										$f_tmp['maintaince']=$infrastructure[$building_num]['maintenance_cost'];
										$f_tmp['e_count']=2;
										$f_tmp['e1']=$infrastructure[$building_num]['building_e1'];
										$f_tmp['e1_desc']=$infrastructure[$building_num]['e1_desc'];
										$f_tmp['e2']=$infrastructure[$building_num]['building_e2'];
										$f_tmp['e2_desc']=$infrastructure[$building_num]['e2_desc'];
										include "tpl-infra-facility.php";
									?>
									<?php
										unset($f_tmp);
										$building_num=6;//Youth academy
										$f_tmp['under_construction']=$infrastructure[$building_num]['under_construction'];
										$f_tmp['days_construction']=$infrastructure[$building_num]['days_next'];
										$f_tmp['build_link']=$infrastructure[$building_num]['building_id'];
										$f_tmp['info_link']=$infrastructure[$building_num]['building_level_id'];
										$f_tmp['group']="primary";
										$f_tmp['name']='<span class="glyphicon glyphicon-education"></span> '.$f_tmp['desc']=$infrastructure[$building_num]['namef_en'];
										$f_tmp['desc']=$infrastructure[$building_num]['building_descr'];
										$f_tmp['img']='<span style="font-size:32px;padding-right:10px;" class="glyphicon glyphicon-home"></span>';
										$f_tmp['lvl']=$infrastructure[$building_num]['building_level'];
										$f_tmp['value']=$infrastructure[$building_num]['building_cost'];
										$f_tmp['maintaince']=$infrastructure[$building_num]['maintenance_cost'];
										$f_tmp['e_count']=2;
										$f_tmp['e1']=$infrastructure[$building_num]['building_e1'];
										$f_tmp['e1_desc']=$infrastructure[$building_num]['e1_desc'];
										$f_tmp['e2']=$infrastructure[$building_num]['building_e2'];
										$f_tmp['e2_desc']=$infrastructure[$building_num]['e2_desc'];
										include "tpl-infra-facility.php";
									?>
								</div>
								<!-- Common deps -->
								<div class="col-md-4 column">
									<?php
										unset($f_tmp);$building_num=2;//Club office
										$f_tmp['under_construction']=$infrastructure[$building_num]['under_construction'];
										$f_tmp['days_construction']=$infrastructure[$building_num]['days_next'];
										$f_tmp['build_link']=$infrastructure[$building_num]['building_id'];
										$f_tmp['info_link']=$infrastructure[$building_num]['building_level_id'];
										$f_tmp['group']="default";
										$f_tmp['name']='<span class="glyphicon glyphicon-home"></span> '.$f_tmp['desc']=$infrastructure[$building_num]['namef_en'];
										$f_tmp['desc']=$infrastructure[$building_num]['building_descr'];
										$f_tmp['img']='<span style="font-size:32px;padding-right:10px;" class="glyphicon glyphicon-home"></span>';
										$f_tmp['lvl']=$infrastructure[$building_num]['building_level'];
										$f_tmp['value']=$infrastructure[$building_num]['building_cost'];
										$f_tmp['maintaince']=$infrastructure[$building_num]['maintenance_cost'];
										$f_tmp['e_count']=2;
										$f_tmp['e1']=$infrastructure[$building_num]['building_e1'];
										$f_tmp['e1_desc']=$infrastructure[$building_num]['e1_desc'];
										$f_tmp['e2']=$infrastructure[$building_num]['building_e2'];
										$f_tmp['e2_desc']=$infrastructure[$building_num]['e2_desc'];
										include "tpl-infra-facility.php";
									?>
									<?php
										unset($f_tmp);$building_num=4;//Scouting
										$f_tmp['under_construction']=$infrastructure[$building_num]['under_construction'];
										$f_tmp['days_construction']=$infrastructure[$building_num]['days_next'];
										$f_tmp['build_link']=$infrastructure[$building_num]['building_id'];
										$f_tmp['info_link']=$infrastructure[$building_num]['building_level_id'];
										$f_tmp['group']="default";
										$f_tmp['name']='<span class="glyphicon glyphicon-search"></span> '.$f_tmp['desc']=$infrastructure[$building_num]['namef_en'];
										$f_tmp['desc']=$infrastructure[$building_num]['building_descr'];
										$f_tmp['img']='<span style="font-size:32px;padding-right:10px;" class="glyphicon glyphicon-home"></span>';
										$f_tmp['lvl']=$infrastructure[$building_num]['building_level'];
										$f_tmp['value']=$infrastructure[$building_num]['building_cost'];
										$f_tmp['maintaince']=$infrastructure[$building_num]['maintenance_cost'];
										$f_tmp['e_count']=2;
										$f_tmp['e1']=$infrastructure[$building_num]['building_e1'];
										$f_tmp['e1_desc']=$infrastructure[$building_num]['e1_desc'];
										$f_tmp['e2']=$infrastructure[$building_num]['building_e2'];
										$f_tmp['e2_desc']=$infrastructure[$building_num]['e2_desc'];
										include "tpl-infra-facility.php";
									?>
									<?php
										unset($f_tmp);$building_num=5;//Medical
										$f_tmp['under_construction']=$infrastructure[$building_num]['under_construction'];
										$f_tmp['days_construction']=$infrastructure[$building_num]['days_next'];
										$f_tmp['build_link']=$infrastructure[$building_num]['building_id'];
										$f_tmp['info_link']=$infrastructure[$building_num]['building_level_id'];
										$f_tmp['group']="default";
										$f_tmp['name']='<span class="glyphicon glyphicon-plus-sign"></span> '.$f_tmp['desc']=$infrastructure[$building_num]['namef_en'];
										$f_tmp['desc']=$infrastructure[$building_num]['building_descr'];
										$f_tmp['img']='<span style="font-size:32px;padding-right:10px;" class="glyphicon glyphicon-home"></span>';
										$f_tmp['lvl']=$infrastructure[$building_num]['building_level'];
										$f_tmp['value']=$infrastructure[$building_num]['building_cost'];
										$f_tmp['maintaince']=$infrastructure[$building_num]['maintenance_cost'];
										$f_tmp['e_count']=2;
										$f_tmp['e1']=$infrastructure[$building_num]['building_e1'];
										$f_tmp['e1_desc']=$infrastructure[$building_num]['e1_desc'];
										$f_tmp['e2']=$infrastructure[$building_num]['building_e2'];
										$f_tmp['e2_desc']=$infrastructure[$building_num]['e2_desc'];
										include "tpl-infra-facility.php";
									?>									
								</div>
								<!-- Economy deps -->
								<div class="col-md-4 column">
									<?php
										unset($f_tmp);$building_num=7;//Economy dpt
										$f_tmp['under_construction']=$infrastructure[$building_num]['under_construction'];
										$f_tmp['days_construction']=$infrastructure[$building_num]['days_next'];
										$f_tmp['build_link']=$infrastructure[$building_num]['building_id'];
										$f_tmp['info_link']=$infrastructure[$building_num]['building_level_id'];
										$f_tmp['group']="success";
										$f_tmp['name']='<span class="glyphicon glyphicon-usd"></span> '.$f_tmp['desc']=$infrastructure[$building_num]['namef_en'];
										$f_tmp['desc']=$infrastructure[$building_num]['building_descr'];
										$f_tmp['img']='<span style="font-size:32px;padding-right:10px;" class="glyphicon glyphicon-home"></span>';
										$f_tmp['lvl']=$infrastructure[$building_num]['building_level'];
										$f_tmp['value']=$infrastructure[$building_num]['building_cost'];
										$f_tmp['maintaince']=$infrastructure[$building_num]['maintenance_cost'];
										$f_tmp['e_count']=2;
										$f_tmp['e1']=$infrastructure[$building_num]['building_e1'];
										$f_tmp['e1_desc']=$infrastructure[$building_num]['e1_desc'];
										$f_tmp['e2']=$infrastructure[$building_num]['building_e2'];
										$f_tmp['e2_desc']=$infrastructure[$building_num]['e2_desc'];
										include "tpl-infra-facility.php";
									?>
									<?php
										unset($f_tmp);
										$f_tmp['group']="success";$building_num=3;//Maint dpt
										$f_tmp['under_construction']=$infrastructure[$building_num]['under_construction'];
										$f_tmp['days_construction']=$infrastructure[$building_num]['days_next'];
										$f_tmp['build_link']=$infrastructure[$building_num]['building_id'];
										$f_tmp['info_link']=$infrastructure[$building_num]['building_level_id'];
										$f_tmp['name']='<span class="glyphicon glyphicon-wrench"></span> '.$f_tmp['desc']=$infrastructure[$building_num]['namef_en'];
										$f_tmp['desc']=$infrastructure[$building_num]['building_descr'];
										$f_tmp['img']='<span style="font-size:32px;padding-right:10px;" class="glyphicon glyphicon-home"></span>';
										$f_tmp['lvl']=$infrastructure[$building_num]['building_level'];
										$f_tmp['value']=$infrastructure[$building_num]['building_cost'];
										$f_tmp['maintaince']=$infrastructure[$building_num]['maintenance_cost'];
										$f_tmp['e_count']=2;
										$f_tmp['e1']=$infrastructure[$building_num]['building_e1'];
										$f_tmp['e1_desc']=$infrastructure[$building_num]['e1_desc'];
										$f_tmp['e2']=$infrastructure[$building_num]['building_e2'];
										$f_tmp['e2_desc']=$infrastructure[$building_num]['e2_desc'];
										include "tpl-infra-facility.php";
										
									?>
								</div>

							</div>
								<?php
										//print("<pre>");
										//print_r($infrastructure);
										//print("</pre>");
								?>
						</div>
					</div>
					<!-- /Content -->			

<?php include $rsm['th_path']."/_common/general-footer.php";?>