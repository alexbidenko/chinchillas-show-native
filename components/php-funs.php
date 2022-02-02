<?php
function BaseConect () {
    $mysqli = new mysqli("127.0.0.1", "u0690120_ch_show", "show_ch_u0690120", "u0690120_chinchillas_show_db");
    if ($mysqli->connect_errno) {
        echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    $mysqli->set_charset("utf8");
    return $mysqli;
}

function CheckUser($mysqli) {
    if (!isset($_COOKIE['login']) || !isset($_COOKIE['password'])) {
        return false;
    }
    
    $result = $mysqli->query("SELECT * FROM super_chin_users_all_data WHERE login = '".$_COOKIE['login']."' AND password = '".$_COOKIE['password']."';");
    
    if ($result->num_rows == 0) {
        return false;
    } else {
        $user = $result->fetch_assoc();

        return $user;
    }
}

function RightsCheck($user, $ArrType) {
    if (!$user) {
        return false;
    }
    return in_array($user['type'], $ArrType);
}
?>