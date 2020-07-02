<?php
require_once("../0_core/config.php");
include("../0_core/session.php");
	//
	$user_id = $_GET['user_id'];
	$s_user = new User_Class();
	$s_user->LoadUser("user_id", $user_id);
	//
	// If edit user button is clicked
  if (isset($_POST["edit_user"])) {  
		//
    // Populate user fields
    //
    $s_user->username      	     	 = mysqli_real_escape_string($db, $_POST['username']);
    $s_user->first_name     	     = mysqli_real_escape_string($db, $_POST['first_name']);
    $s_user->last_name     	   	   = mysqli_real_escape_string($db, $_POST['last_name']);
    $s_user->user_email   	       = mysqli_real_escape_string($db, $_POST['email']);
    $s_user->user_address   	     = mysqli_real_escape_string($db, $_POST['address']);
    $s_user->user_phone_no	       = mysqli_real_escape_string($db, $_POST['phone_number']);
    //
    // Call edit user function
		$s_user->UpdateUser($user_id);
		echo 	$s_user->UpdateUser($_GET['user_id']);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit user</title>
	<link rel="stylesheet" type="text/css" href="../0_core/style.css">
	<link rel="stylesheet" type="text/css" href="../0_core/generic_input.css">
</head>
<body>
	<?php include("../website/navbar.php"); ?>
	<div class="page">
		<h2>Edit User</h2><br>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']. "?user_id=" .$user_id; ?>" enctype="multipart/form-data">
<!-- 
  User name
-->
			<div class="FlexContainer">
				<div class="col-25">
					<label>Username</label>
				</div>
				<div class="col-75">	
					<input type="text" name="username"  value="<?php echo $s_user->username; ?>">
				</div>
			</div><br>
<!-- 
  First name
-->
			<div class="FlexContainer">
				<div class="col-25">
					<label>First name</label>
				</div>
				<div class="col-75">	
					<input type="text" name="first_name" value="<?php echo $s_user->first_name; ?>">
				</div>
			</div><br>
<!-- 
  Last name
-->
			<div class="FlexContainer">
				<div class="col-25">
					<label>Last name</label>
				</div>
				<div class="col-75">	
					<input type="text" name="last_name" value="<?php echo $s_user->last_name; ?>">
				</div>
			</div><br>
<!-- 
  Email
-->							
			<div class="FlexContainer">
				<div class="col-25">
					<label>Email</label>
				</div>
				<div class="col-75">	
					<input type="text" name="email" value="<?php echo $s_user->user_email; ?>">
				</div>
			</div><br>
<!-- 
  Addres
-->			
			<div class="FlexContainer">
				<div class="col-25">
					<label>Address</label>
				</div>
				<div class="col-75">	
					<input type="text" name="address" value="<?php echo $s_user->user_address; ?>">
				</div>
			</div><br>
<!-- 
  Phone number
-->

			<div class="FlexContainer">
				<div class="col-25">
					<label>Phone number</label>
				</div>
				<div class="col-75">	
					<input type="text" name="phone_number" value="<?php echo $s_user->user_phone_no; ?>">
				</div>
			</div><br>
			<!-- 
  Submit button
			-->
				<button type="submit" class="main_button" name="edit_user">Edit user</button>
			<br>
		</form>
	</div>
</body>
</html>