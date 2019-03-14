<html>
<body style="color:white; background-color:powderblue">

<form action ="view_stock.php"> <!-- Goes to view stock page  add view_stock.php -->
<button type = "submit"> View Stock</button>
</form>

<form action ="add_items.php"> <!-- Goes to view add items  add add_items.php -->
<button type = "submit"> Add Items</button>
</form>

<h1>Orders That Need Completing</h1>
<br>
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

echo <<<_END
<form action = "view_items_inorder.php" method ="post">
_END;
$j;
for ($j = 0; $j < $rows; ++$j)
{
	$orders_results->data_seek($j);
	$order_row = $orders_results->fetch_array(MYSQLI_NUM);
	$order_id = $order_row[0]; //Menu item ID
echo <<<_END
	<button type = "submit" name = "order_id" value = "$order_id"> Order $order_id</button>
	<br>
_END;
}
echo <<<_END
</form>
_END;
$conn->close();

?>



</body>
</html>
