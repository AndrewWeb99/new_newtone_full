<?
require_once 'settings/bd_connect.php';
$visitor_ip = $_SERVER['REMOTE_ADDR'];
$date = date("Y-m-d");
$sql0 = "SELECT `visits_id` FROM visits WHERE `date` = '$date'";
$res0 = $mysqli->query($sql0);

if (mysqli_num_rows($res0) == 0) {
    $mysqli->query("DELETE FROM ips");
    $mysqli->query("INSERT INTO ips SET ip_adress = '$visitor_ip'");
    $res_count = $mysqli->query("INSERT INTO visits SET `date` = '$date', `hosts` = '1', `views` = '1'");
} else {
    $current_ip = $mysqli->query("SELECT id FROM ips WHERE `ip_adress` = '$visitor_ip'");
    if (mysqli_num_rows($current_ip) == 1) {
        $mysqli->query("UPDATE visits SET `views` = `views`+1 WHERE `date` ='$date'");
    }else{
        $mysqli->query("INSERT INTO ips SET ip_adress = '$visitor_ip'");
        $mysqli->query("UPDATE visits SET `hosts`= `hosts`+1, `views` = `views`+1 WHERE `date` ='$date'");
    }
}
