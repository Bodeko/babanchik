<?php
define("hostname", "localhost");
define("user", "Cat");
define("password", "1618");
define("database", "freelance");

function db_connect()
{
    return mysqli_connect(hostname, user, password, database);
}

$mysqli = db_connect();
$mysqli->query("SET SQL_SAFE_UPDATES = 0");
?>