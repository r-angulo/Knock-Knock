<?php

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

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
$sql = "SELECT orders.order_id,orders.item_id,orders.times_ordered,food_items.imageURL,food_items.name,food_items.price
FROM orders
LEFT JOIN food_items ON food_items.item_id = orders.item_id
WHERE orders.ip_address ='".$ip ."';";

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
    <title>Your Current Orders</title>
    <script src="https://kit.fontawesome.com/52238bcdb6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="shared.css">
    <link rel="icon" 
      type="image/png" 
      href="images/favicon.png">
    <style type="text/css">

        *{
            box-sizing:border-box;

        }
        .container {
            width: 90%;
            margin: 0 auto;
        }
        
        h2 {
            text-align: center;
        }
        
        .foodImageContainer {
            width: 50%;
            float: left;
        }
        
        .foodImageContainer>img {
            width: 100%;
        }
        
        .container {
            width: 90%;
            margin: 0 auto;
        }
        
        .clearboth {
            clear: both;
        }
        
        .foodDescContainer {
            width: 50%;
            float: left;
        }
        
        .priceParagraph {
            margin: 10px 0px;
        }
        
        .foodNameParagraph {
            font-size: 1.2em;
            font-weight: bold;
            margin: 10px 0px;
        }
        
        .submit-button {
            border-radius: 5px;
            width: 100%;
            border: none;
            height: 45px;
            background-color: #D3455A;
            color: white;
            font-size: 1.2em;
            font-weight: 500;
            margin: 5px 0px;
        }

        .submit-button{
            cursor:pointer;
        }
        
        .alternate-color-button {
            background-color: white;
            border: 2px solid #D3455A;
            color: #D3455A
        }
        
        hr {
            border: 1px solid darkgrey;
        }
        
        @media(min-width: 992px) {
            .container {
                max-width: 1000px;
                /* border: 1px solid forestgreen; */
                background-color: #F7F9FA;
                margin-bottom: 30px;
                border-radius:10px;
            }
            .foodDescContainer {
                /* border: 1px dashed forestgreen; */
            }
            .submit-button {
                width: 20%;
                /* border: 1px solid forestgreen; */
                margin: 0 auto;
                display: inline-block;
                width: 20%;
                text-align: center;
                margin: 2%;
            }

            .foodImageContainer{
                border:5px solid #F7F9FA;
            }

            .foodImageContainer,
            .foodNameParagraph,
            .foodDescContainer,
            .submit-button {
                float: left;
            }
            hr {
                display: none;
            }
            .foodNameParagraph {
                font-size: 1.5em;
                /* border: 1px solid firebrick; */
            }
            .priceParagraph {
                /* border: 1px solid forestgreen; */
                font-size: 1.3em;
                padding-right: 20px;
                float: right;
            }

            .container:hover{
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

    <h2>Your Current Orders</h2>



    <?php while ( $row = $results->fetch_assoc() ) : ?>

    <div class="container">
        <div class="foodImageContainer">
            <!-- <img src="images/foodItem.png"> -->
            <img src="<?php echo $row['imageURL'];?>">

        </div>
        <div class="foodDescContainer">
            <p class="foodNameParagraph"><?php echo $row['name'];?></p>
            <p class="priceParagraph">Total: $<?php echo number_format($row["price"] * $row["times_ordered"], 2);?></p>
        </div>

        <form action="editInformation.php" method="POST">
            <input type="hidden" name="order_id" value="<?php $oi =  $row["order_id"]; echo $oi;?>">
            <button class="submit-button">Edit Order</button>
        </form>

        <form action="" method="" class="cancel_form">
            <input type="hidden" class="cancel-order-id" name="order_id" value="<?php echo  $oi ;?>">
            <button class="submit-button alternate-color-button">Cancel Order</button>
        </form>

        <div class="clearboth"></div>

        <hr>
    </div>
    <?php endwhile; ?>

    <script src="shared.js"></script>
    <script>

        function ajaxPost(endpointUrl, postdata, returnFunction){
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', endpointUrl, true);
                    // When sending POST requests, need to add some info in the header
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                    xhr.onreadystatechange = function(){
                        if (xhr.readyState == XMLHttpRequest.DONE) {
                            if (xhr.status == 200) {
                                returnFunction( xhr.responseText );
                            } else {
                                alert('AJAX Error.');
                                console.log(xhr.status);
                            }
                        }
                    }
                    // Send postdata separately
                    xhr.send(postdata);
        };

        let cancelItems = document.querySelectorAll(".cancel_form");

        for(let i = 0;i < cancelItems.length; i++){
            cancelItems[i].onsubmit = function(event) {
                event.preventDefault();
                let order_id = this.querySelector(".cancel-order-id").value.trim();;

                console.log(this);
                let toURL =  `order_id=${order_id}`;

                ajaxPost("deleteOrder.php",toURL, function(successful) {
                    console.log(successful);
                    if(successful){
                        location.reload()
                    }else{
                        alert("Could not delete item.");
                    }
                });
 
            }
        }
    </script>
</body>

</html>