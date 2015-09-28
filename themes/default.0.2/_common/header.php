   <nav class="navbar navbar-inverse navbar-static-top" id="h-nav">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="/" style="padding-right:50px;"><img src="<?php echo $img_url;?>/_img/logo4_h.png" /></a>
					</div>
				
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<?php
								foreach ($header_menu as $menu) {
									if ($menu['active'] == '1' ){
										$active = "class=\"active\"";
									}
									else $active = '';
									print("<li ".$active."><a href=\"/".$rsm_base_url."/game/".$menu['rsm_menu_header_level1']."\"><span class=\"".$menu['rsm_menu_header_glyph']."\"></span> ".$menu['rsm_menu_header_text']."</a></li>");
								}
							?>
						</ul>
						
						<ul class="nav navbar-nav navbar-right" style="margin-right:-5px">
							<li style=""><a>&nbsp;</a></li>
							<li class="navbar-vr-divider"><a href="/<?php echo($rsm_base_url);?>/game/reminder/" style="height:50px;padding: 10px 10px 10px 10px;">
								<span class="glyphicon glyphicon-bell" style="font-size: 2em;"></span>
								<span class="badge" style="font-size:1em;vertical-align:top;margin-top:5px;"><?php
								$reminder_sum = 0;
								//print_r($reminder_info);
								foreach ($reminder_info as $reminder) {
									$reminder_sum = $reminder_sum + $reminder['rsm_reminder_num'];
								}
								echo($reminder_sum);
								?></span></a>
							</li>
							<li class="navbar-vr-divider"><a href="#"><img src="/images/userpics/32/<?php echo($user_avatar[0]['rsm_user_avatar_filename']);?>.gif" height=20 width=20>&nbsp;<?php echo ($this->ion_auth->user()->row()->username); ?></a></li>
							<li class="navbar-vr-divider" ><a href="#" style="color:#ffd700;">$ 0</a></li>
							<li><a href="#"><img src="/images/flag/<?php echo $user_country['logo']; ?>"></a></li>
						</ul>					
						
					</div>
				</div>
			</nav>
