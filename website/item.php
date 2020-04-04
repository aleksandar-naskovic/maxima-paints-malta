<?php
  require_once("../0_core/config.php");  
  include("../0_core/session.php");
  //
  $vat = GetSettingValue('VAT');
  //
  // Load Item
  //
  $item = get_item_id( $_GET['item_id']);
  $item_name = $item['item_name'];
  //
  // Load Item Price
  $v_price = $item['item_price'];
  //
  // Load Item Coverage
  $v_coverage = $item['item_coverage'];
  //
  // Load Item Volume
  $v_volume = "not defined";
  if(!empty($item['item_volume'])){$v_volume = $item['item_volume'];}
  //
  // Load Item Discount
  $v_disc_10 = $item['item_disc10'];
  //
  // Load Item Stock
  $v_stock = $item['item_stock'];
  //
  // Add to basket submited
  if(isset($_POST["item_add_to_cart"]))
  {
    // Check if Cart is empty
    if(isset($_SESSION["shopping_cart"])) // Cart is not empty
    {
      //
      // Check if item is already in the Cart
      if(empty($_SESSION["shopping_cart"][$item['item_id']]["item_id"])) // Item is NOT in the cart
      {
        //$v_old_qty =  $_SESSION["shopping_cart"][$item['item_id']]["item_quantity"];
        //
        $item_array = array(
          'item_id'			  =>	$item['item_id'],
          'item_name'			=>  $item['item_name'],
          'item_price'	  =>	$v_price,
          'item_disc10'	  =>	$v_disc_10,
          'item_quantity'	=>	$_POST["qty"],
          'item_stock'    =>  $v_stock
        );
        $_SESSION["shopping_cart"][$item['item_id']] = $item_array;
      }
      else // Item is already in the cart
      {
        $v_qty = number_format($_SESSION["shopping_cart"][$item['item_id']]["item_quantity"]) + $_POST["qty"];
        //
        $_SESSION["shopping_cart"][$item['item_id']]["item_quantity"] = $v_qty;
      }
    }
    else // Cart is empty
    {
      $item_array = array(
        'item_id'			  =>	$item['item_id'],
        'item_name'		  =>	$item['item_name'],
        'item_price'	  =>	number_format($v_price,2),
        'item_disc10'	  =>	number_format($v_disc_10,2),
        'item_quantity'	=>	$_POST["qty"],
        'item_stock'    =>  $v_stock
      );
      $_SESSION["shopping_cart"][$item['item_id']] = $item_array;
    }
  }

?>

<html>
  <head>
    <title>Item page</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="item.css">      
  </head>
  <body>
    <?php
      include("navbar.php");
    ?>
    <div class="item_container">
      <a class="category_link" href="../website/category.php?category_name=<?php echo $item['item_category'];?>" >
        < <?php echo $item['item_category']; ?>
      </a>

      <div class="photo_frame">
<!--
  Item Photo
-->
        <div class="item_photo">
          <?php echo  '<img src="../images/'.$item['item_id'].'.png" >'; ?>
          <h3 class="main_description"><?php echo $item['item_description'];?></h3>
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
              <p class="pricetext">€ <?php echo number_format(round($v_price,2),2);?></p>
            </div>
<!--
  VAT
-->
            <p class="underline">VAT</p>
            <div class="vat">
              <p class="vat_text">€ <?php echo number_format(round($v_price*$vat, 2),2);?></p>
            </div>
<!--
  Discount
-->
            <?php //Display Discount only if value exists in DB
              //
              if (!empty($v_disc_10)){
                echo '<p class="underline discountlabel">Discount for 10+</p>';
                echo '<div class="price">';
                echo '  <p class="discounttext">€ ' . number_format(round($v_disc_10,2),2) . '</p>';
                echo '</div>';
              }
            ?>
<!--
  Size
-->
            <p class="underline sizelabel">Size</p>
            <div class="price">
              
              <?php  
              $query = "SELECT * 
                        FROM items
                        WHERE item_name = '$item_name'
                        ";
              
              $result = mysqli_query($db, $query);
                if(mysqli_num_rows($result) > 0){
                  while($row = mysqli_fetch_array($result))
                  { ?>
                  
                    <?php if($row['item_id'] == $_GET['item_id']){?>
                      <a style="border: 3px solid #ff6804;" class="volume_button" href="item.php?item_id=<?php echo $row['item_id']; ?>" onmouseover="displayPrice('<?php echo $row['item_price'];?>')"><?php echo $row['item_volume'];?><?php echo $item['item_unit'];?></a>
                    <?php 
                    continue;
                      } //endif
                    else?>
                      <a class="volume_button" href="item.php?item_id=<?php echo $row['item_id']; ?>" onmouseover="displayPrice('<?php echo $row['item_price'];?>')"><?php echo $row['item_volume'];?><?php echo $item['item_unit'];?></a>
                    <?php
                }
              }
                    ?>
            </div>
            <p id="price_js"></p>
<!--
  Quantity Left
-->
            <p class="underline quantitylabel">Quantity Left</p>
            <div class="stock">
              <p class="stock"><?php echo $v_stock;?></p>
            </div>
<!--
  Add to basket Quantity
-->
      
            <div class="quantity">
              <?php 
                if($v_stock > 0){
                  echo '<input class="qtyinput" min="1" max="'.$v_stock.'" type="number" name="qty" id="qty" maxlength="2" value="1">';
                }
              ?>
            </div>
          </div>
        </div>
<!--
  Add to basket
-->
        <div class="input-group">
          <?php 
            if($v_stock > 0){
              echo '<button type="submit" class="btn" name="item_add_to_cart">Add to basket</button>';
            }
          ?>
        </div>
        </form>
      </div>

<!--
  Item coverage
-->
            <?php //Display Item Coverage only if value exists in DB
              //
              if (!empty($v_coverage)){
                echo '<div class="divHowToUse">';
                echo '<p class="underline"><strong>Item coverage:</strong></p>';
                echo $item["item_coverage"]."m<sup>2";
                echo '<br>';
                echo '</div>';
              }
            ?>
<!--
  Characteristics
-->
        <div class="divHowToUse">
          <p class="underline"><strong>Characteristics:</strong></p>
          <p><?php echo $item['item_characteristic'];?></p>
          <br>
        </div>
<!--
  How to Use
-->
        <div class="divHowToUse">
          <p class="underline"><strong>How to use:</strong></p>
          <p><?php echo $item['item_how_to_use'];?></p>
          <br>
        </div>
<!--
  Additional Info
-->
        <div class="divAdditional">
          <p class="underline"><strong>Additional Info:</strong></p>
          <p><?php echo $item['item_add_info'];?></p>
          <br>
        </div>

      </div>
    </div>
    <script>
    function displayPrice(p_item_price) {
      document.getElementById("price_js").innerHTML  = "€ "+p_item_price;
      document.getElementById("price_js").style  = "color:red";
    }
    
    </script>
  </body>
</html>