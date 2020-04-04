<?php     
  require_once("../0_core/config.php");  
?>

<html>
  <head>
    <title>Category page</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css"> 
    <link rel="stylesheet" type="text/css" href="../2_maxima/generic_item_display.css">
    <link rel="stylesheet" type="text/css" href="category.css">    
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page"><br>
      <h2 class="headertext" id="headertext"><?php echo $_GET['category_name'];?></h2>
      <?php foreach(get_items($_GET['category_name']) as $item) : 
        $v_price = number_format(round($item['item_price'],2),2);  
      ?> 
        <!-- Check if item is hidden -->
          
          <div class="core_cat_item_display">
          <?php if($item['item_status']=="Hidden"){ ?> 
          <div class="core_cat_item_display" style = "border-color: white;"><p>HIDDEN</p> </div>
           <?php } ?> 
         
            <div class="image_box">
              <a href="<?= 'item.php?item_id='.$item['item_id'] ?>">
                  <?php echo  '<img class="image" src="../images/'.$item['item_id'].'.png"/>'; ?>
              </a>
            </div>

            <figcaption class="figcaption">

 <!-- Item Name -->
              <p class="item_name"><b><?=$item['item_name']?></b></p>

<!-- Item Price -->
                <style type="text/css" scoped>
                  .cls_<?php echo $item['item_id'];?>:after {  content:'<?=substr($v_price,strpos($v_price,'.'))?>';
                    font-size:20px; 
                  } 
                </style>  
                <p class="item_price cls_<?php echo $item['item_id'];?>">€ <?= substr($v_price,0,strpos($v_price,'.')) ?></p>

<!-- Item volume/size -->
                  <style type="text/css" scoped>
                  .item_volume:after {  content:'<?=$item['item_unit']?>';
                    font-size:15px; 
                  } 
                  </style>  
                  <p class="item_volume"><?=$item['item_volume']?></p>
               
 <!-- Main Description -->
              <p class="main_description"><?= $item['item_description'] ?></p>
            </figcaption>
          </div>
        <?php 
            endforeach;
        ?>
    </div>

  </body>
</html>