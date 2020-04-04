<?php
include("../0_core/session.php");
require_once("../0_core/config.php");

//Declare variables
$v_stock = "";
$v_comment= "";
$v_item_id = $_GET['item_id'];

?>

<html>
  <head>
    <title>Add Stock</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css">
    <link rel="stylesheet" type="text/css" href="add_stock.css">    
  </head>
  <body>
    <div>
    <h2>Add Stock</h2>	<br><br>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']."?item_id=".$v_item_id; ?>" enctype="multipart/form-data">
        <div class="input-group">
          <label>Stock</label>
          <input type="text" name="stock" value="<?php $v_stock; ?>">
        </div><br>
        <div class="input-group">
          <label>Comment</label>
          <input type="text" name="comment" value="<?php $v_comment; ?>">
        </div><br>
         <button type="submit" class="btn" name="submit">Add stock</button>
        
      </form>
    
    <?php

    if (isset($_POST["submit"])) {  
        $v_stock   =   mysqli_real_escape_string($db, $_POST['stock']);
        $v_comment =   mysqli_real_escape_string($db, $_POST['comment']);
        //call add stock function
        insert_stock_history($v_stock, $v_comment);
       add_stock($v_stock, $v_item_id);
    }
    ?>
    </div>
  </body>
</html>