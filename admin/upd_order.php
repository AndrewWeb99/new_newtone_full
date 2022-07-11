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
    $order = getOrders('WHERE id = ' . $id);
    $order = $order[0];

    $prod_id = array();
    $prod_id = explode(";", $order['product_id']);

    $razm = array();
    $razm = explode(";", $order['razm']);
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
        <div class="main-content">
            <div class="category_list">
                <h2>Детали заказа №<?= $order['id']; ?></h2><br><br>
                <?
                if (isset($_SESSION['update_order_stat'])) {
                    echo $_SESSION['update_order_stat'] . '<br>';
                    unset($_SESSION['update_order_stat']);
                }
                ?>
                <div class="form" style="width: 50%;">
                    <form action="/admin/vendor/upd_order.php" method="POST">
                        <label for="">Изменить статус</label>
                        <input type="hidden" name="id" value="<?= $order['id']; ?>">
                        <div class="select" style="margin-bottom: 40px">
                            <select name="status" id="">
                                <option <?if ($order['status'] == "На оформлении")echo "selected";?> value="На оформлении">На оформлении</option>
                                <option <?if ($order['status'] == "Принят")echo "selected";?> value="Принят">Принят</option>
                                <option <?if ($order['status'] == "Ожидает отгрузки")echo "selected";?> value="Ожидает отгрузки">Ожидает отгрузки</option>
                                <option <?if ($order['status'] == "Доставляется")echo "selected";?> value="Доставляется">Доставляется</option>
                                <option <?if ($order['status'] == "Принят")echo "selected";?> value="Принят">Принят</option>
                                <option <?if ($order['status'] == "Отменен")echo "selected";?> value="Отменен">Отменен</option>
                            </select>
                        </div>
                        <button type="submit" class="c-button">Изменить</button>
                    </form>
                    <br />
                    <div class="order_item">
                        <p style="font-size: 20px;">Дата - <span><?= $order['date']; ?></span></p>
                        <p style="font-size: 20px;">Текущий статус - <span><?= $order['status']; ?></span></p>
                        <p style="font-size: 20px;">Сумма заказа - <span><?= $order['total']; ?> (₸)</span></p><br>
                        <table id="myTable" class="ui celled table stripe" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>№ товара</th>
                                    <th>Изображение</th>
                                    <th>Цена</th>
                                    <th>Размер</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                for ($i = 0; $i < count($prod_id); $i++) {
                                    $sql1 = "SELECT * FROM `products` WHERE `id` =" . $prod_id[$i];
                                    $res1 = $mysqli->query($sql1);
                                    $product = $res1->fetch_assoc();

                                ?>
                                    <tr>
                                        <td><?= $product['id']; ?></td>
                                        <td><img src="/img/product/<?= $product['img']; ?>" alt="" width="100px"></td>
                                        <td><?= $product['price']; ?> ₸</td>
                                        <td><?= $razm[$i]; ?></td>
                                    </tr>

                                <?
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
        let inputs = document.querySelectorAll('.input__file');
        Array.prototype.forEach.call(inputs, function(input) {
            let label = input.nextElementSibling,
                labelVal = label.querySelector('.input__file-button-text').innerText;

            input.addEventListener('change', function(e) {
                let countFiles = '';
                if (this.files && this.files.length >= 1)
                    countFiles = this.files.length;

                if (countFiles)
                    label.querySelector('.input__file-button-text').innerText = 'Выбрано файлов: ' + countFiles;
                else
                    label.querySelector('.input__file-button-text').innerText = labelVal;
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
    <script>
        let add_razm = document.getElementById('add_razm');
        let i = <?= count($array) - 1; ?>;
        add_razm.addEventListener('click', function() {
            i++;
            let input = document.createElement('input');
            input.setAttribute("type", "text");
            input.setAttribute("id", `razm${i}`);
            input.setAttribute("name", "razm[]");
            input.style.marginTop = '13px';
            input.style.marginBottom = '13px';
            input.classList.add('inp_to_del');
            input.setAttribute("data-inp", `razm${i}`);
            add_razm.after(input);
            let a = document.createElement('a');
            a.setAttribute("class", "c-button");
            a.setAttribute("data-elem", `razm${i}`);
            a.classList.add('delete');
            a.setAttribute("id", `del${i}`);
            a.innerHTML = 'Удалить';
            a.style.backgroundColor = 'red';
            a.style.textDecoration = 'none';
            input.after(a);
        })
        document.addEventListener('click', function(el) {
            if (el.target && el.target.classList.contains('delete')) {
                let inps = document.querySelectorAll('.inp_to_del');
                inps.forEach(element => {
                    if (element.dataset.inp == el.target.dataset.elem) {
                        element.remove();
                        el.target.remove();
                    }
                });
            }
        })
    </script>
</body>

</html>