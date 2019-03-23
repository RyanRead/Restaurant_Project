<html>

<head>
    <!--meta charset="utf-8"-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stock Page</title>
    <link rel="stylesheet" type="text/css" href="../style/quickServeStyle.css" />

</head>



<body class="bgChef">
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
if (isset($_POST["item_id"]))
{
	$item_id = $_POST["item_id"];
	$query = "UPDATE ordered_items SET item_complete = true WHERE order_id =" . $order_id . " AND item_id = " . $item_id;
	$insert_order_complete = $conn->query($query);
	if (!$insert_order_complete) 
	{
		echo "UPDATE failed: $query<br>" . $conn->error . "<br><br>";
	}
	removeIngredientsFromStock($conn, $item_id);
	$query = "SELECT item_complete FROM ordered_items WHERE item_complete = false AND order_id = " . $order_id;
	$item_compelte_results = $conn->query($query);
	$count = $item_compelte_results->num_rows;
	if ($count == 0) // Check to see if the order is complete 
	{
		$query = "UPDATE orders SET order_complete = true WHERE order_id =" . $order_id;
		$insert_order_complete = $conn->query($query);
		if (!$insert_order_complete) 
		{
			echo "UPDATE failed: $query<br>" . $conn->error . "<br><br>";
		}
        
        //Once order is complete redirect automatically back to Chefs Main Page.
        header("Location: chef_mainpage.php");
        $db->close();
        exit();
	}
	else
	{
		echo "<h1 class='orderTitle'>Order Number: " . $order_id . "<br></h1>"; 
		displayOrderedItems($conn, $order_id);
	}
}
else
{
	echo "<h1 class='orderTitle'>Order Number: " . $order_id . "<br></h1>"; 
	displayOrderedItems($conn, $order_id);
}

//***************************************************************************************
// removeIngredientsFromStock
// This function updates the database to remove ingredients from stock when they are completed
// Parameters: $conn: This parameter is used to maintain the mySQL connection
//			   $item_id: This parameter is used to pass which item should have their ingredients updated 
// Returns: Nothing
//***************************************************************************************
function removeIngredientsFromStock($conn, $item_id)
{
	$query = "SELECT ingredient_id, amount FROM recipes WHERE item_id = " . $item_id;
	$recipe_results = $conn->query($query);
	$rows = $recipe_results->num_rows;
	for ($j = 0; $j < $rows; ++$j)
	{
		$recipe_results->data_seek($j);
		$recipe_row = $recipe_results->fetch_array(MYSQLI_NUM);
		$ingredient_id = $recipe_row[0];
		$amount = $recipe_row[1];
		$query = "SELECT ingredient_stock FROM ingredients WHERE ingredient_id =". $ingredient_id; 
		$ingredient_results = $conn->query($query);
		$ingredient_results->data_seek(1);
		$ingredient_row = $ingredient_results->fetch_array(MYSQLI_NUM);
		$ingredient_stock = $ingredient_row[0];
		$new_ingredient_stock = $ingredient_stock - $amount;
		if ($new_ingredient_stock < 0)
		{
			$new_ingredient_stock = 0;	
		}
		$query = "UPDATE ingredients SET ingredient_stock = ". $new_ingredient_stock . " WHERE ingredient_id = " . $ingredient_id;
		$update_ingredients_complete = $conn->query($query);
		if (!$update_ingredients_complete) 
		{
			echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
		}
	}
}

//***************************************************************************************
// displayOrderedItems
// This Function displays in a table the names of all items in an order along with information about if they are complete or not
// Parameters: $conn: This parameter is used to maintain the mySQL connection
//			   $order_id: This parameter is used to pass which orders items should be viewed  
// Returns: Nothing
//***************************************************************************************
function displayOrderedItems($conn, $order_id) {
$query = "SELECT item_id, item_name, item_complete FROM menu_items NATURAL JOIN ordered_items WHERE order_id = " . $_POST["order_id"];
$ordered_item_results = $conn->query($query);
$rows = $ordered_item_results->num_rows;

echo <<<_END
<form action = "" method ="post">
<table class="orderTable">
<tr>
	<th> Item Name </th> 
	<th> Item Status</th>
</tr>
_END;

for ($j = 0; $j < $rows; ++$j)
{
	$ordered_item_results->data_seek($j);
	$ordered_item_row = $ordered_item_results -> fetch_array(MYSQLI_NUM);
	$item_id = $ordered_item_row[0];
	$item_name = $ordered_item_row[1];
	$complete = $ordered_item_row[2];
echo <<<_END
	<tr>
	<td> $item_name </td> 
_END;
	if ($complete == true) 
	{	
echo <<<_END
		<td id="doneItem" >Item Complete</td>	
_END;
	}
	else
	{
echo  <<<_END
	<td id="notDone"> <button class="doneButton" type = "submit" name = "item_id" value = "$item_id">Click to finish item</button></td>
	</tr>
_END;
	}
}
echo <<<_END
</table>
<input type ="hidden" name="order_id" value="$order_id">
</form>
_END;
}
?>

    <form action="chef_mainpage.php">
        <button class="returnButton" type="submit">Back</button>
    </form>
</body>

</html>
