<?php
require_once("../0_core/config.php");
	//
	$b_username_missing = FALSE;
	$b_first_name_missing = FALSE;
	$b_last_name_missing = FALSE;
	$b_password_1_missing = FALSE;
	$b_reentered_password_missing = FALSE;
	$b_email_missing = FALSE;
	$b_address_missing = FALSE;
	$b_phone_number_missing = FALSE;
	$b_password_match = FALSE;
	//
	//
  if (isset($_POST["reg_user"])) {  
		//
		if(empty($_POST["username"])){
			$b_username_missing = TRUE;
			//
		}
		if(empty($_POST['first_name'])){
			$b_first_name_missing = TRUE;
			//
		}
		if(empty($_POST['last_name'])){
			$b_last_name_missing = TRUE;
			//
		}
		if(empty($_POST['password_1'])){
			$b_password_1_missing = TRUE;
			//
		}
		if(empty($_POST['reentered_password'])){
			$b_reentered_password_missing = TRUE;
			//
		}
		if(empty($_POST['email'])){
			$b_email_missing = TRUE;
			//
		}
		if(empty($_POST['address'])){
			$b_address_missing = TRUE;
			//
		}
		if(empty($_POST['phone_number'])){
			$b_phone_number_missing = TRUE;
			//
		}
		
		else {
    $s_user = new User_Class();
    //
    // Populate item fields
    //
    $s_user->username	    	     = mysqli_real_escape_string($db, $_POST['username']);
    $s_user->first_name	   	     = mysqli_real_escape_string($db, $_POST['first_name']);
    $s_user->last_name	   	     = mysqli_real_escape_string($db, $_POST['last_name']);
    $s_user->password	   	       = mysqli_real_escape_string($db, md5($_POST['password_1']));
    $s_user->user_email	   	     = mysqli_real_escape_string($db, $_POST['email']);
    $s_user->user_address	       = mysqli_real_escape_string($db, $_POST['address']);
    $s_user->user_phone_no	     = mysqli_real_escape_string($db, $_POST['phone_number']);
    //
    // Insert the item in the database
		$s_user->CreateUser();
		header('location: login.php');
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../0_core/style.css">
	<link rel="stylesheet" type="text/css" href="../0_core/generic_input.css">
	<style>
		.page{
          padding: 60px 120px;
          text-align: center;
        }
        button {
          background-color: white; 
          color: black; 
          border: 2px solid #ff6804;
          padding: 20px 80px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;
          margin: 4px 2px;
          cursor: pointer;
          margin-top: 45px;
      }
	</style>
</head>
<body>
	<?php// include("../website/navbar.php"); ?>
	<div class="page">
		<h2>Create User</h2>	<br>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
			<?php include('errors.php'); ?>
<!-- 
  User name
-->
			<div class="FlexContainer">
				<div class="col-25">
					<label>Username</label>
				</div>
				<div class="col-75">	
					<input type="text" name="username"  value="<?php echo isset($_POST["username"]) ? $_POST["username"] : ''; ?>">
				</div>
				<?php 
				if ($b_username_missing) { 
                echo '<h5 class="login_warning" >*** Username is missing ***</h5>';
				}
				?>
			</div><br>
<!-- 
  First name
-->
			<div class="FlexContainer">
				<div class="col-25">
					<label>First name</label>
				</div>
				<div class="col-75">	
					<input type="text" name="first_name" value="<?php echo isset($_POST["first_name"]) ? $_POST["first_name"] : ''; ?>">
				</div>
				<?php 
				if ($b_first_name_missing) { 
                echo '<h5 class="login_warning" >*** First name is missing ***</h5>';
				}
				?>
			</div><br>
<!-- 
  Last name
-->
			<div class="FlexContainer">
				<div class="col-25">
					<label>Last name</label>
				</div>
				<div class="col-75">	
					<input type="text" name="last_name" value="<?php echo isset($_POST["last_name"]) ? $_POST["last_name"] : ''; ?>">
				</div>
				<?php 
				if ($b_last_name_missing) { 
                echo '<h5 class="login_warning" >*** Last name is missing ***</h5>';
				}
				?>
			</div><br>
<!-- 
  Password
-->			
			<div class="FlexContainer">
				<div class="col-25">
					<label>Password</label>
				</div>
				<div class="col-75">	
					<input type="password" name="password_1">
				</div>
				<?php 
				if ($b_password_1_missing) { 
                echo '<h5 class="login_warning" >*** Password is missing ***</h5>';
				}
				if ($b_password_match) { 
					echo '<h5 class="login_warning" >*** Passwords are not equal ***</h5>';
				}
				?>
			</div><br>
<!-- 
  Confrim password
-->			
			<div class="FlexContainer">
				<div class="col-25">
					<label>Confirm password</label>
				</div>
				<div class="col-75">	
					<input type="password" name="reentered_password">
				</div>
				<?php 
				if ($b_reentered_password_missing) { 
                echo '<h5 class="login_warning" >*** Reentered password is missing ***</h5>';
				}
				?>
			</div><br>
<!-- 
  Email
-->							
			<div class="FlexContainer">
				<div class="col-25">
					<label>Email</label>
				</div>
				<div class="col-75">	
					<input type="email" name="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>">
				</div>
				<?php 
				if ($b_email_missing) { 
                echo '<h5 class="login_warning" >*** Email is missing ***</h5>';
				}
				?>
			</div><br>
<!-- 
  Addres
-->			
			<div class="FlexContainer">
				<div class="col-25">
					<label>Address</label>
				</div>
				<div class="col-75">	
					<input type="text" name="address" value="<?php echo isset($_POST["address"]) ? $_POST["address"] : ''; ?>">
				</div>
				<?php 
				if ($b_address_missing) { 
                echo '<h5 class="login_warning" >*** Address is missing ***</h5>';
				}
				?>
			</div><br>
<!-- 
  Phone number
-->

			<div class="FlexContainer">
				<div class="col-25">
					<label>Phone number</label>
				</div>
				<div class="col-75">	
					<input type="text" name="phone_number" value="<?php echo isset($_POST["phone_number"]) ? $_POST["phone_number"] : ''; ?>">
				</div>
				<?php 
				if ($b_phone_number_missing) { 
                echo '<h5 class="login_warning" >*** Phone number is missing ***</h5>';
				}
				?>
			</div><br>
			<!-- 
  Submit button
			-->
				<button type="submit" class="btn" name="reg_user">Register</button>
			<br>
			<p>
				Already a member ? <a href="login.php">Sign in</a>
			</p>
		</form>
	</div>
</body>
</html>