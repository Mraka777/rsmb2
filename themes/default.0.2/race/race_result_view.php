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
			
	<!— Bootstrap core CSS —>
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
			<?php include "$th_path/_common/header.php";?>
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
					<div class="col-md-3 column main-lcol"> <?php include "$th_path/_common/main-lcol.php";?> </div>
					<!-- /LEFT COLUMN .main-lcol -->
										
					<!-- SubNav and Content -->
					<div class="col-md-9 column main-col">
						<?php include "$th_path/_common/main-subnav.php";?>
					<!-- Content -->
					<div class="panel panel-default">
						<!-- Default panel contents -->
						<div class="panel-heading"><strong>Race result</strong></div>
						<div class="panel-body">					
							<table class="table-striped table-bordered table-condensed">
									<tr>
										<td>Place</td>
										<td>Name</td>
										<td>Team</td>
										<td>Result</td>
										<td>Deficit</td>
										<td>Shooting</td>
										<td>Total</td>
										<td>Points</td>
									</tr>
									<?php
									//echo("<pre>");
									//print_r($race_result_shooting);
									//echo("</pre>");
									//echo('ZZZ'.$race_result_shooting[0]['race_points'].'XXX<br>');
									$i=0;  
									foreach ($race_result as $key => $value) {
										$time=$value['time']/60;
										$minutes=floor($time);
										$hours=floor($minutes/60);
										$minutes=$minutes-$hours*60;
										$seconds=floor(($time-$hours*60-$minutes)*60);
										$mlseconds=round(($value['time']-$hours*60*60-$minutes*60-$seconds)*100,2);
										
										$result[$i]=$value['time'];$delta[$i]=0;
										if ($i>0) {
											
											$delta[$i]=$result[$i]-$result[0];
										}
										
										$time_delta=$delta[$i]/60;
										$minutes_delta=floor($time_delta);
										$hours_delta=floor($minutes_delta/60);
										$minutes_delta=$minutes_delta-$hours_delta*60;
										$seconds_delta=floor(($time_delta-$hours_delta*60-$minutes_delta)*60);
										$mlseconds_delta=round(($delta[$i]-$hours_delta*60*60-$minutes_delta*60-$seconds_delta)*100,2);
										
										
										
										echo '<tr style="font-weight:bold;text-algin:center;">';
										echo '<td>'.($i+1).'';
										echo '<td><img src=/images/flag/'.$value['logo'].'> '.$value['name1'].' '.$value['name2'].' id='.$value['sportsman_id'].'</td>';
										echo '<td>'.$value['team_name'].'</td>';
										echo '<td>'.$hours.':'.$minutes.':'.$seconds.','.$mlseconds.'</td>';
										//echo '<td>'.$delta[$i].'</td>';
										echo '<td>+ '.$hours_delta.':'.$minutes_delta.':'.$seconds_delta.','.$mlseconds_delta.'</td>';
										echo '<td>'.$race_result_shooting[$i]['race_shots_stand'].' + '.$race_result_shooting[$i]['race_shots_lay'].'</td>';
										echo '<td>'.$race_result_shooting[$i]['race_shots_missed'].'</td>';
										echo '<td>'.$race_result_shooting[$i]['race_points'].'</td>';
										echo '</tr>';
										$i++;
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