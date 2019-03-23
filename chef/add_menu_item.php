<?php
    session_start();
    $_SESSION["table_count"] = 0;
    $errorBox = false;
?>

<?php
if (isset($_POST["submitted"]) && $_POST["submitted"])
{
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
		}
	}
}



$query = "INSERT INTO menu_items (item_name, category_id) VALUES ('$name', $category)";
$insert_menu_item = $conn->query($query);
if (!$insert_menu_item) 
{
	echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
}

$conn->close();
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <!--meta charset="utf-8"-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New Category</title>
    <link rel="stylesheet" type="text/css" href="../style/quickServeStyle.css" />

    <script type="text/javascript" src="../javascript/validator.js"> </script>
</head>

<body class="bgChef">
    <h1 class="newMenuItem">Add New Menu Item</h1>

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

    
echo "<div class='menuContainer'><h1 id='listMenu'>Current Menu</h1>";

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
		echo "<strong class='underLine'>".$category_row[0]."</strong><br>";
	}
	
	$value = $menu_item_row[0]; //Menu item ID
	echo "- ". $menu_item_row[1]."<br>";
	$previous = $item_category;
}

echo <<<_END
</div>
<div class="menuIngredientsContainer">
<form action = "add_menu_item.php" method ="post" id="addMenuItemForm">
_END;

echo <<<_END
New Item: <input type='text' name="new_item_name" id='item_name'><br><br>
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
	echo $ingredients_row[1]." (". $ingredients_row[4] .")<br>";
}


echo <<<_END
<br>
<input type="hidden" name="submitted" value="1"/>
<input class="submitButton" type = "submit" value = "Submit">
</form>

<script type="text/javascript" src="../javascript/validation_addMenuItem.js"> </script>
</div>

_END;
$conn->close();

?>

    <div class="errAddMenuBox errText hide" id="errorNewMenuBox">
        <ul id="errorNewMenuList"></ul>
    </div>
    
    
    <div class="navBar">
        <form action="add_items.php">
            <button class="returnButton" type="submit">Back</button>
        </form>

        <form action="chef_mainpage.php">
            <button class="backChefButton" type="submit">Chef Main</button>
        </form>

        <div class="bgChefParallax"></div>
    </div>

</body>

</html>
