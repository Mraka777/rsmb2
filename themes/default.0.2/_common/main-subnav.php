						<!-- SubNavigation -->
						<nav class="navbar navbar-default navbar-inverse" id="nav2" style="color:WHITE;">
							<div class="container-fluid">
								<!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
										<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
												<span class="sr-only">Toggle navigation</span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
										</button>
										<a class="navbar-brand" href="/<?php if (isset ($language_link)) { echo($language_link."/"); print($top_menu[0]['level1']); }?>" style="">
											<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
											<strong><?php
											if (isset($top_menu[0]['level1_view'])) {
												if ($top_menu[0]['level1_view'] != '') {//for Player 
													echo(ucfirst($top_menu[0]['level1_view']));
												}
												else {
													if (isset($top_menu[0]['level1'])) echo(ucfirst($top_menu[0]['level1']));
												}
											}
											?></strong></a>
								</div>
				
								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
										<ul class="nav navbar-nav">
												<?php
													//if (isset($top_menu[0]['level1'])) {
														//print($rsm_base_url);
														foreach ($top_menu as $string) {
															if ($string['level1_view'] != '') {
																$link = $string['level1_view'];
															}
															else {
																$link = $string['level1'];
															}
															
															if ($string['active'] == '1') {
																$class_active = " class=\"active\"";
															}
															else $class_active = '';
															//print($string['level1']);
															//print("<li".$class_active."><a href=\"/".$link."/".$string['level2']."\">".(ucfirst($string['level2']))."</a></li>");
															print("<li".$class_active."><a href=\"/".$rsm_base_url."/".$link."/".$string['level2']."\">".(ucfirst($string['level2']))."</a></li>");
														}
													//}
												?>
										</ul>
								</div><!-- /.navbar-collapse -->
						</div><!-- /.container-fluid -->
					</nav>					
					<!-- /SubNavigation -->