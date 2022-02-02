<?php
include_once "../components/php-funs.php";

$mysqli = BaseConect();

if (!isset($_POST['last_name'])) {
    $result = $mysqli->query("SELECT * FROM super_chin_regist_show_data;");

    $ans = array();

    while($row = $result->fetch_assoc()) {
        array_push($ans, $row);
    }

    echo json_encode($ans);
} else {
    $result = $mysqli->query("SELECT * FROM super_chin_regist_show_data WHERE 
        first_name = '".$_POST['first_name']."' AND 
        last_name = '".$_POST['last_name']."';");

    $row = $result->fetch_assoc();
    
    echo json_encode($row);
}
?>