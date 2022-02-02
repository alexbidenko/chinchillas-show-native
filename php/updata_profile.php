<?php

include_once "../components/php-funs.php";

$mysqli = BaseConect();

$mysqli->query("UPDATE super_chin_users_all_data SET 
    login = '".$_POST['login']."',  
    tel = '".$_POST['tel']."',  
    email = '".$_POST['email']."' ,  
    first_name = '".$_POST['first_name']."' ,  
    last_name = '".$_POST['last_name']."' ,  
    middle_name = '".$_POST['middle_name']."' ,  
    country = '".$_POST['country']."' ,  
    city = '".$_POST['city']."' 
    WHERE 
    id = ".$_POST['id'].";")

?>