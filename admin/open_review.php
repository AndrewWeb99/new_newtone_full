<?
session_start();
if ($_SESSION['user']['role'] != 'admin' or !isset($_SESSION['user'])) {
    $_SESSION['not_admin'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: white;">вы не имеете права администратора</div>';
    header("location: /login.php");
}
require_once '../settings/bd_connect.php';
require_once 'functions/functions.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $rev = getReview('WHERE id =' . $id);

    if (count($rev) == 1) {
        $rev = $rev[0];
    }

    if ($rev['isRead'] == 0) {
        $sql = "UPDATE `reviews` SET `isRead` = 1 WHERE `reviews`.`id` = $id";
        $res = $mysqli->query($sql);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">

    <link rel="stylesheet" href="/css/admin.css">

    <title>Админ панель</title>
</head>

<body>
    <div class="container">

        <!-- Заголовок -->
        <? require_once 'blocks/header.php'; ?>

        <!-- Левое меню -->
        <? require_once 'blocks/nav.php'; ?>

        <!-- Главный контент -->
        <main class="main-content">
            <div class="category_list">
                <h2>Отзыв</h2><br><br>
                <div class="form" style="width: 50%;">
                    <label for="">Имя</label>
                    <input name="title" type="text" value="<?= $rev['name']; ?>" readonly /><br>
                    <label for="">Email</label>
                    <input name="title" type="text" value="<?= $rev['email']; ?>" readonly /><br>
                    <label for="">Дата</label>
                    <input name="title" type="text" value="<?= $rev['date']; ?>" readonly /><br>
                    <label for="">Сообщение</label>
                    <textarea name="" id="" cols="30" rows="10" readonly><?= $rev['review']; ?></textarea><br>
                </div>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://kit.fontawesome.com/bd24e9c30d.js" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $('.sidebar-menu__item-title').click(function() {
                $(this).find('+ .sidebar-menu__subitems').slideToggle('fast');
                $(this).find('i').toggleClass('fa-caret-down');
            });

        });
    </script>

</body>

</html>