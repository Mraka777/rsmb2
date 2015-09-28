<html lang="en">
  <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
 </head>
  
  <body>
		
		<?php
		foreach ($help as $page) {
		print("<b>".$page['path1']."/".$page['path2']." ");
		print($page['help_topic']."</b><br>");	
		print($page['help_text']."<br><br>");		
			
		}
		
		
		?>
		
	</body>

</html>