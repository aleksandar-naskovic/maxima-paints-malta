<?php
require_once("../0_core/config.php");
include("../0_core/session.php");
//

?>
<html>
  <head>
    <title>All users</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="../0_core/generic_input.css"> 
    <link rel="stylesheet" type="text/css" href="my_account.css">   
  </head>
  <body>
  <?php include("navbar.php")?>
    <div class="page">
      <br>
      <h2>All users</h2><br>
         <!-- 
  Order history table
-->
      <!-- Load order history -->
      <?php  $users = User_Class::get_users();?>

      <p class="underline">List of users</p><br>
      <?php if(!empty($users))
      {?>
      <table>
            <tr>
              <th width="10%">Username</th>
              <th width="10%">User type</th>
              <th width="20%">First name</th>
              <th width="20%">Last name</th> 
              <th width="10%">Email</th>
              <th width="10%">Edit</th>
            </tr>
          
  
           <?php foreach($users as $key => $user) 
	      {    ?>
  
            <tr>
              <td><?php echo $user['username']; ?></td>
              <td><?php echo $user['user_type']; ?></td> 
              <td><?php echo $user['first_name']; ?></td>
              <td><?php echo $user['last_name']; ?></td>
              <td><?php echo $user['user_email']; ?></td>         
              <td><a href="edit_user.php?user_id=<?php echo $user["user_id"];?>">Edit</a></td>       
            </tr>
<?php	  }?>
            
    </table>
    <?php 
      } 
    ?>
    </div>
  </body>
</html>
    