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
                <h2>Категории</h2><br><br>
                <?
                if (isset($_SESSION['create_cat'])) {
                    echo $_SESSION['create_cat'] . '<br>';
                    unset($_SESSION['create_cat']);
                }
                if (isset($_SESSION['delete_cat'])) {
                    echo $_SESSION['delete_cat'] . '<br>';
                    unset($_SESSION['delete_cat']);
                }
                if (isset($_SESSION['block_cat'])) {
                    echo $_SESSION['block_cat'] . '<br>';
                    unset($_SESSION['block_cat']);
                }
                ?>
                <a href="/admin/add_category.php" class="c-button" style="text-decoration: none;">Добавить</a><br><br>
                <table id="myTable" class="ui celled table stripe" style="width: 100%">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Название</th>
                            <th>Изображение</th>
                            <th>Заблокировать</th>
                            <th>Удалить</th>
                            <th>Изменить</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $category = getCategory();
                        if (count($category) > 0) {
                            $number = 1;
                            foreach ($category as $c) {
                        ?>
                                <tr>
                                    <td><?= $number++; ?></td>
                                    <td><?= $c['title']; ?></td>
                                    <td><img src="/img/category/<?= $c['img']; ?>" alt="" width="100px"></td>
                                    <td><? if ($c['status'] == 1) {
                                            echo '<a href="/admin/vendor/block_cat.php?id=' . $c['id'] . '" class="c-button" style="text-decoration: none;">Заблокировать</a>';
                                        } else if ($c['status'] == 0) {
                                            echo '<a href="/admin/vendor/block_cat.php?id=' . $c['id'] . '" class="c-button" style="text-decoration: none;">Разблокировать</a>';
                                        }
                                        ?>
                                    </td>
                                    <td><a href="/admin/vendor/del_category.php?id=<?= $c['id']; ?>" class="c-button" style="text-decoration: none; background-color: red;">Удалить</a></td>
                                    <td><a href="/admin/upd_category.php?id=<?= $c['id']; ?>" class="c-button" style="text-decoration: none;">Изменить</a></td>
                                </tr>
                        <?
                            }
                        }else{
                            ?>
                            <td>Категории не найдено</td>
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
    <script>
        $(function() {
            var height = $('.main-content').height();
            $('.sidebar-menu').height(height);
        });
        $('.main-content').bind("DOMSubtreeModified", function() {
            $(function() {
                var height = $('.main-content').height();
                $('.sidebar-menu').height(height);
            });
        });
    </script>
</body>

</html>