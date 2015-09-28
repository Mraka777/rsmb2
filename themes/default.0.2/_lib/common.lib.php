<?php 
function rate_stars($th_url,$item,$dl)
{?>
 <img style="float:right;" src="<?php echo $th_url;?>/_img/stars/<?php echo round($item/$dl);?>.jpg";?>
<?}
?>