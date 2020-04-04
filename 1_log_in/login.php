<?php 
  require_once("../0_core/config.php");
  require_once("../1_log_in/dbio_users.php");
  //
  session_start();
  //
	// variable declaration
  $s_User = new User_Class();
  //
  $b_username_missing    = FALSE;
  $b_username_not_exists = FALSE;
  $b_wrong_password      = FALSE;
  $b_user_not_approved   = FALSE;

  $v_username = '';
  $v_password = '';
	//
	// REGISTER USER
	//
//if(isset($_POST['reg_user']) {
//  // receive all input values from the form
//  $s_Item->user_type 					= mysqli_real_escape_string($db, $_POST['user_type']);
//  $s_Item->user_category      = mysqli_real_escape_string($db, $_POST['user_category']);
//  $s_Item->user_status        = mysqli_real_escape_string($db, $_POST['user_status']);
//  $s_Item->username           = mysqli_real_escape_string($db, $_POST['username']);
//  $s_Item->password           = mysqli_real_escape_string($db, $_POST['password']);
//  $s_Item->first_name         = mysqli_real_escape_string($db, $_POST['first_name']);
//  $s_Item->last_name          = mysqli_real_escape_string($db, $_POST['last_name']);
//  $s_Item->user_total_spend   = mysqli_real_escape_string($db, $_POST['user_total_spend']);
//  $s_Item->user_total_pending = mysqli_real_escape_string($db, $_POST['user_total_pending']);
//  $s_Item->register_date      = mysqli_real_escape_string($db, $_POST['register_date']);
//  $s_Item->last_log_on        = mysqli_real_escape_string($db, $_POST['last_log_on']);
//  $s_Item->user_email         = mysqli_real_escape_string($db, $_POST['user_email']);
//  $s_Item->user_address       = mysqli_real_escape_string($db, $_POST['user_address']);
//  $s_Item->user_phone_no      = mysqli_real_escape_string($db, $_POST['user_phone_no']);
//
//  // form validation: ensure that the form is correctly filled
//  reg_check_input($username, $first_name, $last_name, $email, $password_1, $address, $phone_number );
//  // Check if passwords matches
//  if (is_password_matching($password_1, $reentered_password) == false) {
//    array_push($errors, "The two passwords do not match");
//  }
//  // register user if there are no errors in the form
//  if (count($errors) == 0) {
//    // Hash password
//    $password = md5($password_1);
//    // Query function
//      reg_query ( $user_type,      $user_category, 	$username, 
//                  $first_name,     $last_name,			 	$password, 
//                  $register_date,  $total_spend, 		$last_log_on, 
//                  $email, 					$address, 				$phone_number
//                );
//    header('location: login.php');
//  }
//} 
//
//
//

?>

<!--HTML BEGIN-->

<!DOCTYPE html>
<html>

  <head>  
    <link rel="stylesheet" type="text/css" href="login.css">  
    <title>Login</title>   
  </head>

  <body>
  <?php
    //
    //Load User data if 'Sign In' button is pressed.
    //
    if (isset($_POST["submit"])) { 
      //
      $v_username = $_POST['username'];
      //
      if(empty($v_username)){
        $b_username_missing = TRUE;
        //
      }else{
        //
        $s_User->LoadUser("username", $v_username);
        //
        if(empty($s_User->username)){
          $b_username_not_exists = TRUE;
          //
        }else{
          //
          $v_password = $_POST['password'];
          //
          if($s_User->password != md5($v_password)){
            $b_wrong_password = TRUE;
            //
          }else{
            //
            if($s_User->user_status != 'active'){
              $b_user_not_approved   = TRUE;
              //
            }else{
              // User has logged In successfully
              $_SESSION['username'] = $s_User->username;
              // Redirect to home page
              header('location: ../website/home.php');
            }
          }
        }
      }
    }
  ?>

    <img src="../Logo_1_01.png" width="613" height="334">
    <div class="login_box">
    
      <h1>Login</h2>	

      <form id="myForm" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" >

<!--USERNAME-->
        <div class="input-group">          
          <input type        ="text" 
                 placeholder ="Username" 
                 name        ="username" 
                 value       ="<?php echo $v_username; ?>"
          >
          <!-- Username Issues handler-->
          <?php
            if ($b_username_missing) { 
                echo '<h5 class="login_warning" >*** Username is missing ***</h5>';
            }
            elseif($b_username_not_exists){ 
              echo '<h5 class="login_warning" >*** Username does not exists ***</h5>';
            }
            elseif($b_user_not_approved ){ 
              echo '<h5 class="login_warning" >*** User is not approved yet. ***</h5>';
            } 
          ?>

<!--PASSWORD-->
        </div>
        <div class="input-group">
          <br>
          <input type        = "password" 
                 placeholder = "Password" 
                 name        = "password"
                 value       = "<?php echo $v_password; ?>"
          >
          <!-- Password issues handler-->
          <?php
            if ($b_wrong_password) { 
               echo '<h5 class="login_warning" >*** Wrong password ***</h5>';
            }
          ?>
        </div>
        <br>
<!--SING IN-->
        <div class="input-group">
          <br>
          <button class="btn" name="submit" onclick="SubmitFormFunction()" >Sign In</button>
        </div>
      </form>
<!--SING UP-->
      <div>
          <h4>OR</h4>
          <a href="register.php"><button class="btn" name="register_user">Sign Up</button></a>
        </div>
    </div>

    <!-- DB Error Handling -->
    <?php
      if (mysqli_connect_errno()) {
      echo "<br><br>";
      echo "<p class='error'> An error has occured, please contact the administrator!</p>";
      echo "<p class='error'> Failed to connect to MySQL: " . mysqli_connect_error() . "</p>";
      
//      $s_Item->user_type 					= mysqli_real_escape_string($db, $_POST['user_type']);
//      $s_Item->user_category      = mysqli_real_escape_string($db, $_POST['user_category']);
//      $s_Item->user_status        = mysqli_real_escape_string($db, $_POST['user_status']);
//      $s_Item->username           = mysqli_real_escape_string($db, $_POST['username']);
//      $s_Item->password           = mysqli_real_escape_string($db, $_POST['password']);
//      $s_Item->first_name         = mysqli_real_escape_string($db, $_POST['first_name']);
//      $s_Item->last_name          = mysqli_real_escape_string($db, $_POST['last_name']);
//      $s_Item->user_total_spend   = mysqli_real_escape_string($db, $_POST['user_total_spend']);
//      $s_Item->user_total_pending = mysqli_real_escape_string($db, $_POST['user_total_pending']);
//      $s_Item->register_date      = mysqli_real_escape_string($db, $_POST['register_date']);
//      $s_Item->last_log_on        = mysqli_real_escape_string($db, $_POST['last_log_on']);
//      $s_Item->user_email         = mysqli_real_escape_string($db, $_POST['user_email']);
//      $s_Item->user_address       = mysqli_real_escape_string($db, $_POST['user_address']);
//      $s_Item->user_phone_no      = mysqli_real_escape_string($db, $_POST['user_phone_no']);
    
    
    
    }
    ?>

    <script>
      //
      function SubmitFormFunction() {
            document.getElementById("myForm").submit;
      }
      //
    </script>

  </body>
</html>