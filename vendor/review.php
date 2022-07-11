<?
session_start();
require_once '../settings/bd_connect.php';

$name = $_POST['name'];
$email = $_POST['email'];
$review = $_POST['review'];
$date_t = date('Y-m-d H:i:s');

$sql = "INSERT INTO `reviews` (`id`, `name`, `email`, `review`, `date`, `isRead`) VALUES (NULL, '$name', '$email', '$review', '$date_t', '0')";
$res = $mysqli->query($sql);
if ($res == true) {
    $_SESSION['add_review'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Отзыв отправлен</div>';
    $url = getallheaders()["Referer"];
    header('Location: ' . $url);
} else {
    $_SESSION['add_review'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка отправления</div>';
    $url = getallheaders()["Referer"];
    header('Location: ' . $url);
}
