<?php
require_once 'config.php';

$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);
if($connection -> connect_errno) {
    die("Error in database connection");
}
$query = "CREATE DATABASE IF NOT EXISTS crawl;";

if ($connection->query($query) === TRUE) {
    echo "Database successfully Create" . PHP_EOL;
} else {
    echo "Error creating database: " . $connection->error;
}
$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

$mysqli = "CREATE TABLE crawl (
id int primary key NOT NULL AUTO_INCREMENT,
title varchar(255),
link varchar(255) NOT NULL,
status_code int NOT NULL, 
type enum('image','link'),
created_at timestamp NOT NULL
);";

if ($connection->query($mysqli) === TRUE) {
    echo "Table successfully Create";
} else {
    echo "Error creating table: " . $connection->error;
}

$connection->close();
?>

