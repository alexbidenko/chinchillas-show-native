<?php
include_once "../components/php-funs.php";

$mysqli = BaseConect();

$result = $mysqli->query("SELECT * FROM super_chin_regist_show_data WHERE 
    show_index = 1;"); //(SELECT show_index FROM super_chin_all_shows WHERE id = MAX(id))

$max_rus = 0;
$row_max = array();
$index = 0;

$second_rus = 0;
$row_second = array();
$index_second = 0;

while($row = $result->fetch_assoc()) {
    $registedChins = json_decode($row['registedChins']);
    foreach($registedChins as $num => $chin) {
        $total = 0;
        if(isset($registedChins[$num]->result)) {
            foreach($registedChins[$num]->result as $expert => $data) {
                if($expert == 'e1') {
                    if(isset($registedChins[$num]->result->{$expert}->position)) {
                        unset($registedChins[$num]->result->{$expert}->position);
                    }

                    foreach($registedChins[$num]->result->{$expert} as $points) {
                        if(is_numeric($points)) {
                            $total += intval($points);
                        }
                    }

                    if ($total > $max_rus) {
                        $second_rus = $max_rus;
                        $row_second = $row_max;
                        $index_second = $index;

                        $max_rus = $total;
                        $row_max = $row;
                        $index = $num;
                    }

                    if ($total > $second_rus && $total < $max_rus) {
                        $second_rus = $total;
                        $row_second = $row;
                        $index_second = $num;
                    }
                }
            }
        }
    }
}

if ($max_rus > 0) {
    $registedChins = array();

    foreach(json_decode($row_max['registedChins']) as $key => $value) {
        if(gettype($value) == "object") {
            $value = (array) $value;

            foreach($value as $k => $v) {
                if(gettype($v) == "object") {
                    $value[$k] = (array) $v;

                    foreach($v as $k_in => $v_in) {
                        if(gettype($v_in) == "object") {
                            $value[$k][$k_in] = (array) $v_in;
                        }

                        if($key == $index && $k_in == 'e1') {
                            $value[$k][$k_in]['position'] = "1";
                        }

                        if ($index_second == $index && $key == $index_second && $k_in == 'e1') {
                            $value[$k][$k_in]['position'] = "2";
                        }
                    }
                }
            }
        }
        $registedChins[$key] = $value;
    }

    $mysqli->query("UPDATE super_chin_regist_show_data SET
        registedChins = '".json_encode($registedChins)."' 
        WHERE id = ".$row_max['id'].";");
}

if ($second_rus > 0 && $index_second != $index) {
    $registedChins = array();

    foreach(json_decode($row_second['registedChins']) as $key => $value) {
        if(gettype($value) == "object") {
            $value = (array) $value;

            foreach($value as $k => $v) {
                if(gettype($v) == "object") {
                    $value[$k] = (array) $v;

                    foreach($v as $k_in => $v_in) {
                        if(gettype($v_in) == "object") {
                            $value[$k][$k_in] = (array) $v_in;
                        }

                        if($key == $index_second && $k_in == 'e1') {
                            $value[$k][$k_in]['position'] = "2";
                        }
                    }
                }
            }
        }
        $registedChins[$key] = $value;
    }

    $mysqli->query("UPDATE super_chin_regist_show_data SET
        registedChins = '".json_encode($registedChins)."' 
        WHERE id = ".$row_second['id'].";");
}
?>