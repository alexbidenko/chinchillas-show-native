<?php
include_once "../components/php-funs.php";

$mysqli = BaseConect();

$result = $mysqli->query("SELECT * FROM super_chin_regist_show_data WHERE 
    last_name = '".$_POST['last_name']."' and 
    email = '".$_POST['email']."';");

if($result->num_rows == 0) {
    echo "well";
} else {
    $row = $result->fetch_assoc();
    echo json_encode($row);
}
?>