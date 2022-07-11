<?
session_start();
require_once '../settings/bd_connect.php'; 
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user']['id'];
    $id = $_GET['id'];

    $sql = "INSERT INTO `likes` (`id`, `user_id`, `product_id`) VALUES (NULL, '$user', '$id')";
    $res = $mysqli->query($sql);
    if ($res == true) {
        $_SESSION['add_like'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Товар в избранном</div>';
        $url = getallheaders()["Referer"];
        header('Location: ' . $url);
    } else {
        $_SESSION['add_like'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка добавления</div>';
        $url = getallheaders()["Referer"];
        header('Location: ' . $url);
    }
} else {
    header("location: /login.php");
}
