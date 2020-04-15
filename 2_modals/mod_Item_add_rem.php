<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div id="modal_div">
      <!-- Java Script is adding code here... -->
      <form id="myForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
        <h3 id="id_modal_h3">Error happend please contact administrator!</h3>
        <h2 id="id_modal_h2">Error happend please contact administrator!</h2>
        
        <br>
        <div class="FlexContainer">
          <div class="col-25">  
            <label>Quantity:</label>
          </div>
          <div class="col-75">
            <input type="text" name="sub_value" id="id_sub_value">
          </div>
        </div>
        <br>

        <div class="FlexContainer">
          <div class="col-25">  
            <label>Expiry Date:</label>
          </div>
          <div class="col-75">
            <input type="date" id="id_sub_exp_date" name="sub_exp_date" value="<?php echo date("Y-m-d", strtotime('+2 years')); ?>">
          </div>
        </div>
        <br>

        <div class="FlexContainer_up">
          <div class="col-25">  
            <label>Comment:</label>
          </div>
          <div class="col-75">
            <textarea type="text" rows="10" cols="74" name="sub_comment" id="id_sub_comment"></textarea>
          </div>
        </div>

        <input type="hidden" id="sub_item_id" name="sub_item_id">
        <input type="hidden" id="sub_action" name="sub_action">

        <input id="id_sub_but" class="main_button" type="button" onclick="SubmitFormFunction()" value="Submit form">
      
      </form>
      <!--//-->
    </div>
  </div>
</div>

<script>
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

    document.getElementById("id_sub_value").placeholder   = "Please add a quantity.";
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