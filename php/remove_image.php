<?php
include_once "../components/php-funs.php";

$mysqli = BaseConect();

$result = $mysqli->query("SELECT * FROM super_chin_users_all_data WHERE login = '".$_POST['login']."' AND password = '".$_POST['password']."';");
    
if($result->num_rows > 0)
{	
    $row = $result->fetch_assoc();
    $key = ((int)$row['id'] + 10000) * 13873 + 1777;
    
    $result = $mysqli->query("SELECT * FROM super_chin_all_chins_data WHERE id = ".$_POST['chin'].";");
    
    $row = $result->fetch_assoc();
	$images = json_decode($row['images'], true);
    $arr = [];
    foreach ($images as $val) {
        if ($val != $_POST['src']) {
            array_push($arr, $val);
        }
    }
    $images = $arr;
	$images = json_encode($images, JSON_PRETTY_PRINT);
    $mysqli->query("UPDATE super_chin_all_chins_data SET images = '".$images."' WHERE id = ".$_POST['chin'].";");

    unlink($_POST['src']);

    if ($_POST['src'] == $row['avatar']) {
        $mysqli->query("UPDATE super_chin_all_chins_data SET avatar = '../Datas/site/chinDefault.jpg' WHERE id = ".$_POST['chin'].";");
    }
}
?>