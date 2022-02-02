<?php
/*$filePname = '../Datas/'.$_POST['user'].'/'.$_POST['user'].'Chins.json';
$PData = file_get_contents($filePname);
$f = fopen($filePname, "w");
$fileP = json_decode($PData, true);
array_unshift($fileP[$_POST['id']]['status'], ["date" => date("U"), "status" => $_POST['status']]);
$pretty = json_encode($fileP, JSON_PRETTY_PRINT);
fputs($f,$pretty);
fclose($f);

include_once "../components/php-funs.php";

$mysqli = BaseConect();

$result = $mysqli->query("SELECT * FROM super_chin_users_all_data WHERE login = '".$_POST['login']."' AND password = '".$_POST['password']."';");
    
if($result->num_rows > 0)
{
    $row = $result->fetch_assoc();

    $key = ((int)$row['id'] + 10000) * 13873 + 1777;
    $result = $mysqli->query("SELECT * FROM user_".$key."_chins_data WHERE id = ".$_POST['chin'].";");
    
    $row = $result->fetch_assoc();
    $status = json_decode($row['status'], true);
    if($_POST['status'] != 'sale') {
	    array_unshift($status, [
            "date" => (string)(((int)date("U"))*1000), 
            "status" => $_POST['status'] ]);
    } else {
        array_unshift($status, [
            "date" => (string)(((int)date("U"))*1000), 
            "status" => $_POST['status'],
            "cost" => $_POST['cost'], 
            "currency" => $_POST['currency'] ]);
    }
	$status = json_encode($status, JSON_PRETTY_PRINT);
	$mysqli->query("UPDATE user_".$key."_chins_data SET status = '".$status."' WHERE id = ".$_POST['chin'].";");
	$mysqli->query("UPDATE user_".$key."_chins_data SET now_status = '".$_POST['status']."' WHERE id = ".$_POST['chin'].";");
}*/
?>