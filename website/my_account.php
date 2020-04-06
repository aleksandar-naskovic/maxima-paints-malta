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
    <link rel="stylesheet" type="text/css" href="my_account.css">   
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <br>
      <h2>My account</h2><br>
      <p class="underline"><?php echo $s_user->first_name; ?>'s info</p><br>
      <div class = "user_info">
        <p>Username: <?php echo "<b>" . $s_user->username ."</b>"; ?></p>
        <p>Full name: <?php echo "<b>" . $s_user->first_name. " ".$s_user->last_name ."</b>" ; ?></p>
        <p>Email: <?php echo "<b>" . $s_user->user_email ."</b>"; ?></p>
        <p>Address: <?php echo "<b>" . $s_user->user_address ."</b>"; ?></p>
        <p>Phone number: <?php echo "<b>" . $s_user->user_phone_no ."</b>"; ?></p>
        <a href="update_account_details.php"><button class="generic_button">Edit account details</button></a>
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
    </div>
  </body>
</html>