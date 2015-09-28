<?php

$bs_url="http://".$_SERVER['SERVER_NAME']."/assets/bootstrap";
$th_url= "http://".$_SERVER['SERVER_NAME']."/themes/".$current_theme;
$th_path = $_SERVER['DOCUMENT_ROOT']."/themes/".$current_theme;
$img_url = "http://www.biathlon-manager.com/themes/".$current_theme;

?>

<!DOCTYPE html>
<html lang="en">
  <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
   
		<title>RSM Interface Ver.0.2</title>
   
		<!-- Подключаем Бутстрап из папки assets и дополнительный css (style.css) -->
		<!-- Bootstrap -->
			
		<!-- Bootstrap core CSS -->
		<link href="<?php echo $bs_url;?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $th_url;?>/style.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="<?php echo $th_url;?>/_css/footer.css" rel="stylesheet">
		<link href="<?php echo $th_url;?>/_css/navbar.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
			
		<link rel="icon" href="<?php echo $th_url;?>/favicon.png" type="image/x-png">
  </head>
  
  <body>
		<!-- HEADER -->
		<?php include $th_path."/_common/header.php";?>
		<!-- /HEADER -->
			
		<!-- THEME SHOWCASE -->
		<div class="container theme-showcase">
			<!-- CONTENT HEADER .content-header -->
			<div class="row clearfix content-header">
				<!-- SOCIAL -->
				<div class="col-md-3 column social"> <?php include "$th_path/_common/social.php";?> </div>
				<!-- /SOCIAL -->
					
				<!-- BANNER 468x60 -->
				<div class="col-md-5 column bn"> <img src="<?php echo $img_url;?>/_img/b/468x60.gif" /> </div>
				<!-- /BANNER 468x60 -->
				
				<!-- INFO PANEL -->
				<div class="col-md-4 column"> <?php include "$th_path/_common/info-panel.php";?> </div>
				<!-- INFO PANEL -->					
			</div>
			<!-- /CONTENT HEADER .content-header -->
				
			<!-- MAIN CONTENT .content-main -->
			<div class="row clearfix content-main">
				<!-- LEFT COLUMN .main-lcol -->
				<div class="col-md-3 column main-lcol"> <?php include $th_path."/_common/main-lcol.php";?> </div>
				<!-- /LEFT COLUMN .main-lcol -->
										
				<!-- SubNav and Content -->
				<div class="col-md-9 column main-col">
					<?php include $th_path."/_common/main-subnav.php";?>
					
					<!-- Content -->
					<div class="panel panel-default">
						<!-- Default panel contents -->
						<div class="panel-heading"><strong>Player main view</strong></div>
						<div class="panel-body">					
							<?php 
							$i = 0;
							//print_r($player);
							
							<?php foreach($player as $string) : ?>
								$string=(array)$player[$i];								
								switch ($string['scout_status'])
								{
									case 0:
										$string['scout_status'] = '<font color="red">NO</font>&nbsp;&nbsp;&nbsp;<a href="/player/scout/'.$string['sportsman_id'].'"><img src="/images/player/scout.gif" ALT = "Scout Player"></a>';
										break;
									case 1:
										$string['scout_status'] = '<font color="green">YES</font>';
										break;
									default:
										$string['scout_status'] = 'NO';
								}
									
									switch ($string['popularity']) {
																case 0:
																		$pop_img="/images/pop/0.gif";
																		break;
																case 1:
																		$pop_img="/images/pop/1.gif";
																		break;
																case 2:
																		$pop_img="/images/pop/2.gif";
																		break;
																case 3:
																		$pop_img="/images/pop/3.gif";
																		break;
																case 4:
																		$pop_img="/images/pop/4.gif";
																		break;
																case 5:
																		$pop_img="/images/pop/5.gif";
																		break; 
																case 6:
																		$pop_img="/images/pop/6.gif";
																		break;
																case 7:
																		$pop_img="/images/pop/7.gif";
																		break;
																case 8:
																		$pop_img="/images/pop/8.gif";
																		break;
																case 9:
																		$pop_img="/images/pop/9.gif";
																		break;
																case 10:
																		$pop_img="/images/pop/10.gif";
																		break;
																default:
																	 $pop_img="img/pop/0.gif";
														}
													
									
									?><div class="col-sm-9">
												<div class="panel panel-default">
													<div class="panel-heading">
														<h3 class="panel-title"><?php echo('<b>'.$string['name1'].' '.$string['name2'].'</b>, ID='.$string['sportsman_id'].', OR='.$string['overall_rating']);?></a></h3>
													</div>
													<div class="panel-body">
							<table class="table-striped table-bordered table-condensed ">
							
									<tr style="font-weight:bold;text-algin:center;">
										<td colspan=5 align=center><?php echo('<img src=/images/flag/'.$string['logo'].'>  <b>'.$string['name1'].' '.$string['name2'].', '.$string['team_name'].'</b>');?></td>
									</tr>
									<tr style="font-weight:bold;text-algin:center;">
										<td colspan=2 align=center><?php echo('Attribute');?></td>
										<td align=center><?php echo('Talent');?></td>
										<td colspan=2 align=center><?php echo('Other');?></td>
									</tr>
									<tr style="text-algin:center;">
											<td>STR</td>
											<td><?php echo($string['phys_strength']);?></td>
											<td align=center><?php echo($string['phys_strength_mvu']);?></td>
											<td>Age</td>
											<td><?php echo($string['age']);?></td>   
									</tr>
									<tr style="text-algin:center;">
											<td>END</td>
											<td><?php echo($string['phys_endur']);?></td>
											<td align=center><?php echo($string['phys_endur_mvu']);?></td>
											<td>Career</td>
											<td>?</td>   
									</tr>
									<tr style="text-algin:center;">
											<td>SH TECH</td>
											<td><?php echo($string['shoot_tech']);?></td>
											<td align=center><?php echo($string['shoot_tech_mvu']);?></td>
											<td>Professionalism</td> 
											<td><?php echo($string['sportsman_prof']);?></td>   
									</tr>	
									<tr style="text-algin:center;">
											<td>SH CALM</td>
											<td><?php echo($string['shoot_calm']);?></td>
											<td align=center><?php echo($string['shoot_calm_mvu']);?></td>
											<td>Scouted</td>
											<td><?php echo($string['scout_status']);?></td>   
									</tr>
									<tr style="text-algin:center;">
											<td>SH ACC</td>
											<td><?php echo($string['shoot_acc']);?></td>
											<td align=center><?php echo($string['shoot_acc_mvu']);?></td>
											<td>History</td>
											<td><a href="/player/history/<?php echo($string['sportsman_id']);?>">History</a></td>   
									</tr>
									<tr style="text-algin:center;">
											<td>TR TECH</td>
											<td><?php echo($string['track_tech']);?></td>
											<td align=center><?php echo($string['track_tech_mvu']);?></td>
											<td>Salary</td>
											<td><?php echo($string['salary']);?></td>   
									</tr>
									<tr style="text-algin:center;">
											<td>SPEED</td>
											<td><?php echo($string['track_spd']);?></td>
											<td align=center><?php echo($string['track_speed_mvu']);?></td>
											<td>POP</td>
											<td><img src="<?php echo($pop_img);?>"></td>   
									</tr>
								
							<?php 
							
									$i++;
									?>
									</tr><?php 
							}
							?>
							</table>
						</div>
					</div>
					<!-- /Content -->				
					</div>
					<!-- /SubNav and Content -->

				</div>
				<!-- MAIN CONTENT .content-main -->

   </div>
			<!-- /THEME SHOWCASE -->

			<!-- FOOTER -->
   <footer class="footer">
				<div class="container"> <?php include "$th_path/_common/footer.php";?>	</div>
   </footer>
			<!-- /FOOTER -->
 
 
   <!-- Bootstrap core JavaScript
   ================================================== -->
   <!-- Placed at the end of the document so the pages load faster -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   <script src="<?php echo $bs_path;?>/js/bootstrap.min.js"></script>
   <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  
 </body>
</html>