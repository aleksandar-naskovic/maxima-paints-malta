<?php
require_once("../0_core/config.php");
include("../0_core/session.php");

//
//Read parameters from URL
//
$v_item_id = $_GET['item_id'];


function update_item( $p_item_id
                     ,$p_item_name
                     ,$p_item_volume
                     ,$p_item_unit
                     ,$p_item_price
                     ,$p_item_discount
                     ,$p_item_category
                     ,$p_item_main_description
                     ,$p_item_characteristic
                     ,$p_item_how_to_use
                     ,$p_item_additional_info
                     ,$p_item_interior
                     ,$p_item_exterior
                    ){
global $db;

$query = "UPDATE items
          SET    item_name         = '$p_item_name'
                ,volume          	 = '$p_item_volume'
                ,unit           	 = '$p_item_unit'
                ,price          	 = '$p_item_price'
                ,discount          = '$p_item_discount'
                ,category        	 = '$p_item_category'
                ,main_description	 = '$p_item_main_description'
                ,characteristic	   = '$p_item_characteristic'
                ,how_to_use	       = '$p_item_how_to_use'
                ,additional_info   = '$p_item_additional_info'
                ,interior       	 = '$p_item_interior'
                ,exterior	         = '$p_item_exterior'
          WHERE  item_id = '$p_item_id'
        ";

mysqli_query($db, $query);
mysqli_commit($db);

return TRUE;
}

//
if (isset($_POST["submit"])) {  
  //check if item exist
  $v_item_name =             mysqli_real_escape_string($db, $_POST['item_name']);
  $v_item_volume =           mysqli_real_escape_string($db, $_POST['item_volume']);
  $v_item_unit =             mysqli_real_escape_string($db, $_POST['item_unit']);
  $v_item_price =            mysqli_real_escape_string($db, number_format(round($_POST['item_price'],2),2));
  $v_item_discount =         mysqli_real_escape_string($db, number_format(round($_POST['item_disc10'],2),2));
  $v_item_category =         mysqli_real_escape_string($db, $_POST['item_category']);
  $v_item_main_description = mysqli_real_escape_string($db, $_POST['item_description']);
  $v_item_characteristic =   mysqli_real_escape_string($db, $_POST['item_characteristic']);
  $v_item_how_to_use =       mysqli_real_escape_string($db, $_POST['item_how_to_use']);
  $v_item_additional_info =  mysqli_real_escape_string($db, $_POST['item_add_info']);
  $v_item_interior =         mysqli_real_escape_string($db, $_POST['item_for_interior']);
  $v_item_exterior =         mysqli_real_escape_string($db, $_POST['item_for_exterior']);
  
  //update item function
  update_item( $v_item_id
              ,$v_item_name
              ,$v_item_volume
              ,$v_item_unit
              ,$v_item_price
              ,$v_item_discount
              ,$v_item_category
              ,$v_item_main_description
              ,$v_item_characteristic
              ,$v_item_how_to_use
              ,$v_item_additional_info
              ,$v_item_interior
              ,$v_item_exterior
             );

  header("Location: ../website/all_items.php");
}

$item = get_item_id($v_item_id);

$v_item_name =         $item['item_name'];
$v_item_volume =       $item['item_volume'];
$v_item_unit =         $item['item_unit'];
$v_category =          $item['item_category'];
$v_main_description =  $item['item_description'];
$v_characteristic =    $item['item_characteristic'];
$v_how_to_use =        $item['item_how_to_use'];
$v_add_info =          $item['item_add_info'];
$v_price =             $item['item_price'];
$v_discount =          $item['item_disc10'];
$v_interior =          $item['item_for_interior'];
$v_exterior =          $item['item_for_exterior'];

?>
<html>
  <head>
    <title>Edit Item</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="settings.css">   
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      
      <br>
      <h2>Edit item</h2><br>	
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']. '?item_id='.$item['item_id']; ?>" enctype="multipart/form-data">
      
        <p class="underline">Details</p><br>
