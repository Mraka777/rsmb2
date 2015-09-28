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
						<div class="panel-heading"><strong>Что такое RSM Biathlon Manager?</strong></div>
						<div class="panel-body">					
							<p><strong>RSM Biathlon Manager</strong> - бесплатная игра концепции "free-to-play", в роли менеджера биатлонной команды Вам предстоит привести свою команду к победе в национальных соревнованиях, заполучить кубок страны, побороться за престижный трофей в лиге чемпионов своего континента, и если Вы будете одним из лучших в тактических и стратегических навыках - возглавить сборную своей страны на мировом первенстве.</p>
							
							<p>Имея большой опыт игры в различные менеджеры, при ее разработке мы стараемся учитывать большинство недочетов и недоработок, ошибок построения геймплея и пожелания игроков.</p>

							<p>В дальнейшем часть функционала будет вынесена в платный премиум-пакет, его стоимость будет вполне демократичной.</p>
							
							<p>Хотим заметить, что в игре не планируется платный функций, которые позволят игрокам получать серьезное игровое преимущество - ускорение постройки строений, тренировки игрока и тд.</p>
							
							<p><strong>Текущая версия</strong></p>
							
							<p>На данный момент на сервере доступна первая версия для тестирования - альфа тест, по результатам которого мы будем вносить балансные корректировки во все разделы игры - балансные правки финансовой составляющей, результатов гонки, развития игроков и тд.</p>
							
							<p>Особенности альфа-теста</p>
							
							<p>Поскольку игровой сезон длится 35 календарных дней, сейчас для ускорения тестирования в один календарный день проходит 5 игровых дней. Таким образом один сезон проходит за 7 календарных дней.</p>
							
							<p>
								<table class="table table-condensed  table-bordered table-striped">
									<tr>
										<td>Игровой день</td>
										<td>Время обсчета (по МСК)</td>
									</tr>
									<tr>
										<td>1</td>
										<td>02:00-03:00</td>
									</tr>
									<tr>
										<td>2</td>
										<td>08:00-09:00</td>
									</tr>
									<tr>
										<td>3</td>
										<td>13:00-14:00</td>
									</tr>
									<tr>
										<td>4</td>
										<td>17:00-18:00</td>
									</tr>
									<tr>
										<td>5</td>
										<td>22:00-23:00</td>
									</tr>
								</table>
							</p>
							<p>Некоторые из ошибок и дополнений будут исправляться “на лету” без сброса данных сервера. Остальные правки буду вноситься в течении 1 дня после окончания сезона. При этом мы постараемся сохранить прогресс команды из предыдущего сезона.</p>
							<p>На сервере доступны лиги 2х стран: России и Европы, в каждой из которых по 3 уровня. На 1-м уровне - 1 лига, 2-м уровне - 4 лиги, 3-м уровне - 16 лиг. При регистрации нового пользователя игроку выдается свободная команда в 1-й лиге, если таких команд в 1-й лиге нет - выдается команда из 2-й лиги и тд.</p>

							<p><strong>Сообщения об ошибках и обсуждении игры</strong></p>
 
							<p>Сообщения можно направлять посредством встроенной формы в игровом интерфейсе, во внутриигровом форуме, обсуждении группы в Вконтакте, по электронной почте. 
При сообщении об ошибках просьба наиболее подробно описывайте возникшую проблему, а также механизм ее воспроизведения.</p>

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