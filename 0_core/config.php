<?php
//
ob_start();
//
//Database constants
defined("DB_HOST") ? null : define("DB_HOST", "localhost");
defined("DB_USER") ? null : define("DB_USER", "maximapa_user");
defined("DB_PASS") ? null : define("DB_PASS", "Pucacina1.6-20");
defined("DB_NAME") ? null : define("DB_NAME", "maximapa_production");
//
//Database connnection
$db= mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
//
require_once("../0_core/constants.php");
require_once("../0_core/dbio_settings.php");
require_once("../0_core/functions.php");
//Objects
require_once("../2_maxima/dbio_stock_history.php");
require_once("../1_log_in/dbio_users.php");
//
function dbg($p_string){
  echo "<script>console.log('Debug: [" . $p_string . "]' );</script>";
}

?>