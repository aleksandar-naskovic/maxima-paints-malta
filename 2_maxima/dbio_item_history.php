<?php
//
//
// Item history object
//
class Item_History_Class {
  // Properties
  private $item_id = 0;
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
  public $date;
  public $user;
  //
  // Get next Item_Id Method
  
  public function create_item_history() {
    global $db;
      $query = "INSERT INTO item_history
                  ( item_name
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
                   ,date
                   ,user
                  )
           VALUES ( '$this->item_name'
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
                   ,'$this->date'
                   ,'$this->user'
                 )";
      //Run a query
      mysqli_query($db, $query);

    return TRUE;
  }

}



?>