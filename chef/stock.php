<html>
<body style="color:white; background-color:powderblue">
<h1> Stock </h1>
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

if (isset($_POST["update_stock"]) & isset($_POST["amount"]))
{
	updateStock($conn);
}

$query = "SELECT * FROM ingredients";
$ingredient_results = $conn->query($query);
$rows = $ingredient_results->num_rows;
echo <<<_END
<div style="border:1px; border-style:solid; width:50%;">
<h2> Bought More Stock? </h2>
<strong> How much more did you buy? </strong>
<form action = "" method = "post">
<select name="ingredient_id">
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
<input type="text" name="amount">
<button type = "submit" name = "update_stock" value = "1">Click Here to Update Your Stock</button></td>
<input type = "hidden" name = "view_stock" value = "$_POST["view_stock"]">
</form>
</div>
_END;

if ($_POST["view_stock"] == 1)
{
echo <<<_END
	<p>View All Ingredients</p>
	<form action ="" method ="post">
	<button type = "submit" name = "view_stock" value = "2" >View Ingredients With Low Stock</button>
	</form>
	<br>
_END;
	printAllStock($ingredient_results);
}
else if ($_POST["view_stock"] == 2)
{
	echo <<<_END
	<p>View Low Ingredients</p>
	<form action ="" method ="post">
	<button type = "submit" name = "view_stock" value = "1" >View All Ingredients Stock</button>
	</form>
	<br>
_END;
	printLowStock($ingredient_results);
}

$conn->close();

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

function printAllStock($conn)
{
	$query = "SELECT * FROM ingredients";
	$ingredient_results = $conn->query($query);
	$rows = $ingredient_results->num_rows;	
echo <<<_END
	<table style="width:100%">
	<tr>
		<th> Ingredient Name </th> 
		<th> Ingredient Stock </th>
	</tr>
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
			<tr style="background-color:Red">
				<td> $ingredient_name </td>
				<td> $ingredient_stock $ingredient_unit_type </td>
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

function printLowStock($conn)
{
	$query = "SELECT * FROM ingredients";
	$ingredient_results = $conn->query($query);
	$rows = $ingredient_results->num_rows;	
echo <<<_END
	<table style="width:100%">
	<tr>
		<th> Ingredient Name </th> 
		<th> Ingredient Stock </th>
	</tr>
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
			<tr style="background-color:Red">
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
?>

<form action ="chef_mainpage.php">
<button type = "submit">Return To Chef Main Page </button>
</form>

</body>
</html>
