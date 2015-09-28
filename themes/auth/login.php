<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biathlon manager 0.1b login</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>

<h1 align=center><?php echo lang('login_heading');?></h1>
<p align=center><?php echo lang('login_subheading');?></p>

<div class="container" id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/login");?>

  <p align=center>
    <?php echo lang('login_identity_label', 'identity');?>
    <?php echo form_input($identity);?>
  </p>

  <p align=center>
    <?php echo lang('login_password_label', 'password');?>
    <?php echo form_input($password);?>
  </p>

  <p align=center>
    <?php echo lang('login_remember_label', 'remember');?>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </p>


  <p align=center><?php echo form_submit('submit', lang('login_submit_btn'));?></p>

<?php echo form_close();?>

<p align=center><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>

</html>