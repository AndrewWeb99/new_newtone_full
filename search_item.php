<?
session_start();
require_once 'settings/bd_connect.php';
require_once 'count.php';
require_once 'admin/functions/functions.php';
if (isset($_POST['search'])) {
  $s = $_POST['search'];
  $product = getProduct("WHERE title LIKE '%$s%' or description LIKE '%$s%'"); 
}

if (isset($_GET['search'])) {
  $s = $_GET['search'];
  if (isset($_GET['voz_price'])) {
    $product = getProduct("WHERE title LIKE '%$s%' or description LIKE '%$s%' ORDER BY price ASC");
  }
  if (isset($_GET['ub_price'])) {
    $product = getProduct("WHERE title LIKE '%$s%' or description LIKE '%$s%' ORDER BY price DESC");
  }
  if (isset($_GET['new'])) {
    $product = getProduct("WHERE title LIKE '%$s%' or description LIKE '%$s%' ORDER BY id DESC");
  }
  if (isset($_GET['nazv'])) {
    $product = getProduct("WHERE title LIKE '%$s%' or description LIKE '%$s%' ORDER BY title");
  }
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
        <div class="select">
          <select onchange="window.location.href=this.options[this.selectedIndex].value">
            <option value=""><a href="#">Сортировка</a></option>
            <option value="/search_item.php?search=<?= $s; ?>&voz_price=1">по возрастанию цены</option>
            <option value="/search_item.php?search=<?= $s; ?>&ub_price=1">по убыванию цены</option>
            <option value="/search_item.php?search=<?= $s; ?>&new=1">новые</option>
            <option value="/search_item.php?search=<?= $s; ?>&nazv=1">по названию</option>
          </select>
        </div>
        <div class="cat_box_item">
          <? if (isset($_SESSION['add_basket'])) {
            echo $_SESSION['add_basket'] . '<br>';
            unset($_SESSION['add_basket']);
          }
          if (isset($_SESSION['add_like'])) {
            echo $_SESSION['add_like'] . '<br>';
            unset($_SESSION['add_like']);
          }
          ?>
          <?
          if (count($product) > 0) {
            $in = 0;
            $on = 1; 
            foreach ($product as $p) {
          ?>
              <div class="cat_item_item">
                <a href="/product_main.php?id=<?=$p['id']; ?>">
                  <img src="/img/product/<?= $p['img']; ?>" alt="" />
                  <p class="cat_item_title_item"><?= $p['title']; ?></p>
                  <b>
                    <p class="cat_item_price_item"><?= $p['price']; ?> ₸</p>
                  </b>
                  <div class="razm">
                    <?
                    $text = $p['razm'];
                    $array = explode("; ", $text);

                    for ($i = 0; $i < count($array) - 1; $i++) {
                    ?>
                      <a data-hystmodal="#myModal<?= $in; ?>" data-razm="1" href="#"><?= $array[$i]; ?></a>
                    <?
                    }
                    ?>
                  </div>
                  <div class="hystmodal" id="myModal<?= $in; ?>" aria-hidden="true">
                    <div class="hystmodal__wrap">
                      <div class="hystmodal__window" role="dialog" aria-modal="true">
                        <button data-hystclose class="hystmodal__close">
                          Закрыть
                        </button>
                        <div class="modal_box">
                          <div class="modal_img">
                            <img src="/img/product/<?= $p['img']; ?>" alt="" />
                          </div>
                          <div class="modal_text">
                            <h2><?= $p['title']; ?></h2>
                            <p><?= $p['price']; ?></p>

                            <form class="form_bask" action="/vendor/basket.php" method="POST">
                              <div class="modal_razm">
                                <?
                                for ($i = 0; $i < count($array) - 1; $i++) {
                                ?>
                                  <div class="form_radio_btn rad<?= $on; ?>">
                                    <input id="radio-<?= $on; ?>" class="radio-<?= $on; ?>" type="radio" name="radio" value="<?= $array[$i]; ?>" />
                                    <label for="radio-<?= $on; ?>"><?= $array[$i]; ?></label>
                                  </div>
                                <?
                                  $on++;
                                }
                                ?>
                              </div>
                              <hr />
                              <p style="
                              margin-bottom: 7px;
                              color: #666;
                              margin-top: 10px;
                            ">
                                Cостав
                              </p>
                              <p style="margin-bottom: 7px"><?= $p['material']; ?></p>
                              <p style="margin-bottom: 7px; color: #666">Страна</p>
                              <p style="margin-bottom: 7px"><?= $p['country']; ?></p>
                              <hr />
                              <input name="id" type="hidden" value="<?= $p['id']; ?>">
                              <div class="form_button_box">
                                <button class="form_button_basket" type="submit">В корзину</button>
                                <a class="form_button_like" href="#"><img src="/img/heart.png" alt="" width="25px" /></a>
                              </div>
                              <div class="mes" style="width: 100%; text-align:center; font-size: 25px; color: black;"></div>
                            </form>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="heart">
                  <a href="/vendor/like.php?id=<?= $p['id']; ?>"><img src="/img/heart.png" alt="" /></a>
                  </div>
                </a>
              </div>
          <?

              $in++;
            }
          }
          ?>


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