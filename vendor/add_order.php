<?
session_start();
require_once '../settings/bd_connect.php';
$total = $_GET['total'];
global $mysqli;
$user_id = $_SESSION['user']['id'];
$sql2 = "SELECT * FROM `basket` WHERE `user_id` = " . $user_id;

$res2 = $mysqli->query($sql2);
$bask = array();
while ($data = $res2->fetch_assoc()) {
    $bask[] = $data;
}
$prod;
$razm;
foreach ($bask as $b) {
    $prod = $prod . $b['product_id'] . ';';
    $razm = $razm . $b['razm'] . ';';
}
$prod = rtrim($prod, ';');
$razm = rtrim($razm, ';');
$date_t = date('Y-m-d H:i:s');


$sql = "INSERT INTO `orders` (`id`, `user_id`, `product_id`, `razm`, `date`, `status`, `total`) VALUES (NULL, '$user_id', '$prod', '$razm', '$date_t', 'На оформлении', $total)";
$res = $mysqli->query($sql);
if ($res == true) {
    $sql3 = "DELETE FROM `basket` WHERE `basket`.`user_id` = " . $user_id;
    $res3 = $mysqli->query($sql3);
    $_SESSION['order_upd'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Заказ отправлен</div>';
    header("location: /cabinet.php");
} else {
    $_SESSION['order_upd'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка отправления</div>';
    header("location: /cabinet.php");
}
