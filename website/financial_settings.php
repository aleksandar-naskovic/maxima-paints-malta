<?php
  // Including generics
  require_once("../0_core/config.php");
  include("../0_core/session.php");
  //
  //
  // When Submitted page is loading
  if (isset($_POST["submit"])) { 
    //
    // Update VAT code
    $v_vat = $_POST['update_vat'];
    SetSettingValue('vat', $v_vat);
    //
  }
  // When NON Submitted page is loading
  else{
    //Load VAT value from the DB
    $v_vat = GetSettingValue("vat");
    //
  }


?>
<html>
  <head>
    <title>Financial Settings</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="../0_core/generic_input.css">  
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      
      <br>
      <h2>Financial Settings</h2>
 <!-- 
   Update Vat form
-->     
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <!-- 
          FORM begin
        -->   
        <p class="underline">VAT settings</p>
        <!--           VAT settings section        -->   
        <div class="FlexContainer">        
          <div class="col-25">  
            <label>VAT value</label>
          </div>
          <div id="vat_value" class="col-75">
            <input type="text" name="update_vat" value="<?php echo $v_vat; ?>" >
          </div>
        </div><br>
        <!-- 
          End Line
        -->     
        <p class="underline">&nbsp;</p>
        <!-- 
          Update Button
        -->   
        <div class="col_button">  
          <button type="submit" class="main_button" name="submit">Update</button> 
        </div>    
        <!-- 
          FORM end
        -->
      </form>
    </div>

    <script>
			// Prevent a resubmit on refresh and back button
			if ( window.history.replaceState ) {
					window.history.replaceState( null, null, window.location.href );
		  }
    </script>

  </body>
</html>
    