<?php
require_once("../0_core/config.php");
include("../0_core/session.php");
//
$v_item_filter = "";
$v_date_filter     = "";
$v_date_end_filter = "";
//
?>

<html>
  <head>
    <title>Stock history</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="all_items.css">       
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <h2>Stock history</h2>
     
      <div class="page"><br>
      <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <label for="name1">Item name:</label>
        <input type="text" name="post_item_name">
        <label for="date1">Date start: </label>
        <input type="date" name="post_date_start">
        <label for="date2">Date end: </label>
        <input type="date" name="post_date_end">
        <button type="submit" name="submit">Search</button>
      </form>
        <table>
            <tr>
              <th width="10%">Date</th>
              <th width="10%">User</th>
              <th width="10%">Change type</th>
              <th width="5%">Change value</th>
              <th width="20%">Item name</th>
              <th width="20%">Item category</th>
              <th width="5%">New item stock</th>
              <th width="5%">Size</th>
              <th width="5%">Price</th>
              <th width="5%">Vat</th>
              <th width="10%">Comment</th>
            </tr>
            
            <?php
              if (isset($_POST["submit"])) {              
                $v_item_name  =  $_POST['post_item_name'];         
                $v_date_start =  $_POST['post_date_start'];
                $v_date_end   =  $_POST['post_date_end'];
                echo "POST: [" .$v_item_name. "]";
                
                //Check if item name is empty
                if (!empty($_POST["post_item_name"])) {
                  $v_item_filter =  " AND item_name = '$v_item_name' ";
                }
                //Check if date is empty
                if (!empty($v_date_start)) {
                  $v_date_filter =  " AND date >= '" .$v_date_start. " 00:00:00' ";
                }
                //Check if date end is empty
                if (!empty($v_date_end)) {
                  $v_date_end_filter =  " AND date <= '" .$v_date_end. " 24:59:59' ";
                }
              }
            ?>
            
            <?php
          $query = "SELECT * FROM stock_history WHERE 1 = 1 " . $v_item_filter . $v_date_filter . $v_date_end_filter . "";

echo "DBG: [" .$query. "]";

          $result = mysqli_query($db, $query);
          $v_row_num = mysqli_num_rows($result);

          if($v_row_num > 0)
          {
            while($row = mysqli_fetch_array($result))
            {
          ?>
             
            <tr>
              <td><?php echo $row["record_date"]; ?></td>
              <td><?php echo $row["user"]; ?></td>
              <td><?php echo $row["record_type"]; ?></td>
              <td><?php echo $row["change_value"]; ?></td>
              <td><?php echo $row["item_name"]; ?></td>
              <td><?php echo $row["item_category"]; ?></td>
              <td><?php echo $row["item_new_stock"]; ?></td>
              <td><?php echo $row["item_volume"]." ".$row["item_unit"]; ?></td>
              <td><?php echo $row["item_price"]; ?></td>
              <td><?php echo $row["vat"]; ?></td>
              <td><?php echo $row["comment"]; ?></td>
              
            </tr>
            <?php
            }
          }
        ?>
              
          </table>

          <?php 
            if($v_row_num == 0){
              echo '<h2> No Data Found! </h2>';
            }          
          ?>
         
      </div>
  </body>
</html>


