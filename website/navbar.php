<?php 
  require_once("../0_core/config.php");
  require_once("../1_log_in/dbio_users.php");
  //
  $s_User = new User_Class();
  //
?>

<head>
  <link rel="stylesheet" type="text/css" href="navbar.css">   
</head>

<body>


  <div class="logo">
    <img class='logo_img' src="../Logo_1_01.png"  alt="logo"> 
    <a class="logo_title" href="../website/home.php">Maxima Paints Malta</a>
      <!-- IF USER IS ADMIN -->
      <?php 
        if (isset($_SESSION['username'])) :
          //
          $s_User->LoadUser("username", $_SESSION['username']);
          //
          if ($s_User->user_category == 'admin') : 
      ?>
            <a class='logo_links' href="../website/admin_index.php">Admin page</a>
            <a class='logo_links' href="../website/all_items.php">All items</a>
            <a class='logo_links' href="../website/settings.php">Settings</a>
      <?php
          endif;
        endif; 
      ?>
      <!-- LOG IN-->
      <?php if (!isset($_SESSION['username'])): ?>
        <a class='logo_links'  href="../1_log_in/login.php">Log in</a>
      <?php endif ?>

      <!-- LOG OUT -->
      <?php 
        if (isset($_SESSION['username'])) :
      ?>
          <a class='logo_links' href="my_account.php">My account</a>
          <a class='logo_links' href="home.php?logout='1'">Logout</a>
      <?php 
        endif;
      ?>
  </div>



  <nav class="menu">
          <div class="menu">
            <ul class="menu__list">
              <li class="menu__group"><a class="menu__link" href="../website/home.php">Home</a></li>
              <li class="menu__group"><a class="menu__link" href="all_categories.php">Buy by Category <span>&#x25BE;</span></a>
              <ul>
                <?php           
                foreach(get_category_names() as $category) : ?>           
                  <li class="menu__group" name=<?= $category['item_category'] ?>>
                    <a class="menu__link" href="<?= 'category.php?category_name='.$category['item_category'] ?>"><?= $category['item_category'] ?></a>                          
                  </li>
                  <?php 
                endforeach ?>             
            </ul>        
          </li>
          <li class="menu__group"><a class="menu__link" href="about_us.php">About us</a></li>
          <li class="menu__group"><a class="menu__link" href="contact.php">Contact</a></li>
          <?php

          $cart_total = 0;
          if(!empty($_SESSION["shopping_cart"]))
					{						
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
							$v_item_price  = number_format($values['item_price'],2);
							$v_item_disc10 = number_format($values['item_disc10'],2);
              $v_item_qty    = number_format($values['item_quantity']);
              
              if ($v_item_qty > 9){
                $cart_total = number_format($cart_total,2) + number_format($v_item_disc10 * $v_item_qty,2);
              }
              else{
                $cart_total = number_format($cart_total,2) + number_format($v_item_price * $v_item_qty,2);
              }

            }
          }

          ?>
        <li style="float:right" class="menu__group"><a class="menu__link" href="../website/shopping_cart.php">Shopping Cart ( €<?php echo $cart_total;?> )</a></li>
      </ul>
  </nav>
</body>
  
  
  
  