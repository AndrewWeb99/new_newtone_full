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
                <h2>Изделия</h2><br><br>
                <?
                if (isset($_SESSION['create_prod'])) {
                    echo $_SESSION['create_prod'] . '<br>';
                    unset($_SESSION['create_prod']);
                }
                if (isset($_SESSION['update_prod'])) {
                    echo $_SESSION['update_prod'] . '<br>';
                    unset($_SESSION['update_prod']);
                }
                if (isset($_SESSION['block_prod'])) {
                    echo $_SESSION['block_prod'] . '<br>';
                    unset($_SESSION['block_prod']);
                }
                if (isset($_SESSION['delete_prod'])) {
                    echo $_SESSION['delete_prod'] . '<br>';
                    unset($_SESSION['delete_prod']);
                }
                ?>
                <a href="/admin/add_product.php" class="c-button" style="text-decoration: none;">Добавить</a><br><br>
                <table id="myTable" class="table" style=" min-width:0;">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Название</th>
                            <th>Изображение</th>
                            <th>Цена</th>
                            <th>Доступные размеры</th>
                            <th>Категория</th>
                            <th>Заблокировать</th>
                            <th>Удалить</th>
                            <th>Изменить</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $product = getProduct();
                        if (count($product) > 0) {
                            $number = 1;
                            foreach ($product as $p) {
                        ?>
                                <tr>
                                    <td><?= $number++; ?></td>
                                    <td><?= $p['title']; ?></td>
                                    <td><img src="/img/product/<?= $p['img']; ?>" alt="" width="100px"></td>
                                    <td><?= $p['price']; ?></td>
                                    <td><?= $p['razm']; ?></td>

                                    <td><?
                                        $cat = getCategory('WHERE id =' . $p['category_id']);
                                        if (count($cat) == 1) {
                                            echo $cat[0]['title'];;
                                        }
                                        ?></td>

                                    <td><? if ($p['status'] == 1) {
                                            echo '<a href="/admin/vendor/block_prod.php?id=' . $p['id'] . '" class="c-button" style="text-decoration: none;">Заблокировать</a>';
                                        } else if ($p['status'] == 0) {
                                            echo '<a href="/admin/vendor/block_prod.php?id=' . $p['id'] . '" class="c-button" style="text-decoration: none;">Разблокировать</a>';
                                        }
                                        ?>
                                    </td>
                                    <td><a href="/admin/vendor/del_product.php?id=<?= $p['id']; ?>" class="c-button" style="text-decoration: none; background-color: red;">Удалить</a></td>
                                    <td><a href="/admin/upd_product.php?id=<?= $p['id']; ?>" class="c-button" style="text-decoration: none;">Изменить</a></td>
                                </tr>
                            <?
                            }
                        } else {
                            ?>
                            <td>Изделий не найдено</td>
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