<?php
require_once("../0_core/config.php");
include("../0_core/session.php");
//
//Read parameters from URL
//
$v_order_id = $_GET['order_id'];
//
//If delivered button is clicked
if (isset($_POST["delivered"]))  {  
  //
  $s_order_history = new Order_History_Class();
  $s_order_history->item_delivered($_POST["delivered"], $v_order_id);
  //
  header("Location: ../website/order_history.php");
}
//
//
if (isset($_POST["return"])) {  
  //
  $item_id = $_POST["return"];
  // classes
  $s_stock_history = new Stock_History_Class();
  $s_order_history = new Order_History_Class();
  //load history
  $s_order_history->LoadOrderHistoryById($item_id, $v_order_id);
  //get item quantity value
  $item_quantity = $s_order_history->item_quantity;
  //Get item by id
  $item = get_item_id($item_id);
  // Get VAT value
  $vat_value = GetSettingValue('vat');
  
  //
  // Populate stock history fields
  //
  $s_stock_history->user             = mysqli_real_escape_string($db, $_SESSION['username']);
  $s_stock_history->record_type      = mysqli_real_escape_string($db, 'RETURNED');
  $s_stock_history->change_value     = mysqli_real_escape_string($db, $s_order_history->item_quantity);
  $s_stock_history->item_id          = mysqli_real_escape_string($db, $item_id);
  $s_stock_history->item_name        = mysqli_real_escape_string($db, $item['item_name']);
  $s_stock_history->item_category    = mysqli_real_escape_string($db, $item['item_category']);
  $s_stock_history->item_new_stock   = mysqli_real_escape_string($db, ($item['item_stock']+$s_order_history->item_quantity));
  $s_stock_history->item_volume      = mysqli_real_escape_string($db, $item['item_volume']);
  $s_stock_history->item_unit        = mysqli_real_escape_string($db, $item['item_unit']);
  $s_stock_history->item_price       = mysqli_real_escape_string($db, $item['item_price']);
  $s_stock_history->vat              = mysqli_real_escape_string($db, $vat_value);
  // Create history function
  $s_stock_history->CreateHistory();
  //
  //Return quantity to item stock
  echo new_stock($s_order_history->item_quantity, $item_id);
  //                                    


  }
?>
<html>
  <head>
    <title>Order info</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="../0_core/generic_input.css">
    <link rel="stylesheet" type="text/css" href="all_items.css">
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <br>
      <h2>Order info</h2>
        <!-- 
  Order history table
-->
      <!-- Load order history -->
      <?php $history = Order_History_Class::LoadOrderHistory("order_number_sequence", $v_order_id);?>

    <p class="underline">Order history</p><br>
    <?php if(!empty($history))
    {?>
    
    <form method="post" id="order_history_form" action="<?php echo $_SERVER['PHP_SELF']. '?order_id='.$v_order_id;; ?>" enctype="multipart/form-data"></form>
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
        <td><button type="submit" form="order_history_form" name="delivered" value="<?php echo $s_history['item_id']; ?>">Delivered</button></td>                  
        <td><button type="submit" form="order_history_form" name="return" value="<?php echo $s_history['item_id']; ?>">Return</button></td>                                   
      </tr>
    <?php	
      } //end of foreach
    ?>      
    </table>
    <?php 
    } // end if
    ?>
      <br>
      <div class="FlexContainer">        
        <div class="col-25">  
          <label>Paid amount</label>
        </div>
        <div class="col-75">
         <input type="text" name="paid amount" value="">
        </div>
      </div><br>

      
    </div>
  </body>
</html>
    