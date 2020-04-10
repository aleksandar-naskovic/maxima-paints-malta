<?php include("../0_core/session.php");
//Check if user is admin
?>
<html>
  <head>
    <title>Admin page</title>
    <link rel="stylesheet" type="text/css" href="../0_core/style.css">
    <link rel="stylesheet" type="text/css" href="../0_core/generic_input.css">
    <link rel="stylesheet" type="text/css" href="admin_index.css">      
  </head>
  <body>
    <?php include("navbar.php")?>
    <div class="page">
      <h2>Admin page</h2>
        <div clas="options">
            <div class="items">
            <p class="underline">Item settings</p>
              <button class="button" onclick="window.location.href = 'new_item.php';">New Item</button>
              <button class="button" onclick="window.location.href = 'all_items.php';">Edit Item</button>
            </div>
            <div class="users">
              <p class="underline">User settings</p>
              <button class="button" onclick="window.location.href = 'new_user.php';">New User</button>
              <button class="button" onclick="window.location.href = 'all_users.php';">Edit User</button>
            </div>
            <div class="settings">
            <p class="underline">Admin settings</p>
            <a href="settings.php"><button class="button">Settings</button></a>
            <a href="stock_history.php"><button class="button">Stock history</button></a>
            <a href="order_history.php"><button class="button">Order history</button></a>
            </div>
        </div>
    </div>
  </body>
</html>