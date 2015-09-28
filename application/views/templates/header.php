<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biathlon manager 0.1b</title>

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
 <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
 <script src="/assets/bootstrap/js/doc.min.js"></script>
 <script src="/themes/fermers/js/autocomplete.js"></script>
 
 
  <!-- Load c3.css -->
  <link href="http://www.biathlon-manager.com/core/c3/c3.css" rel="stylesheet" type="text/css">

  <!-- Load d3.js and c3.js -->
  <script src="http://www.biathlon-manager.com/core/c3/d3.min.js" charset="utf-8"></script>
  <script src="http://www.biathlon-manager.com/core/c3/c3.min.js"></script>

	<link rel="icon" href="<?=base_url()?>/favicon.ico" type="image/ico">
	
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
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">BM v0.1b</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
				<li class="navbar-brand"><?php
				$sql = "SELECT * FROM `rsm_live` WHERE `id` = 1";
				$res=mysql_query($sql) or die(mysql_error());
				While ($data = mysql_fetch_row($res))
				{
								$current_day=$data[1];
								//echo($current_day);
								$sql = "SELECT * FROM `rsm_season` WHERE `day_id` = $current_day";
								//echo($sql);
								$res=mysql_query($sql) or die(mysql_error());
								While ($data = mysql_fetch_row($res))
								{
												$current_season=$data[1];
												$current_day=$data[2];
												echo('Season '.$current_season.' Day '.$current_day);
								}
								
				}
				
		?></li> 		
		<li><a href="/office/">Office</a></li>
		<li><a href="/team/">Team</a></li>
		<li><a href="/infrastructure/">Infrastructure</a></li>
		<li><a href="/race/">Race</a></li>
		<li><a href="/league/">League</a></li>
		<li><a href="/next/">Turn Menu</a></li>
		<?php
		//echo("id=".$team."<Br>");
		$sql = "SELECT rsm_team_balance_current FROM `rsm_team_balance` WHERE `rsm_team_balance_id` = $team";
		$res=mysql_query($sql) or die(mysql_error());
		While ($data = mysql_fetch_row($res))
		{  
			echo("<li><img src=/images/general/money-icon2.png></li><li><a href=\"/office/finance/\">$ ".(number_format($data[0], 0, ',', ' ' ))."</a></li>");
		}
		?>
		<li><a href="/todo/"><font color="red">Game news</font></a></li>
	  </ul>             

        </div><!--/.nav-collapse -->
      </div>
    </div>


