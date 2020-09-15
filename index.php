<?php 
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
$sql = "SELECT restaurants.restuarant_id, restaurants.name,restaurants.stars,restaurants.imageURL,food_categories.name AS category
FROM restaurants
LEFT JOIN food_categories ON food_categories.food_category_id = restaurants.food_category_id;";

$results = $mysqli->query($sql);

if ( $results == false ) {
	echo $mysqli->error;
	exit();
}

// Close DB Connection.
$mysqli->close();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurants</title>
    <link rel="stylesheet" type="text/css" href="shared.css">
    <link rel="icon" 
      type="image/png" 
      href="images/favicon.png">

    <style>        
        .resturantName {
            font-weight: bold;
        }
        
        .imageDiv {
            width: 100%;
            margin: 0 auto;
        }
        
        .imageDiv>img {
            width: 100%;
        }
        
        .restaurantDiv {
            width: 100%;
            margin: 0 auto;
        }
        
        .container {
            width: 90%;
            margin: 0 auto;
        }
        
        #display {
            display: none;
        }
        

        @media(min-width: 992px) {
            .container {
                display: flex;
                justify-content: space-around;
                flex-wrap: wrap;
                max-width: 1500px;
            }
            .imageDiv {
                width: 95%;
                margin-top: 10px;
            }
            #display {
                background-color: #E9A2AD;
                height: 500px;
                position: relative;
                display: block;
            }
            #display-caption {
                width: 30%;
                margin: 0 auto;
                padding: 50px;
                font-size: 1.5em;
                background-color: white;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
                color: #D3455B;
                font-weight: bolder;
            }
            .restaurantDiv {
                background-color: #F7F9FA;
                margin: 0;
                border: 2px solid #c4cfd9;
                text-align: center;
                width: 400px;
                margin-top: 20px;
                padding:10px 0px ;
            }

            .restaurantDiv:hover{
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

    <div id="display">
        <div id="display-caption">
            Your favorite local food at your door faster than you can get downstairs.
        </div>
    </div>

    <div class="container">
        <?php while ( $row = $results->fetch_assoc() ) : ?>

        <a href="menu.php?restaurant_id=<?php echo $row["restuarant_id"];?>">
            <div class="restaurantDiv">
                <div class="imageDiv">
                    <img src=<?php echo $row['imageURL'];?>>
                </div>
                <div class="restuarantDescription">
                    <div class="resturantName"><?php echo $row['name'];?></div>
                    <div class="categoryName">Category: <?php echo $row['category'];?></div>
                </div>
                <hr>
            </div>
        </a>
        <?php endwhile; ?>


    </div>


    <script src="shared.js"></script>
    <script src="https://kit.fontawesome.com/52238bcdb6.js" crossorigin="anonymous"></script>

    
</body>

</html>