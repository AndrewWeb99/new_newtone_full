<?
session_start();
require_once 'settings/bd_connect.php';
require_once 'count.php';
require_once 'admin/functions/functions.php';
if (isset($_SESSION['user'])) {
  $user = $_SESSION['user']['id'];
  $basket = getBasket("WHERE user_id =" . $user);
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

    <section class="basket_page">
      <div class="container">
        <br />
        <h2>Корзина</h2>
        <br /><br />
        <? if (isset($_SESSION['del_basket'])) {
            echo $_SESSION['del_basket'] . '<br>';
            unset($_SESSION['del_basket']);
          }
          
          ?>
        <div class="basket_box">
          <div class="basket_products">
            <?
            if (count($basket) > 0) {
              $bask_prod = array();
              foreach ($basket as $b) {
                $sql = "SELECT * FROM products WHERE id =" . $b['product_id'];
                $res = $mysqli->query($sql);
                $product = array();
                while ($data = $res->fetch_assoc()) {
                  $product[] = $data;
                }
                foreach ($product as $r) {
            ?>
                  <div class="basket_item">
                    <img class="basket_item_img" src="/img/product/<?= $r['img'] ?>" alt="" />
                    <div class="basket_item_text">
                      <br />
                      <h2><?= $r['title'] ?></h2>
                      <br />
                      <h2><?= $b['razm'] ?></h2>
                      <br />
                      <h2 class="prices"><?= $r['price'] ?></h2>
                      <br />
                      <a href="/vendor/del_bask.php?id=<?= $b['id']?>" class="c-button" style="text-decoration: none">Удалить</a><br /><br />
                    </div>
                  </div>
            <?
                }
              }
            }else{
             echo '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Корзина пуста</div>';
            }
            ?>
          </div>

          <div class="basket_order">
            <div class="basket_order_border">
              <div class="basket_order_text">
                <h2>Итого</h2>
                <h2 id="total_price"></h2>
              </div>
              <br /><br />
              <div class="basket_order_button">
                <a id="sub_order" href="/vendor/add_order.php" class="c-button" style="
                    text-decoration: none;
                    width: 100%;
                    display: block;
                    overflow: hidden;
                    padding: 8px 0px;
                    text-align: center;
                    font-size: 20px;
                    background-color: #525665;
                  ">Оформить</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <? require_once 'blocks/footer.php'; ?>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script>
    let prices = document.querySelectorAll('.prices');
    let total = document.getElementById('total_price');
    let tot = 0;
    prices.forEach(element => {
      let pr;
      pr = Number(element.innerHTML)
      tot = Number(tot) + pr;
      console.log(tot);
    });
    total.innerHTML = tot + ' ₸';
  </script>
  <script>
    let sub_order = document.getElementById('sub_order');
    sub_order.setAttribute("href", "/vendor/add_order.php?total=" + tot);
  </script>
</body>

</html>