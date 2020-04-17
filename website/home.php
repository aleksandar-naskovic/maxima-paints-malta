<?php 
include("../0_core/config.php");
include("../0_core/session.php");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Home page</title>
  <link rel="stylesheet" type="text/css" href="../0_core/style.css">
  <link rel="stylesheet" type="text/css" href="../2_maxima/generic_item_display.css">
  <link rel="stylesheet" type="text/css" href="home.css">
</head>
<body>

  <?php include("navbar.php") ?>

  <div class="page">

    <br>
    <br>
    <!-- Slideshow -->
    <div class="slideshow-container">
    <!-- Slider 1 -->
      
        <!-- <div class="numbertext">1 / 3</div> -->
        <?php
          for ($i = 1; $i < 3; ++$i) {
            echo '<div class="mySlides fade">
                    <img src="../images/slider_images/slider'.$i.'.jpg" style="width:100%">
                  </div>';
          }
        ?>
        <!-- <div class="text">Caption Text</div>-->
      

    <br>
    <div style="text-align:center">
      <span class="dot" onclick="currentSlide(1)"></span> 
      <span class="dot" onclick="currentSlide(2)"></span> 
      <span class="dot" onclick="currentSlide(3)"></span> 
    </div>
    <!-- Slider code -->
    <script>

      var t = setInterval(runFunction,5000);
      var tick = 0;

      function runFunction(){
        tick = tick + 1;
        currentSlide((tick % 3) + 1)
      }

      var slideIndex = 1;
      showSlides(slideIndex);

      function plusSlides(n) {
        showSlides(slideIndex += n);
      }

      function currentSlide(n) {
        showSlides(slideIndex = n);
      }

      function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        if (n > slides.length) {slideIndex = 1}    
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";
      }
    </script>
    <!-- 
      END of Slideshow
    -->

    <!-- 
      Most popular items 
    -->
    <br>
    <br>
    <h3>Most popular items</h3>
    <?php 
      $most_popular_item_1 = most_popular_item_1();
      $most_popular_item_2 = most_popular_item_2();
      $most_popular_item_3 = most_popular_item_3();
    ?>

    <!-- 
      Most popular item number 1
    -->
    <div class="core_cat_item_display">
        <div class="image_box">
          <a href="<?= 'item.php?item_id='.$most_popular_item_1['item_id'] ?>">
              <?php echo  '<img class="image" src="../images/'.$most_popular_item_1['item_id'].'.png">'; ?>
          </a>
        </div>
        <figcaption>
    <!-- Item Name -->
        <p class="item_name"><b><?=$most_popular_item_1['item_name']; ?></b></p>
    <!-- Item Price --> 
          <p class="item_price"><?php echo $most_popular_item_1['item_price'];?>€</p>
    <!-- Item volume/size -->
            <style type="text/css" scoped>
            .item_volume:after {  content:'<?=$most_popular_item_1['item_unit']?>';
              font-size:15px; 
            } 
            </style>  
            <p class="item_volume"><?=$most_popular_item_1['item_volume']?></p>              
    <!-- Main Description -->
          <p class="main_description"><?= nl2br($most_popular_item_1['item_description']) ?></p>
        </figcaption>
    </div>
    <!-- 
      Most popular item number 2 
    -->
    <div class="core_cat_item_display">
        <div class="image_box">
          <a href="<?= 'item.php?item_id='.$most_popular_item_2['item_id'] ?>">
              <?php echo  '<img class="image" src="../images/'.$most_popular_item_2['item_id'].'.png"/>'; ?>
          </a>
        </div>
        <figcaption>
  <!-- Item Name -->
        <p class="item_name"><b><?=$most_popular_item_2['item_name']; ?></b></p>
  <!-- Item Price --> 
          <p class="item_price"><?php echo $most_popular_item_2['item_price'];?>€</p>
  <!-- Item volume/size -->
            <style type="text/css" scoped>
            .item_volume:after {  content:'<?=$most_popular_item_2['item_unit']?>';
              font-size:15px; 
            } 
            </style>  
            <p class="item_volume"><?=$most_popular_item_2['item_volume']?></p>              
  <!-- Main Description -->
          <p class="main_description"><?= nl2br($most_popular_item_2['item_description']) ?></p>
        </figcaption>
    </div>
    <!-- 
      Most popular item number 3 
    -->
    <div class="core_cat_item_display">
      <div class="image_box">
        <a href="<?= 'item.php?item_id='.$most_popular_item_3['item_id'] ?>">
          <?php echo  '<img class="image" src="../images/'.$most_popular_item_3['item_id'].'.png"/>'; ?>
        </a>
      </div>
      <figcaption>
      <!-- Item Name -->
        <p class="item_name"><b><?=$most_popular_item_3['item_name']; ?></b></p>
        <!-- Item Price --> 	
        <p class="item_price"><?php echo $most_popular_item_3['item_price'];?>€</p>
        <!-- Item volume/size -->
        <style type="text/css" scoped>
          .item_volume:after {  
            content:'<?=$most_popular_item_3['item_unit']?>';
            font-size:15px; 
          }
        </style>  
        <p class="item_volume"><?=$most_popular_item_3['item_volume']?></p>              
        <!-- Main Description -->
        <p class="main_description"><?= nl2br($most_popular_item_3['item_description']) ?></p>
      </figcaption>
    </div>

    <!--
       Categories Cards
    --->
    <br>
    <h3>Browse by Categorie</h3>
    
    <div class="cards">
      <?php foreach(get_category_names() as $v_categorys) : ?>

        <div class="card" onclick="window.location.href='<?= 'category.php?category_name='.$v_categorys['item_category'] ?>'">
          <?php echo '<img src="../images/'.$v_categorys['item_category'].'.png">'; ?>
          <h4><?php echo $v_categorys["item_category"]; ?></h4>
        </div>       
        
      <?php endforeach ?>
    </div>

    <!--
      Map
    -->
    <br><br>
    <h3>Find us</h3>
    <br>
    <div id="googleMap" style="width:100%;height:400px;"></div>

    <script>
      function myMap() {
      var mapProp= {
        center:new google.maps.LatLng(51.508742,-0.120850),
        zoom:5,
      };
      var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
      }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>


      

    <div class="content">
      <!-- notification message -->
      <?php if (isset($_SESSION['success'])) : ?>
        
          <h3>
            <?php 
              echo $_SESSION['success']; 
              unset($_SESSION['success']);
            ?>			
    </div>
      <?php endif ?>

      <!-- if user is not logged in -->			
    <div>
    <?php
    if (!isset($_SESSION['username'])) {
      $_SESSION['msg'] = "You must log in first";
      echo $_SESSION['msg'];
    }
    ?>	
    </div>

    
  </div>

</body>
</html>