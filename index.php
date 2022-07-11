<?
session_start();
require_once 'settings/bd_connect.php';
require_once 'count.php';
require_once 'admin/functions/functions.php'; 
$category = getCategory();
$new_product = getProduct('ORDER BY id DESC LIMIT 10');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NewTone</title>
  <link rel="stylesheet" href="/css/main.css" />
  <link rel="stylesheet" type="text/css" href="/css/slick.css" />

</head>

<body>
  <? require_once 'blocks/header.php'; ?>
  <? if (isset($_SESSION['reg_user'])) {
            echo $_SESSION['reg_user'] . '<br>';
            unset($_SESSION['reg_user']);
          }
          
          ?>
  <section class="images_market">
    <div class="container">
      <div class="market_head">
        <div class="market_head_left">
          <img src="/img/head_one.jpg" alt="" />
        </div>
        <div class="market_head_right">
          <img src="/img/head_two.jpg" alt="" />
        </div>
      </div>
      <div class="market_two">
        <div class="img_and_title">
          <img src="/img/one.jpg" alt="" /><br />
          <span>Низкие цены</span>
        </div>
        <div class="img_and_title">
          <img src="/img/two.jpg" alt="" /><br />
          <span>Новые коллекции</span>
        </div>
        <div class="img_and_title">
          <img src="/img/three.jpg" alt="" /><br />
          <span>Бонусы</span>
        </div>
        <div class="img_and_title">
          <img src="/img/four.jpg" alt="" /><br />
          <span>Брендовые вещи</span>
        </div>
      </div>
      <h2 id="cat" style="font-size: 40px; text-align: center">Категории</h2>
      <div id="cat" class="slider_one">
        <?
        if (count($category) > 0) {
          foreach ($category as $c) {
            if ($c['status'] == 1) {
        ?>

              <div>
                <a style="text-decoration: none; color:black;" href="/category_item.php?id=<?= $c['id']; ?>">
                  <div class="img_text">
                    <img src="/img/category/<?= $c['img']; ?>" alt="" />
                    <p><?= $c['title']; ?></p>
                  </div>
                </a>
              </div>
        <?
            }
          }
        }
        ?>
      </div>
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
                      <img src="/img/product/<?= $np['img']; ?>" alt="" width="330px"/>
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
  </section>
  <section class="brend">
    <div class="container">
      <h2 style="text-align: center; font-size: 40px; margin-top: 100px">
        Наши бренды
      </h2>
      <div class="brend_list">
        <img src="/img/brend1.webp" alt="" />
        <img src="/img/brend2.webp" alt="" />
        <img src="/img/brend3.webp" alt="" />
        <img src="/img/brend4.webp" alt="" />
        <img src="/img/brend5.webp" alt="" />
      </div>
      <div class="sales_box">
        <img src="/img/sales.webp" alt="" />
      </div>
    </div>
  </section>
  <section class="contact">
    <div class="container">
      <div class="contact_box">
        <div class="contact_img"><img src="/img/contat.webp" alt="" /></div>
        <div class="contact_text">
          <h2 style="text-align: left; font-size: 40px;">
            Наш адрес 
          </h2>
          <br><br><br> 
          <p>Адрес:</p>
          <p>г. Петропавловск, улица Театральная 44.</p>
          <br><br><br>
          <p>Контакты:</p>
          <p>+7 800 555-10-61</p>
          <p>пн-пт 10:00-19:00</p>

        </div>
      </div>
    </div>
  </section>
  <? require_once 'blocks/footer.php'; ?>
  <script src="/js/jquery-3.6.0.js"></script>
  <script type="text/javascript" src="/js/slick.min.js"></script>
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
  <script>
    $(document).ready(function() {
      $("#nav").on("click", ".menu1", function(event) {
        event.preventDefault();
        var id = $(this).attr('href'),
          top = $(id).offset().top;
        $('body,html').animate({
          scrollTop: top
        }, 1500);
      });
      $(".footer_logo").on("click", ".footer_logo_img", function(event) {
        event.preventDefault();
        var id = $(this).attr('href'),
          top = $(id).offset().top;
        $('body,html').animate({
          scrollTop: top
        }, 1500);
      });
    });
  </script>
</body>

</html>