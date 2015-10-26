<div class="col-sm-9">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Next day</h3>
    </div>
    <div class="panel-body">
      <?php if (isset($current_day)) echo('Текущий день '.$current_day.'<br>'); ?>
      
      <a href="/next/edit_infr">Edit infra</a><br>
      <a href="/next/edit_help">Edit help</a><br>
      <a href="/next/show_help">Show help</a><br>
      
     <!-- <a href="/next/increase_day">Next day w/o training</a><br>-->
      <a href="/next/increase_training_day">Next day +training</a><br>
      <a href="/core/simple.php?country=1">Race country_id = 1</a><br>
      <a href="/core/simple.php?country=2">Race country_id = 2</a><br><br>
      <a href="/next/generate_season">Generate new season</a><br><br>
      <a href="/next/logout">Log out</a><br><br><br>
      
    </div>