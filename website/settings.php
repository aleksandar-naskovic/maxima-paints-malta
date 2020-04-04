<?php
require_once("../0_core/config.php");
include("../0_core/session.php");
//
//

  //
  // Update most popular item 2 function
function update_most_popular_item_2($p_setting_value){
  global $db;
  $query = "UPDATE settings
            SET    setting_value  = '$p_setting_value'
            WHERE  setting_name   = 'most_popular_item_2'
          ";
  
  mysqli_query($db, $query);
  mysqli_commit($db);
  return TRUE;
  }
  // Update most popular item 3 function
function update_most_popular_item_3($p_setting_value){
  global $db;
  $query = "UPDATE settings
            SET    setting_value  = '$p_setting_value'
            WHERE  setting_name   = 'most_popular_item_3'
          ";
  
  mysqli_query($db, $query);
  mysqli_commit($db);
  return TRUE;
  }
  //
  if (isset($_POST["submit"])) { 
    //
    // Update vat code
    $v_vat = $_POST['update_vat'];
    SetSettingValue('vat', $v_vat);
    //
    // Update most populat 1
    $most_popular_item_1 = $_POST['most_popular_item_1'];
    SetSettingValue('most_popular_item_1', $most_popular_item_1);
    //
    // Update most populat 2
    $most_popular_item_2 = $_POST['most_popular_item_2'];
    SetSettingValue('most_popular_item_2', $most_popular_item_2);
    //
    // Update most populat 3
    $most_popular_item_3 = $_POST['most_popular_item_3'];
    SetSettingValue('most_popular_item_3', $most_popular_item_3);
    //
    // Update About Us Text
    $v_about_us_text = $_POST['about_us_text'];
    SetSettingValue('about_us_text', $v_about_us_text);
    //
    // Update Contact Text
    $v_contact_text = $_POST['contact_text'];
    SetSettingValue('contact_text', $v_contact_text);
  }
  else{
    //Variable declaration
    $v_vat = GetSettingValue("vat");
    $most_popular_item_1 = GetSettingValue("most_popular_item_1");
    $most_popular_item_2 = GetSettingValue("most_popular_item_2");
    $most_popular_item_3 = GetSettingValue("most_popular_item_3");
    $v_about_us_text = GetSettingValue("about_us_text");
    $v_contact_text = GetSettingValue("contact_text");
    //
  }


?>
<html>
  <head>
    <title>Settings</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="settings.css">   
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      
      <br>
      <h2>Settings</h2><br>	
 <!-- 
   Update Vat form
-->     
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
       
       
        <p class="underline">VAT settings</p>
        <div class="FlexContainer">        
          <div class="col-25">  
            <label>VAT value</label>
          </div>
          <div id="vat_value" class="col-75">
            <input type="text" name="update_vat" value="<?php echo $v_vat; ?>" >
          </div>
        </div><br>

 <!-- 
   Update Most popular items
-->   
        <p class="underline">Most Popular</p>

        <div class="FlexContainer">        
          <div class="col-25">  
            <label>Item 1</label>
          </div>
          <div class="col-75">
          <select id="most_popular_item_1" name="most_popular_item_1">
            <?php
              $query = "SELECT * FROM items";
              $result = mysqli_query($db, $query);
              if(mysqli_num_rows($result) > 0)
              {
                while($row = mysqli_fetch_array($result))
                {
            ?>
              <option <?php if ($row["item_id"] == GetSettingValue("most_popular_item_1")) echo 'selected' ; ?> value="<?php echo $row["item_id"]; ?>">
                <?php  echo $row["item_name"] . ' [' . $row["item_volume"] . $row["item_unit"] . ']'; ?>
              </option>
            <?php 
                }
              }
            ?>
            </select>
          </div>
        </div><br>

        <div class="FlexContainer">        
          <div class="col-25">  
            <label>Item 2</label>
          </div>
          <div class="col-75">
          <select id="most_popular_item_2" name="most_popular_item_2">
            <?php
              $query = "SELECT * FROM items";
              $result = mysqli_query($db, $query);
              if(mysqli_num_rows($result) > 0)
              {
                while($row = mysqli_fetch_array($result))
                {
            ?>
              <option <?php if ($row["item_id"] == GetSettingValue("most_popular_item_2")) echo 'selected' ; ?> value="<?php echo $row["item_id"]; ?>">
                <?php  echo $row["item_name"] . ' [' . $row["item_volume"] . $row["item_unit"] . ']'; ?>
              </option>
            <?php 
                }
              }
            ?>
            </select>
          </div>
        </div><br>

        <div class="FlexContainer">        
          <div class="col-25">  
            <label>Item 3</label>
          </div>
          <div class="col-75">
          <select id="most_popular_item_3" name="most_popular_item_3">
            <?php
              $query = "SELECT * FROM items";
              $result = mysqli_query($db, $query);
              if(mysqli_num_rows($result) > 0)
              {
                while($row = mysqli_fetch_array($result))
                {
            ?>
              <option <?php if ($row["item_id"] == GetSettingValue("most_popular_item_3")) echo 'selected' ; ?> value="<?php echo $row["item_id"]; ?>">
                <?php  echo $row["item_name"] . ' [' . $row["item_volume"] . $row["item_unit"] . ']'; ?>
              </option>
            <?php 
                }
              }
            ?>
            </select>
          </div>
        </div>

        <p class="underline">Site Settings</p>

        <div class="FlexContainer_up">
          <div class="col-25">  
            <label>About Us - Page Text</label>
          </div>
          <div class="col-75">  
            <textarea id="about_us_text" rows="20" cols="70" name="about_us_text"><?php echo $v_about_us_text;?></textarea>
          </div>
        </div><br>

        <div class="FlexContainer_up">
          <div class="col-25">  
            <label>Contact - Page Text</label>
          </div>
          <div class="col-75">  
            <textarea id="contact_text" rows="20" cols="70" name="contact_text"><?php echo $v_contact_text;?></textarea>
          </div>
        </div>
        <!-- 
          End Line
        -->     
        <p class="underline">&nbsp;</p>
        <!-- 
          Update Button
        -->   
        <div class="col_button">  
        <button type="submit" class="btn" name="submit">Update</button> 
        </div>      
      </form>
    </div>
  </body>
</html>
    