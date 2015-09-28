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
						<div class="panel-heading"><strong>Club info</strong></div>
						<div class="panel-body">					


							<?php
							//print($rsm_base_url);
							if (isset($data_team_renamed)) {
								if (($data_team_renamed == '1') and ($data_track_renamed == '1')) {
									//print()
								echo("<b>Welcome to the Biathlon Manager game!</b><br>Please enter your Team and Stadium name:<br>");
								
									echo form_open("".$rsm_base_url."/office/");
									//echo('<input type="hidden" name="topic" value="'.$message['rsm_board_topic_id'].'">');
									//echo("<textarea name=\"message\" cols=\"40\" rows=\"3\"></textarea></p>");
									echo("New team name:<br>");
									echo("<input name=\"team_name\" type=\"text\" value=\"".$club_info[0]['team_name']."\"><br><br>");
									echo("New track name:<br>");
									echo("<input name=\"track_name\" type=\"text\" value=\"".$club_info[0]['name_en']."\">");
									echo("<br><br>");
									echo('<input type="hidden" name="topic" value="123">');
									echo("<input type=\"submit\" value=\"Send\">");
									echo form_close();
									echo("<br><br>");
								}
							}
							
							
							?>
		
						</div>
					</div>
					<!-- /Content -->				
<?php include $rsm['th_path']."/_common/general-footer.php";?>