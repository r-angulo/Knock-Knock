<?php

if ( !isset($_POST['quantity']) || empty($_POST['quantity']) 
    || !isset($_POST['fullname']) || empty($_POST['fullname'])
    || !isset($_POST['email']) || empty($_POST['email'])
    || !isset($_POST['homeaddress']) || empty($_POST['homeaddress'])
    || !isset($_POST['city']) || empty($_POST['city'])
    || !isset($_POST['state']) || empty($_POST['state'])
    || !isset($_POST['zipcode']) || empty($_POST['zipcode'])
    || !isset($_POST['order_id']) || empty($_POST['order_id'])
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

    $mysqli->set_charset('utf8');


    if ( isset($_POST['instructions']) && !empty($_POST['instructions']) ) {
        $instructions = $_POST['instructions'] ;
    } else {
        $instructions = "null";
    }

    $statement = $mysqli->prepare(
        "UPDATE orders
        SET orders.person_name = ?, orders.times_ordered = ?, orders.instructions = ?, 
            orders.time_placed = now(), orders.email_address = ?, orders.home_address = ?, 
            orders.city = ?, orders.state =?,orders.zip_code = ?
        WHERE orders.order_id = ?;"
    );

    $statement->bind_param("sisssssii", $_POST["fullname"],$_POST["quantity"],$instructions,
                            $_POST["email"],$_POST["homeaddress"],$_POST["city"],$_POST["state"],$_POST["zipcode"],$_POST["order_id"]);

    $executed = $statement->execute();
    if(!$executed) {
        echo $mysqli->error;
    }

    $isUpdated = false;
    if ($statement->affected_rows == 1) {
        $isUpdated = true;
    }
    $statement->close();

    $mysqli->close();



    echo json_encode($isUpdated);

}
?>