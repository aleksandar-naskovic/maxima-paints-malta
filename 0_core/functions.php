<?php
function most_popular_item_1(){
  global $db;
  $v_setting = GetSettingValue('most_popular_item_1');

	$query = "SELECT *
            FROM   items
            WHERE  item_id = '$v_setting'
            ";

$items = mysqli_query($db, $query);
	return mysqli_fetch_array($items) ;
}
function most_popular_item_2(){
  global $db;
  $v_setting = GetSettingValue('most_popular_item_2');

	$query = "SELECT *
						FROM items
						WHERE item_id = '$v_setting'
						";
	$items = mysqli_query($db, $query);
	return mysqli_fetch_array($items) ;
}
function most_popular_item_3(){
  global $db;
  $v_setting = GetSettingValue('most_popular_item_3');

	$query = "SELECT *
						FROM items
						WHERE item_id = '$v_setting'
						";
	$items = mysqli_query($db, $query);
	return mysqli_fetch_array($items) ;
}


function get_setting($p_setting_name){
	global $db;
	$query = "SELECT setting_value
				FROM settings
			   WHERE setting_name = '$p_setting_name'
			 ";
						
	$v_row = mysqli_query($db, $query);
	$v_structure = mysqli_fetch_array($v_row);
	$v_setting_value = $v_structure['setting_value'];
	return $v_setting_value;
}
function SetSetting($p_setting_name, $p_setting_value){
	global $db;
	$query = "UPDATE settings
	             SET setting_value = '$p_setting_value'
			   WHERE setting_name = '$p_setting_name'
			 ";
	//
	//Execute a query
	mysqli_query($db, $query);
	//
	//Check for query errors
	if(empty(mysqli_error($db))){
		return TRUE;
	}else{
		return FALSE;
	}
	//
}
//function is_logged_in($user){
//}
//Hide item
function hide_item($item_id){
	global $db;
	$query = "UPDATE items
         		SET    status  = 'hidden'
            WHERE  item_id = '$item_id'
        ";
}
//Get items
function get_all_items(){
	global $db;
	$query = "SELECT *
						FROM  items
				 	 ";
	$items = mysqli_query($db, $query);
	return mysqli_fetch_array($items);
}

//Get User
function get_user($p_username){
	global $db;
	$v_query = "SELECT * 
				  		FROM 	 users 
				  		WHERE  username = '{$p_username}' 
				  		";
  $v_aUser = mysqli_query($db, $v_query);
  
	return mysqli_fetch_array($v_aUser);
}

//Get Categories
function get_categories(){
	global $db;
	$query = "SELECT category
						FROM   items";
	$categories = mysqli_query($db, $query);
	return $categories;
}
//Get category names
function get_category_names(){
	global $db;
	$query = "SELECT DISTINCT item_category
						FROM  items
					 ";
	$categories = mysqli_query($db, $query);
	return $categories;
}
//Get items
function get_items($p_category){
	global $db;
	$query = "SELECT *
						FROM  items
						WHERE item_category= '{$p_category}'
						ORDER BY ABS(item_price) DESC
				 	 ";
	$v_items = mysqli_query($db, $query);
	return $v_items;
}
// Check if item exist
function is_item_exist($p_item_name){
	global $db;
		$query= " SELECT count(*)
							FROM 	 items
							WHERE  item_name = '{$p_item_name}'
						";
		$v_count = mysqli_query($db, $query);
		if ($v_count==0) {
			return false;
		}
		return true;
				



}
//
function get_item_id($item_id){
	global $db;
	$query = "SELECT *
						FROM 	 items
						WHERE  item_id = '{$item_id}'
					 ";
	$items = mysqli_query($db, $query);
	return mysqli_fetch_array($items) ;
}
//
//
// FUNCTIONS FOR REGISTRATION PROCESS
// Check does passwords match
function is_password_matching($password_1, $reentered_password){
	if ($password_1 != $reentered_password) {
		return false;
	}
	return true;
}
// Registration input check
function reg_check_input($username, $first_name, $last_name, $email, $password_1, $address, $phone_number){
	global $errors;
	if (empty($username)) 		{ array_push($errors, "Username is required"); }
	if (empty($first_name)) 	{ array_push($errors, "First name is required"); }
	if (empty($last_name)) 		{ array_push($errors, "Last name is required"); }
	if (empty($email)) 				{ array_push($errors, "Email is required"); }
	if (empty($password_1)) 	{ array_push($errors, "Password is required"); }
	if (empty($address)) 			{ array_push($errors, "Address is required"); }
	if (empty($phone_number)) { array_push($errors, "Phone number is required"); }
	return $errors;
}
// INSERT INTO QUERY
function reg_query($user_type, $user_category, $username, $first_name, $last_name, $password, $register_date,
$total_spend, $last_log_on, $email, $address, $phone_number){
	global $db;
	$query = "INSERT INTO users( user_type
															,user_category
															,username
															,first_name
															,last_name
															,password
															,register_date
															,total_spend
															,last_log_on
															,email
															,address
															,phone_number
															) 
													VALUES
													(
													 	 '$user_type'
														,'$user_category'
														,'$username'
														,'$first_name'
														,'$last_name'
														,'$password'
														,'$register_date'
														,'$total_spend'
														,'$last_log_on'
														,'$email'
														,'$address'
														,'$phone_number'
													)
													";
return mysqli_query($db, $query);
}
//
//LOGIN FUNCTIONS
//
function login_input_check($username, $password){
	global $errors;
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}
	return $errors;
}

function login_query($username, $password){
	$query = "SELECT * 
						FROM   users 
						WHERE  username = '{$username}' 
						AND    password = '{$password}'";
		 return $query;
}

function admin_approval($username){
	$approval =  "SELECT * 
								FROM 	users 
								WHERE username = '{$username}'  
								AND 	approval =" .CONST_LOG_IN_APPROVED;
		 return $approval;
}

?>

