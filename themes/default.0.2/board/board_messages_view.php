<?php

$bs_url="http://".$_SERVER['SERVER_NAME']."/assets/bootstrap";
$th_url= "http://".$_SERVER['SERVER_NAME']."/themes/".$current_theme;
$th_path = $_SERVER['DOCUMENT_ROOT']."/themes/".$current_theme;
$img_url = "http://".$_SERVER['SERVER_NAME']."/themes/".$current_theme;

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
						<div class="panel-heading"><strong><a href="/board/">Forum</a> -> <?php print("<a href=\"/board/section/".$topic_messages[0]['rsm_board_section_id']."\">".$topic_messages[0]['rsm_board_section_name']."</a>");?> -> <?php echo($topic_messages[0]['rsm_board_section_topic_name']);?></strong></div>
						<div class="panel-body">					
							<?php
							//print("<pre>");
							
							//print_r($topic_messages);
							//print("</pre>");
								foreach ($topic_messages as $message) {
									//print ("<a href=\"/board/topic/".$topic['rsm_board_section_topic_id']."\">".$topic['rsm_board_section_topic_name']."</a>");
									//print_r($message);
									print("<table class=\"table-striped table-bordered table-condensed \" width=100%>");
									print("<tr>");
									print("<td rowspan=\"2\" width=75><img src=\"/images/userpics/64/".$message['rsm_user_avatar_filename'].".gif\" width=64 height=64></td>");
									print("<td>".$message['username']."</td>");
									print("<td width=20%>".$message['rsm_board_message_date_time']."</td>");
									print("</tr>");
									print("<tr>");
									print("<td>".$message['rsm_board_message_text']."</td>");
									print("<td>*status etc*</td>");
									print("</tr>");
									print("</table>");
									//print("<hr>");
								}
								print("<hr>");
								echo form_open("/".$rsm_base_url."/board/topic/".$message['rsm_board_topic_id']."");
								echo('<input type="hidden" name="topic" value="'.$message['rsm_board_topic_id'].'">');
								echo("<textarea name=\"message\" cols=\"40\" rows=\"3\"></textarea></p>");
								echo("<input type=\"submit\" value=\"Send\">");
								echo form_close(); 
							?>
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