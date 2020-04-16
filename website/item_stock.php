<?php
require_once("../0_core/config.php");
include("../0_core/session.php");

function f_new_stock($p_item_id, $p_value){
  global $db;

  $query = "UPDATE items 
            SET    item_stock = item_stock + " . $p_value . "
            WHERE  item_id = '$p_item_id'
            ";

  mysqli_query($db, $query);
  mysqli_commit($db);

  return true;
}

function function_remove_stock( $p_item_id, $p_value){
  global $db;

  $query = "UPDATE item_addendum_stock
            SET    item_stock_quantity = item_stock_quantity - " . $p_value . "
            WHERE  item_id = '$p_item_id'
          ";
  
  mysqli_query($db, $query);
  mysqli_commit($db);

  return true;
}


// Stock changing functionality
if (isset($_POST["sub_item_id"])) {  
  //check if item exist
  $v_sub_item_id = mysqli_real_escape_string($db, $_POST['sub_item_id']);
  $v_sub_value   = mysqli_real_escape_string($db, $_POST['sub_value']);
  $v_sub_action  = mysqli_real_escape_string($db, $_POST['sub_action']);
  $v_sub_comment = mysqli_real_escape_string($db, $_POST['sub_comment']);

  $s_stock_history = new Stock_History_Class();
    //Get item by id
    $item = get_item_id($v_sub_item_id);
    // Get VAT value
    $vat_value = GetSettingValue('vat');

  if ($v_sub_action == 'A'){
    f_new_stock($v_sub_item_id, $v_sub_value);
    
    //
    // Populate stock fields
    //
    //$s_stock_history->record_date      = mysqli_real_escape_string($db, $_POST['item_category']);
    //$s_stock_history->orig_record_id   = mysqli_real_escape_string($db, $_POST['item_volume']);
    $s_stock_history->user             = mysqli_real_escape_string($db, $_SESSION['username']);
    $s_stock_history->record_type      = mysqli_real_escape_string($db, 'ADD');
    $s_stock_history->change_value     = mysqli_real_escape_string($db, $v_sub_value);
    $s_stock_history->item_id          = mysqli_real_escape_string($db, $v_sub_item_id);
    $s_stock_history->item_name        = mysqli_real_escape_string($db, $item['item_name']);
    $s_stock_history->item_category    = mysqli_real_escape_string($db, $item['item_category']);
    $s_stock_history->item_new_stock   = mysqli_real_escape_string($db, ($item['item_stock']+$v_sub_value));
    $s_stock_history->item_volume      = mysqli_real_escape_string($db, $item['item_volume']);
    $s_stock_history->item_unit        = mysqli_real_escape_string($db, $item['item_unit']);
    $s_stock_history->item_price       = mysqli_real_escape_string($db, $item['item_price']);
    //$s_stock_history->item_disc10      = mysqli_real_escape_string($db, $item['item_name']);
    //$s_stock_history->item_status      = mysqli_real_escape_string($db, $item['item_name']);
    $s_stock_history->vat              = mysqli_real_escape_string($db, $vat_value);
    $s_stock_history->comment          = mysqli_real_escape_string($db, $v_sub_comment);
    // Create history function
    $s_stock_history->CreateHistory();
                                         


  }elseif($v_sub_action == 'R'){
    function_remove_stock($v_sub_item_id, $v_sub_value);
    //
    // Populate stock fields
    //
    //$s_stock_history->record_date      = mysqli_real_escape_string($db, $_POST['item_category']);
    //$s_stock_history->orig_record_id   = mysqli_real_escape_string($db, $_POST['item_volume']);
    $s_stock_history->user             = mysqli_real_escape_string($db, $_SESSION['username']);
    $s_stock_history->record_type      = mysqli_real_escape_string($db, 'REMOVE');
    $s_stock_history->change_value     = mysqli_real_escape_string($db, $v_sub_value);
    $s_stock_history->item_id          = mysqli_real_escape_string($db, $v_sub_item_id);
    $s_stock_history->item_name        = mysqli_real_escape_string($db, $item['item_name']);
    $s_stock_history->item_category    = mysqli_real_escape_string($db, $item['item_category']);
    $s_stock_history->item_new_stock   = mysqli_real_escape_string($db, ($item['item_stock']-$v_sub_value));
    $s_stock_history->item_volume      = mysqli_real_escape_string($db, $item['item_volume']);
    $s_stock_history->item_unit        = mysqli_real_escape_string($db, $item['item_unit']);
    $s_stock_history->item_price       = mysqli_real_escape_string($db, $item['item_price']);
    //$s_stock_history->item_disc10      = mysqli_real_escape_string($db, $item['item_name']);
    //$s_stock_history->item_status      = mysqli_real_escape_string($db, $item['item_name']);
    $s_stock_history->vat              = mysqli_real_escape_string($db, $vat_value);
    $s_stock_history->comment          = mysqli_real_escape_string($db, $v_sub_comment);
    // Create history function
    $s_stock_history->CreateHistory();
  }
  //
  //
}


