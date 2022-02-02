<?php
include_once "../components/php-funs.php";

$mysqli = BaseConect();

$result = $mysqli->query("SELECT * FROM super_chin_users_all_data WHERE id = ".$_POST['user']." AND login = '".$_POST['login']."' AND password = '".$_POST['password']."';");

$row = $result->fetch_assoc();

if($result->num_rows > 0)
{
    $mysqli->query("INSERT INTO super_chin_all_messages 
        (user, speaker, message) 
        VALUES 
        (".$_POST['user'].", ".$_POST['speaker'].", '".$_POST['message']."');");
}
?>