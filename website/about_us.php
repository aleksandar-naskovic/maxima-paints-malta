<?php
require_once("../0_core/config.php");
include("../0_core/session.php");

?>
<html>
  <head>
    <title>About us</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="about_us.css">     
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <h2>About us</h2>	<br>
      <p><?php echo GetSettingValue("about_us_text");?></p>
    </div>
  </body>
</html>