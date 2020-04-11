<?php
  // Including generics
  require_once("../0_core/config.php");
  include("../0_core/session.php");
  //
  //
  // When Submitted page is loading
  if (isset($_POST["submit"])) { 
    //
    // Update Company Address
    $v_company_address = $_POST['post_company_address_value'];
    SetSettingValue('company_address', $v_company_address);
    //
    // Update Company VAT
    $v_company_vat = $_POST['post_company_VAT_value'];
    SetSettingValue('company_VAT', $v_company_vat);
    //
    // Update Company Contact Number
    $v_company_contact_number = $_POST['post_company_contact_number_value'];
    SetSettingValue('company_contact_number', $v_company_contact_number);
    //
    // Update Company Email Address
    $v_company_email_address = $_POST['post_company_email_address_value'];
    SetSettingValue('company_email_address', $v_company_email_address);
  }
  // When NON Submitted page is loading
  else{
    //Load VAT value from the DB
    $v_company_address        = GetSettingValue("company_address");
    $v_company_vat            = GetSettingValue("company_VAT");
    $v_company_contact_number = GetSettingValue("company_contact_number");
    $v_company_email_address  = GetSettingValue("company_email_address");
    //
  }


?>
<html>
  <head>
    <title>Company Settings</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="../0_core/generic_input.css">  
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      
      <br>
      <h2>Company Settings</h2>
 <!-- 
   Update Vat form
-->     
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <!-- 
          FORM begin
        -->   
        <p class="underline">Company Billing Information</p>
        <!--           Company Address settings section        -->   
        <div class="FlexContainer_up">        
          <div class="col-25">  
            <label>Address</label>
          </div>
          <div class="col-75">  
            <textarea id="company_address_text" rows="6" cols="70" name="post_company_address_value"><?php echo $v_company_address;?></textarea>
          </div>
        </div><br>
        <!--           VAT info settings section        -->   
        <div class="FlexContainer_up">        
          <div class="col-25">  
            <label>VAT info</label>
          </div>
          <div class="col-75">  
            <textarea id="company_VAT_value" rows="6" cols="70" name="post_company_VAT_value"><?php echo $v_company_vat;?></textarea>
          </div>
        </div><br>
        <!--           Contact Number settings section        -->   
        <div class="FlexContainer">        
          <div class="col-25">  
            <label>Contact Number</label>
          </div>
          <div id="company_contact_number" class="col-75">
            <input type="text" name="post_company_contact_number_value" value="<?php echo $v_company_contact_number; ?>" >
          </div>
        </div><br>
        <!--           Email Address settings section        -->   
        <div class="FlexContainer">        
          <div class="col-25">  
            <label>Email Address</label>
          </div>
          <div id="company_email_address" class="col-75">
            <input type="text" name="post_company_email_address_value" value="<?php echo $v_company_email_address; ?>" >
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
    