<?php
//
// INT_USERS object
//
class User_Class {
  // Properties
  private $user_id = 0;
  //  
  public $user_type;
  public $user_category;
  public $user_status;
  public $username;
  public $password;
  public $first_name;
  public $last_name;
  public $user_total_spend;
  public $user_total_pending;
  public $register_date;
  public $last_log_on;
  public $user_email;
  public $user_address;
  public $user_phone_no;
  //
  // Get next User_Id Method
  protected function GetNextUserId(){
    global $db;
    //
    $v_next_seq = GetSettingValue('next_sequence_user_id');
    //
    //Check if Sequence exists
    if(!empty($v_next_seq)){
      //Increment sequence by 1
      $v_new_next_seq = number_format($v_next_seq) + 1;
      //
      //Save new sequence number to Database
      if (SetSettingValue('next_sequence_user_id', $v_new_next_seq)){
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
  // Load user data
  //
  // p_type = 'user_id'
  // p_type = 'username'
  public function LoadUser($p_type, $p_value) {
    global $db;
    //
    $query =
    "SELECT user_type
           ,user_category
           ,user_status
           ,username
           ,password
           ,user_total_spend
           ,user_total_pending
           ,register_date
           ,last_log_on
           ,user_email
           ,user_address
           ,user_phone_no
      FROM users
     WHERE $p_type = '$p_value'
    ";
    //
    // Get data from the mySQL query
    $v_db_row = mysqli_query($db, $query);
    $v_db_structure = mysqli_fetch_array($v_db_row); 
    //
    $this->user_type          = $v_db_structure['user_type'];
    $this->user_category      = $v_db_structure['user_category'];
    $this->user_status        = $v_db_structure['user_status'];
    $this->username           = $v_db_structure['username'];
    $this->password           = $v_db_structure['password'];
    $this->user_total_spend   = $v_db_structure['user_total_spend'];
    $this->user_total_pending = $v_db_structure['user_total_pending'];
    $this->register_date      = $v_db_structure['register_date'];
    $this->last_log_on        = $v_db_structure['last_log_on'];
    $this->user_email         = $v_db_structure['user_email'];
    $this->user_address       = $v_db_structure['user_address'];
    $this->user_phone_no      = $v_db_structure['user_phone_no'];
    //
    return TRUE;
  }
  //
  // Create New User Method
  // User with same "Username" must not already exists
  //
  public function CreateUser() {
    global $db;
    //Get next sequence number
    $v_new_seq = $this->GetNextUserId(); 
    //
    if($v_new_seq > 0){
      $query = "INSERT INTO users
                  ( user_id
                   ,user_type
                   ,username
                   ,password
                   ,user_email
                   ,register_date
                   ,user_address
                   ,user_phone_no
                  )
           VALUES ( '$v_new_seq'
                   ,'user'
                   ,'$this->username'
                   ,'$this->password'
                   ,'$this->user_email'
                   , NOW()
                   ,'$this->user_address'
                   ,'$this->user_phone_no'
                 )";
      //Run a query
      mysqli_query($db, $query);
      //Check if query went fine
      if(empty(mysqli_error($db))){
        return TRUE;
      }else{
        return FALSE;
      }
    }
    else // $v_new_seq = 0
    {
      return FALSE;
    }
    //
  }

public function UpdateUser($username){
  global $db;
  $query = "UPDATE users
            SET    username             = '$this->username'
                  ,user_email           = '$this->user_email'
                  ,user_address         = '$this->user_address'
                  ,user_phone_no        = '$this->user_phone_no'
            WHERE  username = '$this->username'
            ";
    //Run a query
    mysqli_query($db, $query);

    dbg("Error description: " . mysqli_error($db));
    //Commit
    mysqli_commit($db);

return $query;
}

public function ChangePassword($username){
  global $db;
  $query = "UPDATE users
            SET    password = '$this->password'
            WHERE  username =  $username";
}
//
public function get_users() {
  global $db;
  //
  $query =
  "SELECT *
   FROM users
  ";
  // Get data from the mySQL query
  $v_db_row = mysqli_query($db, $query);
  //
  return $v_db_row;
  }

}



?>