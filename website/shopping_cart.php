<?php 

session_start();
require_once("../0_core/config.php");
//
$vat = GetSettingValue('VAT');
//
$v_total     = 0;
$v_total_qty = 0;

//
if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		// Remove the item from the array
		unset($_SESSION["shopping_cart"][$_GET['id']]);
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Shopping Cart</title>
		<link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="shopping_cart.css"> 
	</head>
	<body>
	<?php include ("navbar.php");?>
	<div class="page">
			<h3>Order Details</h3>
			<div>
				<table>
					<tr>
						<th width="10%">Item Photo</th>
						<th width="30%">Item Name</th>
						<th width="5%"></th>
						<th width="5%" class="qty">Qty</th>
						<th width="5%"></th>
						<th width="20%">Price</th>
						<th width="15%">Total</th>
						<th width="5%">Action</th>
					</tr>
					<?php
					$_SESSION["total"] = $v_total;
					
					if(!empty($_SESSION["shopping_cart"]))
					{
						
						foreach($_SESSION["shopping_cart"] as $keys => $values)

						{
							$v_item_id     = $values['item_id'];
							$v_item_price  = $values['item_price'];
							$v_item_disc10 = $values['item_disc10'];
							$v_item_qty    = $values['item_quantity'];
							$v_item_stock  = $values['item_stock'];
							//
							$v_price_style  = 'color: black; font-weight: normal;';
							//
							// Price is set to normal price
							$v_price = $v_item_price;
							if ($v_item_qty > 9){
								if(!empty($v_item_disc10)){
									// Price is set to DISCOUNT price
									$v_price = $v_item_disc10;
									$v_price_style  = 'color: red; font-weight: bold;';
								}
							}
							

							
					?>
					<tr>
						<td><a href="<?= 'item.php?item_id='.$values['item_id'] ?>">
							<?php echo  '<img class="image" src="../images/'.$values['item_id'].'.png" height = "100" width = "100">'; ?></a>
						</td>
						
						
						<td><a style="text-decoration: none;" href="<?= 'item.php?item_id='.$values['item_id'] ?>"><?php echo $values["item_name"]; ?></a></td>
						<td class="more"><button id="b_more_<?php echo $v_item_id; ?> " onclick="ChangeQty('more', '<?php echo $v_item_id;?>', '<?php echo $v_item_price;?>', '<?php echo $v_item_disc10;?>', '<?php echo $vat;?>', '<?php echo $v_item_stock;?>')">+</button></td>
						<td id="qty_<?php echo $v_item_id; ?>" class="qty"><?php echo $v_item_qty; ?></td>
						<td class="less"><button id="b_less_<?php echo $v_item_id; ?>" onclick="ChangeQty('less', '<?php echo $v_item_id;?>', '<?php echo $v_item_price;?>', '<?php echo $v_item_disc10;?>', '<?php echo $vat;?>', '<?php echo $v_item_stock;?>')">-</button></td>
						<!-- 
							Price displayed is the row 
						-->
						<td id="i_price_<?php echo $v_item_id; ?>" style="<?php echo  $v_price_style?>">€<?php echo $v_price; ?></td>
						<!-- 
							Total displayed is the row 
						-->
						<td id="i_total_<?php echo $v_item_id; ?>" class = "i_total">€<?php echo number_format($v_item_qty * $v_price, 2);?></td>
						<!-- 
							Remove link in the row 
						-->
						<td><a class="remove" href="shopping_cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span>Remove</span></a></td>
					</tr>
					<?php
              $v_total = $v_total + ($v_item_qty * $v_price);
              $v_total_qty = $v_total_qty + $v_item_qty;
							
						}				
					}					
					?>						
				</table>
				<br>
          <!-- 
            Grand Total
          -->
					<h1 id="grand_total">
						Total: €<?php echo number_format($v_total, 2);?>
					</h1>
					<h2 id="vat_total" style="font-size: small; margin-top: -20px;">
						VAT: €<?php echo number_format(round($v_total*$vat, 2),2);?>
					</h2>
					<br>
				
				<!-- 
					Send Email
				-->
        <?php	
        if($v_total_qty > 0){
        ?>
				<form method="post" action="payment_details.php" enctype="multipart/form-data">
					<input type="submit" name="order_now" style="margin-top:5px;" value="Continue to purchase" />
        </form>
        <?php	
				}
        ?>
			</div>
	</div>
	<br />
    <script>
			// Prevent a resubmit on refresh and back button
			if ( window.history.replaceState ) {
					window.history.replaceState( null, null, window.location.href );
		  }
		  	//Change quantity in the Shoping Cart
			function ChangeQty(p_type, p_item_id, p_price, p_disc, p_vat, p_stock){
				//
				var current_qty = document.getElementById("qty_"+p_item_id).innerHTML;
				var new_qty;
				var price = p_price;
				//
				// Minus Button
				if(p_type == "less"){
					new_qty = parseInt(current_qty, 10) - 1;
					if(new_qty < 0){new_qty = 0;};
				}
				// Plus Button
				else if(p_type == "more"){
					new_qty = parseInt(current_qty, 10) + 1;
					if(parseInt(new_qty) > parseInt(p_stock)){new_qty = p_stock;}
				}
				// Display and save new quantity in HTML
				document.getElementById('qty_'+p_item_id).innerHTML = new_qty;

				//var testObject = { 'one': 53, 'two': 2, 'three': 3 };
				//var v_session = {};
				//v_session[1] = testObject;
				//v_session = sessionStorage.getItem("shopping_cart");
				//sessionStorage.setItem("ABC", JSON.stringify(v_session));

				//var vABC = {};
				//vABC = sessionStorage.getItem("ABC");

				//document.getElementById("i_price_"+p_item_id).innerHTML = JSON.parse(vABC)[1].one;

				//sessionStorage.setItem('shopping_cart'+'1'+'item_quantity', current_qty);
				//
				// Change price to Discount if quantity is more then 9
				if (new_qty > 9 ){
					if(p_disc != ''){
						price = p_disc;
						document.getElementById("i_price_"+p_item_id).style.color = "red";
						document.getElementById("i_price_"+p_item_id).style.fontWeight = 'bold';
					}
				}else{
						document.getElementById("i_price_"+p_item_id).style.color = "black";
						document.getElementById("i_price_"+p_item_id).style.fontWeight = "normal";
					}
				//
				document.getElementById("i_price_"+p_item_id).innerHTML = '€' + price;
				//
				// Display recalculated item total
				document.getElementById("i_total_" + p_item_id).innerHTML = "€" + (new_qty * price).toFixed(2);
				//
				// Display recalculated grand total
					var v_grand_total = 0;
					var v_rTotals = document.getElementsByClassName("i_total");
						for(var i = 0; i < v_rTotals.length; i++)
						{
							v_grand_total = (parseFloat(v_grand_total, 10) + parseFloat(v_rTotals[i].innerHTML.replace("€", ''), 10)).toFixed(2);	
						}
				
				document.getElementById("grand_total").innerHTML =  "Total: €" +  v_grand_total;
				document.getElementById("vat_total").innerHTML =  "VAT: €" +  parseFloat(v_grand_total * p_vat).toFixed(2);
			}

		</script>
	
	</body>
</html>
