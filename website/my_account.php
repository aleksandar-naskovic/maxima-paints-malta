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
    <title>My account</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="../0_core/generic_input.css"> 
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <br>
      <h2>My Account</h2><br>
      <p class="underline">Account Details</p><br>
      <div class = "user_info">
        <div class="FlexContainer">
          <div class="col-25"> 
            <label>Username:</label>
          </div>
          <p><?php echo "<b>" . $s_user->username ."</b>"; ?></p>
        </div>
        <div class="FlexContainer">
          <div class="col-25"> 
            <label>Email:</label>
          </div>
          <p><?php echo "<b>" . $s_user->user_email ."</b>"; ?></p>
        </div>
        <div class="FlexContainer">
          <div class="col-25"> 
            <label>Address:</label>
          </div>
          <p><?php echo "<b>" . $s_user->user_address ."</b>"; ?></p>
        </div>
        <div class="FlexContainer">
          <div class="col-25"> 
            <label>Phone number:</label>
          </div>
          <p><?php echo "<b>" . $s_user->user_phone_no ."</b>"; ?></p>
        </div>
        <br>

        <button class="button" onclick="window.location.href = 'change_password.php';">Change Password</button>
        <button class="button" onclick="window.location.href = 'update_account_details.php';">Edit Account Details</button>
        <br>

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
    else echo "<b>You don't have any purchase history yet.</b>";
    ?>
    </div>
  </body>
</html>