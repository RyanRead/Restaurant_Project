<?php
    session_start();
    $_SESSION["table_count"] = 0;
    $errorBox = false;
?>


<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <!--meta charset="utf-8"-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New Ingredient</title>
    <link rel="stylesheet" type="text/css" href="../style/quickServeStyle.css" />

    <script type="text/javascript" src="../javascript/validator.js"> </script>
</head>

<body class="bgChef">
    <h1 class="newIngredients"> Add New Ingredients</h1> <br>
    <?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "restaurant_database";

    
    echo "<div class='ingredientsContainer'>
    <h1 id='listIngredients'>List of Ingredients</h1>
    <ul>";
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
</div>
<div class="addIngredientsForm">
<form action ="" id="addNewIngredientsForm" method = "post">
	<label>Name of Ingredient</label><br>
	<input type="text" name="ingredient_name" id="name_of_ingredient"><br>
	<label># in stock</label><br>
	<input type="number" step="0.01" name="ingredient_stock" id="in_stock"><br>
	<label>minimum stock</label><br>
	<input  type="number" step="0.01" name="ingredient_minimum_stock" id="min_stock"><br>
	<label>Unit of measurement (examples: mLs, lbs, bags, etc.)</label><br>
	<input type="text" name="ingredient_unit_type" id="ingredient_unit"><br><br>
	<input class="submitButton" type="submit" value="Submit">
</form>
<script type="text/javascript" src="../javascript/validation_addingredients.js"> </script>
</div>
_END;
?>
    <div class="navBar">
        <form action="add_items.php">
            <button class="returnButton" type="submit">Back</button>
        </form>

        <form action="chef_mainpage.php">
            <button class="backChefButton" type="submit">Chef Main</button>
        </form>
    </div>

    <div class="errAddIngredientsBox errText hide" id="errorAddIngredientBox">
        <ul id="errorNewIngredientList"></ul>
    </div>


    <div class="bgChefParallax"></div>
</body>

</html>
