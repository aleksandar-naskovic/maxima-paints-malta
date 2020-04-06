<?php
include("../0_core/config.php");
include("../0_core/session.php");
//
//Specific include
include("../2_maxima/dbio_items.php");
//
//
function insert_item($p_item_name,      $p_category,   $p_main_description,
                     $p_characteristic, $p_how_to_use, $p_price,
                     $p_interior,       $p_exterior){
  global $db;
  $query = "INSERT INTO items( item_name
                              ,category
                              ,main_description
                              ,characteristic
                              ,how_to_use
                              ,price
                              ,interior
                              ,exterior
                              )
                      VALUES ( '$p_item_name'
                              ,'$p_category'
                              ,'$p_main_description'
                              ,'$p_characteristic'
                              ,'$p_how_to_use'
                              ,'$p_price'
                              ,'$p_interior'
                              ,'$p_exterior'
                            ) 
                            ";
  return mysqli_query($db, $query);
}

$v_item_name ="";
$v_category ="";
$v_main_description ="";
$v_characteristic ="";
$v_how_to_use ="";
$v_price ="";
$v_interior="";
$v_exterior="";

$additional_info="";

$target_dir = "../images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
?>


<?php

  if (isset($_POST["item_name"])) {  
    //
    $s_Item = new Item_Class();
    //
    // Populate item fields
    //
    $s_Item->item_name           = mysqli_real_escape_string($db, $_POST['item_name']);
    $s_Item->item_category       = mysqli_real_escape_string($db, $_POST['item_category']);
    $s_Item->item_volume         = mysqli_real_escape_string($db, $_POST['item_volume']);
    $s_Item->item_unit           = mysqli_real_escape_string($db, $_POST['item_unit']);
    $s_Item->item_price          = mysqli_real_escape_string($db, $_POST['item_price']);
    $s_Item->item_disc10         = mysqli_real_escape_string($db, $_POST['item_disc10']);
    $s_Item->item_stock          = mysqli_real_escape_string($db, '0');
    $s_Item->item_description    = mysqli_real_escape_string($db, $_POST['item_description']);
    $s_Item->item_characteristic = mysqli_real_escape_string($db, $_POST['item_characteristic']);
    $s_Item->item_how_to_use     = mysqli_real_escape_string($db, $_POST['item_how_to_use']);
    $s_Item->item_add_info       = mysqli_real_escape_string($db, $_POST['item_add_info']);
    $s_Item->item_for_interior   = mysqli_real_escape_string($db, $_POST['item_for_interior']);
    $s_Item->item_for_exterior   = mysqli_real_escape_string($db, $_POST['item_for_exterior']);
    //Set Item Status
    $s_Item->item_status         = mysqli_real_escape_string($db, $_POST['item_status']);
    if(empty($s_Item->item_status)){
      $s_Item->item_status = "Disabled";
    }
    //
    // Insert the item in the database
    $s_Item->CreateItem();
    //
      //Create item history
      //
      $s_item_history = new Item_History_Class();
      //
      $s_item_history->item_id               = $v_item_id;
      $s_item_history->item_name             = mysqli_real_escape_string($db, $_POST['item_name']);
      $s_item_history->item_category         = mysqli_real_escape_string($db, $_POST['item_category']);
      $s_item_history->item_volume           = mysqli_real_escape_string($db, $_POST['item_volume']);
      $s_item_history->item_unit             = mysqli_real_escape_string($db, $_POST['item_unit']);
      $s_item_history->item_price            = mysqli_real_escape_string($db, number_format(round($_POST['item_price'],2),2));
      $s_item_history->item_disc10           = mysqli_real_escape_string($db, number_format(round($_POST['item_disc10'],2),2));
      //$s_item_history->item_stock            = mysqli_real_escape_string($db, $_POST['item_stock']);
      $s_item_history->item_description      = mysqli_real_escape_string($db, $_POST['item_description']);
      $s_item_history->item_characteristic   = mysqli_real_escape_string($db, $_POST['item_characteristic']);
      $s_item_history->item_how_to_use       = mysqli_real_escape_string($db, $_POST['item_how_to_use']);
      $s_item_history->item_add_info         = mysqli_real_escape_string($db, $_POST['item_add_info']);
      if (!empty($_POST['item_for_interior'])) { $s_item_history->item_for_interior = '1'; } 
      else { $s_item_history->item_for_interior = '0'; }
      //
      if (!empty($_POST['item_for_exterior'])) { $s_item_history->item_for_exterior = '1'; } 
      else { $s_item_history->item_for_exterior = '0'; }
      //$s_item_history->item_status           = mysqli_real_escape_string($db, $_POST['item_status']);
      //$s_item_history->date                  = mysqli_real_escape_string($db, $_POST['item_for_exterior']);
      $s_item_history->user                  = mysqli_real_escape_string($db, $_SESSION['username']);
      //
      $s_item_history->create_item_history();

    //
    // Save the Image
    //
    if ($target_file == "../images/") {
        $msg = "cannot be empty";
        $uploadOk = 0;
    } // Check if file already exists
    else if (file_exists($target_file)) {
        $msg = "Sorry, file already exists.";
        $uploadOk = 0;
    } // Check file size
    else if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $msg = "Sorry, your file is too large.";
        $uploadOk = 0;
    } // Check if $uploadOk is set to 0 by an error
    else if ($uploadOk == 0) {
        $msg = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $msg = "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
       }
    }
    //
    //
  }
?>



