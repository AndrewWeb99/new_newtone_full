<?
session_start();
require_once '../../settings/bd_connect.php';
require_once '../functions/functions.php';
if (isset($_GET['id'])) {
    $users = getUsers('WHERE id = ' . $_GET['id']);
    if ($users[0]['status'] == 1) {
        $sql = "UPDATE `users` SET `status` = '0' WHERE `users`.`id` =" . $_GET['id'];
    } else if ($users[0]['status'] == 0) {
        $sql = "UPDATE `users` SET `status` = '1' WHERE `users`.`id` =" . $_GET['id'];
    }
    $res = $mysqli->query($sql);

    if ($res == true) {
        $_SESSION['block_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Статус изменен</div>';
        header("location: /admin/users.php");
    } else {
        $_SESSION['block_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка изменения</div>';
        header("location: /admin/users.php");
    }
}
