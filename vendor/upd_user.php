<?
session_start();
require_once '../settings/bd_connect.php';
require_once '../admin/functions/functions.php';
$id = $_POST['id'];
$fio = $_POST['fio'];
$number = $_POST['number'];
$email = $_POST['email'];
$login = $_POST['login'];
$password = $_POST['password'];
$status = $_POST['status'];
$role = $_POST['role'];

if ($password == '') {
    $sql = "UPDATE `users` SET `fio` = '$fio', `number` = '$number', `email` = '$email', `login` = '$login' WHERE `users`.`id` = $id";
    $_SESSION["user"] = [
        "id" => $id,
        "fio" => $fio,
        "number" => $number,
        "email" => $email,
        "login" => $login,
        "role" => $role,
        "status" => $status
    ];
} else {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE `users` SET `fio` = '$fio', `number` = '$number', `email` = '$email', `login` = '$login', `password` = '$password' WHERE `users`.`id` = $id";
    $_SESSION["user"] = [
        "id" => $id,
        "fio" => $fio,
        "number" => $number,
        "email" => $email,
        "login" => $login,
        "role" => $role,
        "status" => $status
    ];
}

$res = $mysqli->query($sql);

if ($res == true) {
    $_SESSION['update_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Данные изменены</div>';
    header("location: /cabinet.php");
} else {
    $_SESSION['update_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка изменения</div>';
    header("location: /cabinet.php");
}
