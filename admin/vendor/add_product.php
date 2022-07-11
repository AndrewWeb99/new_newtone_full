<?
session_start();
require_once '../../settings/bd_connect.php';
require_once '../functions/functions.php';
$title = $_POST['title'];
$price = $_POST['price'];
$razm = $_POST['razm'];
$description = $_POST['description'];
$material = $_POST['material'];
$country = $_POST['country'];
$category_id = $_POST['category_id'];
$razmer = '';
foreach ($razm as $r) {
    $razmer = $razmer . $r . '; ';
}


if (!empty($_FILES['img']) && $_FILES['img']['error'] == 0) {
    $errors = array();
    $file_name     = $_FILES['img']['name'];
    $file_size     = $_FILES['img']['size'];
    $file_tmp     = $_FILES['img']['tmp_name'];
    $file_type    = $_FILES['img']['type'];
    $file_ext     = strtolower(end(explode('.', $file_name)));
    $img         = rand(1, 1000) . '_product -' . date("d-Y") . '.' . $file_ext;

    $expensions = array("jpeg", "jpg", "png");

    if ($file_size > 5097152) {
        $errors[] = "Файл превысил размер 5МБ";
    }

    if (!in_array($file_ext, $expensions)) {
        $errors[] = "Неверный тип файла";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO `products` (`id`, `title`, `img`, `price`, `razm`, `description`, `material`, `country`, `status`, `category_id`) VALUES (NULL, '$title', '$img', $price, '$razmer', '$description', '$material', '$country', 1, '$category_id')";
        move_uploaded_file($file_tmp, "../../img/product/" . $img);
        $res = $mysqli->query($sql);
        if ($res == true) {
            $_SESSION['create_prod'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Изделие добавлено</div>';
            header("location: /admin/products.php");
        } else {
            $_SESSION['create_prod'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка изменения</div>';
            header("location: /admin/products.php");
        }
    } else {
        $err_size = $errors[0];
        $err_type = $errors[1];
        $_SESSION['img_error'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка загруки файла: ' . $err_size . ' ' . $err_type . '</div>';
        header("location: /admin/add_product.php");
    }
}
