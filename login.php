<?
session_start();
require_once 'settings/bd_connect.php';
require_once 'count.php';
if (isset($_SESSION['user'])) {
  if ($_SESSION['user']['role'] == 'admin') {
    header("location: /admin/index.php");
  } else if ($_SESSION['user']['role'] == 'user') {
    header("location: /index.php");
  }
}
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
    <form action="/vendor/login.php" method="POST">
      <? if (isset($_SESSION['reg_user'])) {
        echo $_SESSION['reg_user'] . '<br>';
        unset($_SESSION['reg_user']);
      }
      if (isset($_SESSION['log_user'])) {
        echo $_SESSION['log_user'] . '<br>';
        unset($_SESSION['log_user']);
      }
      if (isset($_SESSION['not-admin'])) {
        echo $_SESSION['not-admin'] . '<br>';
        unset($_SESSION['not-admin']);
      }
      ?>
      <div class="dws-input">
        <input type="text" name="login" placeholder="Введите логин" required>
      </div>
      <div class="dws-input">
        <input type="password" name="password" placeholder="Введите пароль" required>
      </div>
      <input class="dws-submit" type="submit" name="submit" value="ВОЙТИ"><br />
      <a href="/regist.php">Регистрация</a><br>
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