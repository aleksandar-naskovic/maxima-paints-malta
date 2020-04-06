<?php include("../0_core/session.php");
//Check if user is admin
?>
<html>
  <head>
    <title>Admin page</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css">
    <link rel="stylesheet" type="text/css" href="admin_index.css">      
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <h2>Admin page</h2>
        <div clas="options">
            <div class="items">
            <p class="underline">Item settings</p>
                <a href="add_item.php"><button class="generic_button">Add item</button></a>
                <a href="all_categories.php"><button class="generic_button">Edit item</button></a><br><br>
            </div>
            <div class="users">
            <p class="underline">User settings</p>
            <a href="#"><button class="generic_button">Add user</button></a>
            <a href="#"><button class="generic_button">Edit user</button></a>
            </div>
            <div class="settings">
            <p class="underline">Admin settings</p>
            <a href="settings.php"><button class="generic_button">Settings</button></a>
            <a href="stock_history.php"><button class="generic_button">Stock history</button></a>
            </div>
        </div>
    </div>
  </body>
</html>