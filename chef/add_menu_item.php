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

// Grab all current items on the menu
$query = "SELECT * FROM menu_items ORDER BY category_id";
$menu_item_results = $conn->query($query);
$rows = $menu_item_results->num_rows;
$previous = -1;

echo <<<_END
<form action = "update_menu.php" method ="post">
_END;

echo "M E N U";

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
	
	$value = $menu_item_row[0]; //Menu item ID
	echo "- ". $menu_item_row[1]."<br>";
	$previous = $item_category;
}
echo "<br>ADD MENU ITEM<br><br>";

echo <<<_END
New Item: <input type='text' name='new_item_name'><br><br>
_END;


//Grabs all the Menu Item Categories from the table and put it into a drop down menu
$query = "SELECT * FROM menu_item_categories ORDER BY category_id";
$menu_item_category_results = $conn->query($query);
$rows = $menu_item_category_results->num_rows;
echo "<select name='category'>";
for ($i = 0; $i < $rows; ++$i)
{
	$menu_item_category_results->data_seek($i);
	$menu_item_category_row = $menu_item_category_results->fetch_array(MYSQLI_NUM);
	//echo $menu_item_category_row['category_id'];
	echo "<option value = '$menu_item_category_row[0]'>".$menu_item_category_row[1]."</option>";
}
echo "</select><br><br>Ingredients:<br>";

$query = "SELECT * FROM ingredients ORDER BY ingredient_id";
$ingredients_results = $conn->query($query);
$rows = $ingredients_results->num_rows;
echo "";
for ($i = 0; $i < $rows; ++$i)
{
	$ingredients_results->data_seek($i);
	$ingredients_row = $ingredients_results->fetch_array(MYSQLI_NUM);
	$name = "item"."$i";
	$name_amount = $name."_amount";
	$value = $ingredients_row[0];
echo <<<_END
	<input type = "checkbox" name = "$name" value = "$value"/> <input type="number" step="0.01" name="$name_amount" /> 
_END;
	echo $ingredients_row[1]."<br>";
}

//echo " <button type='button'>Add Ingredient</button><br><br>";



echo <<<_END
<input type = "submit" value = "Submit">
</form>
_END;
$conn->close();

?>

</body>
</html>