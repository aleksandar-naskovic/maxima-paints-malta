<?php
require_once("../0_core/config.php");
include("../0_core/session.php");

?>
<html>
  <head>
    <title>Contact</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="contact.css">     
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <h2>Contact</h2><br>
      <p><?php echo GetSettingValue("contact_text");?></p>
    </div>
  </body>
</html>