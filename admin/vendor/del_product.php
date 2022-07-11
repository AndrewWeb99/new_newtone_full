<?
session_start();
require_once '../../settings/bd_connect.php';
require_once '../functions/functions.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $prod = getProduct('WHERE id =' . $id);
    if (count($prod) == 1) {
        $img = $prod[0]['img'];
        $path = '../../img/product/' . $img;
        unlink($path);
        $sql = "DELETE FROM `products` WHERE id =" . $id;
        $res = $mysqli->query($sql);
        if ($res == true) {
            $_SESSION['delete_prod'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Продукт удален</div>';
            header("location: /admin/products.php");
        } else {
            $_SESSION['delete_prod'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка удаления</div>';
            header("location: /admin/products.php");
        }
    }
}
