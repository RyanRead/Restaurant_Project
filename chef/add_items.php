<html>
<body style="color:white; background-color:powderblue">

<form action ="add_category.php"> 
<button type = "submit"> Add Category</button>
</form>

<br>

<form action ="add_menu_item.php"> 
<button type = "submit"> Add Menu Item</button>
</form>

<br>

<form action ="add_ingredient.php"> 
<button type = "submit"> Add Ingredient</button>
</form>

<br>

<form action ="" method = "post"> 
<button type = "submit" name = "add_table" value = "1"> Click Here to Add One More Table </button>
</form>

<br>


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
		echo "You Added One Table";
	}
}
$conn->close();
?>

<form action ="chef_mainpage.php"> 
<button type = "submit"> Return to Chef Main Page</button>
</form>

</body>
</html>
