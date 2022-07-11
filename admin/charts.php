<?
session_start();
if ($_SESSION['user']['role'] != 'admin' or !isset($_SESSION['user'])) {
    $_SESSION['not_admin'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: white;">вы не имеете права администратора</div>';
    header("location: /login.php");
}
require_once '../settings/bd_connect.php';
require_once 'functions/functions.php';
$sql1 = "SELECT COUNT(*), MONTH(date) FROM `orders` GROUP BY MONTH(date)";
$res1 = $mysqli->query($sql1);
$orders = array();
while ($data = $res1->fetch_assoc()) {
    $orders[] = $data;
}
$rev = getReview();
$us = getUsers();
//Всего просмотров
$sql2 = "SELECT views FROM `visits`";
$res2 = $mysqli->query($sql2);
$view = 0;
while ($data = $res2->fetch_assoc()) {
    $view = $view + $data['views'];
}
//За последний день
$sql3 = "SELECT * FROM `visits` WHERE (DATE(NOW()) - `date`) = 1";
$res3 = $mysqli->query($sql3);
$day = mysqli_num_rows($res3);

//Всего уникальных
$sql4 = "SELECT * FROM `visits`";
$res4 = $mysqli->query($sql4);
$all = mysqli_num_rows($res4);

//За неделю
$sql5 = "SELECT * FROM `visits` WHERE (DATE(NOW()) - `date`) <= 7";
$res5 = $mysqli->query($sql5);
$week = mysqli_num_rows($res5);

//За месяц
$sql6 = "SELECT * FROM `visits` WHERE (DATE(NOW()) - `date`) <= 31";
$res6 = $mysqli->query($sql6);
$month = mysqli_num_rows($res6);

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
            <h2 style="margin-left: 20px;">Статистика</h2><br><br>
            <div class="chart_oneline">
                <div class="chart_item_one chart_visitor">
                    <div class="chart_visitor_img">
                        <img src="/img/user_admin.png" alt="" width="100px">
                    </div>
                    <div class="chart_visitor_text">
                        <h2>Количество открытий страниц</h2>
                        <p style="font-size: 15px; font-weight:700;">Всего - <span><?= $view; ?></span></p>
                    </div>
                </div>
                <div class="chart_item_one chart_review">
                    <div class="chart_review_img">
                        <img src="/img/email_PNG51 (1).png" alt="" width="100px">
                    </div>
                    <div class="chart_review_text">
                        <h2>Количество отзывов</h2>
                        <p style="font-size: 35px; font-weight:700;"><?= count($rev); ?></p>
                    </div>
                </div>
                <div class="chart_item_one chart_user">
                    <div class="chart_user_img">
                        <img src="/img/men.png" alt="" width="100px">
                    </div>
                    <div class="chart_user_text">
                        <h2>Количество клиентов</h2>
                        <p style="font-size: 35px; font-weight:700;"><?= count($us); ?></p>
                    </div>
                </div>
                <div class="chart_item_one chart_cal">
                    <!--Dayspedia.com widget--><iframe width='316' height='100%' style='padding:0!important;margin:0!important;border:none!important;background:none!important;background:transparent!important' marginheight='0' marginwidth='0' frameborder='0' scrolling='no' comment='/*defined*/' src='https://dayspedia.com/if/digit/?v=1&iframe=eyJ3LTEyIjpmYWxzZSwidy0xMSI6dHJ1ZSwidy0xMyI6dHJ1ZSwidy0xNCI6ZmFsc2UsInctMTUiOmZhbHNlLCJ3LTExMCI6ZmFsc2UsInctd2lkdGgtMCI6ZmFsc2UsInctd2lkdGgtMSI6dHJ1ZSwidy13aWR0aC0yIjpmYWxzZSwidy0xNiI6IjI0cHgiLCJ3LTE5IjoiNDgiLCJ3LTE3IjoiMTYiLCJ3LTIxIjp0cnVlLCJiZ2ltYWdlIjowLCJiZ2ltYWdlU2V0Ijp0cnVlLCJ3LTIxYzAiOiIjZmZmZmZmIiwidy0wIjp0cnVlLCJ3LTMiOnRydWUsInctM2MwIjoiIzM0MzQzNCIsInctM2IwIjoiMSIsInctNiI6IiMzNDM0MzQiLCJ3LTIwIjp0cnVlLCJ3LTQiOiIjMDA1NWZmIiwidy0xOCI6ZmFsc2UsInctd2lkdGgtMmMtMCI6IjMwMCIsInctMTE1IjpmYWxzZX0=&lang=ru&cityid=6661'></iframe>
                    <!--Dayspedia.com widget ENDS-->
                </div>
            </div>
            <div class="chart_twoline">
                <div><canvas id="myChart"></canvas></div>
                <div><canvas id="myCharts"></canvas></div>

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- График первый -->
    <script>
        var jArray = <?php echo json_encode($orders); ?>;
        const arrays = new Array();
        for (let i = 0; i < 12; i++) {
            arrays[i] = 0;
        }

        jArray.forEach(element => {
            for (let j = 0; j < arrays.length; j++) {
                if (j == element['MONTH(date)']) {
                    arrays[j] = element['COUNT(*)'];
                }
            }
        });
        console.log(arrays);
        let d = arrays.toString();
        console.log(d);
        const data = {
            labels: [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь",
            ],
            datasets: [{
                label: "Количество заказов",
                backgroundColor: "rgb(255, 99, 132)",
                borderColor: "rgb(255, 99, 132)",
                data: arrays,
            }, ],
        };


        const config = {
            type: "line",
            data: data,
            options: {},
        };
        const myChart = new Chart(document.getElementById("myChart"), config);
    </script>
    <script>
        const data1 = {
            labels: [
                "Уникальных",
                "Сегодня",
                "За неделю",
                "За месяц"
            ],
            datasets: [{
                label: 'Статистика посещений',
                data: [<?= $all; ?>, <?= $day; ?>, <?= $week; ?>, <?= $month; ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                ],
                borderWidth: 1
            }]
        };
        const config1 = {
            type: 'bar',
            data: data1,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        };
        const myCharts1 = new Chart(document.getElementById("myCharts"), config1);
    </script>

</body>

</html>