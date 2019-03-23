<?php
    session_start();
    $chefName = $_SESSION["chefName"];
    $_SESSION["table_count"] = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <!--meta charset="utf-8"-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chef <?=$chefName?>'s Page</title>
    <link rel="stylesheet" type="text/css" href="../style/quickServeStyle.css" />

    <script type="text/javascript" src="../javascript/validator.js"> </script>
</head>

<body>
    <div class="navBar">
        <form action="stock.php" name="view_stock" value="1">
            <!-- Goes to view stock page  add view_stock.php -->
            <button class="viewStockButton" type="submit"> View Stock</button>
        </form>

        <form action="add_items.php">
            <!-- Goes to view add items  add add_items.php -->
            <button class="addItemButton" type="submit"> Add Items</button>
        </form>

        <form action="../Logout.php">
            <input class="logoutButton" type="submit" value="Logout" />
        </form>
    </div>
    <div class="bgChef">

        <div class="chefTitle"><?=$chefName?>'s Management Page</div>

        <?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "restaurant_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
} 



$query = "SELECT order_id FROM orders WHERE order_complete = false";
$orders_results = $conn->query($query);
$rows = $orders_results->num_rows;
if ($rows != 0)
{
echo <<<_END
	<div class="onGoing">Orders to complete</div>
	<br>	
_END;
}
echo <<<_END
<div class="ordersContainer">
<form action = "view_items_inorder.php" method ="post">
_END;
for ($j = 0; $j < $rows; ++$j)
{
	$orders_results->data_seek($j);
	$order_row = $orders_results->fetch_array(MYSQLI_NUM);
	$order_id = $order_row[0]; //Menu item ID
echo <<<_END

	<button class="checkOrderButton" type = "submit" name = "order_id" value = "$order_id"> Order $order_id</button>
	<br>
    <br>
   
_END;
}
echo <<<_END
</form>
 </div>
_END;
$conn->close();

?>

    </div>
    <div class="bgChefParallax"></div>

</body>

</html>