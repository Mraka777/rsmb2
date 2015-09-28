	
						<div class="panel panel-default">
							<!-- Default panel contents -->
							<div class="panel-heading" ><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <strong>Club management</strong></div>
							<!-- List group -->
							<div class="list-group">
								<!--<a href="#" class="list-group-item "><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <span class="badge">8</span>Office</a>
								<a href="#" class="list-group-item active"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <span class="badge">4</span>Team</a>
								<a href="#" class="list-group-item "><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <span class="badge">3</span>Infrastructure</a>
								<a href="#" class="list-group-item "><span class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="badge">3</span>Scouting</a>
								<a href="#" class="list-group-item "><span class="glyphicon glyphicon-road" aria-hidden="true"></span> <span class="badge">4</span>Races</a>
								<a href="#" class="list-group-item "><span class="glyphicon glyphicon-signal" aria-hidden="true"></span> <span class="badge">3</span>Competitions</a> -->
								<?php
									foreach ($left_menu as $string) {
										//print("<a href=\"#\" class=\"list-group-item \"><span class=\"glyphicon glyphicon-th-large\" aria-hidden=\"true\"></span> <span class=\"badge">8</span>Office</a>")
										print ("<a href=\"/".$rsm_base_url."/".$string['level1']."\" class=\"list-group-item \"><span class=\"".$string['glyph']."\" aria-hidden=\"true\"></span> <span class=\"badge\">".$string['num']."</span>".(ucfirst($string['level1_text']))."</a>");
									}
									//print ("<a href=\"/board/\" class=\"list-group-item \"><span class=\"\" aria-hidden=\"true\">Board</span> <span class=\"badge\"></a>");
									//print_r($left_menu);	 
								?>
							</div>
						</div>
						
						<img src="<?php echo $img_url;?>/_img/b/250x250.gif" style="width:100%;"/>
