<?php
  require_once("../0_core/config.php");  
  include("../0_core/session.php");
  //
  // Load Item
  //
  $item = get_item_id( $_GET['item_id']);
  //
  // Load Item Price
  $v_price = "not defined";
  if(!empty($item['price'])){$v_price = $item['price'];}
  //
  // Load Item Volume
  $v_volume = "not defined";
  if(!empty($item['volume'])){$v_volume = $item['volume'];}
  //
  // Load Item Discount
  $v_discount = $item['discount'];

?>

<html>
  <head>
    <title>Item page</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="item_photo.css">      
  </head>
  <body>
    <?php include("navbar.php")?>
    
    <div class="item_container">
      <div class="photo_frame">
<!--
  Item Photo
-->
        <div class="item_photo">
          <?php echo  '<img src="../images/'.$item['item_id'].'.png" >'; ?>
          <h3 class="main_description"><?php echo $item['main_description'];?></h3>
        </div>
      </div>

      <div class="item_details">
<!--
  Item Name
-->
        <h1 id="item_name"><?php echo $item['item_name'];?></h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?item_id='.$item['item_id']; ?>" enctype="multipart/form-data">
        <div class="input-group">
          <div class="fieldset">
<!--
  Price
-->
            <p class="underline">Price</p>
            <div class="price">
              <p class="pricetext">€ <?php echo $v_price;?></p>
            </div>
<!--
  Discount
-->
            <?php //Display Discount only if value exists in DB
              //
              if (!empty($v_discount)){
                echo '<p class="underline discountlabel">Discount for 10+</p>';
                echo '<div class="price">';
                echo '  <p class="discounttext">€ ' . $v_discount . '</p>';
                echo '</div>';
              }
            ?>
<!--
  Size
-->
            <p class="underline sizelabel">Size</p>
            <div class="price">
              <p class="sizetext"><?php echo $v_volume;?><?php echo $item['unit'];?></p>
            </div>
        </form>
      </div>

      </div>


    
    </div>

  </body>
</html>