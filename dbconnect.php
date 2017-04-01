<?php

        $server = "us-cdbr-iron-east-03.cleardb.net";
            $username = "b8362f7492b419";
            $password = "b790c879";
            $dbname = "ad_4b9db46d62be7e3";

$mysqli = new mysqli($server, $username, $password, $dbname);

    if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
	}

?>
