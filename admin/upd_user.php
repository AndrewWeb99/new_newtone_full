<?
session_start();
if ($_SESSION['user']['role'] != 'admin' or !isset($_SESSION['user'])) {
    $_SESSION['not_admin'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: white;">вы не имеете права администратора</div>';
    header("location: /login.php");
}
require_once '../settings/bd_connect.php';
require_once 'functions/functions.php';
if (isset($_GET['id'])) {
    $user = getUsers('WHERE id = ' . $_GET['id']);
    $user = $user[0];
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
                <h2>Изменить пользователя</h2><br><br>
                <?
                if (isset($_SESSION['update_user'])) {
                    echo $_SESSION['update_user'] . '<br>';
                    unset($_SESSION['update_user']);
                }
                ?>
                <div class="form" style="width: 50%;">
                    <form action="/admin/vendor/upd_user.php" method="POST">
                        <label for="">ФИО</label>
                        <input name="fio" type="text" value="<?= $user['fio'];?>"/><br>
                        <label for="">Номер</label>
                        <input name="number" type="text" value="<?= $user['number'];?>"/><br>
                        <label for="">Email</label>
                        <input name="email" type="text" value="<?= $user['email'];?>"/><br>
                        <label for="">Логин</label>
                        <input name="login" type="text" value="<?= $user['login'];?>"/><br />
                        <label for="">Тип</label>
                        <input name="role" type="text" disabled value="<?= $user['role'];?>"/><br />
                        <label for="">Сменить пароль</label>
                        <input name="password" type="text" /><br />
                        <input name="id" type="hidden" value="<?= $user['id'];?>">
                        <button type="submit" class="c-button">Изменить</button>
                    </form>
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