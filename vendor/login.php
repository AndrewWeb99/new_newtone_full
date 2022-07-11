<?
session_start();
require_once '../settings/bd_connect.php';
$login = $_POST['login'];
$password = $_POST['password'];
$sql = "SELECT * FROM users WHERE login = '$login'";
$res = $mysqli->query($sql);
if ($c = mysqli_num_rows($res) == 1) {
    $data = mysqli_fetch_assoc($res);
    if (password_verify($password, $data['password'])) {
        if ($data['status'] == '1') {
            if ($data['role'] == 'user') {
                $_SESSION["user"] = [
                    "id" => $data["id"],
                    "fio" => $data["fio"],
                    "number" => $data["number"],
                    "email" => $data["email"],
                    "login" => $data["login"],
                    "role" => $data["role"],
                    "status" => $data["status"]
                ];
                header("location: /cabinet.php");
            } else {
                $_SESSION["user"] = [
                    "id" => $data["id"],
                    "fio" => $data["fio"],
                    "number" => $data["number"],
                    "email" => $data["email"],
                    "login" => $data["login"],
                    "role" => $data["role"],
                    "status" => $data["status"]
                ];
                header("location: /admin/index.php");
            }
        } else {
            $_SESSION['log_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: white;">Пользователь заблокирован</div>';
            header("location: /login.php");
        }
    } else {
        $_SESSION['log_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: white;">Неверный логин или пароль</div>';
        header("location: /login.php");
    }
} else {
    $_SESSION['log_user'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: white;">Ошибка входа</div>';
    header("location: /login.php");
}
