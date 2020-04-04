<?php
require_once("../0_core/config.php");
include("../0_core/session.php");

function f_add_stock($p_item_id, $p_value){
  global $db;

  $query = "UPDATE items 
            SET    item_stock = item_stock + " . $p_value . "
            WHERE  item_id = '$p_item_id'
            ";

  mysqli_query($db, $query);
  mysqli_commit($db);

  return true;
}

function f_remove_stock( $p_item_id, $p_value){
  global $db;

  $query = "UPDATE ite
            SET    item_stock = item_stock - " . $p_value . "
            WHERE  item_id = '$p_item_id'
          ";
  
  mysqli_query($db, $query);
  mysqli_commit($db);

  return true;
}


// Stock changing functionality
if (isset($_POST["sub_item_id"])) {  
  //check if item exist
  $v_sub_item_id = mysqli_real_escape_string($db, $_POST['sub_item_id']);
  $v_sub_value   = mysqli_real_escape_string($db, $_POST['sub_value']);
  $v_sub_action  = mysqli_real_escape_string($db, $_POST['sub_action']);
  $v_sub_comment = mysqli_real_escape_string($db, $_POST['sub_comment']);

  $s_stock_history = new Stock_History_Class();
    //Get item by id
    $item = get_item_id($v_sub_item_id);
    // Get VAT value
    $vat_value = GetSettingValue('vat');

  if ($v_sub_action == 'A'){
    f_add_stock($v_sub_item_id, $v_sub_value);
    
    //
    // Populate stock fields
    //
    //$s_stock_history->record_date      = mysqli_real_escape_string($db, $_POST['item_category']);
    //$s_stock_history->orig_record_id   = mysqli_real_escape_string($db, $_POST['item_volume']);
    $s_stock_history->user             = mysqli_real_escape_string($db, $_SESSION['username']);
    $s_stock_history->record_type      = mysqli_real_escape_string($db, 'ADD');
    $s_stock_history->change_value     = mysqli_real_escape_string($db, $v_sub_value);
    $s_stock_history->item_id          = mysqli_real_escape_string($db, $v_sub_item_id);
    $s_stock_history->item_name        = mysqli_real_escape_string($db, $item['item_name']);
    $s_stock_history->item_category    = mysqli_real_escape_string($db, $item['item_category']);
    $s_stock_history->item_new_stock   = mysqli_real_escape_string($db, ($item['item_stock']+$v_sub_value));
    $s_stock_history->item_volume      = mysqli_real_escape_string($db, $item['item_volume']);
    $s_stock_history->item_unit        = mysqli_real_escape_string($db, $item['item_unit']);
    $s_stock_history->item_price       = mysqli_real_escape_string($db, $item['item_price']);
    //$s_stock_history->item_disc10      = mysqli_real_escape_string($db, $item['item_name']);
    //$s_stock_history->item_status      = mysqli_real_escape_string($db, $item['item_name']);
    $s_stock_history->vat              = mysqli_real_escape_string($db, $vat_value);
    $s_stock_history->comment          = mysqli_real_escape_string($db, $v_sub_comment);
    // Create history function
    $s_stock_history->CreateHistory();
                                         


  }elseif($v_sub_action == 'R'){
    f_remove_stock($v_sub_item_id, $v_sub_value);
    //
    // Populate stock fields
    //
    //$s_stock_history->record_date      = mysqli_real_escape_string($db, $_POST['item_category']);
    //$s_stock_history->orig_record_id   = mysqli_real_escape_string($db, $_POST['item_volume']);
    $s_stock_history->user             = mysqli_real_escape_string($db, $_SESSION['username']);
    $s_stock_history->record_type      = mysqli_real_escape_string($db, 'REMOVE');
    $s_stock_history->change_value     = mysqli_real_escape_string($db, $v_sub_value);
    $s_stock_history->item_id          = mysqli_real_escape_string($db, $v_sub_item_id);
    $s_stock_history->item_name        = mysqli_real_escape_string($db, $item['item_name']);
    $s_stock_history->item_category    = mysqli_real_escape_string($db, $item['item_category']);
    $s_stock_history->item_new_stock   = mysqli_real_escape_string($db, ($item['item_stock']-$v_sub_value));
    $s_stock_history->item_volume      = mysqli_real_escape_string($db, $item['item_volume']);
    $s_stock_history->item_unit        = mysqli_real_escape_string($db, $item['item_unit']);
    $s_stock_history->item_price       = mysqli_real_escape_string($db, $item['item_price']);
    //$s_stock_history->item_disc10      = mysqli_real_escape_string($db, $item['item_name']);
    //$s_stock_history->item_status      = mysqli_real_escape_string($db, $item['item_name']);
    $s_stock_history->vat              = mysqli_real_escape_string($db, $vat_value);
    $s_stock_history->comment          = mysqli_real_escape_string($db, $v_sub_comment);
    // Create history function
    $s_stock_history->CreateHistory();
  }
  //
  //
}


