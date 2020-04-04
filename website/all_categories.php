<?php
  require_once("../0_core/config.php");
  include("../0_core/session.php");
?>

<html>
  <head>
    <title>All categories</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="all_categories.css">
    <link rel="stylesheet" type="text/css" href="../2_maxima/generic_item_display.css">
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
        <h2>Categories</h2>	<br>
      <div class="cards">
        <?php foreach(get_category_names() as $v_categorys) : ?>
          <div class="card" onclick="window.location.href='<?= 'category.php?category_name='.$v_categorys['item_category'] ?>'">
            <?php echo '<img src="../images/'.$v_categorys['item_category'].'.png">'; ?>
            <h4>
              <?php echo $v_categorys["item_category"]; ?>
            </h4>
          </div>
        <?php 
              endforeach ?>
      </div>
    </div>
  </body>
</html>