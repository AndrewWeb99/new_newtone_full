<?
session_start();
require_once 'settings/bd_connect.php';
require_once 'count.php';
require_once 'admin/functions/functions.php'; 
if (isset($_GET['id'])) {
  $s = $_GET['id'];
  $product = getProduct("WHERE id = " . $s);
  $new_product = getProduct('ORDER BY id DESC LIMIT 10');
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
  <!-- -->
</head>

<body>
  <div class="main">
    <? require_once 'blocks/header.php'; ?>

    <section class="category_item">
      <div class="container">
        <div class="product_box">
          <? if (isset($_SESSION['add_basket'])) {
            echo $_SESSION['add_basket'] . '<br>';
            unset($_SESSION['add_basket']);
          }
          if (isset($_SESSION['add_like'])) {
            echo $_SESSION['add_like'] . '<br>';
            unset($_SESSION['add_like']);
          }
          if (isset($_SESSION['add_review'])) {
            echo $_SESSION['add_review'] . '<br>';
            unset($_SESSION['add_review']);
          }
          ?>
          <?
          if (count($product) > 0) {
            $in = 0;
            $on = 1;
            foreach ($product as $p) {
          ?>
              <div class="product_head">
                <div class="product_img">
                  <img src="/img/product/<?= $p['img']; ?>" alt="" />
                </div>
                <div class="product_basket">
                  <h2 class="product_title"><?= $p['title']; ?></h2>
                  <h2 class="product_price"><?= $p['price']; ?></h2>
                  <form class="form_bask" action="/vendor/basket.php" method="POST">
                    <input type="hidden" name="id" value="<?= $p['id']; ?>">
                    <div class="select" style="margin-bottom: 40px">
                      <select name="razmer" id="">
                        <option value="" disabled>Размер</option>
                        <?
                        $text = $p['razm'];
                        $array = explode("; ", $text);

                        for ($i = 0; $i < count($array) - 1; $i++) {
                        ?>
                          <option value="<?= $array[$i]; ?>"><?= $array[$i]; ?></option>
                        <?
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form_button_box">
                      <button class="form_button_basket" type="submit" style="text-decoration: none; width: 80%; border-radius: 1%">В корзину</button>
                      <a class="form_button_like" href="/vendor/like.php?id=<?= $p['id']; ?>" style="text-decoration: none; width: 80%; border-radius: 1%"><img src="/img/heart.png" alt="" width="25px" /></a>
                    </div>
                  </form>

                </div>
              </div>
              <div class="product_desc">
                <div class="desc_text">
                  <div class="xar">
                    <h2>Описание</h2>
                    <p>
                      <?= $p['description']; ?>
                    </p><br><br>
                    <h2>Характеристики</h2><br><br>
                    <p>Материал..................................<span><?= $p['material']; ?></span></p><br>
                    <p>Страна........................................<span><?= $p['country']; ?></span></p>
                  </div>
                  <div class="form_otz">
                    <form action="/vendor/review.php" method="post">
                      <h2>Оставьте отзыв</h2><br>
                      <label for="">Имя</label>
                      <input name="name" type="text" required><br><br>
                      <label for="">Email</label>
                      <input name="email" type="email" required><br><br>
                      <label for="">Отзыв</label>
                      <textarea name="review" id="" cols="30" rows="10" required></textarea><br><br>
                      <button type="submit" class="c-button">Отправить</button>
                    </form>
                  </div>
                </div>
            <?
            }
          }
            ?>



            <h2 id="new" style="font-size: 40px; text-align: center; margin-top: 100px">
              Новинки
            </h2>
            <div class="slider_one">
              <?
              if (count($new_product) > 0) {
                foreach ($new_product as $np) {
                  if ($np['status'] == 1) {
              ?>
                    <div>
                      <a style="text-decoration: none; color:black;" href="/product_main.php?id=<?= $np['id']; ?>">
                        <div>
                          <div class="img_text">
                            <img src="/img/product/<?= $np['img']; ?>" alt="" width="330px" />
                            <p><?= $np['title']; ?></p>
                          </div>
                        </div>
                      </a>
                    </div>
              <?
                  }
                }
              }
              ?>
            </div>



              </div>
        </div>
      </div>
    </section>
  </div>
  <? require_once 'blocks/footer.php'; ?>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".slider_one").slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        variableWidth: true,
      });
    });
  </script>
  
  <script src="/js/hystmodal.min.js"></script>

  <script>
    let modals = document.querySelectorAll(".hystmodal");
    let names = [];
    for (let i = 0; i < modals.length; i++) {
      names[i] =
        "let myModal" +
        i +
        ' = new HystModal({ linkAttributeName: "data-hystmodal",});';
    }
    for (let i = 0; i < names.length; i++) {
      eval(names[i]);
    }
  </script>
</body>

</html>