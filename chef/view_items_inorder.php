<html>
<body style="color:white; background-color:powderblue">

<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>


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

$order_id = $_POST["order_id"];
if (isset($_POST["item_item"]))
{
	$query = "UPDATE ordered_items SET order_complete = true WHERE order_id =" . $order_id;
	$insert_order_complete = $conn->query($query);
	if (!$insert_order_complete) 
	{
		echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
	}
	$query = "SELECT item_complete FROM ordered_items WHERE item_compelte = false AND order_id = " . $order_id;
	$item_compelte_results = $conn->query($query);
	$count = $item_compelte_results->num_rows;
	if (count == 0)
	{
		echo "<strong> This order is complete </strong>";
		// add part about making the orders say ready to be server
		$query = "UPDATE orders SET order_complete = true WHERE order_id =" . $order_id;
		$insert_order_complete = $conn->query($query);
		if (!$insert_order_complete) 
		{
			echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
		}
	}
	else
	{
		displayOrderedItems($conn);
	}
}
else
{
	displayOrderedItems($conn);
}


// This function displays all the ordered items if there are still items to be displayed
function displayOrderedItems($conn) {
$query = "SELECT item_id, item_name, item_complete FROM menu_items NATURAL JOIN ordered_items WHERE order_id = " . $_POST["order_id"];
//echo $query;
$ordered_item_results = $conn->query($query);
$rows = $ordered_item_results->num_rows;

echo <<<_END
<form action = "" method ="post">
<table style="width:100%">
<tr>
	<th> Item Name </th> 
	<th> Item Complete</th>
</tr>
_END;

for ($j = 0; $j < $rows; ++$j)
{
	$ordered_item_results->data_seek($j);
	$ordered_item_row = $ordered_item_results -> fetch_array(MYSQLI_NUM);
	
	$item_name = $ordered_item_row[1];
	$complete = $ordered_item_row[2];
echo <<<_END
	<tr>
	<td> $item_name </td> 
_END;
	if ($complete == true) 
	{	
echo <<<_END
		<td style="color:Green">Item Complete</td>	
_END;
	}
	else
	{
echo  <<<_END
	<td td style="color:Red"> <button type = "submit" name = "item_id" value = "item_id">I am done this item</button></td>
	</tr>
_END;
	}
}
echo <<<_END
</table>
<input type ="hidden" name="order_id" value="order_id">
</form>
_END;
}
?>
</body>
</html>