<!-- 
  Item name
-->
        <div class="FlexContainer">        
          <div class="col-25">  
            <label>Item name</label>
          </div>
          <div class="col-75">
            <input type="text" name="item_name" value="<?php echo $v_item_name; ?>" >
          </div>
        </div><br>
<!-- 
  Item Volume
-->
<div class="FlexContainer">        
        <div class="col-25">  
            <label>Item Volume</label>
          </div>
          <div class="col-75">
            <input type="text" name="item_volume" value="<?php echo $v_item_volume; ?>">
          </div>
        </div><br>
<!-- 
  Item Unit
-->
<div class="FlexContainer">        
        <div class="col-25">  
          <label>Item Unit</label>
        </div>
        <div class="col-75">
         <input type="text" name="item_unit" value="<?php echo $v_item_unit; ?>">
        </div>
      </div><br>
<!-- 
  Price
-->
<div class="FlexContainer">
            <div class="col-25">
              <label>Price</label>
            </div>
            <div class="col-75">
              <input type="text" name="price" value="<?php echo $v_price; ?>">
            </div>
        </div><br>
<!-- 
  Discount
-->
<div class="FlexContainer">
            <div class="col-25">
              <label>Discount</label>
            </div>
            <div class="col-75">
              <input type="text" name="discount" value="<?php echo $v_discount; ?>" >
            </div>
        </div><br>
<!-- 
  Category
-->
        <div class="FlexContainer">
          <div class="col-25">  
            <label>Category</label>
          </div>
          <div class="col-75">
          <input type="text" name="category" value="<?php echo $v_category; ?>">
          </div>
        </div><br>
<!-- 
  Main description
-->
        <div class="FlexContainer">
          <div class="col-25">  
            <label>Main description</label>
          </div>
          <div class="col-75">
          <input type="text" name="main_description" value="<?php echo $v_main_description;?>">
          </div>
        </div><br>
<!-- 
  Characteristic
-->
        <div class="FlexContainer_up">
          <div class="col-25">  
            <label>Characteristic</label>
          </div>
          <div class="col-75">
          <textarea id="characteristic" rows="10" cols="60" name="characteristic"><?php echo $v_characteristic;?></textarea>
          </div>
        </div><br>
<!-- 
  How to use
-->
        <div class="FlexContainer_up">
          <div class="col-25">  
            <label>How to use</label>
          </div>
          <div class="col-75">
          <textarea id="how_to_use" rows="10" cols="60" name="how_to_use"><?php echo $v_how_to_use;?></textarea>
          </div>
        </div><br>
<!-- 
  Additional info
-->
        <div class="FlexContainer_up">
          <div class="col-25">  
            <label>Additional information</label>
          </div>
          <div class="col-75">
          <textarea id="additional_info" rows="10" cols="60" name="additional_info"><?php echo $v_add_info;?></textarea>
          </div>
        </div><br>
<!-- 
  Input radio buttons
-->
        <div class="FlexContainer">
          <div class="col-25">
            <label>For Interior</label>
          </div>
          <div class="col-75">
            <input type="checkbox" id="interior" name="interior" value="1">
          </div>
        </div><br>
        <div class="FlexContainer">
          <div class="col-25">
            <label>For Exterior</label>
          </div>
          <div class="col-75">
            <input type="checkbox" id="exterior" name="exterior" value="1">
          </div>
        </div><br>

        <p class="underline">Image</p><br>
<!-- 
  Image
-->
          <div class="FlexContainer">
            <div class="col-25">
              <label>Select image:</label>
            </div>
            <div class="col-75">
              <input type="file" name="fileToUpload" id="fileToUpload">
            </div>
          </div>
<!-- 
  Update Button
-->
          <p class="underline">&nbsp;</p> 

          <button type="submit" class="btn" name="submit">Update</button>       

</form>
    </div>
  </body>
</html>
    