<?php
include_once "../components/php-funs.php";

$mysqli = BaseConect();

$result = $mysqli->query("SELECT * FROM super_chin_users_all_data WHERE login = '".$_POST['login']."' AND password = '".$_POST['password']."';");
    
if($result->num_rows > 0)
{	
    $row = $result->fetch_assoc();
	$key = ((int)$row['id'] + 10000) * 13873 + 1777;
	$mysqli->query("UPDATE super_chin_all_chins_data SET avatar = '".$_POST['src']."' WHERE id = ".$_POST['chin'].";");
}
?>