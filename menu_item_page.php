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

$section_id = $_POST['section_id'];

$query = "SELECT * FROM menu_items ORDER BY category_id";
$menu_item_results = $conn->query($query);
$rows = $menu_item_results->num_rows;
$previous = -1;
echo <<<_END
<form action = "add_orders.php" method ="post">
_END;
$j;
for ($j = 0; $j < $rows; ++$j)
{
	$menu_item_results->data_seek($j);
	$menu_item_row = $menu_item_results->fetch_array(MYSQLI_NUM);
	// Maybe Print Category Title
	$item_category = $menu_item_row[2];
	
	if ($previous == -1 || $previous != $item_category)
	{
		//echo $item_category;
		$query = "SELECT category_name FROM menu_item_categories WHERE category_id =".$item_category; 
		$category_results = $conn->query($query);
		$category_results->data_seek(1);
		$category_row = $category_results->fetch_array(MYSQLI_NUM);
		echo "<br><strong>".$category_row[0]."</strong><br>";
	}
	
	$name = "item" . $j;
	$value = $menu_item_row[0]; //Menu item ID
echo <<<_END
	<input type = "checkbox" name = "$name" value = "$value">
_END;
	echo $menu_item_row[1]."<br>";
	$previous = $item_category;
}
echo <<<_END
<input type ="hidden" name="section_id" value="$section_id">
<input type = "submit" value = "Submit">
<input type="reset">
</form>
_END;
$conn->close();

?>

</body>
</html>