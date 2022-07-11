<?
session_start();
require_once '../settings/bd_connect.php';
if (isset($_SESSION['user'])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM `basket` WHERE `basket`.`id` = $id";
        $res = $mysqli->query($sql);
        if ($res == true) {
            $_SESSION['del_basket'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Товар удален</div>';
            $url = getallheaders()["Referer"];
            header('Location: ' . $url);
        } else {
            $_SESSION['del_basket'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка удаления</div>';
            $url = getallheaders()["Referer"];
            header('Location: ' . $url);
        }
    }
} else {
    header("location: /login.php");
}
