<?php
include_once "../components/php-funs.php";

$mysqli = BaseConect();
	
if ($_POST['comand'] == "add") {
    $result = $mysqli->query("SELECT * FROM super_chin_regist_show_data WHERE 
        last_name = '".$_POST['all_data']['last_name']."' AND 
        first_name = '".$_POST['all_data']['first_name']."' AND 
        middle_name = '".$_POST['all_data']['middle_name']."';");

    if($result->num_rows > 0) {
        $mysqli->query("DELETE FROM super_chin_regist_show_data WHERE 
            last_name = '".$_POST['all_data']['last_name']."' AND 
            first_name = '".$_POST['all_data']['first_name']."' AND 
            middle_name = '".$_POST['all_data']['middle_name']."';");
    }

    if(!$mysqli->query("INSERT INTO super_chin_regist_show_data 
        (
            show_index, 
            user_id, 
            last_name, 
            first_name, 
            middle_name, 
            city, 
            email, 
            tel, 
            farm, 
            registedChins
        ) VALUES (
            1, 
            ".$_POST['all_data']['user_id'].", 
            '".$_POST['all_data']['last_name']."', 
            '".$_POST['all_data']['first_name']."', 
            '".$_POST['all_data']['middle_name']."', 
            '".$_POST['all_data']['city']."', 
            '".$_POST['all_data']['email']."', 
            '".$_POST['all_data']['tel']."', 
            '".$_POST['all_data']['farm']."', 
            '".json_encode($_POST['all_data']['registedChins'])."'
        )") ) 
    {
        echo ": (" . $mysqli->errno . ") " . $mysqli->error;
    } else {
        echo "well";
        file_put_contents('../race/last-updata.txt', date('U'));
    }
} else if ($_POST['comand'] == "updata") {
	$bool = false;
	$all_data = [];
	if (isset($_POST['all_data']) && $_POST['len'] <= strlen($_POST['all_data'])) {
	    $all_data = json_decode($_POST['all_data']);
	    $bool = true;
	} elseif(isset($_POST['data']) && $_POST['len'] <= strlen($_POST['data'])) {
	    array_push($all_data, json_decode($_POST['data']));
	    $bool = true;
	}
	if($bool) {
		foreach ($all_data as $data) {
		    if(!$mysqli->query("UPDATE super_chin_regist_show_data SET 
		        registedChins = '".json_encode($data->registedChins)."' 
		        WHERE 
		        last_name = '".$data->last_name."' AND 
		        first_name = '".$data->first_name."';") ) 
		    {
		        echo ": (" . $mysqli->errno . ") " . $mysqli->error;
		    } else {
		        echo "well";
		    }
		}
        file_put_contents('../race/last-updata.txt', date('U'));
	}
}
?>