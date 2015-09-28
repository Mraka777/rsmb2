<?php include $rsm['th_path']."/_common/general-header.php";?>

					<!-- Content -->
					<div class="panel panel-default content-panel">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<h1>Club News</h1>
							<div class="help-on-page"><?php include $rsm['th_path']."/_common/tpl-help-on-page.php";?></div>
						</div>
						<div class="panel-body">					

							<table class="table-striped table-bordered table-condensed ">
									<tr style="font-weight:bold;text-align:center;">
											<td colspan=2>Club data</td>
									</tr>	
							
									<tr>
										<td>
											<table class="table-striped table-bordered table-condensed">
												<tr style="font-weight:bold;text-align:center;">
													<td>News id</td>
													<td>Date</td>
													<td>Time</td>
													<td>Author</td>
													<td>Title</td>
													<td>Preview</td>  
													<td>Full text</td>   
												 </tr>	
												<?php 
												//print_r($news);
												$i = 0;
												foreach($news as $string) {
													$string=(array)$news[$i];
													//print_r($string);
													if ($string['status']==0) {$unread1 = "<FONT COLOR=\"red\">";} else $unread1 = '';
													echo("<tr>");
													echo("<td>".$string['rsm_news_id']."</td>");
													echo("<td>".$string['real_date']."</td>");
													echo("<td>".$string['time']."</td>");
													echo("<td>".$string['username']."</td>");
													echo("<td>".$unread1." ".$string['news_title']."</td>");
													echo("<td>".$string['news_preview']."</td>");
													echo("<td>".$string['news_content']."</td>");
													echo("</tr>");
													$i++;
												}
													?>
											
											</table>
											
										</td>
									</tr>
							
							</table>				
						</div>
					</div>
					<!-- /Content -->				

<?php include $rsm['th_path']."/_common/general-footer.php";?>