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
$category;
$name;
$item;

$query = "SELECT * FROM menu_items ORDER BY category_id";
$menu_item_results = $conn->query($query);
$rows = $menu_item_results->num_rows;
$rows = $rows + 1;

foreach ($_POST as $x => $x_value) 
{
	
	echo "$x<br>  $x_value<br>";
	if($x == "new_item_name")
	{
		$name = $x_value;
		continue;
	}
	elseif($x == "category")
	{
		$category = $x_value;
		continue;
	}
	elseif($x_value != null)
	{
		if(strlen($x) < 8)
		{
			$item = $x_value;
		}
		else
		{
			$query = "INSERT INTO recipes (item_id, ingredient_id, amount) VALUES ($rows, $item, $x_value)";
			$insert_recipe = $conn->query($query);
			if (!$insert_recipe) 
			{
				echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
			}
			else
			{
				echo "Successfully inserted into Recipes<br>";
			}
		}
	}
}


$query = "INSERT INTO menu_items (item_name, category_id) VALUES ('$name', $category)";
$insert_menu_item = $conn->query($query);
if (!$insert_menu_item) 
{
	echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
}
else
{
	echo "Successfully inserted into menu_items <br>";
}

$conn->close();

echo <<<_END
<meta http-equiv="refresh" content="0;URL=add_menu_item.php" />
_END;
?>
