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

echo <<<_END
<table style="width:100%">
<tr>
	<th> Ingredient Name </th> 
	<th> Ingredient Stock </th>
</tr>
_END;

$query = "SELECT * FROM ingredients";
$ingredient_results = $conn->query($query);
$rows = $ingredient_results->num_rows;
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

$conn->close();

?>



</body>
</html>
