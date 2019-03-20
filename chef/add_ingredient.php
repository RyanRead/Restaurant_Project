<html>
<body style="color:white; background-color:powderblue">
<h1> Add New Ingredient <h1> <br>
<h2> Current Ingredients </h2> <br>
<ul>
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

if (isset($_POST["ingredient_name"]))
{
	$new_ingredient_name = $_POST["ingredient_name"];
	$ingredient_stock = $_POST["ingredient_stock"];
	$ingredient_minimum_stock = $_POST["ingredient_minimum_stock"];
	$ingredient_unit_type = $_POST["ingredient_unit_type"];
	$query = "INSERT INTO ingredients (ingredient_name, ingredient_stock, ingredient_minimum_stock, ingredient_unit_type)
	VALUES ('$new_ingredient_name', $ingredient_stock, $ingredient_minimum_stock, '$ingredient_unit_type')";
	$insert_ingredient_results = $conn->query($query);
	if (!$insert_ingredient_results) 
	{
		echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
	}
}


$query = "SELECT ingredient_name FROM ingredients";
$ingredient_results = $conn->query($query);
$rows = $ingredient_results->num_rows;
for ($j = 0; $j < $rows; ++$j)
{
	$ingredient_results->data_seek($j);
	$ingredient_row = $ingredient_results->fetch_array(MYSQLI_NUM);
	$ingredient_name = $ingredient_row[0]; //Menu item ID

echo <<<_END
	<li>$ingredient_name</li>
_END;
}

echo <<<_END
</ul>

<form action ="" method = "post">
	<label>Name of Ingredient:</label><br>
	<input type="text" name="ingredient_name"><br><br>
	<label>How many are in stock:</label><br>
	<input type="number" step="0.01" name="ingredient_stock"><br><br>
	<label>What is the minimum stock:</label><br>
	<input type="number" step="0.01" name="ingredient_minimum_stock"><br><br>
	<label>What is the unit of measurement (mLs, lbs, bags, etc.):</label><br>
	<input type="text" name="ingredient_unit_type"><br><br><br>
	<input type="submit" value="Submit">
</form>
_END;
?>

<form action ="add_items.html">
<button type = "submit">Return To Previous Page</button>
</form>
</body>
</html>