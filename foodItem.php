<?php
if(!isset($_GET["item_id"]) || empty($_GET["item_id"])) {
	$error = "Food Item not selected!";
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
    $sql = "select * FROM food_items where food_items.item_id = ".$_GET["item_id"].";";
        // Submit the query!
	$results = $mysqli->query($sql);
	if(!$results) {
		echo $mysqli->error;
		exit();
	}

	$row = $results->fetch_assoc();

    
    // Close DB Connection.
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php  echo $row["name"];?></title>
    <link rel="stylesheet" type="text/css" href="shared.css">
    <link rel="icon" 
      type="image/png" 
      href="images/favicon.png">

    <style type="text/css">
        /*finish the stepper JS*/
        
        .foodImageContainer {
            width: 90%;
            margin: 0 auto;
        }
        
        .foodImageContainer>img {
            width: 100%;
        }
        /* #food-image-div{
		width: 90%;
		margin:0 auto;
	} */
        
        .food-name-paragraph {
            font-size: 2em;
            font-weight: bold;
            color: #293945;
            margin: 5px 0px;
        }
        
        .item-information-container {
            width: 90%;
            margin: 0 auto;
            text-align: center;
        }
        
        .price-paragraph {
            margin: 5px 0px;
        }
        
        .description-paragraph {
            color: #788996;
            margin: 5px 0px;
        }
        
        .orders-paragraph {
            float: left;
            width: 50%;
            font-size: 1.5em;
            font-weight: bold;
            margin: 0;
            /* border: 2px solid palevioletred; */
        }
        
        .clearboth {
            clear: both;
        }
        
        .order-stepper-container {
            width: 90%;
            margin: 0 auto;
        }
        
        .stepper-container {
            float: left;
            width: 50%;
        }
        
        .change-button {
            float: right;
            font-size: 2em;
            font-weight: bold;
            color: #4B5D6B;
            margin:0px 10px;
        }

        .change-button:hover {
            cursor:pointer;
        }
        
        .number-input {
            float: right;
            width: 50px;
            height: 35px;
            border-radius: 5px;
            text-align: center;
            border:2px solid #c4cfd9;
        }
        
        .instructions-container {
            width: 90%;
            margin: 0 auto;
        }
        
        #instructions-p {
            font-weight: bold;
        }
        
        #instructions-textarea {
            width: 100%;
            /* border: 2px solid #C6CED6; */
            border-radius: 5px;
            height: 100px;
            resize: none;
            font-size: 1em;
            margin-bottom:10px;
        }
        
        #button-container {
            width: 90%;
            margin: 10px auto;
        }
        
        #submit-button {
            border-radius: 5px;
            width: 100%;
            border: none;
            height: 45px;
            background-color: #D3455A;
            color: white;
            font-size: 1.2em;
            font-weight: bold;
        }
        
        .image-control-button-div {
            float: left;
            width: 50%;
            text-align: center;
            font-size: 2em;
        }
        
        .image-control-button-div:hover {
            background-color: lightgray;
        }

        .error{
            display:none;
            text-align:center;
            color:red;
            font-weight:bold;
        }

        .phperror{
            width:100%;
            text-align:center;
            color:red;
        }

        .phperror>a{
            color:blue;
        }
        @media(min-width: 992px) {
            /*screens from 992px and up will have this css applied*/
            .foodImageContainer {
                max-width: 1000px;
                /* border: 1px solid firebrick; */
            }
            .container {
                background-color: #F7F9FA;
                max-width: 800px;
                margin: 0 auto;
            }
            #button-container {
                max-width: 800px;
                margin: 30px auto;
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
    <div class="foodImageContainer">
        <img src=<?php echo $row["imageURL"];?> alt=<?php echo $row["name"];?>>
    </div>

    <div class="container">

        <div class="item-information-container">
            <p class="food-name-paragraph"><?php echo $row["name"];?></p>
            <p class="price-paragraph">$<?php echo number_format( $row["price"], 2);?></p>
            <p class="description-paragraph"><?php echo $row["description"];?></p>
        </div>
        <form id="order-form" action="orderinformation.php" method="POST">
            <div class="order-stepper-container">
                <p class="orders-paragraph">Orders</p>
                <div class="stepper-container">
                    <div class="change-button" id="increase"><i class="fas fa-plus"></i></div>
                    <input class="number-input" id="number-input" type="number" name="numOrders" value="1" min="1" max="100" >
                    <div class="change-button" id="decrease"><i class="fas fa-minus"></i></div>
                </div>
                <div class="clearboth"></div>
            </div>

            <div class="instructions-container">
                <p id="instructions">Special Instructions</p>
                <textarea id="instructions-textarea" name="instructions" placeholder="Please remove the tomatoes..."></textarea>
            </div>


    </div>

    <input type="hidden" name="item_id" value="<?php echo $_GET["item_id"];?>">

    <br>
    <div class="error container">Error message</div>

    <div id="button-container">
        <button type="submit" id="submit-button">Add to Order</button>
    </div>

    </form>

    <script>
        document.querySelector("#increase").addEventListener("click", function() {
            let value = parseInt(document.querySelector("#number-input").value)
            if (value < 100) {
                document.querySelector("#number-input").value = value + 1;
            }
        });
        document.querySelector("#decrease").addEventListener("click", function() {
            let value = parseInt(document.querySelector("#number-input").value)
            if (value > 1) {
                document.querySelector("#number-input").value = value - 1;
            }
        });
    </script>

    <script src="shared.js"></script>
    <script src="https://kit.fontawesome.com/52238bcdb6.js" crossorigin="anonymous"></script>
    <script>
        document.querySelector("#order-form").onsubmit = function(event) {
            event.preventDefault();
            document.querySelector(".error").innerHTML = ""; //empty out previous error message

            let errorMessage = "";

            let quantityValue = document.querySelector("#number-input").value;
            let instructionsValue = document.querySelector("#instructions-textarea").value;

            //Check for errors         
            if(quantityValue < 1 || quantityValue > 100){
                errorMessage += "Quantity has to be between 1 and 100" + "<br />" ;
            }

            if(isNaN(quantityValue)){
                errorMessage += "Quantity has to be a number value" + "<br />" ;
            }

            if(quantityValue === "" ){
                errorMessage += "Quantity cannot be empty\n" + "<br />" ;
            }

            if(instructionsValue.length  > 200 ){
                errorMessage += "Instructions cannot be greater than 200 characters" + "<br />" ;
            }

            //Output Error Message             
            if(errorMessage !== ""){
                document.querySelector(".error").style.display = 'block';
                document.querySelector(".error").innerHTML = errorMessage;
                console.log(errorMessage);
            }else{
                this.submit();
            }
        }
    </script>
        <?php endif; ?>

</body>

</html>