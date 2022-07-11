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
        <div class="main-content">
            <div class="category_list">
                <h2>Добавить изделие</h2><br><br>
                <?
                if (isset($_SESSION['img_error'])) {
                    echo $_SESSION['img_error'] . '<br>';
                    unset($_SESSION['img_error']);
                }
                ?>
                <div class="form" style="width: 50%;">
                    <form action="/admin/vendor/add_product.php" method="POST" enctype="multipart/form-data">
                        <label for="">Название</label>
                        <input name="title" type="text" value="" /><br>
                        <label for="">Изображение</label><br><br>
                        <div class="input__wrapper">
                            <input name="img" type="file" id="input__file" class="input input__file" multiple>
                            <label for="input__file" class="input__file-button">
                                <span class="input__file-icon-wrapper"><img class="input__file-icon" src="/img/add.svg" alt="Выбрать файл" width="25"></span>
                                <span class="input__file-button-text">Выберите файл</span>
                            </label>
                        </div><br>
                        <label for="">Цена</label>
                        <input name="price" type="text" value="" /><br>
                        <label for="">Категория</label>
                        <div class="select" style="margin-bottom: 40px">
                        <select name="category_id" id="">
                            <?
                            $cat = getCategory();
                            if (count($cat) > 0) {
                                $number = 1;
                                foreach ($cat as $c) {
                            ?>
                                    <option value="<?= $c['id']; ?>"><?= $c['title']; ?></option>
                            <?
                                }
                            }
                            ?>
                        </select>
                        </div>
                        <label for="">Размер </label><a id="add_razm" class="c-button">Добавить</a><br><br>
                        <label for="">Описание</label>
                        <textarea name="description" id="" cols="30" rows="10"></textarea><br>
                        <label for="">Материал</label>
                        <input name="material" type="text" value="" /><br>
                        <label for="">Страна</label>
                        <input name="country" type="text" value="" /><br>
                        <button type="submit" class="c-button">Добавить</button>
                    </form>
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
        let i = 0;
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