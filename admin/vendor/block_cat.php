<?
session_start();
require_once '../../settings/bd_connect.php';
require_once '../functions/functions.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $cat = getCategory('WHERE id = ' . $id);
    $cat =  $cat[0];
    if ($cat['status'] == 1) {
        $sql = "UPDATE `category` SET `status` = '0' WHERE `id` =" . $id;
    } else if ($cat['status'] == 0) {
        $sql = "UPDATE `category` SET `status` = '1' WHERE `id` =" . $id;
    }
    $res = $mysqli->query($sql);

    if ($res == true) {
        $_SESSION['block_cat'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Статус изменен</div>';
        header("location: /admin/category.php");
    } else {
        $_SESSION['block_cat'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка изменения</div>';
        header("location: /admin/category.php");
    }
}
