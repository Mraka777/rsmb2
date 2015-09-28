                   <div class="panel panel-<?php echo $f_tmp['group'];?>">
										<div class="panel-heading"><?php echo $f_tmp['name']; if ($f_tmp['days_construction'] != '0') {?> *d=<?echo($f_tmp['days_construction']);}?></div>
										<table class="table table-condensed table-bordered" style="width:100%">
											<tbody>
												<tr>
													<td colspan="5">
														<div style="float:left;"><?php echo $f_tmp['img'];?></div>
														<?php echo $f_tmp['desc'];?>
													</td>
												</tr>
												<tr style="font-weight:bold;text-align:center;">
													<td style="width:40px;">Lvl</td>
													<td>Value,$</td>
													<td>Per day,$</td>
                          <?php if($f_tmp['e_count']==1) {?><td colspan="2" title="<?php echo $f_tmp['e1_desc'];?>">E1</td><?}
                          else {?>
													<td title="<?php echo $f_tmp['e1_desc'];?>">E1</td>
													<td title="<?php echo $f_tmp['e2_desc'];?>">E2</td>
                          <?}?>
												</tr>
												<tr style="text-align:center;">
													<td><?php echo $f_tmp['lvl'];?></td>
													<td><?php echo $f_tmp['value'];?></td>
													<td><?php echo $f_tmp['maintaince'];?></td>
                          <?php if($f_tmp['e_count']==1) {?><td colspan="2"><?php echo $f_tmp['e1'];?></td><?}
                          else {?>
													<td><?php echo $f_tmp['e1'];?></td>
													<td><?php echo $f_tmp['e2'];?></td>
                          <?}?>
												</tr>
												<tr>
													<td colspan="5">
														<a href="/<?php echo($rsm_base_url);?>/infrastructure/facility_info/<?php echo $f_tmp['info_link'];?>"><button type="button" class="btn btn-info btn-xs">Info</button></a>
                            <?php if ($f_tmp['under_construction'] == '0') {?><a href="/<?php echo($rsm_base_url);?>/infrastructure/build_facility/<?php echo $f_tmp['build_link']; }?><?php if ($f_tmp['under_construction'] == '0') {?>"<?php } ?><button type="button" class="btn btn-success btn-xs">Build</button></a>
                            <button type="button" class="btn btn-warning btn-xs">Lay up</button>
                            <button type="button" class="btn btn-danger btn-xs">Destroy</button>
                            <button type="button" class="btn btn-primary btn-xs">To rent</button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>