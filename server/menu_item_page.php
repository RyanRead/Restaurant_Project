<html>

<head>
    <!--meta charset="utf-8"-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Making Order</title>
    <link rel="stylesheet" type="text/css" href="../style/quickServeStyle.css" />
    <script type="text/javascript" src="../javascript/validator.js"> </script>
</head>

<body class="bgChef">
    <h1 class="makeOrder">Making Order</h1>


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

$section_id = $_POST['section_id']; //This variable stores which table is creating the order 
$query = "SELECT * FROM menu_items ORDER BY category_id";
$menu_item_results = $conn->query($query);
$rows = $menu_item_results->num_rows;
$previous = -1;
echo <<<_END
<div class="chooseOrderContainer">
<form action = "add_orders.php" method ="post" id="makeOrderForm">
_END;
$j;
for ($j = 0; $j < $rows; ++$j)
{
	$menu_item_results->data_seek($j);
	$menu_item_row = $menu_item_results->fetch_array(MYSQLI_NUM);
	$item_id = $menu_item_row[0]; 
	$item_name = $menu_item_row[1];
	$item_category = $menu_item_row[2];
	
	if ($previous == -1 || $previous != $item_category) //This if-statement tests if the items category should be displayed
	{
		$query = "SELECT category_name FROM menu_item_categories WHERE category_id =".$item_category; 
		$category_results = $conn->query($query);
		$category_results->data_seek(1);
		$category_row = $category_results->fetch_array(MYSQLI_NUM);
		echo "<div class='underLine2'><strong>".$category_row[0]."</strong></div>";
	}
	$displayItem = checkForEnoughIngredients($conn, $item_id);	
	if ($displayItem) //This if-statement determines if the item should be displayed as orderable or out of stock
	{
		$name = "item" . $j;
		$value = $item_id; 
echo <<<_END
		<input type = "checkbox" name = "$name" value = "$value">
_END;
		echo $item_name."<br>";
	}
	else
	{
		echo "<div class='outOfStock'>" . $item_name. " [Out Of Stock!] <br></div>";
	}
	$previous = $item_category;
}


echo <<<_END
<br>
<input type ="hidden" name="section_id" value="$section_id">
<input class="submitOrderButton" type = "submit" value = "Place Order">
<input class="resetOrderButton" type="reset" value="Reset Order">
<script type="text/javascript" src="../javascript/validation_AddToOrder.js"> </script>
</form>
</div>
_END;
$conn->close();

//***************************************************************************************
// checkForEnoughIngredients
// This function checks if there is enough stock from an item to completed 
// Parameters: $conn: This parameter is used to maintain the mySQL connection
//			   $item_id: This parameter is used to pass which item should be checked
// Returns: True if the item can be completed
//			False if the item can't be completed  
//***************************************************************************************
function checkForEnoughIngredients($conn, $item_id)
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
			return false;
		}
	}
	return true;
}

?>

    <div class="errMakeOrderBox errText hide" id="errorNewOrderBox">
        <ul id="errorMewOrderList"></ul>
    </div>
    
    <div class="navBar">
        <form action="select_section.php">
            <button class="returnButton" type="submit">Back</button>
        </form>

        <form action="server_homepage.php">
            <button class="backServerButton" type="submit">Server Main</button>
        </form>
    </div>
</body>

</html>
