<?php
if(!isset($_POST["order_id"]) || empty($_POST["order_id"])) {
	$error = "Invalid order_id.";
}else{
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
    $sql = "SELECT orders.order_id,orders.person_name,orders.item_id,orders.times_ordered,orders.instructions,orders.email_address,orders.home_address,orders.city,orders.state,orders.zip_code,food_items.name,food_items.price,orders.ip_address
    FROM orders
    LEFT JOIN food_items 
    ON orders.item_id = food_items.item_id
    WHERE orders.order_id = '".$_POST["order_id"]."';";
        // Submit the query!
        ECHO $sql;
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
    <title>Edit Information</title>
    <link rel="stylesheet" type="text/css" href="shared.css">
    <link rel="icon" 
      type="image/png" 
      href="images/favicon.png">
    <script src="https://kit.fontawesome.com/52238bcdb6.js" crossorigin="anonymous"></script>

    <style type="text/css">
        .container {
            width: 90%;
            margin: 0 auto;
        }
        
        #order-information-p {
            text-align: center;
        }
        
        input,
        select,textarea {
            border: 2px solid #C6CED6;
            width: 100%;
            height: 35px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 1em;
        }
        
        label {
            font-weight: bolder;
            font-size: 1.2em;
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
        
        .button-container {
            max-width: 800px;
            margin: 30px auto;
            width: 90%;
            margin: 10px auto;
        }

        #return-button{
            background-color: #45d376;
        }
        
        h3,h4{
            font-weight:normal;
            text-align:center;
            width:100%;
        }

        .error{
            display:none;
            text-align:center;
            color:red;
            font-weight:bold;
        }

        @media(min-width: 992px) {
            .container {
                margin-top: 10px;
                background-color: #F7F9FA;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                max-width: 1500px;
            }
            .input-div {
                width: 45%;
                /* border: 1px solid red; */
                /* float: left; */
                /* margin-bottom: 20px; */
                margin: 25px;
            }
            hr {
                display: none;
            }
            /* form{
				display: none;
			} */
        }
    </style>
</head>

<body>
    <div class="header">
        <div id="logo"><i class="fas fa-bars" id="menu-icon"></i><a href="index.php"><span id="logo-red">Knock</span> Knock</a></div>
        <div id="restaurants-link"><i class="fas fa-utensils"></i><a href="index.php">Restaurants</a></div>
        <div id="shopping-cart"><i class="fas fa-shopping-cart"></i> <a href="currentorders.php">Orders</a></div>
    </div>
    <h1 id="order-information-p">Edit Information</h1>
    <form id="updateForm" action="" method="">

    <div class="container">
    <h3><strong>Item: </strong><?php echo $row["name"];?></h3>
