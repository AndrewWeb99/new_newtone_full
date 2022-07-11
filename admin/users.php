<?
session_start();
if ($_SESSION['user']['role'] != 'admin' or !isset($_SESSION['user'])) {
    $_SESSION['not_admin'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: white;">вы не имеете права администратора</div>';
    header("location: /login.php");
}
require_once '../settings/bd_connect.php';
require_once 'functions/functions.php';
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
                <h2>Пользователи</h2><br><br>
                <?
                if (isset($_SESSION['block_user'])) {
                    echo $_SESSION['block_user'] . '<br>';
                    unset($_SESSION['block_user']);
                }
                ?>
                <table id="myTable" class="ui celled table stripe" style="width: 100%">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>ФИО</th>
                            <th>Номер</th>
                            <th>Email</th>
                            <th>Логин</th>
                            <th>Заблокировать</th>
                            <th>Удалить</th>
                            <th>Изменить</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $users = getUsers();
                        if (count($users) > 0) {
                            $number = 1;
                            foreach ($users as $u) {
                        ?>
                                <tr>
                                    <td><?= $number++; ?></td>
                                    <td><?= $u['fio']; ?></td>
                                    <td><?= $u['number']; ?></td>
                                    <td><?= $u['email']; ?></td>
                                    <td><?= $u['login']; ?></td>
                                    <td><? if ($u['status'] == 1) {
                                            echo '<a href="/admin/vendor/block_user.php?id=' . $u['id'] . '" class="c-button" style="text-decoration: none;">Заблокировать</a>';
                                        } else if ($u['status'] == 0) {
                                            echo '<a href="/admin/vendor/block_user.php?id=' . $u['id'] . '" class="c-button" style="text-decoration: none;">Разблокировать</a>';
                                        }
                                        ?>
                                    </td>
                                    <td><a href="/admin/vendor/del_user.php?id=<?= $u['id']; ?>" class="c-button" style="text-decoration: none; background-color: red;">Удалить</a></td>
                                    <td><a href="/admin/upd_user.php?id=<?= $u['id']; ?>" class="c-button" style="text-decoration: none;">Изменить</a></td>
                                </tr>
                            <?
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="8">Пользователей не найдено</td>
                            </tr>
                        <?
                        }
                        ?>

                    </tbody>
                </table>
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