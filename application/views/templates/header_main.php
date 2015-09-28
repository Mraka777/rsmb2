<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RSM Biathlon manager: on-line biathlon manager game</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
 <script type="text/javascript" src="http://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="/js/bootstrap.min.js"></script>
 
  <!-- Load c3.css -->
  <link href="http://www.biathlon-manager.com/core/c3/c3.css" rel="stylesheet" type="text/css">

  <!-- Load d3.js and c3.js -->
  <script src="http://www.biathlon-manager.com/core/c3/d3.min.js" charset="utf-8"></script>
  <script src="http://www.biathlon-manager.com/core/c3/c3.min.js"></script>

	<link rel="icon" href="/favicon.ico" type="image/ico">
	
  </head>
  <body>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-58376012-1', 'auto');
  ga('send', 'pageview');

</script>
<?php


//print_r($todo);

?>
		
		
		
		
<table align=center width=800>
	<tr>
		<td align=left>
			<table border=0 width=100%>
				<tr>
					<td><br><br><img src="/images/main/bm_logo.gif" alt="RSM Biathlon manager"><br><br></td>
					<td valign=bottom>
						<a href="/en/"><img src="/images/lang/en.png" height=16 width=27></a>
						<a href="/ru/"><img src="/images/lang/ru.png" height=16 width=23></a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
<tr>
	<td>
    <div> <!-- Only required for left/right tabs -->
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab"><?php echo($general[0]['rsm_type_text']);?></a></li>
        <li><a href="#tab2" data-toggle="tab"><?php echo($general[1]['rsm_type_text']);?></a></li>
				<li><a href="#tab3" data-toggle="tab"><?php echo($general[2]['rsm_type_text']);?></a></li>
				<li><a href="#tab4" data-toggle="tab"><?php echo($general[3]['rsm_type_text']);?></a></li>
				<li><a href="#tab5" data-toggle="tab"><?php echo($general[4]['rsm_type_text']);?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab1">
					<?php echo($general[0]['rsm_text']);?>
        </div>
        <div class="tab-pane" id="tab2">
					<div style="height: 350px; overflow-y: scroll;">
						<br>
					<?php foreach ($updates as $upd_news) {
						print("<p align=\"justify\"><i>".$upd_news['date']."</i><br>".$upd_news['text']."</p>");
					}
					?>
					</div>
        </div>
        <div class="tab-pane" id="tab3">
          <table border=0 cellspacing="10"><br>
						<?php foreach ($todo as $list) {
							print("<tr>");
							print("<td>".$list['task']."</td>");
							print("<td width=50>&nbsp;</td>");
							print("<td width=150 valign=center><br>");
							print("<div class=\"progress\">
											<div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"".$list['progress']."\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: ".$list['progress']."%;\">
												".$list['progress']."
											</div>
										</div>");
							print("</td>");
							print("</tr>");
						}
						?>
					</table>
        </div>
				<div class="tab-pane" id="tab4"><br>
					<?php echo($general[3]['rsm_text']);?>
				</div>
				<div class="tab-pane" id="tab5"><br>
					<?php echo($general[4]['rsm_text']);?>
					<?phpphp echo form_open("auth/create_user");?>
						<p>
									<label for="first_name">Username:</label> <br />
									<input type="text" name="first_name" value="" id="first_name"  />      </p>
						<p>
									<label for="email">Email:</label> <br />
									<input type="text" name="email" value="" id="email"  />      </p>
			
						<p>
									<label for="password">Password:</label> <br />
									<input type="password" name="password" value="" id="password"  />      </p>
			
						<p>
									<label for="password_confirm">Confirm Password:</label> <br />
									<input type="password" name="password_confirm" value="" id="password_confirm"  />      </p>
			
						<p>
									<label for="user_country">Your country (based on IP address)</label> <br />
									RU      </p>
						
						<p><input type="submit" name="submit" value="Go!"  /></p>
					<?phpphp echo form_close();?>
				</div>
      </div>
    </div>
	</td>
</tr>
<tr>
	<td><hr></td>
</tr>
<tr>
	<td>




