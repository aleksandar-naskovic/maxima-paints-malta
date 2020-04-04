
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../styles/style.css">
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
	<?php include("../website/navbar.php"); ?>
	<div class="page">
		<h2>Create User</h2>	<br>
		<form method="post" action="register.php">
			<?php include('errors.php'); ?>
			<div class="input-group">
				<label>User type</label>
				<input type="text" name="user_type" value="<?php echo $user_type; ?>">
			</div>
			<div class="input-group">
				<label>User Category</label>
				<input type="text" name="user_category" value="<?php echo $user_category; ?>">
			</div>
			<div class="input-group">
				<label>Username</label>
				<input type="text" name="username" value="<?php echo $username; ?>">
			</div>
			<div class="input-group">
				<label>First name</label>
				<input type="text" name="first_name" value="<?php echo $first_name; ?>">
			</div>
			<div class="input-group">
				<label>Last name</label>
				<input type="text" name="last_name" value="<?php echo $last_name; ?>">
			</div>
			<div class="input-group">
				<label>Password</label>
				<input type="password" name="password_1">
			</div>
			<div class="input-group">
				<label>Confirm password</label>
				<input type="password" name="reentered_password">
			</div>
			<div class="input-group">
				<label>Register date</label>
				<input type="date" name="register_date">
			</div>		
			<div class="input-group">
				<label>Total spend</label>
				<input type="text" name="total_spend" value="<?php echo $total_spend; ?>">
			</div>
			<div class="input-group">
				<label>Last log on</label>
				<input type="date" name="last_log_on">
			</div>		
			<div class="input-group">
				<label>Email</label>
				<input type="email" name="email" value="<?php echo $email; ?>">
			</div>
			<div class="input-group">
				<label>Address</label>
				<input type="text" name="address" value="<?php echo $address; ?>">
			</div>
			<div class="input-group">
				<label>Phone number</label>
				<input type="text" name="phone_number" value="<?php echo $phone_number; ?>">
			</div>
			<div class="input-group">
				<button type="submit" class="btn" name="reg_user">Register</button>
			</div><br>
			<p>
				Already a member ? <a href="login.php">Sign in</a>
			</p>
		</form>
	</div>
</body>
</html>