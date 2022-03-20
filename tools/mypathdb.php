<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $serverName = "localhost";
    $userName = "root";
    $password = "";
    $dbName = "sistema";
}

if ($_SERVER['SERVER_NAME'] == 'www.gustabin.com') {
    $serverName = "localhost";
    $userName = "managerweb";
    $password = "superclave12345";
    $dbName = "gustabin-sistema";
}

//crear la conexión
$conn = mysqli_connect($serverName, $userName, $password, $dbName);
mysqli_set_charset($conn, 'utf8');

//chequear la conexión
if (!$conn) {
    $data = array('error' => '3');
    die(json_encode($data));
}

