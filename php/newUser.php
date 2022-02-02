<?php
if ($_POST['password'] == $_POST['pass_double']) {
    unset($_COOKIE['sistemMessage']);
    
    include_once "../components/php-funs.php";

	$mysqli = BaseConect();

    $result = $mysqli->query("SELECT * FROM super_chin_users_all_data WHERE login = '".$_POST['login']."' OR email = '".
        $_POST['email']."' OR tel = '".$_POST['tel']."';");

    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        if ($row['login'] == $_POST['login']) {
            echo "Такой логин уже существует!";
        }
        else if ($row['email'] == $_POST['email']) {
            echo "Адрес электронной почты уже занят!";
        }
        else if ($row['tel'] == $_POST['tel']) {
            echo "Такой телефон уже занят!";
        }
    }
    else
    {
        $whois;
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];
 
        if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
        elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
        else $ip = $remote;
 
        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));    
        if($ip_data && $ip_data->geoplugin_countryName != null) {
            if ($ip_data->geoplugin_countryCode == "RU") {
                $whois = "russian";
            } else {
                $whois = "csenos";
            }
        }

        $mysqli->query("INSERT INTO super_chin_users_all_data (type, login, password, tel, email, first_name, 
            last_name, middle_name, whois, country, city, older_chin, avatar) VALUES ('u1', '".trim($_POST['login'])."', '".
            trim($_POST['password'])."', '".trim($_POST['tel'])."', '".trim($_POST['email'])."', '".trim($_POST['first_name'])."', '".
            trim($_POST['last_name'])."', '".trim($_POST['middle_name'])."', '".$whois."', '".trim($_POST['country'])."', '".trim($_POST['city']).
            "', 0, '../Datas/site/avatarDefault.png')");
        
        setcookie('login', $_POST['login'], 0, "/");
        setcookie('password', $_POST['password'], 0, "/");

        if(isset($_COOKIE['oldPage'])) {
            echo 'well: '.$_COOKIE['oldPage'];
        } else {
            echo 'well: ../race';
        }
    }
} else {
    echo 'Пароли не совпадают!';
}
?>