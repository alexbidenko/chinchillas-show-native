<?php
$usersData = json_decode(file_get_contents('../Datas/site/usersData.json'), true);
$usersData[$_POST['user']]["type"] = $_POST['type'];
$f = fopen('../Datas/site/usersData.json', "w");
$pretty = json_encode($usersData, JSON_PRETTY_PRINT);
fputs($f,$pretty);
fclose($f);
?>