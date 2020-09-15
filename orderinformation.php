<?php
if ( !isset($_POST['numOrders']) || empty($_POST['numOrders']) 
	|| !isset($_POST['item_id']) || empty($_POST['item_id'])
) {

	// Missing required fields.
	$error = "Please fill out all required fields.";

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Information</title>
    <link rel="stylesheet" type="text/css" href="shared.css">

    <script src="https://kit.fontawesome.com/52238bcdb6.js" crossorigin="anonymous"></script>
    <link rel="icon" 
      type="image/png" 
      href="images/favicon.png">
    <style type="text/css">
        .container {
            width: 90%;
            margin: 0 auto;
        }
        
        #order-information-p {
            text-align: center;
        }
        
        input,
        select {
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
        
        #button-container {
            max-width: 800px;
            margin: 30px auto;
            width: 90%;
            margin: 10px auto;
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
    <h1 id="order-information-p">Order Information</h1>
    <form action="orderplaced.php" method="POST" id="contact-form">

        <div class="container">
            <div class="input-div">

                <label for="fullname">Your Full Name</label><br>
                <input type="text" name="fullname" id="fullname" placeholder="Tommy Trojan" ><br>
            </div>
            <div class="input-div">

                <label for="email">Your Email Address</label><br>
                <input type="email" name="email" id="email" placeholder="ttrojan@usc.edu" ><br>
            </div>

            <hr>
        </div>

        <div class="container">
            <div class="input-div">

                <label for="homeaddress">Home Address</label><br>
                <input type="text" name="homeaddress" id="homeaddress" placeholder="3551 Trousdale Pkwy" ><br>
            </div>
            <div class="input-div">

                <label for="city">City</label><br>
                <input type="text" name="city" id="city" placeholder="Los Angeles" ><br>
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
                <input type="number" name="zipcode" id="zipcode" placeholder="90089" ><br>
            </div>
        </div>
        <input type="hidden" name="item_id" id="item_id" value="<?php echo $_POST["item_id"];?>">
        <input type="hidden" name="instructions" value="<?php echo $_POST["instructions"];?>">
        <input type="hidden" name="numOrders" id="numOrders" value="<?php echo $_POST["numOrders"];?>">

        <div class="error container"></div>

        <div id="button-container">
            <button type="submit" id="submit-button">Place Order</button>
        </div>
    </form>
    <script src="shared.js"></script>
    <script>

    function setStyles() {
        // 1. Grab the saved key/values pairs from local storage
        let savedName = localStorage.getItem("name");
        let savedEmail = localStorage.getItem("email");
        let savedAddress = localStorage.getItem("address");
        let savedCity = localStorage.getItem("city");
        let savedState = localStorage.getItem("state");
        let savedZipcode = localStorage.getItem("zipcode");

        // 2. Pre-fill the input tag and dropdown with saved values from the local storage
        document.querySelector("#fullname").value = savedName;
        document.querySelector("#email").value = savedEmail;
        document.querySelector("#homeaddress").value = savedAddress;
        document.querySelector("#city").value = savedCity;
        document.querySelector("#state").value = savedState;
        document.querySelector("#zipcode").value = savedZipcode;
    }

    // When user first loads the page, apply the styles right away using the saved values in storage
    // If no values are store in the storage, show default 
    if(localStorage.getItem("name")) {
        setStyles();
    }

    document.querySelector("#contact-form").onsubmit = function(event) {
        event.preventDefault();

        let fullnameValue = document.querySelector("#fullname").value;
        let emailValue = document.querySelector("#email").value;
        let homeaddressValue = document.querySelector("#homeaddress").value;
        let cityValue = document.querySelector("#city").value;
        let stateValue = document.querySelector("#state").value;
        let zipcodeValue = document.querySelector("#zipcode").value;
        let item_idValue = document.querySelector("#item_id").value;
        let quantityValue = document.querySelector("#numOrders").value;

            document.querySelector(".error").innerHTML = ""; //empty out previous error message

            let errorMessage = "";



            if(item_idValue == ""){
                errorMessage += "Lost track of item. Please reattempt ordering item"  + "<br />" ;
            }

            if(quantityValue == ""){
                errorMessage += "Quantity cannot be empty"  + "<br />" ;
            }

            if(fullnameValue.length == 0){
                errorMessage += "Name cannot be empty"  + "<br />" ;
            }

            if(emailValue.length == 0){
                errorMessage += "Email cannot be empty"  + "<br />" ;
            }

            if(homeaddressValue.length == 0){
                errorMessage += "Home Address cannot be empty"  + "<br />" ;
            }

            if(cityValue.length == 0){
                errorMessage += "City cannot be empty"  + "<br />" ;
            }

            if(stateValue.length == 0){
                errorMessage += "State cannot be empty"  + "<br />" ;
            }

            if(zipcodeValue.length == 0){
                errorMessage += "Zip Code cannot be empty" + "<br />" ;  
            }

            if(zipcodeValue.length > 5){
                errorMessage += "Zip Code cannot be greater that 5 numbers" + "<br />" ;  
            }

            if(isNaN(zipcodeValue)){
                errorMessage += "Zip Code has to be a number" + "<br />" ;  
            }

            //Output Error Message             
            if(errorMessage !== ""){
                document.querySelector(".error").style.display = 'block';
                document.querySelector(".error").innerHTML = errorMessage;
            }else{
                localStorage.setItem("name", fullnameValue);
                localStorage.setItem("email", emailValue);
                localStorage.setItem("address", homeaddressValue);
                localStorage.setItem("city", cityValue);
                localStorage.setItem("state", stateValue);
                localStorage.setItem("zipcode", zipcodeValue);
                setStyles()
                this.submit();
            }
    }
    </script>
</body>

</html>