?>
<html>
  <head>
    <title>All items</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="all_items.css">       
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <div class="link_decor">
        <a href="../website/all_items.php">
          <h2>All items</h2>
      </a>
    </div>

      <?php
        //Submit Debugs
        //echo "<h2>Item id:: " . $v_sub_item_id . "</h2>";
        //echo "<h2>value: " . $v_sub_value . "</h2>";
        //echo "<h2>action: " . $v_sub_action . "</h2>";
      ?>

      <div class="page">	<br>
        <table>
            <tr>
              <th width="8%"></th>
              <th width="7%"></th> 
              <th width="5%"></th>
              <th width="5%" class="link_decor">
                <a href=" <?php 
                            echo $_SERVER['PHP_SELF']?>?orderby=<?php if ($_GET['orderby'] == 'stocka'){
                                                                        echo 'stockd';
                                                                      }else{
                                                                        echo 'stocka';
                                                                        }?>">
                  <span>Stock</span>
                </a>
              </th>
              <th width="5%"></th>
              <th width="300px" class="link_decor">
                <a href=" <?php echo $_SERVER['PHP_SELF']?>">
                  <span>Name</span>
              </th>
              <th class='left link_decor' width="10%">
               <a href=" <?php 
                            echo $_SERVER['PHP_SELF']?>?orderby=<?php if ($_GET['orderby'] == 'sizea'){
                                                                        echo 'sized';
                                                                      }else{
                                                                        echo 'sizea';
                                                                        }?>">
                  <span>Size</span>
                </a>
              </th>
              <th class='left link_decor' width="10%">
                <a href=" <?php 
                            echo $_SERVER['PHP_SELF']?>?orderby=<?php if ($_GET['orderby'] == 'pricea'){
                                                                        echo 'priced';
                                                                      }else{
                                                                        echo 'pricea';
                                                                        }?>">
                  <span>Price</span>
                </a>
              </th>
              <th class='left' width="10%">Disc 10+</th>
            </tr>
          
          <?php


          if (!empty($_GET['filterby'])){                                                              
            $v_filterby = " where item_name = '" . $_GET['filterby'] . "' ";
          }else{
            $v_filterby = "";
          }

          $v_orderby = " ORDER BY item_name asc, ABS(item_volume) asc";

          if (!empty($_GET['orderby'])){
            if ($_GET['orderby'] == 'stocka'){
              $v_orderby = " ORDER BY item_stock asc";
            }elseif($_GET['orderby'] == 'stockd'){
              $v_orderby = " ORDER BY item_stock desc";
            }
            elseif($_GET['orderby'] == 'sized'){
              $v_orderby = " ORDER BY ABS(item_volume) desc";
            }elseif($_GET['orderby'] == 'sizea'){
              $v_orderby = " ORDER BY ABS(item_volume) asc";
            }
            elseif($_GET['orderby'] == 'priced'){
              $v_orderby = " ORDER BY ABS(item_price) desc";
            }elseif($_GET['orderby'] == 'pricea'){
              $v_orderby = " ORDER BY ABS(item_price) asc";
            }
          }

          $v_orderby = $v_orderby . ", item_name asc, ABS(item_volume) asc";

          $query = "SELECT * FROM items" . $v_filterby . $v_orderby . "";

