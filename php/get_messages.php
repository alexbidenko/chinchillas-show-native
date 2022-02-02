<?php
include_once "../components/php-funs.php";

$mysqli = BaseConect();

$result = $mysqli->query("SELECT * FROM super_chin_users_all_data WHERE id = ".$_POST['user']." AND login = '".$_POST['login']."' AND password = '".$_POST['password']."';");

$row = $result->fetch_assoc();

if($result->num_rows > 0)
{
    if($_POST['what'] == 'chat') {
        $result = $mysqli->query("SELECT * FROM super_chin_all_messages WHERE 
            user = ".$_POST['user']." AND speaker = ".$_POST['speaker']." 
            OR 
            user = ".$_POST['speaker']." AND speaker = ".$_POST['user'].";");

        $ask = array();

        while ($row = $result->fetch_assoc()) {
            array_push($ask, $row);
        }

        echo json_encode($ask);
    } else if($_POST['what'] == 'dialogs') {
        $result = $mysqli->query("SELECT * FROM super_chin_all_messages WHERE 
            user = ".$_POST['user']." 
            OR 
            speaker = ".$_POST['user']." ORDER BY id DESC;");

        $ask = array();

        while ($row = $result->fetch_assoc()) {
            array_push($ask, $row);
        }

        echo json_encode($ask);
    }
}
?>