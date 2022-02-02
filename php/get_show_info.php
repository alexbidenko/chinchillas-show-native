<?php
include_once "../components/php-funs.php";

$mysqli = BaseConect();

if($_POST['do'] == 'get') {
    $result = $mysqli->query("SELECT * FROM super_chin_all_shows");

    $row = $result->fetch_assoc();

    echo json_encode($row);
} else if($_POST['do'] == 'set') {
    $mysqli->query("UPDATE super_chin_all_shows SET
        title = '".$_POST['data']['title']."',
        step = '".$_POST['data']['step']."' 
        WHERE show_index = ".$_POST['data']['show_index'].";");
}
?>