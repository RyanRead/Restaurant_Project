<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <!--meta charset="utf-8"-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stock Page</title>
    <link rel="stylesheet" type="text/css" href="../style/quickServeStyle.css" />

    <script type="text/javascript" src="../javascript/validator.js"> </script>
</head>

<body class="bgStock">




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

	
if (isset($_POST["update_stock"]) & isset($_POST["amount"]))
{
	updateStock($conn);
}
$view_stock = 1;
if (isset($_POST["view_stock"]))
{
	$view_stock = $_POST["view_stock"];
}
$query = "SELECT * FROM ingredients";
$ingredient_results = $conn->query($query);
$rows = $ingredient_results->num_rows;
echo <<<_END
<div class="moreStockContainer">
<form action = "" method = "post" id="addStockForm">
<p class="addStock">Add to stock</p>
<select class="selectStock" name="ingredient_id">
_END;
for ($j = 0; $j < $rows; ++$j)
{
	$ingredient_results->data_seek($j);
	$ingredient_row = $ingredient_results->fetch_array(MYSQLI_NUM);
	$ingredient_id = $ingredient_row[0];
	$ingredient_name = $ingredient_row[1];
	$ingredient_unit_type = $ingredient_row[4];
echo <<<_END
	<option value = "$ingredient_id">$ingredient_name ($ingredient_unit_type)</option>
_END;
}
echo <<<_END
</select>
<input class="stockFields" type="text" name="amount" placeholder="amount" id="add_stock">
<button class="updateStockButton" type = "submit" name = "update_stock" value = "1">Update Stock</button></td>
<input type = "hidden" name = "view_stock" value = "$view_stock">
<script type="text/javascript" src="../javascript/validation_addMoreStock.js"> </script>
</form>
</div>
_END;

if ($view_stock == 1)
{
echo <<<_END
	<p class="inventoryTitle">Viewing all Ingredients</p>
    <form action ="" method ="post">
	<button class="viewDifStockButton" type = "submit" name = "view_stock" value = "2" >View Ingredients With Low Stock</button>
	</form>
	
_END;
	$query = "SELECT * FROM ingredients";
	$ingredient_results = $conn->query($query);
	$rows = $ingredient_results->num_rows;	
echo <<<_END
	<table class="stockTable">
_END;
	for ($j = 0; $j < $rows; ++$j)
	{
		$ingredient_results->data_seek($j);
		$ingredient_row = $ingredient_results->fetch_array(MYSQLI_NUM);
		$ingredient_name = $ingredient_row[1];
		$ingredient_stock = $ingredient_row[2];
		$ingredient_minimum_stock = $ingredient_row[3];
		$ingredient_unit_type = $ingredient_row[4];
		if ($ingredient_stock < $ingredient_minimum_stock)
		{
echo <<<_END
			<tr id="lowStock">
				<td id="lowStock"> $ingredient_name </td>
				<td id="lowStock"> $ingredient_stock $ingredient_unit_type </td>
			</tr>
_END;
		}
		else
		{
echo <<<_END
			<tr>
				<td> $ingredient_name </td>
				<td> $ingredient_stock $ingredient_unit_type </td>
			</tr>
_END;
		}
	}
echo <<<_END
	</table>
_END;
}
elseif ($view_stock == 2)
{
echo <<<_END
	<p class="inventoryTitle">Viewing Low Ingredients</p>
	<form action ="" method ="post">
	<button class="viewDifStockButton" type = "submit" name = "view_stock" value = "1" >View All Ingredients Stock</button>
	</form>
	<br>
_END;
	
	$query = "SELECT * FROM ingredients";
	$ingredient_results = $conn->query($query);
	$rows = $ingredient_results->num_rows;	
echo <<<_END
	<table class="stockTable">
_END;
	for ($j = 0; $j < $rows; ++$j)
	{
		$ingredient_results->data_seek($j);
		$ingredient_row = $ingredient_results->fetch_array(MYSQLI_NUM);
		$ingredient_name = $ingredient_row[1];
		$ingredient_stock = $ingredient_row[2];
		$ingredient_minimum_stock = $ingredient_row[3];
		$ingredient_unit_type = $ingredient_row[4];
		if ($ingredient_stock < $ingredient_minimum_stock)
		{
echo <<<_END
			<tr class="lowStock">
				<td id="lowStock"> $ingredient_name </td>
				<td id="lowStock"> $ingredient_stock $ingredient_unit_type </td>
			</tr>
_END;
		}
	}
echo <<<_END
	</table>
_END;
}



function updateStock($conn)
{
	$ingredient_id = $_POST["ingredient_id"];
	$query = "SELECT ingredient_stock FROM ingredients WHERE ingredient_id =". $ingredient_id; 
	$stock_results = $conn->query($query);
	$stock_results->data_seek(1);
	$stock_row = $stock_results->fetch_array(MYSQLI_NUM);
	$current_stock = $stock_row[0];
	$new_ingredient_stock = $current_stock + $_POST["amount"];
	$query = "UPDATE ingredients SET ingredient_stock = ". $new_ingredient_stock . " WHERE ingredient_id = " . $ingredient_id;
	$update_ingredients_complete = $conn->query($query);
	if (!$update_ingredients_complete) 
	{
		echo "UPDATE failed: $query<br>" . $conn->error . "<br><br>";
	}
}

$conn->close();
?>

    <div class="errAddStockBox errText hide" id="errorAddStockBox">
        <ul id="errorAddStockList"></ul>
    </div>
    
    <div class="navBar">
        <form action="chef_mainpage.php">
            <button class="returnButton" type="submit">Back</button>
        </form>
    </div>

</body>

</html>
