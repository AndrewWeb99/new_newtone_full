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
    $cat = getCategory('WHERE id =' . $id);
    if (count($cat) == 1){
        $cat = $cat[0];
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
                <h2>Изменить категорию</h2><br><br>
                <?
                if (isset($_SESSION['img_error'])) {
                    echo $_SESSION['img_error'] . '<br>';
                    unset($_SESSION['img_error']);
                }
                if (isset($_SESSION['update_cat'])) {
                    echo $_SESSION['update_cat'] . '<br>';
                    unset($_SESSION['update_cat']);
                }
                ?>
                <div class="form" style="width: 50%;">
                    <form action="/admin/vendor/upd_category.php" method="POST" enctype="multipart/form-data">
                        <label for="">Название</label>
                        <input name="title" type="text" value="<?= $cat['title'];?>" /><br>
                        <label for="">Текущее изображение</label><br><br>
                        <img src="/img/category/<?= $cat['img']; ?>" alt="" width="300px"><br><br>
                        <label for="">Новое изображение</label><br><br>
                        <div class="input__wrapper">
                            <input name="img" type="file" id="input__file" class="input input__file" multiple>
                            <label for="input__file" class="input__file-button">
                                <span class="input__file-icon-wrapper"><img class="input__file-icon" src="/img/add.svg" alt="Выбрать файл" width="25"></span>
                                <span class="input__file-button-text">Выберите файл</span>
                            </label>
                        </div><br><br>
                        <input name="id" type="hidden" value="<?= $cat['id'];?>" />
                        <input name="old_img" type="hidden" value="<?= $cat['img']; ?>" />
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
</body>

</html>