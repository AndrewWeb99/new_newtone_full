<?
if (isset($_SESSION['user'])) {
    $sql9 = "SELECT COUNT(*) FROM `basket` WHERE `user_id` = " . $_SESSION['user']['id'];
    $res9 = $mysqli->query($sql9);
    $row9 = mysqli_fetch_assoc($res9);
    $bas = $row9['COUNT(*)'];

    $sql8 = "SELECT COUNT(*) FROM `likes` WHERE `user_id` = " . $_SESSION['user']['id'];
    $res8 = $mysqli->query($sql8);
    $row8 = mysqli_fetch_assoc($res8);
    $lik = $row8['COUNT(*)'];
}

?>
<section id="head" class="header">
    <div class="container">
        <div class="header_box">
            <div class="logo">
                <a href="/index.php"><img src="/img/logo.svg" alt="" /></a>
            </div>
            <div class="search">
                <form class="form-wrapper" action="/search_item.php" method="POST">
                    <input id="search" placeholder="Поиск" required="" type="text" name="search" />
                    <button id="submit" type="submit" style="background-color: transparent; border: none;"><img src="/img/search-interface-symbol.png" alt="" width="30px" /></button>
                </form>
            </div>
            <div class="manage">
                <div class="head_img_1">
                    <a href="/cabinet.php"><img src="/img/user.png" alt="" /></a>
                </div>
                <div class="head_img_2">
                    <a href="/like.php"><img src="/img/heart.png" alt="" /></a>
                    <span><?= $lik; ?></span>
                </div>
                <div class="head_img_3">
                    <a href="/basket.php"><img src="/img/shopping-bag.png" alt="" /></a>
                    <span><?= $bas; ?></span>
                </div>
            </div>
        </div>
        <div class="nav" id="nav">
            <a class="menu" href="/category.php">Категории</a>
            <a class="menu1" href="#new">Новинки</a>
        </div>
    </div>
</section>