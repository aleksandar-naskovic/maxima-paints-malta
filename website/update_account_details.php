<?php
require_once("../0_core/config.php");
include("../0_core/session.php");

$s_user = new User_Class();
if (isset($_SESSION['username'])) {
  $s_user->LoadUser("username", $_SESSION['username']);
}
if (isset($_POST["submit"])) {  
  // Populate user fields
  $s_user->username       = mysqli_real_escape_string($db, $_POST['username']);
  $s_user->first_name     = mysqli_real_escape_string($db, $_POST['first_name']);
  $s_user->last_name      = mysqli_real_escape_string($db, $_POST['last_name']);
  $s_user->user_email     = mysqli_real_escape_string($db, $_POST['email']);
  $s_user->user_address   = mysqli_real_escape_string($db, $_POST['user_address']);
  $s_user->user_phone_no  = mysqli_real_escape_string($db, $_POST['user_phone_no']);

  $s_user->EditUser($s_user->username);
  
  
}

?>
<html>
  <head>
    <title>Update account details</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="update_account_details.css">   
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <br>
      <h2>Update account details</h2><br>
     
      <!-- 
  Update form
-->
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
      
        <p class="underline">Update info</p><br>
<!-- 
  Username
-->
        <div class="FlexContainer">        
          <div class="col-25">  
            <label>Username</label>
          </div>
          <div class="col-75">
            <input type="text" name="username" value="<?php echo $s_user->username; ?>" >
          </div>
        </div><br>
<!-- 
  First name
-->
<div class="FlexContainer">        
        <div class="col-25">  
            <label>First name</label>
          </div>
          <div class="col-75">
            <input type="text" name="first_name" value="<?php echo $s_user->first_name; ?>">
          </div>
        </div><br>
<!-- 
  Last name
-->
<div class="FlexContainer">        
        <div class="col-25">  
          <label>Last name</label>
        </div>
        <div class="col-75">
         <input type="text" name="last_name" value="<?php echo $s_user->last_name; ?>">
        </div>
      </div><br>
<!-- 
  Email
-->
<div class="FlexContainer">
            <div class="col-25">
              <label>Email</label>
            </div>
            <div class="col-75">
              <input type="text" name="email" value="<?php echo $s_user->user_email; ?>">
            </div>
        </div><br>
<!-- 
  User Address
-->
<div class="FlexContainer">
            <div class="col-25">
              <label>User Address</label>
            </div>
            <div class="col-75">
              <input type="text" name="user_address" value="<?php echo $s_user->user_address; ?>" >
            </div>
        </div><br>
<!-- 
  Phone number
-->
        <div class="FlexContainer">
          <div class="col-25">  
            <label>Phone number</label>
          </div>
          <div class="col-75">
          <input type="text" name="user_phone_no" value="<?php echo $s_user->user_phone_no; ?>">
          </div>
        </div><br>

<!-- 
  Update Button
-->
          <p class="underline">&nbsp;</p> 

          <button type="submit" class="btn" name="submit">Update</button>       

</form>
    </div>
  </body>
</html>