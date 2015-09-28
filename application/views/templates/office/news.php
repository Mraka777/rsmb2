<div class="col-sm-9">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Team news</h3>
</div>
<div class="panel-body">
	
	
<table class="table-striped table-bordered table-condensed">
  <tr style="font-weight:bold;text-align:center;">
    <td>News id</td>
    <td>Date</td>
    <td>Time</td>
    <td>Author</td>
    <td>Title</td>
    <td>Preview</td>  
    <td>Full text</td>   
   </tr>	
	<?php 
	//print_r($news);
	$i = 0;
	foreach($news as $string) {
		$string=(array)$news[$i];
		//print_r($string);
		if ($string['status']==0) {$unread1 = "<FONT COLOR=\"red\">";} else $unread1 = '';
		echo("<tr>");
		echo("<td>".$string['rsm_news_id']."</td>");
		echo("<td>".$string['real_date']."</td>");
		echo("<td>".$string['time']."</td>");
		echo("<td>".$string['username']."</td>");
		echo("<td>".$unread1." ".$string['news_title']."</td>");
		echo("<td>".$string['news_preview']."</td>");
		echo("<td>".$string['news_content']."</td>");
		echo("</tr>");
		$i++;
	}
		?>

</table>

</div>