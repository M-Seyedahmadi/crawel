<?php
const DB_HOST = '127.0.0.1';
const DB_DATABASE = 'crawl';
const DB_USER = 'root';
const DB_PASSWORD = '';
const DB_PORT = '3306';

function init(){
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);
    if($connection -> connect_errno) {
        die("Error in database connection");
    }
    return $connection;
}

function get_query_result($query){
    $connection = init();
    $result = $connection -> query($query);
    $connection->close();
    return $result;
}
?>
