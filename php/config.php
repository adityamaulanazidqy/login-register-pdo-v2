<?php

$hostName = "localhost";
$username = "root";
$password = "";
$dbName = "login_pdo_v2";

$dsn = "mysql:host=$hostName;dbname=$dbName";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error!" . $e->getMessage());
}
