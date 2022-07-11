<?
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/login.css">
  <title>NewTone</title>
</head>

<body>
  <div class="container">
    <img src="/img/men.png">
    <form action="/vendor/add_user.php" method="post">
      <? if (isset($_SESSION['reg_user'])) {
        echo $_SESSION['reg_user'];
        unset($_SESSION['reg_user']);
      } ?>
      <div class="dws-input">
        <input type="text" name="login" placeholder="Введите логин" required>
      </div>
      <div class="dws-input">
        <input type="password" name="password" placeholder="Введите пароль" required>
      </div>
      <div class="dws-input">
        <input type="text" name="fio" placeholder="ФИО" required>
      </div>
      <div class="dws-input">
        <input type="text" name="number" placeholder="Номер телефона" required>
      </div>
      <div class="dws-input">
        <input type="text" name="email" placeholder="Email" required>
      </div>
      <input class="dws-submit" type="submit" name="submit" value="Зарегистрироваться"><br />
      <a href="/login.php">Авторизация</a><br>
      <a href="/index.php">Вернуться на сайт</a><br>
    </form>
    <div class="dws-social">
      <i class="fa fa-vk" aria-hidden="true"></i>
      <i class="fa fa-twitter" aria-hidden="true"></i>
      <i class="fa fa-facebook" aria-hidden="true"></i>
      <i class="fa fa-google-plus-official" aria-hidden="true"></i>
      <i class="fa fa-odnoklassniki" aria-hidden="true"></i>
    </div>
  </div>
  <script src="https://kit.fontawesome.com/bd24e9c30d.js" crossorigin="anonymous"></script>
</body>

</html>