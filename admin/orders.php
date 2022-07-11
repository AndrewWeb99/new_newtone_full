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
                <h2>Заказы</h2><br><br>
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
                            <th>ФИО заказчика</th>
                            <th>Дата</th>
                            <th>Статус</th>
                            <th>Сумма</th>
                            <th>Детали/Изменить статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $orders = getOrders();
                        if (count($orders) > 0) {
                            $number = 1;
                            foreach ($orders as $o) {
                        ?>
                                <tr>
                                    <td><?= $number++; ?></td>
                                    <td><?
                                        $sql = "SELECT * FROM `users` WHERE `id` =" . $o['user_id'];
                                        $res = $mysqli->query($sql);
                                        $data = $res->fetch_assoc();
                                        echo $data['fio'];
                                        ?></td>
                                    <td><?= $o['date']; ?></td>
                                    <td><?= $o['status']; ?></td>
                                    <td><?= $o['total']; ?></td>
                                    <td><a href="/admin/upd_order.php?id=<?= $o['id']; ?>" class="c-button" style="text-decoration: none;">Открыть</a></td>
                                </tr>
                            <?
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="8">Заказов не найдено</td>
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