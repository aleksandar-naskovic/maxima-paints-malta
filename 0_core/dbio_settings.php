<?php
  // 
  // Manupulations on the "SETTING" table.
  //
  // Return setting value
  function GetSettingValue($p_setting_name){
    global $db;
    $query = "SELECT setting_value
                FROM settings
               WHERE setting_name = '$p_setting_name'
             ";
    //
    $v_row = mysqli_query($db, $query);
    $v_structure = mysqli_fetch_array($v_row);
    $v_setting_value = $v_structure['setting_value'];
    return $v_setting_value;
  }
  //
  // Set setting value
  function SetSettingValue($p_setting_name, $p_setting_value){
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
?>