<?
session_start();
require_once '../../settings/bd_connect.php';
require_once '../functions/functions.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $prod = getProduct('WHERE id = ' . $id);
    $prod =  $prod[0];
    if ($prod['status'] == 1) {
        $sql = "UPDATE `products` SET `status` = '0' WHERE `id` =" . $id;
    } else if ($prod['status'] == 0) {
        $sql = "UPDATE `products` SET `status` = '1' WHERE `id` =" . $id;
    }
    $res = $mysqli->query($sql);

    if ($res == true) {
        $_SESSION['block_prod'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Статус изменен</div>';
        header("location: /admin/products.php");
    } else {
        $_SESSION['block_prod'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка изменения</div>';
        header("location: /admin/products.php");
    }
}
