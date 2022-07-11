<?
session_start();
require_once '../settings/bd_connect.php';
require_once '../admin/functions/functions.php';
$id = $_POST['id'];
$nas = $_POST['nas'];
$street = $_POST['street'];
$house = $_POST['house'];
$kvart = $_POST['kvart'];

$sql2 = "SELECT * FROM `adresses` WHERE `user_id` = $id";
$res2 = $mysqli->query($sql2);
if (mysqli_num_rows($res2) > 0){
    $sql = "UPDATE `adresses` SET `nas` = '$nas', `street` = '$street', `house` = '$house', `kvart` = '$kvart' WHERE `adresses`.`user_id` = $id";
}else {
    $sql = "INSERT INTO `adresses` (`id`, `user_id`, `nas`, `street`, `house`, `kvart`) VALUES (NULL, $id, '$nas', '$street', '$house', '$kvart')";
}

$res = $mysqli->query($sql);

if ($res == true) {
    $_SESSION['update_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Данные изменены</div>';
    header("location: /cabinet.php");
} else {
    $_SESSION['update_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка изменения</div>';
    header("location: /cabinet.php");
}
