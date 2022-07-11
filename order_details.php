<?
session_start();
require_once 'settings/bd_connect.php';
require_once 'count.php';
require_once 'admin/functions/functions.php';
if (isset($_SESSION['user'])) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM `orders` WHERE `id` =" . $id;
  $res = $mysqli->query($sql);
  $order = $res->fetch_assoc();

  $prod_id = array();
  $prod_id = explode(";", $order['product_id']);

  $razm = array();
  $razm = explode(";", $order['razm']);
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
          <h2>Детали заказа №<?= $order['id']; ?></h2>
          <br />
          <div class="order_item">
            <p style="font-size: 20px;">Дата - <span><?= $order['date']; ?></span></p>
            <p style="font-size: 20px;">Статус - <span><?= $order['status']; ?></span></p>
            <p style="font-size: 20px;">Сумма заказа - <span><?= $order['total']; ?></span></p><br>
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
    </section>
  </div>
  <? require_once 'blocks/footer.php'; ?>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


</body>

</html>