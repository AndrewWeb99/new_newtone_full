<?
session_start();
require_once 'settings/bd_connect.php';
require_once 'count.php';
require_once 'admin/functions/functions.php';
if (isset($_SESSION['user'])) {
} else {
  header("location: /login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NewTone</title>
  <link rel="stylesheet" href="/css/main.css" />
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <link rel="stylesheet" href="/css/hystmodal.min.css" />
</head>

<body>
  <div class="main">
    <? require_once 'blocks/header.php'; ?>

    <section class="cabinet">
      <div class="container">
        <div class="cabinet_order">
          <? if (isset($_SESSION['update_user'])) {
            echo $_SESSION['update_user'] . '<br>';
            unset($_SESSION['update_user']);
          }
          if (isset($_SESSION['order_upd'])) {
            echo $_SESSION['order_upd'] . '<br>';
            unset($_SESSION['order_upd']);
          } 
          ?>
          <h2>История заказов</h2>
          <br />
          <div class="order_item">
            <table id="myTable" class="ui celled table stripe" style="width: 100%">
              <thead>
                <tr>
                  <th>№</th>
                  <th>Дата</th>
                  <th>Сумма</th>
                  <th>Детали</th>
                </tr>
              </thead>
              <tbody>
                <?
                $num = 1;
                $sql3 = "SELECT * FROM `orders` WHERE `user_id` =" . $_SESSION['user']['id'];
                $res3 = $mysqli->query($sql3);
                $order = array();
                while ($data3 = $res3->fetch_assoc()) {
                  $order[] = $data3;
                }
                foreach ($order as $o) {
                ?>
                  <tr>
                    <td><?= $num++; ?></td>
                    <td><?= $o['date']; ?></td>
                    <td><?= $o['total']; ?></td>
                    <td><a href="/order_details.php?id=<?= $o['id']; ?>" class="c-button" style="text-decoration: none;">Открыть</a></td>
                  </tr>
                <?
                }
                ?>

              </tbody>
            </table>
          </div>
          <br /><br />
          <h2>Адрес доставки</h2>
          <br />
          <div class="address">
            <?
            $sql = "SELECT * FROM `adresses` WHERE `user_id` =" . $_SESSION['user']['id'];
            $res = $mysqli->query($sql);
            $data = $res->fetch_assoc();
            ?>
            <form action="/vendor/upd_adress.php" method="POST">
              <label for="">Населенный пункт</label>
              <input type="text" name="nas" value="<?= $data['nas']; ?>" />
              <label for="">Улица</label>
              <input type="text" name="street" value="<?= $data['street']; ?>" />
              <label for="">Дом</label>
              <input type="text" name="house" value="<?= $data['house']; ?>" />
              <label for="">Квартира</label>
              <input type="text" name="kvart" value="<?= $data['kvart']; ?>" /><br />
              <input type="hidden" name="id" value="<?= $_SESSION['user']['id']; ?>" />
              <button type="submit" class="c-button">Изменить</button>
            </form>
          </div>
          <br /><br />
          <h2>Контактные данные</h2>
          <br />
          <div class="address">
            <form action="/vendor/upd_user.php" method="POST">
              <label for="">ФИО</label>
              <input type="text" name="fio" value="<?= $_SESSION['user']['fio']; ?>" required />
              <label for="">Номер</label>
              <input list="tel" name="number" type="tel" value="<?= $_SESSION['user']['number']; ?>" required />
              <datalist id="tel">
                <option value="Пример +77057845874">
              </datalist>
              <label for="">Email</label>
              <input type="email" name="email" value="<?= $_SESSION['user']['email']; ?>" required />
              <label for="">Логин</label>
              <input type="text" name="login" value="<?= $_SESSION['user']['login']; ?>" required />
              <label for="">Сменить пароль</label>
              <input type="text" name="password" /><br />
              <input type="hidden" name="id" value="<?= $_SESSION['user']['id']; ?>" required />
              <input type="hidden" name="status" value="<?= $_SESSION['user']['status']; ?>" required />
              <input type="hidden" name="role" value="<?= $_SESSION['user']['role']; ?>" required />
              <button type="submit" class="c-button">Изменить</button>
            </form>
            <br /><br />
          </div>
          <h2>Выход</h2><br>
          <a href="/vendor/logout.php" class="c-button" style="background-color: red; text-decoration: none;">Выход</a>

        </div>
      </div>
    </section>
  </div>
  <? require_once 'blocks/footer.php'; ?>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  

</body>

</html>