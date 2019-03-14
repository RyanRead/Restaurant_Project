<html> 
<body style="color:white; background-color:powderblue">
<form action ="select_section.php">
<button type = "submit">Make An Order</button>
</form>

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

if (isset($_POST["order_id"])) //Delete ordered items once they have been served 
{
	$order_id = $_POST["order_id"];
	$query = "DELETE FROM orders WHERE order_id = " . $order_id;
	$delete_order_complete = $conn->query($query);
	if (!$delete_order_complete) 
	{
		echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
	}
	$query = "DELETE FROM ordered_items WHERE order_id = " . $order_id;
	$delete_order_items_complete = $conn->query($query);
	if (!$delete_order_items_complete) 
	{
		echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
	}
}
$query = "SELECT order_id FROM orders WHERE order_complete = true";
$complete_orders = $conn->query($query);
$rows = $complete_orders->num_rows;
if ($complete_orders->num_rows != 0) //If there is no complete orders then nothing should be printed
{ 
echo <<<_END
<strong> Orders Ready To Serve: </strong>
<br>
<form action = "" method = "post" >
_END;
	for ($j = 0; $j < $rows; ++$j)
	{
		$complete_orders->data_seek($j);
		$complete_order_row = $complete_orders->fetch_array(MYSQLI_NUM);
		$order_id = $complete_order_row[0];
echo <<<_END
		<div style="border:1px; border-style:solid; padding:5px; width:50%;">
		<h2> Order Number $order_id </h2> <br> 
_END;
		displayItemsInOrder($conn, $order_id);
echo <<<_END
		<br>
		<button type = "submit" name = "order_id" value = "$order_id">I have served this order</button>
		</div>
_END;
	}
echo <<<_END
 </form>
_END;
}

function displayItemsInOrder($conn, $order_id) 
{	
	$query = "SELECT item_name FROM menu_items NATURAL JOIN ordered_items WHERE order_id = " . $order_id; 
	$items_in_order = $conn->query($query);
	$rows = $items_in_order->num_rows;
	echo "<ul>";
	for ($j = 0; $j < $rows; ++$j)
	{
		$items_in_order->data_seek($j);
		$items_in_order_row = $items_in_order->fetch_array(MYSQLI_NUM);
		$item_name = $items_in_order_row[0];
	    echo "<li>" . $item_name . "</li>";

	}
	echo "</ul>";
}
?>

</body>

</html>
