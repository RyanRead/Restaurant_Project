<?php
    $servername = "localhost";
    $username = "root";
    $pswd = "";
    $database = "restaurant_database";
    $errorBox = false;
    if (isset($_POST["submitted"]) && $_POST["submitted"])
    {
        $chefName = trim($_POST["chefName"]);
        $password = trim($_POST["password"]);
        $db = new mysqli($servername, $username, $pswd, $database);

        if (!$db)
        {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
        }

        $q = "SELECT * FROM Chefs WHERE chefName = '$chefName' AND password = '$password';";
        $result = mysqli_query($db,$q);

        if(!$result)
        {
            echo "ERROR in query";
        }

        if($row = mysqli_fetch_assoc($result))
        {
            //login success
            session_start();
            $_SESSION["chefID"] = $row["chefID"];
            $_SESSION["chefName"] = $row["chefName"];
            $_SESSION["serverCode"] = $row["serverCode"];
            header("Location: chef_mainpage.php");
            $db->close();
            exit();
        }

        else
        {
            $error = "The CHEFNAME/PASSWORD combination was incorrect. Login failed.";
            $db->close();
            $errorBox = true;
        }

    }
    else
    {
        $error = "";
    }
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <!--meta charset="utf-8"-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>QuickServe: Chef Login</title>
        <link rel="stylesheet" type="text/css" href="../style/quickServeStyle.css" />
        
        <script type="text/javascript" src="../javascript/validator.js"> </script>
    </head>

    <body>
        <div class="bg">
        <form action="../index.html">
            <input class="homeButton" type="submit" value="Home"/>
        </form>
            <div class="title">Welcome CHEF</div>
            <div class="subTitle">Please enter login information</div>
            <div class="container">
                <br/>
                <form action="chef_login.php" class="logIn" id="chefSignIn" method="POST">
                    <input type="text" name="chefName" class="logInBox"id="cName" placeholder="CHEFNAME"/>
                    <br/><br/>
                    <input type="password" name="password" id="pswd" class="logInBox" placeholder="PASSWORD"/>
                    <br/><br/>
                    <input type="hidden" name="submitted" value="1"/>
                    <input type="submit" name="submit" class="submitBtn" id="signIn" value="SIGN IN"/>
                </form>
                <script type = "text/javascript"  src = "../javascript/validation_chefLogin.js" ></script>
            </div>
            <div class="errBox errText hide" id="errorBox">
                <ul id="errorList"></ul>
            </div>
            <?php
                if($errorBox)
                { 
                  echo '<div class="errorChefLogin">'.$error.'</div>';
                } 
            ?>
            
        </div>
    </body>

</html>