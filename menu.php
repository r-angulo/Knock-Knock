<?php 
if(!isset($_GET["restaurant_id"]) || empty($_GET["restaurant_id"])) {
	// A track id is not given, show error message. Don't do anything else.
	$error = "Could not load menu. Please selected a restaurant!";
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

    $mysqli->set_charset('utf8');
    
    $sql = "SELECT * FROM food_items WHERE restaurant_id = ".$_GET["restaurant_id"].";";

    // Submit the query!
	$results = $mysqli->query($sql);
	if(!$results) {
		echo $mysqli->error;
		exit();
	}
    

    /////////////////////////
    // DB Connection
    
    $restaurant_sql = "SELECT restaurants.name,restaurants.imageURL
    FROM restaurants
    WHERE restuarant_id = ".$_GET["restaurant_id"].";";

    // Submit the query!
	$restaurant_results = $mysqli->query($restaurant_sql);
	if(!$restaurant_results) {
		echo $mysqli->error;
		exit();
	}

    $restaurant_results = $mysqli->query($restaurant_sql);

	$restaurant_row = $restaurant_results->fetch_assoc();

    
    // Close DB Connection.
    $mysqli->close();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $restaurant_row["name"];?> Menu</title>
    <script src="https://kit.fontawesome.com/52238bcdb6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="shared.css">
    <link rel="icon" 
      type="image/png" 
      href="images/favicon.png">
    <style type="text/css">        
        #imageDiv {
            width: 100%;
            
        }
        
        #imageDiv>img {
            width: 100%;
        }
        
        .menuItemContainer {
            width: 90%;
            margin: 0 auto;
            color:black;
        }
        
        .foodImageContainer {
            width: 50%;
            float: left;
            /* border: 1px solid orange; */
        }
        
        .foodImageContainer>img {
            width: 100%
        }
        
        .foodDescContainer {
            width: 50%;
            float: left;
            /* border: 1px solid red; */
        }
        
        .foodNameParagraph {
            font-size: 1.2em;
            font-weight: bold;
            margin: 10px 0px;
            /* border: 1px solid green; */
        }
        
        .priceParagraph {
            margin: 10px 0px;
            /* border: 1px solid black; */
        }
        
        .accoladeParagraph {
            margin: 10px 0px;
            /* border: 1px dashed black; */
        }
        
        .clearboth {
            clear: both;
        }
        
        #restaurant-header {
            height: 200px;
            /* background-image: url("images/restaurantimage.jpg"); */
            background-image: url(<?php echo $restaurant_row["imageURL"];?>);

            
            background-repeat: no-repeat;
            width: 100%;
            background-position: center;
            background-size: 100% 100%;
            position: relative;
        }
        
        #display-caption {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50%;
            margin: 0 auto;
            padding: 50px;
            font-size: 1.5em;
            background-color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            font-weight: bolder;
        }

        .phperror{
            width:100%;
            text-align:center;
            color:red;
        }

        .phperror>a{
            color:blue;
        }
        @media(min-width: 768px) {
            /*screens from 992px and up will have this css applied*/
            .container {
                width: 100%;
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
                margin: 0 auto;
                max-width: 1500px;
                /* border: 1px dashed firebrick; */
            }
            #restaurantHeader {
                width: 100%;
            }
            .menuItemContainer {
                width: 40%;
                background-color: #F7F9FA;
                margin-top: 10px;
                float: left;
                border: 2px solid #c4cfd9;
            }
            hr {
                display: none;
            }
            .foodDescContainer,
            .priceParagraph,
            .priceParagraph,
            .accoladeParagraph {
                float: none;
                width: 100%;
                text-align: center;
            }
            .foodImageContainer {
                width: 100%;
            }
        }
        
        @media(min-width: 992px) {
            .menuItemContainer {
                width: 30%;
            }


            .menuItemContainer:hover{
                box-shadow: 0px 0px 20px 0px rgba(153,153,153,1);
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
    <?php if ( isset($error) && !empty($error) ) : ?>

        <div class="phperror">
            <?php echo $error; ?><br>
            <a href="index.php">View Restaurants</a>
        </div>

<?php else : ?>
    <div id="restaurant-header">
        <div id="display-caption">
        <?php echo $restaurant_row["name"];?>
        </div>
    </div>

    <div class="container">
        <?php while ( $row = $results->fetch_assoc() ) : ?>

        <a class="menuItemContainer" href="foodItem.php?item_id=<?php echo $row["item_id"];?>"> 
            <div class="foodImageContainer">
                <img src=<?php echo $row['imageURL'];?> alt="<?php echo $row['name'];?>">
            </div>
            <div class="foodDescContainer">
                <p class="foodNameParagraph">
                    <?php echo $row['name'];?></p>
                <p class="priceParagraph">$<?php echo number_format( $row["price"], 2);?></p>
            </div>
            <div class="clearboth"></div>
            <hr>
        </a>
        <?php endwhile; ?>


    </div>
    <script src="shared.js"></script>

    <?php endif; ?>

</body>

</html>