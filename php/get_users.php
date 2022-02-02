<?php
function answer() {
    $mysqli = new mysqli("81.90.180.128", "database_super_chin", "chin_super_database", "database_super_chin");
    if ($mysqli->connect_errno) {
        echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    $result = $mysqli->query("SELECT id, login, first_name, last_name, avatar, country, older_chin city FROM super_chin_users_all_data");

    $ans = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($ans, $row);
        }
    }
    return json_encode($ans);
}
echo answer();
?>