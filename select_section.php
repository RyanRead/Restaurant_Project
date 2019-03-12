<html>
<body style="color:white; background-color:powderblue">


<?php
//*****************
// This allows the server to select a table to serve to 
//***************


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



$query = "SELECT * FROM sections";
$section_results = $conn->query($query);
$rows = $section_results->num_rows;

echo <<<_END
<form action = "menu_item_page.php" method ="post">
_END;
for ($j = 0; $j < $rows; ++$j)
{
	$section_results->data_seek($j);
	$section_row = $section_results->fetch_array(MYSQLI_NUM);
	
	$value = $section_row[0];
	 //Menu item ID
echo <<<_END
	<input type = "radio" name = "section_id" value = "$value">
_END;
	echo "Table ". $value . "<br>";
}
echo <<<_END
<input type = "submit" value = "Submit">
</form>
_END;
$conn->close();

?>

</body>
</html>