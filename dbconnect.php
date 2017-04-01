<?php

	$server = "localhost";
	$username = "root";
	$password = "";
	$dbname = "airport";
    $mysqli = new mysqli($server, $username, $password, $dbname);

    if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
	}
// $con=mysqli_connect("localhost","root","","supercoders");
// $check="SELECT * FROM userdet WHERE uticket = '1403'";
// $rs = mysqli_query($con,$check);
// $data = mysqli_fetch_array($rs, MYSQLI_NUM);
// if($data[0] > 0) {
//     echo json_encode($data);

// }

?>