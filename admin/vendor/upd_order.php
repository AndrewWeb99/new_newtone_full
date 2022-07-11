<?
session_start();
require_once '../../settings/bd_connect.php';
require_once '../functions/functions.php';
$id = $_POST['id'];
$status = $_POST['status'];


$sql = "UPDATE `orders` SET `status` = '$status' WHERE `orders`.`id` = " . $id;
$res = $mysqli->query($sql);

if ($res == true) {
    $_SESSION['update_order_stat'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Данные изменены</div>';
    $url = getallheaders()["Referer"];
    header('Location: ' . $url);
} else {
    $_SESSION['update_order_stat'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка изменения</div>';
    $url = getallheaders()["Referer"];
    header('Location: ' . $url);
}
