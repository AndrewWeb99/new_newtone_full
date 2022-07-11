<?php
header('Content-Type: text/html; charset=utf-8');
define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', 'root');
define('DB', 'newtone');

$mysqli = new mysqli(HOST, USERNAME, PASSWORD, DB);

if($mysqli->connect_error) {
    exit('Ошибка базы данных');
}
?>