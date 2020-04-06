<?php
//
//
// INT_ITEMS object
//
class Item_Class {
  // Properties
  public $item_id = 0;
  //  //
  public $item_name;
  public $item_category;
  public $item_volume;
  public $item_unit;
  public $item_price;
  public $item_disc10;
  public $item_stock;
  public $item_description;
  public $item_characteristic;
  public $item_how_to_use;
  public $item_add_info;
  public $item_for_interior;
  public $item_for_exterior;
  public $item_status;
  //
  // Get next Item_Id Method
  protected function GetNextItemId(){
    global $db;
    //
    $v_next_seq = GetSettingValue('next_sequence_item_id');
    //
    //Check if Sequence exists
    if(!empty($v_next_seq)){
      //Increment sequence by 1
      $v_new_next_seq = number_format($v_next_seq) + 1;
      //
      //Save new sequence number to Database
      if (SetSettingValue('next_sequence_item_id', $v_new_next_seq)){
        return $v_next_seq;
      }else{
        //ERROR: Saving of new next sequence has failed
        return '0';
      }
      //
    }else{
      //ERROR: Some error happend when getting the sequence or the sequence does not exists
      return '0';
    }
    //
  }

  //
  // Create New item Method
  // Item with same "Name" and "Volume+Unit" must not already exists
  //
  public function CreateItem() {
    global $db;
    //Get next sequence number
    $v_new_seq = $this->GetNextItemId(); 
    //
    if($this->item_for_interior <> '1'){ $this->item_for_interior = '0'; }
    if($this->item_for_exterior <> '1'){ $this->item_for_exterior = '0'; }
    //
    if($v_new_seq > 0){
      $query = "INSERT INTO items
                  ( item_id
                   ,item_name
                   ,item_category
                   ,item_volume
                   ,item_unit
                   ,item_price
                   ,item_disc10
                   ,item_stock
                   ,item_description
                   ,item_characteristic
                   ,item_how_to_use
                   ,item_add_info
                   ,item_for_interior
                   ,item_for_exterior
                   ,item_status
                  )
           VALUES ( '$v_new_seq'
                   ,'$this->item_name'
                   ,'$this->item_category'
                   ,'$this->item_volume'
                   ,'$this->item_unit'
                   ,'$this->item_price'
                   ,'$this->item_disc10'
                   ,'$this->item_stock'
                   ,'$this->item_description'
                   ,'$this->item_characteristic'
                   ,'$this->item_how_to_use'
                   ,'$this->item_add_info'
                   ,'$this->item_for_interior'
                   ,'$this->item_for_exterior'
                   ,'$this->item_status'
                 )";
      //Run a query
      mysqli_query($db, $query);
      //Check if query went fine
      if(empty(mysqli_error($db))){
        dbg('> "INSERT INTO items" query is fine! New sequence: '.$v_new_seq);
      }else{
        echo mysqli_error($db);
        dbg('ERROR: "INSERT INTO items" query has errors!');
      }
    }else{
      dbg('ERROR: "GetNextItemId()" returns 0!');
    }
    //
    dbg('> CreateItem 1');
    //
    return TRUE;
  }

  //
  // Update Item Method
  //
  public function UpdateItem() {
    global $db;
    //
    if($this->item_for_interior <> '1'){ $this->item_for_interior = '0'; }
    if($this->item_for_exterior <> '1'){ $this->item_for_exterior = '0'; }
    //
      $query = "UPDATE items
                   SET item_name           = '$this->item_name'
                      ,item_volume         = '$this->item_volume'
                      ,item_unit           = '$this->item_unit'
                      ,item_price          = '$this->item_price'
                      ,item_disc10         = '$this->item_disc10'
                      ,item_category       = '$this->item_category'
                      ,item_stock          = '$this->item_stock'
                      ,item_description    = '$this->item_description'
                      ,item_characteristic = '$this->item_characteristic'
                      ,item_how_to_use     = '$this->item_how_to_use'
                      ,item_add_info       = '$this->item_add_info'
                      ,item_for_interior   = '$this->item_for_interior'
                      ,item_for_exterior   = '$this->item_for_exterior'                      
                WHERE  item_id = '$this->item_id'
               ";
      //Run a query
      mysqli_query($db, $query);
      //Check if query went fine
      if(empty(mysqli_error($db))){
        dbg('> "UPDATE items" query is fine!');
      }else{
        echo mysqli_error($db);
        dbg('ERROR: "UPDATE items" query has errors!');
        //
        return FALSE;
      }
    //
    return TRUE;
  }
  //
  //
  // Delete Item method
  //
  public function DeleteItem() {
    global $db;
    //
      $query = "DELETE items                     
                WHERE  item_id = '$this->item_id'
               ";
      //Run a query
      mysqli_query($db, $query);
      //Check if query went fine
      if(empty(mysqli_error($db))){
        dbg('> "DELETE items" query is fine!');
      }else{
        echo mysqli_error($db);
        dbg('ERROR: "DELETE items" query has errors!');
        //
        return FALSE;
      }
    //
    return TRUE;
  }

}



?>