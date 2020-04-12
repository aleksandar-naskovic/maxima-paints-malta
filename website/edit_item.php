<?php
require_once("../0_core/config.php");
include("../0_core/session.php");
//
//Specific include
include("../2_maxima/dbio_items.php");
//
//
//Read parameters from URL
//
$v_item_id = $_GET['item_id'];
//
//
//
if (isset($_POST["delete"])) {  
  //
  $s_Item = new Item_Class();
  //
  $s_Item->item_id = $v_item_id;
  //
  $s_Item->DeleteItem();
  //
}
//
//
if (isset($_POST["submit"])) {  
  //
  $s_Item = new Item_Class();
  $s_Old_Item = new Item_Class();
  $s_Old_Item->LoadItem("item_id", $v_item_id); 
  //
  // Populate item fields
  //
  $s_Item->item_id =               $v_item_id;
  $s_Item->item_name =             mysqli_real_escape_string($db, $_POST['post_item_name']);
  $s_Item->item_volume =           mysqli_real_escape_string($db, $_POST['post_item_volume']);
  $s_Item->item_unit =             mysqli_real_escape_string($db, $_POST['post_item_unit']);
  $s_Item->item_price =            mysqli_real_escape_string($db, number_format(round($_POST['post_item_price'],2),2));
  $s_Item->item_disc10 =           mysqli_real_escape_string($db, number_format(round($_POST['post_item_disc10'],2),2));
  $s_Item->item_category =         mysqli_real_escape_string($db, $_POST['post_item_category']);
  $s_Item->item_description =      mysqli_real_escape_string($db, $_POST['post_item_description']);
  $s_Item->item_characteristic =   mysqli_real_escape_string($db, $_POST['post_item_characteristic']);
  $s_Item->item_how_to_use =       mysqli_real_escape_string($db, $_POST['post_item_how_to_use']);
  $s_Item->item_add_info =         mysqli_real_escape_string($db, $_POST['post_item_add_info']);
  //
  if (!empty($_POST['post_item_for_interior'])) { $s_Item->item_for_interior = '1'; } 
  else { $s_Item->item_for_interior = '0'; }
  //
  if (!empty($_POST['post_item_for_exterior'])) { $s_Item->item_for_exterior = '1'; } 
  else { $s_Item->item_for_exterior = '0'; }
  //
  //Fields which are not updating
  $s_Item->item_stock = $s_Old_Item->item_stock;
  //
  //
  //Update Item class function
  //
  $s_Item->UpdateItem();
  //
  //
  //Create item history
  //
  $s_item_history = new Item_History_Class();
  
  //
  $s_item_history->item_id = $v_item_id;
  echo "[". $s_Old_Item->item_name ."] [".$_POST['post_item_name']."]";
  echo strcmp($v_item_name, $_POST['post_item_name']);
  //
  //check if item name has changed
  if(strcmp($s_Old_Item->item_name, $_POST['post_item_name']) <> 0){
    $s_item_history->item_name = mysqli_real_escape_string($db, $_POST['post_item_name']);
} 
  //
  //check if item category has changed
  if(strcmp($s_Old_Item->item_category, $_POST['post_item_category']) <> 0){
    $s_item_history->item_category = mysqli_real_escape_string($db, $_POST['post_item_category']);
}
  //
  //check if item volume has changed
  if(strcmp($s_Old_Item->item_volume, $_POST['post_item_volume']) <> 0){
    $s_item_history->item_volume = mysqli_real_escape_string($db, $_POST['post_item_volume']);
    }
  //
  //check if item unit has changed
  if(strcmp($s_Old_Item->item_unit, $_POST['post_item_unit']) <> 0){
    $s_item_history->item_unit = mysqli_real_escape_string($db, $_POST['post_item_unit']);
    }
  //
  //check if item price has changed
  if(strcmp($s_Old_Item->item_price, $_POST['post_item_price']) <> 0){
    $s_item_history->item_price = mysqli_real_escape_string($db, number_format(round($_POST['post_item_price'],2),2));
    }
  //
  //check if item discount has changed
  if(strcmp($s_Old_Item->item_disc10, $_POST['post_item_disc10']) <> 0){
    $s_item_history->item_disc10 = mysqli_real_escape_string($db, number_format(round($_POST['post_item_disc10'],2),2));
    }
  //
  //check if item desription has changed
  if(strcmp($s_Old_Item->item_description, $_POST['post_item_description']) <> 0){
    $s_item_history->item_description = mysqli_real_escape_string($db, $_POST['post_item_description']);
    }
  //
  //check if item characteristic has changed
  if(strcmp($s_Old_Item->item_characteristic, $_POST['post_item_characteristic']) <> 0){
    $s_item_history->item_characteristic = mysqli_real_escape_string($db, $_POST['post_item_characteristic']);
    }
  //
  //check if item how_to_use has changed
  if(strcmp($s_Old_Item->item_how_to_use, $_POST['post_item_how_to_use']) <> 0){
    $s_item_history->item_how_to_use = mysqli_real_escape_string($db, $_POST['post_item_how_to_use']);
    }
  //
  //check if item_add_info has changed
  if(strcmp($s_Old_Item->item_add_info, $_POST['post_item_add_info']) <> 0){
    $s_item_history->item_add_info = mysqli_real_escape_string($db, $_POST['post_item_add_info']);
    }
  if (!empty($_POST['post_item_for_interior'])) { $s_item_history->item_for_interior = '1'; } 
  else { $s_item_history->item_for_interior = ' '; }
  //
  if (!empty($_POST['post_item_for_exterior'])) { $s_item_history->item_for_exterior = '1'; } 
  else { $s_item_history->item_for_exterior = ' '; }
  $s_item_history->user = mysqli_real_escape_string($db, $_SESSION['username']);
  //
  $s_item_history->create_item_history();

  
  //
  //
  header("Location: ../website/all_items.php");
}
//
//
// Load Item details to be displayed in the page
//
$item = get_item_id($v_item_id);
//
$v_item_name           =  $item['item_name'];
$v_item_volume         =  $item['item_volume'];
$v_item_unit           =  $item['item_unit'];
$v_item_category       =  $item['item_category'];
$v_item_description    =  $item['item_description'];
$v_item_characteristic =  $item['item_characteristic'];
$v_item_how_to_use     =  $item['item_how_to_use'];
$v_item_add_info       =  $item['item_add_info'];
$v_item_price          =  $item['item_price'];
$v_item_disc10         =  $item['item_disc10'];
$v_item_for_interior   =  $item['item_for_interior'];
$v_item_for_exterior   =  $item['item_for_exterior'];

