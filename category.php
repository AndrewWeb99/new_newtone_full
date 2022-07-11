<?
session_start();
require_once 'settings/bd_connect.php';
require_once 'count.php';
require_once 'admin/functions/functions.php';
$category = getCategory(); 
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

</head>

<body>
  <div class="main">
    <? require_once 'blocks/header.php'; ?>

    <section class="category">
      <div class="container">
        <div class="cat_box">
          <?
          if (count($category) > 0) {
            foreach ($category as $c) {
              if ($c['status'] == 1) {
          ?>
                <div class="cat_item">
                  <a href="/category_item.php?id=<?= $c['id']; ?>">
                  <img src="/img/category/<?= $c['img']; ?>" alt="" />
                  <p><?= $c['title']; ?></p>
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
  
</body>

</html>