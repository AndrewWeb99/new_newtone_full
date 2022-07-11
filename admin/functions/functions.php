<?
// Получить пользователей
function getUsers($where = ''){
    global $mysqli;
    if($where == ''){
        $sql = "SELECT * FROM users";
    }else{
        $sql = "SELECT * FROM users " . $where;
    }
    $res = $mysqli->query($sql);
    $users = array();
    while($data = $res->fetch_assoc())
        $users[] = $data;
    return $users;
}
// Получить категории 
function getCategory($where = ''){
    global $mysqli;
    if($where == ''){
        $sql = "SELECT * FROM category";
    }else{
        $sql = "SELECT * FROM category " . $where;
    }
    $res = $mysqli->query($sql);
    $category = array();
    while($data = $res->fetch_assoc())
        $category[] = $data;
    return $category;
}
// Получить одежду
function getProduct($where = ""){
    global $mysqli;
    if($where == ''){
        $sql = "SELECT * FROM products";
    }else{
        $sql = "SELECT * FROM products " . $where;
    }
    $res = $mysqli->query($sql);
    $product = array();
    while($data = $res->fetch_assoc())
        $product[] = $data;
    return $product;
}

// Получить отзывы 
function getReview($where = ''){
    global $mysqli;
    if($where == ''){
        $sql = "SELECT * FROM reviews";
    }else{
        $sql = "SELECT * FROM reviews " . $where;
    }
    $res = $mysqli->query($sql);
    $review = array();
    while($data = $res->fetch_assoc())
        $review[] = $data;
    return $review;
}
// Получить корзину
function getBasket($where = ''){
    global $mysqli;
    if($where == ''){
        $sql = "SELECT * FROM basket";
    }else{
        $sql = "SELECT * FROM basket " . $where;
    }
    $res = $mysqli->query($sql);
    $basket = array();
    while($data = $res->fetch_assoc())
        $basket[] = $data;
    return $basket;
}
// Получить избранное
function getLike($where = ''){
    global $mysqli;
    if($where == ''){
        $sql = "SELECT * FROM likes";
    }else{
        $sql = "SELECT * FROM likes " . $where;
    }
    $res = $mysqli->query($sql);
    $likes = array();
    while($data = $res->fetch_assoc())
        $likes[] = $data;
    return $likes;
}

// Получить заказы
function getOrders($where = ''){
    global $mysqli;
    if($where == ''){
        $sql = "SELECT * FROM `orders`";
    }else{
        $sql = "SELECT * FROM `orders` " . $where;
    }
    $res = $mysqli->query($sql);
    $orders = array();
    while($data = $res->fetch_assoc()){
        $orders[] = $data;
    }
        
    return $orders;
}