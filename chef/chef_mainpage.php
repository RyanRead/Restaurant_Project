<html>
<body style="color:white; background-color:powderblue">


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
$menu_item_results = $conn->query($query);
$rows = $orders_results->num_rows;

echo <<<_END
<form action = "view_items_inorder.php" method ="post">
_END;
$j;
for ($j = 0; $j < $rows; ++$j)
{
	$orders_results->data_seek($j);
	$order_row = $orders_results->fetch_array(MYSQLI_NUM);
	// Maybe Print Category Title
	$order_id = $order_row[0]; //Menu item ID
echo <<<_END
	<button type = "submit" name = "order_id" value = "$order_id"> Order $order_id</button>
_END;
}
echo <<<_END
</form>
_END;
$conn->close();

?>



</body>
</html>