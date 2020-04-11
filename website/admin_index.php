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
            <p class="underline"><b>ITEMS</b></p>
              <button class="button" onclick="window.location.href = 'new_item.php';">New Item</button>
              <button class="button" onclick="window.location.href = 'all_items.php';">Edit Items</button>
              <button class="button" onclick="window.location.href = 'stock_history.php';">Stock History</button>
              <button class="button" onclick="window.location.href = 'order_history.php';">Order history</button>
            </div>
            <div class="financials">
              <p class="underline"><b>FINANCIALS</b></p>
              <button class="button" onclick="window.location.href = 'financial_settings.php';">Financial Settings</button>
            </div>
            <div class="users">
              <p class="underline"><b>USERS</b></p>
              <button class="button" onclick="window.location.href = 'new_user.php';">New User</button>
              <button class="button" onclick="window.location.href = 'all_users.php';">Edit User</button>
            </div>
            <div class="settings">
              <p class="underline"><b>WEBSITE SETTINGS</b></p>
              <button class="button" onclick="window.location.href = 'settings.php';">Generic Settings</button>
              <button class="button" onclick="window.location.href = 'company_settings.php';">Company Settings</button>
            </div>
        </div>
    </div>
  </body>
</html>