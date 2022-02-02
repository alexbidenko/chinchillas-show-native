<?php
function answer() {
    include_once "../components/php-funs.php";

	$mysqli = BaseConect();

    $result = $mysqli->query("SELECT * FROM super_chin_users_all_data WHERE login = '".$_POST['login']."' AND password = '".$_POST['password']."';");
    
    if($result->num_rows > 0)
    {
    	$user = $result->fetch_assoc();
    	
        if (isset($_POST['now_status'])) {
            $result = $mysqli->query("SELECT * FROM super_chin_all_chins_data WHERE now_status = '".$_POST['now_status']."' ORDER BY chin_name");

            $ans = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($ans, $row);
                }
            }
            return json_encode($ans); 
        }
        else if (isset($_POST['id'])) {
            $result = $mysqli->query("SELECT * FROM super_chin_all_chins_data WHERE id = ".$_POST['id'].";");
            $row = $result->fetch_assoc();
            return json_encode($row); 
        }
        else if (isset($_POST['array_id'])) {
            $ans = array();
            foreach(array_unique(json_decode($_POST['array_id'], true)) as $id) {
                $result = $mysqli->query("SELECT * FROM super_chin_all_chins_data WHERE id = ".$id.";");
                $row = $result->fetch_assoc();
                array_push($ans, $row);
            }
            return json_encode($ans); 
        }
        else if (isset($_POST['breader'])) {
            $result = $mysqli->query("SELECT * FROM super_chin_all_chins_data WHERE owners LIKE '%".$_POST['breader']."%';");
            
            $ans = array();
            $ans['famale'] = array();
            $ans['male'] = array();

            while($row = $result->fetch_assoc()) {
                if($row['sex'] == 'famale') {
                    array_push($ans['famale'], $row);
                } else {
                    array_push($ans['male'], $row);
                }
            }

            return json_encode($ans); 
        }
        else if(isset($_POST['now_owner']))
        {
        	if ($user['id'] == $_POST['now_owner'] || $user['type'] == 'a11' || $user['type'] == 'm10')
            	$result = $mysqli->query("SELECT * FROM super_chin_all_chins_data WHERE now_owner = ".$_POST['now_owner']);
            else 
            	$result = $mysqli->query("SELECT * FROM super_chin_all_chins_data WHERE now_owner = ".$_POST['now_owner']." AND redacted = 'ready'");

            $ans = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['now_status'] != 'breeding') {
                        if (!isset($ans[$row['now_status']])) {
                            $ans[$row['now_status']] = array();
                        }
                        array_push($ans[$row['now_status']], $row);
                    } 
                    else 
                    {
                        if (!isset($ans[$row['sex']])) {
                            $ans[$row['sex']] = array();
                        }
                        array_push($ans[$row['sex']], $row);
                    }
                }
            }
            return json_encode((Object)$ans); 
        }
        else
        {
            $result = $mysqli->query("SELECT * FROM super_chin_all_chins_data");

            $ans = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($ans, $row);
                }
            }
            return json_encode($ans); 
        }
    }
}
echo answer();
?>