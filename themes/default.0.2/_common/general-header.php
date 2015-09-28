<?php

//Текстовые переменные
$lng['scout_player']="scout player";
$lng['team']="team";
$lng['or']="OR";

$th_path = $rsm['th_path'];
$bs_url = $rsm['bs_url'];
$th_url = $rsm['th_url'];
$img_url = $rsm['img_url'];

include $th_path."/_lib/common.lib.php";

?>

<!DOCTYPE html>
<html lang="en">
  <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
   
		<title>RSM Interface Ver.0.2</title>

		<!-- JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   
		<!-- Подключаем Бутстрап из папки assets и дополнительный css (style.css) -->
		<!-- Bootstrap -->
			
		<!-- Bootstrap core CSS -->
		<link href="<?php echo $bs_url;?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $th_url;?>/style.css" rel="stylesheet">
		

		
		<!-- Load c3.css -->
		<link href="http://www.biathlon-manager.com/core/c3/c3.css" rel="stylesheet" type="text/css">
	
		<!-- Load d3.js and c3.js -->
		<script src="http://www.biathlon-manager.com/core/c3/d3.min.js" charset="utf-8"></script>
		<script src="http://www.biathlon-manager.com/core/c3/c3.min.js"></script>
		<!-- RSM JS -->
		<script src="http://www.biathlon-manager.com/assets/rsm/rsm.js"></script>
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
				<div class="col-md-3 column social"> <?php include $rsm['th_path']."/_common/social.php";?> </div>
				<!-- /SOCIAL -->
					
				<!-- BANNER 468x60 -->
				<div class="col-md-5 column bn"> <img src="<?php echo $rsm['th_url'];?>/_img/b/468x60.gif" /> </div>
				<!-- /BANNER 468x60 -->
				
				<!-- INFO PANEL -->
				<div class="col-md-4 column"> <?php include $rsm['th_path']."/_common/info-panel.php";?> </div>
				<!-- INFO PANEL -->					
			</div>
			<!-- /CONTENT HEADER .content-header -->
				
			<!-- MAIN CONTENT .content-main -->
			<div class="row clearfix content-main">
				<!-- LEFT COLUMN .main-lcol -->
				<div class="col-md-3 column main-lcol"> <?php include $rsm['th_path']."/_common/main-lcol.php";?> </div>
				<!-- /LEFT COLUMN .main-lcol -->
										
				<!-- SubNav and Content -->
				<div class="col-md-9 column main-col">
					<?php include $rsm['th_path']."/_common/main-subnav.php";?>