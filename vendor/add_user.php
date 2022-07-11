<?
session_start();
require_once '../settings/bd_connect.php';
$fio = $_POST['fio'];
$number = $_POST['number'];
$email = $_POST['email'];
$login = $_POST['login'];
$password = $_POST['password'];
$password = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO `users` (`id`, `fio`, `number`, `email`, `login`, `password`, `role`, `status`) VALUES (NULL, '$fio', '$number', '$email', '$login', '$password', 'user', 1)";
$res = $mysqli->query($sql);
if ($res == true) {
    $_SESSION['reg_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: white;">Регистрация успешна</div>';
    header("location: /login.php");
} else {
    $_SESSION['reg_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: white;">Ошибка регистрации</div>';
    header("location: /regist.php");
}
?>
