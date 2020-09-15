<?php

if ( !isset($_POST['order_id']) || empty($_POST['order_id'])) {

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

    $sql = "DELETE FROM orders WHERE orders.order_id =" . $_POST['order_id'] .";";

	$results = $mysqli->query($sql);
	if (!$results) {
		echo $mysqli->error;
		exit();
    }
    
    $isDeleted = false;
	if ($mysqli->affected_rows == 1) {
		$isDeleted = true;
	}
	$mysqli->close();


    echo json_encode($isDeleted);
}
?>