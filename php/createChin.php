<?php
    include_once "../components/php-funs.php";

	$mysqli = BaseConect();

    $birthday;

    if ($_GET['id'] == "" || !isset($_GET['id'])) {

        $status = json_encode(array(["date" => (string)(((int)date("U"))*1000), "status" => $_POST['status']]));
        $birthday = (string)(((int)date("U", strtotime($_POST['birthday'])))*1000);
        $colors = json_encode(array('standart' => $_POST['standart'],
            'white' => $_POST['white'], 'mosaic' => $_POST['mosaic'], 'beige' => $_POST['beige'],
            'violet' => $_POST['violet'], 'sapphire' => $_POST['sapphire'],
            'angora' => $_POST['angora'], 'ebony' => $_POST['ebony'],
            'velvet' => $_POST['velvet'], 'pearl' => $_POST['pearl'],
            'california' => $_POST['california'], 'rex' => $_POST['rex'],
            'lova' => $_POST['lova'], 'german' => $_POST['german'],
            'blue' => $_POST['blue'], 'fur' => $_POST['fur']));
        $owners = json_encode(["*".$_GET['user']."*"]);

        if(!$mysqli->query("INSERT INTO super_chin_all_chins_data (redacted, now_status, status, avatar, name_chin, birthday, sex, breader, 
            images, mother, father, childrens, colors, weight, brothers, winer, about, owners, now_owner) VALUES ('".$_POST['redacted']."', '".$_POST['status']."', '".$status."', '../Datas/site/chinDefault.jpg', '".
            trim($_POST['name_chin'])."', '".$birthday."', '".$_POST['sex']."', '".$_POST['breader']."', '[]', '".
            $_POST['mother']."', '".$_POST['father']."', '[]', '".$colors."', ".((int)$_POST['weight']).", ".((int)$_POST['brothers']).", '".
            $_POST['winer']."', '".$_POST['about']."', '".$owners."', ".$_GET['user'].")")) 
                echo "Плохо: (" . $mysqli->errno . ") " . $mysqli->error;

            echo "INSERT INTO super_chin_all_chins_data (now_status, status, avatar, name_chin, birthday, sex, breader, 
            images, mother, father, childrens, colors, weight, brothers, winer, about, owners, now_owner) VALUES ('".$_POST['status']."', '".$status."', '../Datas/site/chinDefault.jpg', '".
            trim($_POST['name_chin'])."', '".$birthday."', '".$_POST['sex']."', ".$_POST['breader'].", '[]', '".
            $_POST['mother']."', '".$_POST['father']."', '[]', '".$colors."', ".((int)$_POST['weight']).", ".((int)$_POST['brothers']).", '".
            $_POST['winer']."', '".$_POST['about']."', '".$owners."', ".$_GET['user'].")";

            echo $_POST['mother'];
            echo $_POST['father'];
    } else {
        /*$id = $_GET['id'];
        $mother = ($_POST['breader'] == 'Неизвестен')?'Не указано':(($_POST['breader'] == 'Нет на сайте')?'Не указано':$_POST['mother']);
        $father = ($_POST['breader'] == 'Неизвестен')?'Не указано':(($_POST['breader'] == 'Нет на сайте')?'Не указано':$_POST['father']);
        
        if ($file[$id]['status'][0]['status'] != $_POST['status'])
            array_unshift($file[$id]['status'], ["date" => date("U"), "status" => $_POST['status']]);
        $file[$id]['nameChin'] = $_POST['nameChin'];
        $file[$id]['birthday'] = $_POST['birthday'];
        $file[$id]['sex'] = $_POST['sex'];
        $file[$id]['breader'] = $_POST['breader'];
        $file[$id]['mother'] = $mother;
        $file[$id]['father'] = $father;
        $file[$id]['colors'] = array('standart' => $_POST['standart'],
        'white' => $_POST['white'], 'mosaic' => $_POST['mosaic'], 'beige' => $_POST['beige'],
        'violet' => $_POST['violet'], 'sapphire' => $_POST['sapphire'],
        'angora' => $_POST['angora'], 'ebony' => $_POST['ebony'],
        'velvet' => $_POST['velvet'], 'pearl' => $_POST['pearl'],
        'california' => $_POST['california'], 'rex' => $_POST['rex'],
        'lova' => $_POST['lova'], 'german' => $_POST['german'],
        'blue' => $_POST['blue'], 'fur' => $_POST['fur']);
        $file[$id]['weight'] = ($_POST['weight'] != "")?$_POST['weight']:'Не указано';
        $file[$id]['brothers'] = ($_POST['brothers'] != "")?$_POST['brothers']:'Не указано';
        $file[$id]['winer'] = ($_POST['winer'] != "")?$_POST['winer']:'Не указано';
        $file[$id]['about'] = ($_POST['about'] != "")?$_POST['about']:'Не указано';
        
        $f = fopen($filename, "w");
        $pretty = json_encode($file);
        fputs($f,$pretty);
        fclose($f);*/
    }

    $result = $mysqli->query("SELECT * FROM super_chin_all_chins_data WHERE birthday = ".$birthday." and name_chin = '".$_POST['name_chin']."';");
    
    $row = $result->fetch_assoc();
    $chinID = $row['id'];

    if (is_numeric($_POST['breader']) && is_numeric($_POST['mother']) && is_numeric($_POST['father'])) {

        $result = $mysqli->query("SELECT * FROM super_chin_all_chins_data WHERE id = ".$_POST['mother'].";");

        $row = $result->fetch_assoc();
        array_push(
            json_decode($row['childrens'], true), $chinID);
        $row['childrens'] = array_unique($row['childrens']);
        $childrens = json_encode($row['childrens']);
        $mysqli->query("UPDATE super_chin_all_chins_data SET childrens = '".$childrens."' WHERE id = ".$_POST['mother'].";");
            
        $result = $mysqli->query("SELECT * FROM super_chin_all_chins_data WHERE id = ".$_POST['father'].";");

        $row = $result->fetch_assoc();
        $childrens = json_decode($row['childrens'], true);
        array_push($childrens, $chinID);
        $row['childrens'] = array_unique($row['childrens']);
        $childrens = json_encode($row['childrens']);
        $mysqli->query("UPDATE super_chin_all_chins_data SET childrens = '".$childrens."' WHERE id = ".$_POST['father'].";");
    }
    
    /*$all_chins = json_decode(file_get_contents('../Datas/site/all_chins.json'), true);
    $pretty = json_encode([$id => array("owner" => $_GET['login'] + $all_chins, "nameChin" => $_POST['nameChin'])], JSON_PRETTY_PRINT);
    $f = fopen('../Datas/site/all_chins.json', "w");
    fputs($f,$pretty);
    fclose($f);*/
    
    header('Location: http://super-chin.h1n.ru/dna-base/profile-chin?profile='.$_GET['user'].'&chin='.$chinID);
?>