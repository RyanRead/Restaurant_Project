<?php
    session_start();
    $_SESSION["table_count"] = 0;
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
    <h1 class="newCategory"> Add New Category </h1> <br>


    <?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "restaurant_database";
echo "  <div class='categoryContainer'><h1 class='listCategory'>Current Categories</h1><ul>";
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
</div>
<div class='addCategoryForm'>
<h2>Enter the Name of the New Category </h2>
<form action ="" method = "post" id="newCategoryForm">
	 <input type="text" name="new_categorey_name" id="category_name"><br><br>
	 <input class="submitButton" type="submit" value="Submit">
</form>
<script type="text/javascript" src="../javascript/validation_addNewCategory.js"> </script>
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

    <div class="errAddCategoryBox errText hide" id="errorNewCategoryBox">
        <ul id="errorNewCategoryList"></ul>
    </div>

    <div class="bgChefParallax"></div>
</body>

</html>
