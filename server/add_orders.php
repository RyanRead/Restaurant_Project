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
$section_id = $_POST["section_id"];
//echo number_format($section_id);

$query = "INSERT INTO orders (section_id, order_complete) VALUES (".$section_id.", false)";
//echo $query."<br><br>";
$insert_order_results = $conn->query($query);
if (!$insert_order_results) 
	echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
else
	$order_id = $insert_order_results->insert_id;
	//echo "Order ID: ".$order_id[0];
	
	
//echo $insertOrderResults;
	$insert_successful = true;
	foreach ($_POST as $x => $x_value) 
	{
		// So that you dont accidentally add the section_id to the order
		if ($x == "section_id")
			continue;
		$query = "INSERT INTO ordered_items (order_id, item_id, item_complete) VALUES (".$order_id.",".$x_value.",false)";
		$insert_order_item = $conn->query($query);
		if (!$insert_order_item) 
		{
			echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
			$insert_successful = false;
			break;
		}
	}
	if ($insert_successful)
	{
		echo "<br><strong> You Have Successfully Ordered: </strong><br><br>";
		$query = "SELECT item_name FROM menu_items NATURAL JOIN ordered_items WHERE order_id =".$order_id; 
		$order_results = $conn->query($query);
		$rows = $order_results->num_rows;
		for ($j = 0; $j < $rows; ++$j)
		{
			$order_results->data_seek($j);
			$order_row = $order_results->fetch_array(MYSQLI_NUM);
			echo $order_row[0]."</strong><br>";
		}
	}
	
	
	


?>
	
<form action ="select_section.php">
<button type = "submit">Make Another Order</button>
</form>
<br>
<form action ="server_homepage.html">
<button type = "submit">Return To  The Server Homepage</button>
</form>	
	
</body>
</html>
