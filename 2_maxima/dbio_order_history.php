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
 public   $order_status;
 public   $delivery_date;
 public   $paid_amount;
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
                  ,order_status
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
                 ,'PENDING'
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
         ,order_status
         ,delivery_date
         ,paid_amount
    FROM int_order_history
   WHERE $p_type = '$p_value'
  ";
  //
  // Get data from the mySQL query
  $v_db_row = mysqli_query($db, $query);
  //
  return $v_db_row;
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
           ,order_status
           ,delivery_date
           ,paid_amount
      FROM int_order_history
    ";
    //
    // Get data from the mySQL query
    //
    $v_db_row = mysqli_query($db, $query);
    //
    return $v_db_row;
    }
//
public function item_delivered($p_item_id, $p_order_id){
  global $db;
  
  $query = "UPDATE int_order_history
            SET    delivery_date   =  NOW()
            WHERE  item_id = '$p_item_id' AND order_number_sequence = '$p_order_id'
          ";
  
  mysqli_query($db, $query);
    if(empty(mysqli_error($db))){
      dbg('> "UPDATE int_order_history" query is fine!');
    }else{
      echo mysqli_error($db);
      dbg('ERROR: "UPDATE int_order_history" query has errors!');
      //
      return FALSE;
    }
  //
  return $query;
  }
//
public function LoadOrderHistoryById($p_item_id, $p_order_id) {
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
         ,order_status
         ,delivery_date
         ,paid_amount
    FROM int_order_history
   WHERE item_id = '$p_item_id' AND order_number_sequence = '$p_order_id'
  ";
  //
  // Get data from the mySQL query
  $v_db_row = mysqli_query($db, $query);
  //
  return $v_db_row;
  }
//
}
?>