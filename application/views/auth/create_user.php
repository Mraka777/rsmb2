<h1><?php echo lang('create_user_heading');?></h1>
<p><?php echo lang('create_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
//echo($ip." - ");

$ip_link = "http://api.wipmania.com/";
$ip_link .= $ip;

$country = file_get_contents($ip_link);

?>


<?php echo form_open("auth/create_user");?>

      <p>
            <label for="first_name">Username:</label> <br />
            <input type="text" name="first_name" value="" id="first_name"  />      </p>

      <!--<p>
            <label for="last_name">Last Name:</label> <br />
            <input type="text" name="last_name" value="" id="last_name"  />      </p>

      <p>
            <label for="company">Company Name:</label> <br />
            <input type="text" name="company" value="" id="company"  />      </p> -->

      <p>
            <label for="email">Email:</label> <br />
            <input type="text" name="email" value="" id="email"  />      </p>

      <!--<p>
            <label for="phone">Phone:</label> <br />
            <input type="text" name="phone" value="" id="phone"  />      </p>-->

      <p>
            <label for="password">Password:</label> <br />
            <input type="password" name="password" value="" id="password"  />      </p>

      <p>
            <label for="password_confirm">Confirm Password:</label> <br />
            <input type="password" name="password_confirm" value="" id="password_confirm"  />      </p>

      <p>
            <label for="user_country">Your country (based on IP address)</label> <br />
            RU      </p>
      
      <p><input type="submit" name="submit" value="Create User"  /></p>

<?php echo form_close();?>
