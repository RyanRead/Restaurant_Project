<html>

<head>
    <!--meta charset="utf-8"-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Items Selection</title>
    <link rel="stylesheet" type="text/css" href="../style/quickServeStyle.css" />
</head>

<body class="bgChef">
    <div class="addItemButtonMenu">
    <form action="add_menu_item.php">
        <button class="addMenuItemButton" type="submit"> Add Menu Item</button>
    </form>
    <form action="add_category.php">
        <button class="addCategoryButton" type="submit"> Add Category</button>
    </form>
    <form action="add_ingredient.php">
        <button class="addIngredientButton" type="submit"> Add Ingredient</button>
    </form>
    <form action="" method="post">
        <button class="addTableButton" type="submit" name="add_table" value="1">Add One Table</button>
    </form>
    </div>
    <?php
    session_start();
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

if (isset($_POST["add_table"]))
{
	$query = "INSERT INTO sections () VALUES ()";
	$insert_section = $conn->query($query);
	if (!$insert_section) 
	{
		echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
	}
	else
	{
        $_SESSION["table_count"] += 1;
        $table_count = $_SESSION["table_count"];
        if($table_count > 1)
        {
        ?>
    <div class="numTablesText">You've Added <?=$table_count?> Table's </div>
    <?php }
        else
        {?>
    <div class="numTablesText">You've Added <?=$table_count?> Table </div>
    <?php }
	}
}
$conn->close();
?>
    <div class="navBar">
        <form action="chef_mainpage.php">
            <button class="returnButton" type="submit">Back</button>
        </form>
    </div>

</body>

</html>
