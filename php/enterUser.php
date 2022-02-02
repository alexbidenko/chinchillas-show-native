<?php
if (isset($_POST['login_enter']) and isset($_POST['password_enter'])) {

    include_once "../components/php-funs.php";

	$mysqli = BaseConect();
    
    $result = $mysqli->query("SELECT * FROM super_chin_users_all_data WHERE login = '".$_POST['login_enter']."' AND password = '".
        $_POST['password_enter']."';");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        setcookie('login', $_POST['login_enter'], 2147483647, "/");
        setcookie('password', $_POST['password_enter'], 2147483647, "/");
        if(isset($_COOKIE['oldPage'])) {
            echo 'well: '.$_COOKIE['oldPage'];
        } else {
            echo 'well: ../race';
        }
    } else {
        echo "Неверный логин или пароль!";
    }
}
?>