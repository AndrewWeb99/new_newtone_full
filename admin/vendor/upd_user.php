<?
session_start();
require_once '../../settings/bd_connect.php';
require_once '../functions/functions.php';
$id = $_POST['id'];
$fio = $_POST['fio'];
$number = $_POST['number'];
$email = $_POST['email'];
$login = $_POST['login'];
$password = $_POST['password'];

if ($password == '') {
    $sql = "UPDATE `users` SET `fio` = '$fio', `number` = '$number', `email` = '$email', `login` = '$login' WHERE `users`.`id` = $id";
} else {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE `users` SET `fio` = '$fio', `number` = '$number', `email` = '$email', `login` = '$login', `password` = '$password' WHERE `users`.`id` = $id";
}

$res = $mysqli->query($sql);

if ($res == true) {
    $_SESSION['update_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Данные изменены</div>';
    header("location: /admin/upd_user.php?id=$id");
} else {
    $_SESSION['update_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка изменения</div>';
    header("location: /admin/upd_user.php?id=$id");
}