<h4><strong>Price: </strong>$<?php echo number_format($row["price"],2);?></h4>
            <hr>
    </div>

    <div class="container">
            <div class="input-div">

                <label for="quantity">Quantity</label><br>
                <input type="number" min="1" max="100" name="quantity" id="quantity" placeholder="1"  value="<?php echo $row["times_ordered"];?>"><br>
            </div>
            <div class="input-div">
                <label for="instructions">Instructions</label><br>
                <textarea  name="instructions" id="instructions" placeholder="Your special instructions" value="<?php echo $row["instructions"];?>" ></textarea>
            </div>

            <hr>
        </div>

        <div class="container">
            <div class="input-div">

                <label for="fullname">Your Full Name</label><br>
                <input type="text" name="fullname" id="fullname" placeholder="Tommy Trojan"  value="<?php echo $row["person_name"];?>" ><br>
            </div>
            <div class="input-div">

                <label for="email">Your Email Address</label><br>
                <input type="email" name="email" id="email" placeholder="ttrojan@usc.edu"  value="<?php echo $row["email_address"];?>" ><br>
            </div>

            <div class="input-div">

                <label for="homeaddress">Home Address</label><br>
                <input type="text" name="homeaddress" id="homeaddress" placeholder="3551 Trousdale Pkwy"  value="<?php echo $row["home_address"];?>"><br>
            </div>
            <div class="input-div">

                <label for="city">City</label><br>
                <input type="text" name="city" id="city" placeholder="Los Angeles"  value="<?php echo $row["city"];?>" ><br>
            </div>
            <div class="input-div">

                <label for="state">State</label><br>
                <select id="state" name="state" >
				<option value="California">California</option>
			</select>
            </div>
            <br>
            <div class="input-div">
                <label for="zipcode">Zip Code</label><br>
                <input type="number" name="zipcode" id="zipcode" placeholder="90089"  value="<?php echo $row["zip_code"];?>" ><br>
            </div>
        </div>

        <input type="hidden" name="order_id"  id="order_id" value="<?php echo $row["order_id"];?>">

        <div class="error container"></div>


        <div class="button-container">
            <button type="submit" id="submit-button">Update Order</button>
        </div>


    </form>


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

        document.querySelector("#updateForm").onsubmit = function(event) {
            event.preventDefault();

	        // Get the user's search term input
	        let quantityInput = document.querySelector("#quantity").value.trim();
            let instructionsInput = document.querySelector("#instructions").value.trim();
	        let fullnameInput = document.querySelector("#fullname").value.trim();
	        let emailInput = document.querySelector("#email").value.trim();
	        let homeaddressInput = document.querySelector("#homeaddress").value.trim();
	        let cityInput = document.querySelector("#city").value.trim();
	        let stateInput = document.querySelector("#state").value.trim();
	        let zipcodeInput = document.querySelector("#zipcode").value.trim();
	        let order_idInput = document.querySelector("#order_id").value.trim();


            document.querySelector(".error").innerHTML = ""; //empty out previous error message

            let errorMessage = "";


            //Check for errors         
            if(quantityInput < 1 || quantityInput > 100){
                errorMessage += "Quantity has to be between 1 and 100" + "<br />" ;
            }

            if(isNaN(quantityInput)){
                errorMessage += "Quantity has to be a number value" + "<br />" ;
            }

            if(quantityInput === "" ){
                errorMessage += "Quantity cannot be empty\n" + "<br />" ;
            }

            if(instructionsInput.length  > 200 ){
                errorMessage += "Instructions cannot be greater than 200 characters" + "<br />" ;
            }

            ///////////////
            if(order_idInput == ""){
                errorMessage += "Lost track of order. Please try editing order again"  + "<br />" ;
            }

            if(fullnameInput.length == 0){
                errorMessage += "Name cannot be empty"  + "<br />" ;
            }

            if(emailInput.length == 0){
                errorMessage += "Email cannot be empty"  + "<br />" ;
            }

            if(homeaddressInput.length == 0){
                errorMessage += "Home Address cannot be empty"  + "<br />" ;
            }

            if(cityInput.length == 0){
                errorMessage += "City cannot be empty"  + "<br />" ;
            }

            if(stateInput.length == 0){
                errorMessage += "State cannot be empty"  + "<br />" ;
            }

            if(zipcodeInput.length == 0){
                errorMessage += "Zip Code cannot be empty" + "<br />" ;  
            }

            if(zipcodeInput.length > 5){
                errorMessage += "Zip Code cannot be greater that 5 numbers" + "<br />" ;  
            }

            if(isNaN(zipcodeInput)){
                errorMessage += "Zip Code has to be a number" + "<br />" ;  
            }

            //Output Error Message             
            if(errorMessage !== ""){
                document.querySelector(".error").style.display = 'block';
                document.querySelector(".error").innerHTML = errorMessage;
                console.log(errorMessage);
            }else{
                // Send a POST request via AJAX
                let toURL =  `quantity=${quantityInput}&instructions=${instructionsInput}&fullname=${fullnameInput}&email=${emailInput}&homeaddress=${homeaddressInput}&city=${cityInput}&state=${stateInput}&zipcode=${zipcodeInput}&order_id=${order_idInput}`;
                ajaxPost("updateOrder.php",toURL, function(results) {
                    let success = JSON.parse(results);
                    console.log(success);
                    if(success){
                        alert("Success Updating! Sending you to your orders.");
                        window.location.href = "currentorders.php";

                    }else{
                        alert("ERROR UPDATING ORDER. Try again!");
                        location.reload();
                    }
                });
                // END: Send a POST request via AJAX
            }
        }


    </script>
</body>

</html>