?>
<html>
  <head>
    <title>Item Stock</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css">
    <link rel="stylesheet" type="text/css" href="../0_core/generic_input.css">
    <link rel="stylesheet" type="text/css" href="all_items.css">       
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <div class="link_decor">
        <a href="../website/all_items.php">
          <h2>Item Stock</h2>
      </a>
    </div>

    <div class="page">	<br>
      <table>
          <tr>
            <th width="8%"></th>
            <th width="7%"></th> 
            <th width="5%"></th>
            <th width="5%" class="link_decor">Stock</th>
            <th width="5%"></th>
            <th width="300px" class="link_decor">Name</th>
            <th class='left link_decor' width="10%">Size</th>
            <th class='left' width="15%">Expiry date</th>
          </tr>
        
        <?php

        $query = "SELECT it.item_id
                        ,it.item_name
                        ,it.item_category
                        ,it.item_volume
                        ,it.item_unit
                        ,it.item_price
                        ,it.item_disc10	 
                        ,NVL(ias.item_stock_quantity, '0') as item_stock_quantity
                        ,NVL(ias.stock_expiry_date, '/') as stock_expiry_date
                    FROM items it

                      -- Show ITEM records which are not existing in the addendum to be able to display them as Stock = 0
               LEFT JOIN item_addendum_stock ias
                      ON ias.item_id = it.item_id

                   WHERE it.item_id is not NULL
                ORDER BY stock_expiry_date asc, it.item_name asc" ;

echo "DBG [" . $query . "]";

        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result) > 0)
        {
          while($row = mysqli_fetch_array($result))
          {
        ?>
          
          <tr>
            <td><a href="<?= 'item.php?item_id='.$row['item_id'] ?>">
                <?php echo  '<img class="image" src="../images/'.$row['item_id'].'.png" height="100px" width="100px" alt ="n/a"/>'; ?>
            </a></td>
            <td><a class="edit" href="edit_item.php?item_id=<?php echo $row["item_id"]; ?>"><span>Edit</span></a></td>
            <td><button onclick="myFunction('<?php echo $row['item_id'];?>', '<?php echo $row['item_name'] . ' [' . $row['item_volume'] . $row['item_unit'] . ']'?>', 'A' )" >+</button></td>
            <td><?php echo $row["item_stock_quantity"]; ?></td>
            <td><button onclick="myFunction('<?php echo $row['item_id'];?>', '<?php echo $row['item_name'] . ' [' . $row['item_volume'] . $row['item_unit'] . ']'?>', 'R' )" >-</button></td>
            <!-- 
              Name 
            -->
            <td class='left link_decor'>
              <a href="<?php echo $_SERVER['PHP_SELF']?>?filterby=<?php echo $row["item_name"];?>">
                <span><?php echo $row["item_name"];?></span>
              </a
            ></td>
            <!-- 
              Size 
            -->
            <td class='left'><?php echo $row["item_volume"]." ".$row["item_unit"]; ?></td>
            <!-- 
              Expiry Date
            -->
            <td class='left'><?php echo $row["stock_expiry_date"]; ?></td>
          </tr>
          <!-- Trigger/Open The Modal -->



        <?php
          }
        }
        ?>
      </table>
  </div>

  <?php
    include("../2_modals/mod_Item_add_rem.php");
  ?>
 
<script>
  // Prevent a resubmit on refresh and back button
  if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href );
  }
</script>

</body>

</html>


