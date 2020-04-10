<?php
 
class Stock_History_Class {	
 //
 private  $record_id = 0;
 //
 public   $record_date;
 public   $orig_record_id;
 public   $user;
 public   $record_type;
 public   $change_value;
 public   $item_id;
 public   $item_name;
 public   $item_category;
 public   $item_new_stock;
 public   $item_volume;
 public   $item_unit;
 public   $item_price;
 public   $item_disc10;
 public   $item_status;
 public   $vat;
 public   $comment;
//
 public function CreateHistory() {
  global $db;
  
  //$this->record_date     = calculatedate();
  //$this->orig_record_id  = calculatid();

    $query = "INSERT INTO stock_history
                (  
                   user
                  ,record_type
                  ,change_value
                  ,item_id
                  ,item_name
                  ,item_category
                  ,item_new_stock
                  ,item_volume
                  ,item_unit
                  ,item_price                 
                  ,vat
                  ,comment
                )
         VALUES ( 
                  '$this->user'
                 ,'$this->record_type'
                 ,'$this->change_value'
                 ,'$this->item_id'
                 ,'$this->item_name'
                 ,'$this->item_category'
                 ,'$this->item_new_stock'
                 ,'$this->item_volume'
                 ,'$this->item_unit'
                 ,'$this->item_price'
                 ,'$this->vat'
                 ,'$this->comment'
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

 public function LoadHistory($p_type, $p_value) {
  global $db;
  //
  $query =
  "SELECT record_date
         ,orig_record_id
         ,user
         ,record_type
         ,change_value
         ,item_id
         ,item_name
         ,item_category
         ,item_new_stock
         ,item_volume
         ,item_unit
         ,item_price
         ,item_disc10
         ,item_status
         ,vat
         ,comment
    FROM stock_history
   WHERE $p_type = '$p_value'
  ";
  //
  // Get data from the mySQL query
  $v_db_row = mysqli_query($db, $query);
  $v_db_structure = mysqli_fetch_array($v_db_row); 
  //
  $this->record_date      = $v_db_structure['record_date'];
  $this->orig_record_id   = $v_db_structure['orig_record_id'];
  $this->user             = $v_db_structure['user'];
  $this->record_type      = $v_db_structure['record_type'];
  $this->change_value     = $v_db_structure['change_value'];
  $this->item_id          = $v_db_structure['item_id'];
  $this->item_name        = $v_db_structure['item_name'];
  $this->item_category    = $v_db_structure['item_category'];
  $this->item_new_stock   = $v_db_structure['item_new_stock'];
  $this->item_volume      = $v_db_structure['item_volume'];
  $this->item_unit        = $v_db_structure['item_unit'];
  $this->item_price       = $v_db_structure['item_price'];
  $this->item_disc10      = $v_db_structure['item_disc10'];
  $this->item_status      = $v_db_structure['item_status'];
  $this->vat              = $v_db_structure['vat'];
  $this->comment          = $v_db_structure['comment'];
 
  //
  return TRUE;
  }
  public function get_purchase_history($p_user) {
    global $db;
    //
    $query =
    "SELECT record_date
           ,orig_record_id
           ,user
           ,record_type
           ,change_value
           ,item_id
           ,item_name
           ,item_category
           ,item_new_stock
           ,item_volume
           ,item_unit
           ,item_price
           ,item_disc10
           ,item_status
           ,vat
           ,comment
      FROM stock_history
     WHERE user = '$p_user' AND record_type = 'buy'
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
}

?>

<?php
// 
//  Function New stock
function new_stock($p_stock, $p_item_id){
  global $db;
  
  $query = "UPDATE items
            SET    stock   =  stock + " . $p_stock . "
            WHERE  item_id = '$p_item_id'
          ";
  
  mysqli_query($db, $query);
  mysqli_commit($db);
  
  return TRUE;
  }
  // 
//  Function Update stock
function remove_stock($p_stock, $p_item_id){
  global $db;
  
  
  $query = "UPDATE items
            SET    stock   =  stock - '$p_stock'
            WHERE  item_id = '$p_item_id'
          ";
  
  mysqli_query($db, $query);
  mysqli_commit($db);
  
  return TRUE;
  }
?>