?>
<html>
  <head>
    <title>Edit <?php echo $v_item_name;?></title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="../0_core/generic_input.css">
  </head>
  <body>

  <?php
    //dbg('> DELETE ? [' . $v_delete . ']');
  ?>


    <?php include("navbar.php")?>
    <div class="page">
      
      <br>
      <h2>Edit item Page</h2>
      <h1 class="left"><?php echo $v_item_name;?> [<?php echo $v_item_volume;?><?php echo $v_item_unit;?>]</h1>
      
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']. '?item_id='.$item['item_id']; ?>" enctype="multipart/form-data">
      
        <p class="underline">Actions</p><br>

        <button type="submit" class="button" name="delete">Delete Item</button>

        <button type="submit" class="button" name="hide">Hide Item</button>

        <p class="underline">Details</p><br>
        <img src="../images/<?php echo $v_item_id; ?>.png" alt="">
<!-- 
  Item name
-->
        <div class="FlexContainer">        
          <div class="col-25">  
            <label>Item name</label>
          </div>
          <div class="col-75">
            <input type="text" name="post_item_name" value="<?php echo $v_item_name; ?>" >
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
            <input type="text" name="post_item_volume" value="<?php echo $v_item_volume; ?>">
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
         <input type="text" name="post_item_unit" value="<?php echo $v_item_unit; ?>">
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
              <input type="text" name="post_item_price" value="<?php echo $v_item_price; ?>">
            </div>
        </div><br>
<!-- 
  Discount
-->
<div class="FlexContainer">
            <div class="col-25">
              <label>Discount 10+</label>
            </div>
            <div class="col-75">
              <input type="text" name="post_item_disc10" value="<?php echo $v_item_disc10; ?>" >
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
          <input type="text" name="post_item_category" value="<?php echo $v_item_category; ?>">
          </div>
        </div><br>
<!-- 
  Main description
-->
        <div class="FlexContainer_up">
          <div class="col-25">  
            <label>Main description</label>
          </div>
          <div class="col-75">
            <textarea type="text" rows="3" cols="60"  name="post_item_description" ><?php echo $v_item_description;?></textarea>
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
          <textarea id="characteristic" rows="10" cols="60" name="post_item_characteristic"><?php echo $v_item_characteristic;?></textarea>
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
          <textarea id="how_to_use" rows="10" cols="60" name="post_item_how_to_use"><?php echo $v_item_how_to_use;?></textarea>
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
          <textarea id="additional_info" rows="10" cols="60" name="post_item_add_info"><?php echo $v_item_add_info;?></textarea>
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
            <input type="checkbox" id="interior" name="post_item_for_interior" <?php if($v_item_for_interior=='1'){echo 'checked';}?> >
          </div>
        </div><br>
        <div class="FlexContainer">
          <div class="col-25">
            <label>For Exterior</label>
          </div>
          <div class="col-75">
            <input type="checkbox" id="exterior" name="post_item_for_exterior" <?php if($v_item_for_exterior=='1'){echo 'checked';}?>>
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

          <button type="submit" class="main_button" name="submit">Update</button>       

      </form>
    </div>



<!-- 
  DELETE button Modal
-->
    <div id="DeleteModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
              <span class="close">&times;</span>
              <div id="modal_div">
                <!-- Java Script is adding code here... -->
                <form id="myForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
                  <p class="modal_p">Are you sure you want to delete the item? If yes type 'delete' in the text box and press YES. </p> 
                  <input type="text" name="sub_value" id="id_sub_value">
                  <input type="hidden" id="sub_delete_value" name="sub_delete_value">
                  <input id="id_sub_but" type="button" onclick="SubmitFormFunction()" value="Delete">
                </form>
                <!--//-->
              </div>
            </div>
          </div>

    <script>
			// Prevent a resubmit on refresh and back button
			if ( window.history.replaceState ) {
					window.history.replaceState( null, null, window.location.href );
		  }

      // DELETE Modal
      var modal = document.getElementById("DeleteModal");

      function DeleteItemFunction() {

        var v_submit = true;

        //set to default first
        document.getElementById("id_sub_comment").style.borderColor = "";
        document.getElementById("id_sub_comment").style.borderWidth = "";
        document.getElementById("id_sub_value").style.borderColor = "";
        document.getElementById("id_sub_value").style.borderWidth = "";


        if (document.getElementById("id_sub_comment").value == '') {
          document.getElementById("id_sub_comment").style.borderColor = "red";
          document.getElementById("id_sub_comment").style.borderWidth = "3px";
          v_submit = false;
        }

        if(document.getElementById("id_sub_value").value == '') {
          document.getElementById("id_sub_value").style.borderColor = "red";
          document.getElementById("id_sub_value").style.borderWidth = "3px";
          v_submit = false;
        }

        if(v_submit == true){
          document.getElementById("myForm").submit();
        }

        }

    </script>

  </body>
</html>
    