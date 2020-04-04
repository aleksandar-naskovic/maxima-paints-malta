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
    <title>My account</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="my_account.css">   
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <br>
      <h2>My account</h2><br>
      <p class="underline"><?php echo $s_user->first_name; ?>'s info</p><br>
      <div class = "user_info" style="text-align: left;">
        <p>Username: <?php echo $s_user->username; ?></p>
        <p>Full name: <?php echo $s_user->first_name. " ".$s_user->last_name ; ?></p>
        <p>Email: <?php echo $s_user->user_email; ?></p>
        <p>Address: <?php echo $s_user->user_address; ?></p>
        <p>Phone number: <?php echo $s_user->user_phone_no; ?></p>
      </div>
         <!-- 
  Purchase history
-->
      <!-- Load user history -->
      <?php $history=Stock_History_Class::get_purchase_history($_SESSION['username']);?>
      <p class="underline">Purchase history</p><br>
      <?php if(!empty($history))
      {?>
      <table>
            <tr>
              <th width="20%">Date</th>
              <th width="30%">Name</th> 
              <th width="5%">Qty</th>
              <th width="10%">Size</th>
              <th width="10%">Price</th>
            </tr>
          
  
           <?php foreach($history as $s_history) 
	      {    ?>
  
            <tr>
              <td><?php echo $s_history['record_date']; ?></td>
              <td><?php echo $s_history['item_name']; ?></td>
              <td><?php echo $s_history['change_value']; ?></td>
              <td><?php echo $s_history['item_volume'] ." ". $s_history['item_unit']; ?></td>
              <td><?php echo "€".$s_history['item_price']; ?></td>            
            </tr>
<?php	  }?>
            
    </table>
    <?php 
      } 
    else echo "<b>You don't have any purchase history</b>";
    ?>
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