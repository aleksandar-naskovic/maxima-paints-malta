<?php
require_once("../0_core/config.php");
include("../0_core/session.php");

$s_user = new User_Class();
if (isset($_SESSION['username'])) {
  $s_user->LoadUser("username", $_SESSION['username']);
}
?>
<html>
  <head>
    <title>Change password</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="../0_core/generic_input.css"> 
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <br>
      <h2>Change password</h2><br>
     
      <!-- 
  Update form
-->
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
      
        <p class="underline">Change password</p><br>
<!-- 
  Old password
-->
        <div class="FlexContainer">        
          <div class="col-25">  
            <label>Old password</label>
          </div>
          <div class="col-75">
            <input type="password" name="old_password">
          </div>
        </div><br>
<!-- 
  New password
-->
        <div class="FlexContainer">        
          <div class="col-25">  
            <label>New password</label>
          </div>
          <div class="col-75">
            <input type="password" name="new_password">
          </div>
        </div><br>
<!-- 
  Confirm new password
-->
      <div class="FlexContainer">        
        <div class="col-25">  
          <label>Confirm new password</label>
        </div>
        <div class="col-75">
         <input type="password" name="confirm_password">
        </div>
      </div><br>
<!-- 
  Update Button
-->
      <p class="underline">&nbsp;</p> 
      <button type="submit" class="main_button" name="submit">Update</button> 
  <!-- 
  If button clicked
-->
  <?php 
  if (isset($_POST["submit"])) { 
    //check old password
    if($s_user->password == md5($_POST['old_password'])) {
      // check if new password match the confirm password
      if (strcmp($_POST['new_password'], $_POST['confirm_password']) == 0) {
        $s_user->password = mysqli_real_escape_string($db, $_POST['new_password']);
        $s_user->ChangePassword($s_user->username);
        echo "<h3>Password updated</h3>";
      }
      else echo "<h3>New password doesn't match the confirm password</h3>";
    }
    else echo "<h3>Your old password is not correct</h3>";
  }
?>      
</form>
    </div>
  </body>
</html>