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
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
					<input type="submit" name="order_now" style="margin-top:5px;" value="Order now" />
					<?php						
					date_default_timezone_set("Europe/Paris");
					if(isset($_POST["order_now"])){
					// Order Number sequence
					$v_order_seq = GetSettingValue('next_order_number_sequence');
					$v_next_order_seq = $v_order_seq + 1;
					//
					//Add to history
					$s_stock_history = new Stock_History_Class();
					$s_order_history = new Order_History_Class();
					foreach($_SESSION["shopping_cart"] as $keys => $value)
						{
							//Stock history table
							//Get item by id
							$item = get_item_id($value['item_id']);
							//Populate fields
							$s_stock_history->user             = mysqli_real_escape_string($db, $_SESSION['username']);
    					$s_stock_history->record_type      = mysqli_real_escape_string($db, 'BUY');
    					$s_stock_history->change_value     = mysqli_real_escape_string($db, $value['item_quantity']);
    					$s_stock_history->item_id          = mysqli_real_escape_string($db, $value['item_id']);
    					$s_stock_history->item_name        = mysqli_real_escape_string($db, $value['item_name']);
    					$s_stock_history->item_category    = mysqli_real_escape_string($db, $item['item_category']);
    					$s_stock_history->item_new_stock   = mysqli_real_escape_string($db, ($item['item_stock']-$value['item_quantity']));
    					$s_stock_history->item_volume      = mysqli_real_escape_string($db, $item['item_volume']);
    					$s_stock_history->item_unit        = mysqli_real_escape_string($db, $item['item_unit']);
    					$s_stock_history->item_price       = mysqli_real_escape_string($db, $item['item_price']);
    					$s_stock_history->item_disc10      = mysqli_real_escape_string($db, $value['item_disc10']);
    					//$s_stock_history->item_status      = mysqli_real_escape_string($db, $item['item_name']);
    					$s_stock_history->vat              = mysqli_real_escape_string($db, $vat);
    					// Create history function
							
							//
							//
							//Order history table
    					$s_order_history->item_id         				  = mysqli_real_escape_string($db, $value['item_id']);
    					$s_order_history->item_name       				  = mysqli_real_escape_string($db, $value['item_name']);
    					$s_order_history->item_category   				  = mysqli_real_escape_string($db, $item['item_category']);
    					$s_order_history->item_volume     				  = mysqli_real_escape_string($db, $item['item_volume']);
    					$s_order_history->item_unit       				  = mysqli_real_escape_string($db, $item['item_unit']);
    					$s_order_history->item_price      				  = mysqli_real_escape_string($db, $item['item_price']);
    					$s_order_history->item_disc10     				  = mysqli_real_escape_string($db, $value['item_disc10']);
    					$s_order_history->item_quantity   					= mysqli_real_escape_string($db, $value['item_quantity']);
    					//$s_order_history->record_date     				  = mysqli_real_escape_string($db, date());
							$s_order_history->user_username             = mysqli_real_escape_string($db, $_SESSION['username']);
							$s_order_history->order_number_sequence     = mysqli_real_escape_string($db, $v_next_order_seq);
							//
							$s_order_history->CreateOrderHistory();
						}
						
	//Email
  $subject = "This is subject";
	$message = "
	<!doctype html>
	<html>
	<head>
		<meta charset='utf-8'>
		<title></title>
		<style>
		.invoice-box {
			max-width: 800px;
			margin: auto;
			padding: 30px;
			border: 1px solid #eee;
			box-shadow: 0 0 10px rgba(0, 0, 0, .15);
			font-size: 16px;
			line-height: 24px;
			font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			color: #555;
		}
		
		.invoice-box table {
			width: 100%;
			line-height: inherit;
			text-align: left;
		}
		
		.invoice-box table td {
			padding: 5px;
			vertical-align: top;
		}
		
		.invoice-box table tr td:nth-child(2) {
			text-align: right;
		}
		
		.invoice-box table tr.top table td {
			padding-bottom: 20px;
		}
		
		.invoice-box table tr.top table td.title {
			font-size: 45px;
			line-height: 45px;
			color: #333;
		}
		
		.invoice-box table tr.information table td {
			padding-bottom: 40px;
		}
		
		.invoice-box table tr.heading td {
			background: #eee;
			border-bottom: 1px solid #ddd;
			font-weight: bold;
		}
		
		.invoice-box table tr.details td {
			padding-bottom: 20px;
		}
		
		.invoice-box table tr.item td{
			border-bottom: 1px solid #eee;
		}
		
		.invoice-box table tr.item.last td {
			border-bottom: none;
		}
		
		.invoice-box table tr.total td:nth-child(2) {
			border-top: 2px solid #eee;
			font-weight: bold;
		}
		
		@media only screen and (max-width: 600px) {
			.invoice-box table tr.top table td {
				width: 100%;
				display: block;
				text-align: center;
			}
			
			.invoice-box table tr.information table td {
				width: 100%;
				display: block;
				text-align: center;
			}
		}
		
		/** RTL **/
		.rtl {
			direction: rtl;
			font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
		}
		
		.rtl table {
			text-align: right;
		}
		
		.rtl table tr td:nth-child(2) {
			text-align: left;
		}
		</style>
	</head>
	<body>
		<div class='invoice-box'>
			<table cellpadding='0' cellspacing='0'>
				<tr class='top'>
					<td colspan='2'>
						<table>
							<tr>
								<td class='title'>
									<img src='../Logo_1_01.png' style='width:100%; max-width:100px;'>
								</td>
								<td>"
									.date('l, jS \of F Y'). "<br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				
				<tr class='information'>
					<td colspan='2'>
					<b>Invoice #</b>
					<hr>
						<table>
							<tr>
								<td><b>Invoiced to</b><br>
										XYZ Corp.<br>
										John Doe<br>
										johndoe@gmail.com
								</td>
								<td>
								<b>Pay to</b><br>
									Maxima Paints Malta, Inc.<br>
									12345 Sunny Road<br>
									maximapa@maximapaintsmalta.com
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr class='heading'>
					<td>Item</td>
					<td>Qty</td>
					<td>Amount</td>
				</tr>";
				foreach($_SESSION["shopping_cart"] as $keys => $values) {
					$message .="<tr>
							<td>".str_replace(chr(194),'',$values['item_name'])."</td>
							<td style='text-align: center'>".$values['item_quantity']."</td>
							<td>".$values['item_price']."</td>
					</tr>";
			}
			$message .= "</tbody>
				<tr class='total'>
					<td></td>  
					<td>Sub Total: €". $total-($total*$vat) ."</td>
				</tr>	
				<tr class='total'>
					<td></td>  
					<td>VAT: €". $total*$vat ."</td>
				</tr>
				<tr class='total'>
					<td></td>  
					<td>Total: €". $total ."</td>
				</tr>
			</table>
		</div>
	</body>
	</html>";
						$from = "maximapa@maximapaintsmalta.com";
						$headers = "From: $from";
						$headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
						//Email 1
						//mail($to,$subject,$message,$headers);
						//Email 2
						$to= "aleksandar.naskovich@gmail.com";
						mail($to,$subject,$message,$headers);

					echo  '<p>Sent</p>';
					}
          ?>
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
