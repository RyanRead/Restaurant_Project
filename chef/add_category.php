<html>
<body style="color:white; background-color:powderblue">
<h1> Add New Category <h1> <br>
<h2> Current Categories </h2> <br>
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

if (isset($_POST["new_categorey_name"]))
{
	$new_categorey_name = $_POST["new_categorey_name"];
	$query = "INSERT INTO menu_item_categories (category_name) VALUES ('".$new_categorey_name."')";
	$insert_category_results = $conn->query($query);
	if (!$insert_category_results) 
	{
		echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
	}
}


$query = "SELECT category_name FROM menu_item_categories";
$categories_results = $conn->query($query);
$rows = $categories_results->num_rows;
for ($j = 0; $j < $rows; ++$j)
{
	$categories_results->data_seek($j);
	$category_row = $categories_results->fetch_array(MYSQLI_NUM);
	$category_name = $category_row[0]; //Menu item ID
echo <<<_END
	<li> $category_name </li>
_END;
}
echo <<<_END
</ul>
<h2>Enter the Name of the New Category </h2>
<form action ="" method = "post">
	 <input type="text" name="new_categorey_name"><br>
	 <input type="submit" value="Submit">
</form>
_END;
?>

<form action ="add_items.html">
<button type = "submit">Return To Previous Page</button>
</form>
</body>
</html>
