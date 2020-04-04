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
            <h3>Item settings</h3>
                <a href="add_item.php"><button>Add item</button></a>
                <a href="all_categories.php"><button>Edit item</button></a><br><br>
            </div>
            <div class="users">
            <h3>User settings</h3>
            <a href="#"><button>Add user</button></a>
            <a href="#"><button>Edit user</button></a>
            </div>
            <div class="settings">
            <h3>Admin settings</h3>
            <a href="settings.php"><button>Settings</button></a>
            <a href="stock_history.php"><button>Stock history</button></a>
            </div>
        </div>
    </div>
  </body>
</html>