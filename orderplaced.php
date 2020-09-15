<?php 

if ( !isset($_POST['fullname']) || empty($_POST['fullname']) 
    || !isset($_POST['email']) || empty($_POST['email'])
    || !isset($_POST['homeaddress']) || empty($_POST['homeaddress'])
    || !isset($_POST['city']) || empty($_POST['city'])
    || !isset($_POST['zipcode']) || empty($_POST['zipcode'])
    || !isset($_POST['state']) || empty($_POST['state'])
    || !isset($_POST['item_id']) || empty($_POST['item_id'])
    || !isset($_POST['numOrders']) || empty($_POST['numOrders'])

) {

	// Missing required fields.
	$error = "Please fill out all required fields.";

}else{
    
    $host = "303.itpwebdev.com";
    $user = "angulor_db_user";
    $password = "uscItp2020";
    $db = "angulor_knock_knock";

        // DB Connection
	$mysqli = new mysqli($host, $user, $password, $db);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
    }
    
    if ( isset($_POST['instructions']) && !empty($_POST['instructions']) ) {
        $instructions = $_POST['instructions'] ;
    } else {
        $instructions = null;
    }

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    $statement = $mysqli->prepare(
        "INSERT INTO `orders` ( `person_name`, `item_id`, `times_ordered`, `instructions`, `time_placed`, `email_address`, 
                                `ip_address`, `home_address`, `city`, `state`, `zip_code`) 
        VALUES (?, ?, ?, ?, now(), ?, ?, ?, ?, ?, ?);"
    );

    $statement->bind_param("siissssssi", $_POST["fullname"],  $_POST["item_id"], $_POST["numOrders"], $instructions,
                                         $_POST["email"],$ip, $_POST["homeaddress"], $_POST["city"], $_POST["state"], $_POST["zipcode"]);

    $executed = $statement->execute();
    if(!$executed) {
        echo $mysqli->error;
    }

    // affected_rows will return how many records have been inserted/updated from the above statement
    if ($statement->affected_rows == 1) {
        $isUpdated = true;
    }
    $statement->close();

    $mysqli->close();

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed</title>
    <link rel="stylesheet" type="text/css" href="shared.css">

    <script src="https://kit.fontawesome.com/52238bcdb6.js" crossorigin="anonymous"></script>
    <link rel="icon" 
      type="image/png" 
      href="images/favicon.png">
    <style type="text/css">
        /*make sure there is consistency between the pages and the font sizes for titles AND colors*/
        /*make a vector of the check mark*/
        
        .container {
            width: 90%;
            margin: 0 auto;
            text-align: center;
        }
        
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }
        
        * {
            box-sizing: border-box;
        }
        
        #logo {
            color: #D3455A;
            text-align: center;
            font-size: 2.5em;
            font-weight: bolder;
        }
        
        h1 {
            text-align: center;
        }
        
        .image-container {
            width: 100%;
        }
        
        .image-container>img {
            width: 100%;
        }
        
        p {
            text-align: center;
            color: #788996;
        }
        
        #submit-button {
            border-radius: 5px;
            width: 100%;
            border: none;
            height: 45px;
            background-color: #D3455A;
            color: white;
            font-size: 1.2em;
            font-weight: 500;

        }

        #submit-button:hover {
            cursor:pointer;
        }
        
        h1 {
            width: 100%;
        }
        
        p {
            text-align: center;
            width: 100%;
        }
        
        @media(min-width: 768px) {
            .container {
                width: 90%;
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
                max-width: 800px;
                text-align: center;
            }
            .image-container {
                width: 50%;
                margin: 0 auto;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div id="logo"><i class="fas fa-bars" id="menu-icon"></i><a href="index.php"><span id="logo-red">Knock</span> Knock</a></div>
        <div id="restaurants-link"><i class="fas fa-utensils"></i><a href="index.php">Restaurants</a></div>
        <div id="shopping-cart"><i class="fas fa-shopping-cart"></i> <a href="currentorders.php">Orders</a></div>
    </div>
    <div class="container">
        <h1>Order Placed</h1>
        <div class="image-container">
            <img src="images/greencheckmark.png">
        </div>
        <p>Your order will arrive in 10-15 minutes.</p>
        <button id="submit-button">All Orders</button>
    </div>
    <script src="shared.js"></script>
    <script>
    document.querySelector("#submit-button").onclick = function(){
        window.location.href = "currentorders.php";
    }
    
    </script>
</body>

</html>