echo "DBG " . $query;

          $result = mysqli_query($db, $query);
          if(mysqli_num_rows($result) > 0)
          {
            while($row = mysqli_fetch_array($result))
            {
          ?>
            
            <tr>
              <td><a href="<?= 'item.php?item_id='.$row['item_id'] ?>">
                  <?php echo  '<img class="image" src="../images/'.$row['item_id'].'.png" height="100px" width="100px" alt ="n/a"/>'; ?>
              </a></td>
              <td><a class="edit" href="edit_item.php?item_id=<?php echo $row["item_id"]; ?>"><span>Edit</span></a></td>
              <td><button onclick="myFunction('<?php echo $row['item_id'];?>', '<?php echo $row['item_name'] . ' [' . $row['item_volume'] . $row['item_unit'] . ']'?>', 'A' )" >+</button></td>
              <td><?php echo $row["item_stock"]; ?></td>
              <td><button onclick="myFunction('<?php echo $row['item_id'];?>', '<?php echo $row['item_name'] . ' [' . $row['item_volume'] . $row['item_unit'] . ']'?>', 'R' )" >-</button></td>
              <!-- 
                Name 
              -->
              <td class='left link_decor'>
                <a href="<?php echo $_SERVER['PHP_SELF']?>?filterby=<?php echo $row["item_name"];?>">
                  <span><?php echo $row["item_name"];?></span>
                </a
              ></td>
              <!-- 
                Size 
              -->
              <td class='left'><?php echo $row["item_volume"]." ".$row["item_unit"]; ?></td>
              <!-- 
                Price 
              -->
              <td class='left'>€ <?php echo $row["item_price"]; ?></td>
              <td class='left'><?php if(empty($row["item_disc10"])) {echo "/";}else echo "€ ".$row["item_disc10"]; ?></td>
            </tr>
            <!-- Trigger/Open The Modal -->



            <?php
            }
          }
        ?>
    </table>



          <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
              <span class="close">&times;</span>
              <div id="modal_div">
                <!-- Java Script is adding code here... -->
                <form id="myForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
                  <h3 id="id_modal_h3">Error happend please contact administrator!</h3>
                  <h2 id="id_modal_h2">Error happend please contact administrator!</h2>
                  <p class="modal_p">Value:</p> <input type="text" name="sub_value" id="id_sub_value">
                  <p class="modal_p">Comment:</p> <input type="text" name="sub_comment" id="id_sub_comment">
                  <input type="hidden" id="sub_item_id" name="sub_item_id">
                  <input type="hidden" id="sub_action" name="sub_action">
                  <input id="id_sub_but" type="button" onclick="SubmitFormFunction()" value="Submit form">
                </form>
                <!--//-->
              </div>
            </div>
          </div>

      </div>
      <!-- The Modal -->
  
      <?php
    ?>

<script>

// Prevent a resubmit on refresh and back button
if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
}

var v_item_id = 0;
// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

function SubmitFormFunction() {

  var v_submit = true;

  //set to default first
  document.getElementById("id_sub_comment").style.borderColor = "";
  document.getElementById("id_sub_comment").style.borderWidth = "";
  document.getElementById("id_sub_value").style.borderColor = "";
  document.getElementById("id_sub_value").style.borderWidth = "";


  if (document.getElementById("id_sub_comment").value == '') {
    document.getElementById("id_sub_comment").style.borderColor = "red";
    document.getElementById("id_sub_comment").style.borderWidth = "3px";
    v_submit = false;
  }
  
  if(document.getElementById("id_sub_value").value == '') {
    document.getElementById("id_sub_value").style.borderColor = "red";
    document.getElementById("id_sub_value").style.borderWidth = "3px";
    v_submit = false;
  }
  
  if(v_submit == true){
    document.getElementById("myForm").submit();
  }

}

// When the user clicks the button, open the modal 
function myFunction(p_item_id, p_item_name, p_action) {

  //set defauls
  document.getElementById("id_sub_comment").value = "";
  document.getElementById("id_sub_value").value = "";

  document.getElementById("id_sub_value").placeholder   = "Please add a value.";
  document.getElementById("id_sub_comment").placeholder   = "Please add a comment.";
  document.getElementById("id_sub_comment").style.borderColor = "";
  document.getElementById("id_sub_comment").style.borderWidth = "";

  if (p_action == 'A') {
    document.getElementById("id_modal_h3").innerHTML  = "Add quantity to:";
    document.getElementById("id_modal_h2").innerHTML  = p_item_name;
    document.getElementById("id_sub_but").value  = "Add";
    document.getElementById("sub_item_id").value = p_item_id;
    document.getElementById("sub_action").value  = p_action;
  }
  else if (p_action == 'R'){
    document.getElementById("id_modal_h3").innerHTML  = "Remove quantity from:";
    document.getElementById("id_modal_h2").innerHTML  = p_item_name;
    document.getElementById("id_sub_but").value  = "Remove";
    document.getElementById("sub_item_id").value = p_item_id;
    document.getElementById("sub_action").value  = p_action;
  }else{
    document.getElementById("modal_text").innerHTML = "Error Happend! Please contact the Administrator.";
  }


  modal.style.display = "block";

}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
  location.reload();
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
if (event.target == modal) {
  modal.style.display = "none";
}
}
</script>

</body>
</html>


