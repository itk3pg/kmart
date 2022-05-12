<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <link rel="icon" type="image/ico" href="<?php echo base_url(); ?>images/favicon.ico">
  <title>Login Form</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
  <script src="<?php echo base_url(); ?>js/jquery-1.10.2.js"></script>
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <section class="container">
  	<!-- <center><img src="<?php echo base_url(); ?>images/smart_logo.png" style="width: 200px; margin-bottom: 30px; " /></center> -->
    <div class="login">
    <!-- <?php echo base_url();  ?>  -->
     <!--  server name:<?php echo  $_SERVER['SERVER_NAME']; ?>: -->
      <h1>Silahkan Login</h1>
      <form method="post" action="<?php echo base_url(); ?>index.php/login/proseslogin">
      	<p style="color: red; margin-top: -10px; margin-bottom: -10px;"><?php echo $this->session->flashdata('error_login'); ?></p>
        <p><input type="text" name="username" onkeyup="setUpper()" id="username" value="" placeholder="Username"></p>
        <p><input type="password" name="password" id="password" value="" placeholder="Password"></p>
        <p class="submit"><input type="submit" name="commit" value="Login"></p>
      </form>
    </div>
    <!--<p style="color: white; margin-left: 225px; margin-top: 10px;">Page rendered in <strong>{elapsed_time}</strong> seconds</p> -->
	<p style="color: white; margin-left: 250px; margin-top: 10px;">PUSLAHDA K3PG @2020</p> 
  </section>
  <script>
	function setUpper(){
		var username = $("#username").val();
		var res = username.toUpperCase();
		$("#username").val(res);
	}
  </script>
</body>
</html>