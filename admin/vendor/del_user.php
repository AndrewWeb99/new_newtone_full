<?
session_start();
require_once '../../settings/bd_connect.php';
if (isset($_GET['id'])) {
    $sql = "DELETE FROM `users` WHERE id =" . $_GET['id'];
    $res = $mysqli->query($sql);
    if ($res == true) {
        $_SESSION['block_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Пользователь удален</div>';
        header("location: /admin/users.php");
    } else {
        $_SESSION['block_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка удаления</div>';
        header("location: /admin/users.php");
    }
}
