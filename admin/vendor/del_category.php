<?
session_start();
require_once '../../settings/bd_connect.php';
require_once '../functions/functions.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $cat = getCategory('WHERE id =' . $id);
    if (count($cat) == 1) {
        $img = $cat[0]['img'];
        $path = '../../img/category/' . $img;
        unlink($path);
        $sql = "DELETE FROM `category` WHERE id =" . $id;
        $res = $mysqli->query($sql);
        if ($res == true) {
            $_SESSION['delete_cat'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Категория удалена</div>';
            header("location: /admin/category.php");
        } else {
            $_SESSION['delete_cat'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка удаления</div>';
            header("location: /admin/category.php");
        }
    }
}
