<?
session_start();
require_once '../settings/bd_connect.php';
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user']['id'];
    $id = $_POST['id'];

    if (isset($_POST['radio'])) {
        $razm = $_POST['radio'];
    }
    if (isset($_POST['razmer'])) {
        $razm = $_POST['razmer'];
    }
    $sql = "INSERT INTO `basket` (`id`, `user_id`, `product_id`, `razm`) VALUES (NULL, $user, $id, '$razm')";
    $res = $mysqli->query($sql);
    if ($res == true) {
        $_SESSION['add_basket'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Товар в корзине</div>';
        $url = getallheaders()["Referer"];
        header('Location: ' . $url);

    } else {
        $_SESSION['add_basket'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка добавления</div>';
        $url = getallheaders()["Referer"];

        header('Location: ' . $url);
    }
} else {
    header("location: /login.php");
}
