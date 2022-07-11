<?
session_start();
require_once '../../settings/bd_connect.php';
require_once '../functions/functions.php';
$title = $_POST['title'];

if (!empty($_FILES['img']) && $_FILES['img']['error'] == 0) {
    $errors = array();
    $file_name     = $_FILES['img']['name'];
    $file_size     = $_FILES['img']['size'];
    $file_tmp     = $_FILES['img']['tmp_name'];
    $file_type    = $_FILES['img']['type'];
    $file_ext     = strtolower(end(explode('.', $file_name)));
    $img         = rand(1, 1000) . '_category -' . date("d-Y") . '.' . $file_ext;

    $expensions = array("jpeg", "jpg", "png");

    if ($file_size > 5097152) {
        $errors[] = "Файл превысил размер 5МБ";
    }

    if (!in_array($file_ext, $expensions)) {
        $errors[] = "Неверный тип файла";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO `category` (`id`, `title`, `img`, `status`) VALUES (NULL, '$title', '$img', '1')";
        move_uploaded_file($file_tmp, "../../img/category/" . $img);
        $res = $mysqli->query($sql);
        if ($res == true) {
            $_SESSION['create_cat'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Категория добавлена</div>';
            header("location: /admin/category.php");
        } else {
            $_SESSION['create_cat'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка изменения</div>';
            header("location: /admin/category.php");
        }
    } else {
        $err_size = $errors[0];
        $err_type = $errors[1];
        $_SESSION['img_error'] = '<div style="width: 100%; text-align:center; font-size: 25px; color: black;">Ошибка загруки файла: ' . $err_size . ' ' . $err_type . '</div>';
        header("location: /admin/add_category.php");
    }
}
