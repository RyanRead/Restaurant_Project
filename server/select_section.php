<html>

<head>
    <!--meta charset="utf-8"-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Items Selection</title>
    <link rel="stylesheet" type="text/css" href="../style/quickServeStyle.css" />
</head>

<body class="bgChef">
    <h1 class="chooseTable">Choose A Table</h1>

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
<div class="tableListContainer">
<form action = "menu_item_page.php" method ="post">
<select name="section_id">
_END;
for ($j = 0; $j < $rows; ++$j)
{
	$section_results->data_seek($j);
	$section_row = $section_results->fetch_array(MYSQLI_NUM);
	
	$value = $section_row[0];
	 //Menu item ID
echo <<<_END
    <option value="$value">Table $value</option>

_END;
}
echo <<<_END
    </select><br><br>
<input class="chooseTableSubmit" type = "submit" value = "Submit">
</form>
</div>
_END;
$conn->close();

?>
    <div class="navBar">

        <form action="server_homepage.php">
            <button class="returnButton" type="submit">Back</button>
        </form>
    </div>
</body>

</html>
