<?php
require_once("../0_core/config.php");
require_once("../0_core/session.php");
//
//
$s_user = new User_Class();
if (isset($_SESSION['username'])) {
  $s_user->LoadUser("username", $_SESSION['username']);
}
//
//
if (isset($_POST["submit"])) {  
  // Populate user fields
  $s_user->username       = $_SESSION['username'];
  $s_user->user_email     = mysqli_real_escape_string($db, $_POST['email']);
  $s_user->user_address   = mysqli_real_escape_string($db, $_POST['user_address']);
  $s_user->user_phone_no  = mysqli_real_escape_string($db, $_POST['user_phone_no']);
  //
  $s_user->UpdateUser($s_user->username);
  //
  // Redirect to My Account page
  header("Location: ../website/my_account.php");
}
//
?>

<html>
  <head>
    <title>Update Account Details</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="../0_core/generic_input.css"> 
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <br>
      <h2>Update Account Details</h2><br>
     
      <!-- 
  Update form
-->
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
      
        <p class="underline">Account Details</p><br>
<!-- 
  Username
-->
        <div class="FlexContainer">        
          <div class="col-25">  
            <label>Username</label>
          </div>
          <div class="col-75">
            <input type="text" name="username" value="<?php echo $s_user->username; ?>" disabled>
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

          <button type="submit" class="main_button" name="submit">Update</button>       

</form>
    </div>
  </body>
</html>