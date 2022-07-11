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
            <div class="category_list" style="margin-left: 20px;">
                <h2>Отзывы</h2><br><br>
                <table id="myTable" class="ui celled table stripe" style="width: 100%">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Дата</th>
                            <th>Изучить</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $review = getReview();
                        if (count($review) > 0) {
                            $number = 1;
                            foreach ($review as $r) {
                        ?>
                                <tr>
                                    <td><?= $number++; ?></td>
                                    <td><?= $r['name']; ?></td>
                                    <td><?= $r['email']; ?></td>
                                    <td><?= $r['date']; ?></td>
                                    <td><? if ($r['isRead'] == 1) {
                                            echo '<a href="/admin/open_review.php?id=' . $r['id'] . '" class="c-button" style="text-decoration: none; background-color: rgb(80, 80, 80);">Прочитано</a>';
                                        } else if ($r['isRead'] == 0) {
                                            echo '<a href="/admin/open_review.php?id=' . $r['id'] . '" class="c-button" style="text-decoration: none;">Прочитать</a>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                        <?
                            }
                        }else{
                            ?>
                            <td>Отзывов не найдено</td>
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