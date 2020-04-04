<?php
  //
  session_start();
  //
  //if login in session is not set
  if(empty($_SESSION['username'])){ 
    header("Location: ../1_log_in/login.php");
  }
  //
  //If logout is clicked
 // if (isset($_GET['logout'])) {
 //   // Destroy session when user log out
 //   session_destroy();
 //   unset($_SESSION['username']);
 //   header("location: ../1_log_in/login.php");
 // }
?>