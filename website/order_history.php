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
    <title>Order history</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="../0_core/generic_input.css">   
    <link rel="stylesheet" type="text/css" href="all_items.css">   
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <br>
      <h2>Order history</h2><br>
         <!-- 
  Order history table
-->
      <!-- Load order history -->
      <?php  $history = Order_History_Class::get_order_history();?>

      <p class="underline">Order history</p><br>
      <?php if(!empty($history))
      {?>
      <table>
            <tr>
              <th width="10%">Date</th>
              <th width="10%">Order Number</th>
              <th width="20%">Item name</th>
              <th width="20%">Item category</th> 
              <th width="10%">Qty</th>
              <th width="5%">Size</th>
              <th width="10%">Price</th>
              <th width="10%">Disc</th>
              <th width="10%">User</th>
              <th width="10%">Status</th>
              <th width="10%">Delivery date</th>
              <th width="10%">Paid amount</th>
              <th width="10%"></th>
            </tr>
          
  
           <?php foreach($history as $key => $s_history) 
	      {    ?>
  
            <tr>
              <td><?php echo $s_history['record_date']; ?></td>
              <td><?php echo $s_history['order_number_sequence']; ?></td>           
              <td><?php echo $s_history['item_name']; ?></td>
              <td><?php echo $s_history['item_category']; ?></td>
              <td><?php echo $s_history['item_quantity']; ?></td>
              <td><?php echo $s_history['item_volume']." ".$s_history['item_unit']; ?></td>
              <td><?php echo $s_history['item_price']; ?></td>
              <td><?php echo $s_history['item_disc10']; ?></td>
              <td><?php echo $s_history['user_username']; ?></td>           
              <td><?php echo $s_history['order_status']; ?></td>           
              <td><?php echo $s_history['delivery_date']; ?></td>           
              <td><?php echo $s_history['paid_amount']; ?></td>           
              <td><a href="order_info.php?order_id=<?php echo $s_history['order_number_sequence']; ?>">More</a></td>           
            </tr>
<?php	  }?>
            
    </table>
    <?php 
      } 
    ?>
    </div>
  </body>
</html>