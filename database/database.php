<?php
require_once 'config.php';

function countbyStatuscode ($code)
{
    $query = "SELECT COUNT(*) AS count FROM crawl where status_code=" . $code;
    return get_query_result($query)->fetch_assoc()['count'];
}

function countbytype ($type)
{
    $query = "SELECT COUNT(*) AS count FROM crawl where type=" . $type;
    return get_query_result($query)->fetch_assoc()['count'];
}

function delete_crawl ($id) {
    $query= "DELETE FROM crawl WHERE id=" .$id;
    return get_query_result($query);
}

function insert_crawl ($data){
    $query = "INSERT INTO crawl (title, link, type, status_code ,created_at) VALUES ('".$data["title"]."','".$data["link"]."','".$data["type"]."','".$data["status_code"]."','". new DateTime()."')";
    return get_query_result($query);
}
?>