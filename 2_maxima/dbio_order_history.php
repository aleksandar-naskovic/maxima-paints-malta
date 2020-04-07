<?php
 
class Order_History_Class {	
//
 public   $item_id;
 public   $item_name;
 public   $item_category;
 public   $item_volume;
 public   $item_unit;
 public   $item_price;
 public   $item_disc10;
 public   $item_quantity;
 public   $record_date;
 public   $user_username;
 public   $order_number_sequence;
//
 public function CreateOrderHistory() {
  global $db;
  
  //$this->record_date     = calculatedate();
  //$this->orig_record_id  = calculatid();

    $query = "INSERT INTO int_order_history
                (  
                   item_id
                  ,item_name
                  ,item_category
                  ,item_volume
                  ,item_unit
                  ,item_price
                  ,item_disc10
                  ,item_quantity
                  ,record_date
                  ,user_username
                  ,order_number_sequence
                )
         VALUES ( 
                  '$this->item_id'
                 ,'$this->item_name'
                 ,'$this->item_category'
                 ,'$this->item_volume'
                 ,'$this->item_unit'
                 ,'$this->item_price'
                 ,'$this->item_disc10'
                 ,'$this->item_quantity'
                 , NOW()
                 ,'$this->user_username'
                 ,'$this->order_number_sequence'
               )";
    //Run a query
    mysqli_query($db, $query);
    //Check if query went fine
    if(empty(mysqli_error($db))){
      return $query;
    }else{
      return FALSE;
    }
 }

 public function LoadOrderHistory($p_type, $p_value) {
  global $db;
  //
  $query =
  "SELECT item_id
         ,item_name
         ,item_category
         ,item_volume
         ,item_unit
         ,item_price
         ,item_disc10
         ,item_quantity
         ,record_date
         ,user_username
         ,order_number_sequence
    FROM int_order_history
   WHERE $p_type = '$p_value'
  ";
  //
  // Get data from the mySQL query
  $v_db_row = mysqli_query($db, $query);
  $v_db_structure = mysqli_fetch_array($v_db_row); 
  //
  $this->item_id                 = $v_db_structure['item_id'];
  $this->item_name               = $v_db_structure['item_name'];
  $this->item_category           = $v_db_structure['item_category'];
  $this->item_volume             = $v_db_structure['item_volume'];
  $this->item_unit               = $v_db_structure['item_unit'];
  $this->item_price              = $v_db_structure['item_price'];
  $this->item_disc10             = $v_db_structure['item_disc10'];
  $this->item_quantity              = $v_db_structure['item_quantity'];
  $this->record_date             = $v_db_structure['record_date'];
  $this->user_username           = $v_db_structure['user_username'];
  $this->order_number_sequence   = $v_db_structure['order_number_sequence'];
 
  //
  return TRUE;
  }
  //
  public function get_order_history() {
    global $db;
    //
    $query =
    "SELECT item_name
           ,item_category
           ,item_volume
           ,item_unit
           ,item_price
           ,item_disc10
           ,item_quantity
           ,record_date
           ,user_username
           ,order_number_sequence
      FROM int_order_history
    ";
    //
    // Get data from the mySQL query
    //
    $v_db_row = mysqli_query($db, $query);
    $v_db_structure = mysqli_fetch_array($v_db_row); 
    //
    $array = [];
          if($v_db_row) {
            while($v_db_structure = mysqli_fetch_assoc($v_db_row)) 
            {
            $array[] = $v_db_structure;
            }
          }
        return $array;
    }
//
}
?>