<html>
  <head>
    <title>Add Item</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css">
    <link rel="stylesheet" type="text/css" href="settings.css">    
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">

    <h2>Add New Item</h2><br>

      <form id="myForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        
        <p class="underline">Details</p>
        
        <div class="FlexContainer">
          <div class="col-25">  
            <label>Item name</label>
          </div>
          <div class="col-75">  
            <input id="item_name" type="text" name="item_name" value="<?php $v_item_name; ?>" autocomplete="off">
          </div>
        </div><br>

        <div class="FlexContainer">
          <div class="col-25">  
            <label>Category</label>
          </div>
          <div class="col-75">  
            <input id="item_category" type="text" name="item_category" value="<?php $v_item_category; ?>" autocomplete="off">
          </div>
        </div><br>

        <div class="FlexContainer">
          <div class="col-25">  
            <label>Volume (size)</label>
          </div>
          <div class="col-75">  
            <input id="item_volume" type="text" name="item_volume" value="<?php $v_item_volume; ?>" autocomplete="off">
          </div>
        </div><br>

        <div class="FlexContainer">
          <div class="col-25">  
            <label>Unit [kg/L]</label>
          </div>
          <div class="col-75">  
            <input id="item_unit" type="text" name="item_unit" value="<?php $v_item_unit; ?>" autocomplete="off">
          </div>
        </div><br>

        <div class="FlexContainer">
          <div class="col-25">  
            <label>Stock</label>
          </div>
          <div class="col-75">  
            <input type="text" name="item_stock" value="0" disabled autocomplete="off">
          </div>
        </div><br>
        
        <div class="FlexContainer">
          <div class="col-25">  
            <label>Price</label>
          </div>
          <div class="col-75">  
            <input id="item_price" type="text" name="item_price" value="<?php $v_item_price; ?>" autocomplete="off">
          </div>
        </div><br>
                
        <div class="FlexContainer">
          <div class="col-25">  
            <label>Discount 10+</label>
          </div>
          <div class="col-75">  
            <input type="text" name="item_disc10" value="<?php $v_item_disc10; ?>" autocomplete="off">
          </div>
        </div><br>

        <div class="FlexContainer_up">
          <div class="col-25">  
            <label>Description</label>
          </div>
          <div class="col-75">  
            <textarea id="item_description" rows="8" cols="50" name="item_description"><?php $v_item_description;?></textarea>
          </div>
        </div><br>

        <div class="FlexContainer_up">
          <div class="col-25">  
            <label>Characteristic</label>
          </div>
          <div class="col-75">  
            <textarea id="item_characteristic" rows="8" cols="50" name="item_characteristic"><?php $v_item_characteristic;?></textarea>
          </div>
        </div><br>

        <div class="FlexContainer_up">
          <div class="col-25">  
            <label>How to use</label>
          </div>
          <div class="col-75">  
            <textarea id="item_how_to_use" rows="8" cols="50" name="item_how_to_use"><?php $v_item_how_to_use;?></textarea>
          </div>
        </div><br>

        <div class="FlexContainer_up">
          <div class="col-25">  
            <label>Additional info</label>
          </div>
          <div class="col-75">    
            <textarea id="item_add_info" rows="8" cols="50" name="item_add_info"><?php $v_item_additional_info;?></textarea>
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
            <input type="checkbox" id="item_for_interior" name="item_for_interior" value="1">
          </div>
        </div><br>

        <div class="FlexContainer">
          <div class="col-25">
            <label>For Exterior</label>
          </div>
          <div class="col-75">
            <input type="checkbox" id="item_for_exterior" name="item_for_exterior" value="1">
          </div>
        </div><br>

        <p class="underline">Item Image</p><br>

        <!--
          Item Photo
        -->
        <div class="FlexContainer">
          <div class="col-25">
            <label>Select image</label>
          </div>
          <div class="col-75">
            <input type="file" name="fileToUpload" id="fileToUpload"><br>
          </div>
        </div><br>

        <p class="underline">Item Status</p><br>

        <div class="FlexContainer">
          <div class="col-25">
            <label>Active</label>
          </div>
          <div class="col-75">
            <input type="checkbox" id="item_status" name="item_status" value="Active">
          </div>
        </div>
        
        <p class="underline">&nbsp;</p>
        <button id="id_sub_but" type="submit" class="btn"  onclick="SubmitFormFunction()" >Add Item</button> 
        
      </form>
    
    </div>

    <script>
			// Prevent a resubmit on refresh and back button
			if ( window.history.replaceState ) {
					window.history.replaceState( null, null, window.location.href );
		  }


      function SubmitFormFunction() {
        var v_submit = true;
        //
        document.getElementById("item_name").style.border     = "1px rgb(204, 204, 204) solid";
        document.getElementById("item_category").style.border = "1px rgb(204, 204, 204) solid";
        document.getElementById("item_volume").style.border   = "1px rgb(204, 204, 204) solid";
        document.getElementById("item_unit").style.border     = "1px rgb(204, 204, 204) solid";
        document.getElementById("item_price").style.border    = "1px rgb(204, 204, 204) solid";

        //
        if(document.getElementById("item_name").value =='') {document.getElementById("item_name").style.border="2px red solid"; v_submit=false;}
        if(document.getElementById("item_category").value =='') {document.getElementById("item_category").style.border="2px red solid"; v_submit=false;}
        if(document.getElementById("item_volume").value =='') {document.getElementById("item_volume").style.border="2px red solid"; v_submit=false;}
        if(document.getElementById("item_unit").value =='') {document.getElementById("item_unit").style.border="2px red solid"; v_submit=false;}
        if(document.getElementById("item_price").value =='') {document.getElementById("item_price").style.border="2px red solid"; v_submit=false;}

        if(v_submit == true){
          document.getElementById("myForm").submit();
        }

      }

    </script>
  </body>
</html>