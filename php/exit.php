<?php
setcookie("login", "", time() - 100, "/");
setcookie("password", "", time() - 100, "/");
setcookie("oldPage", "", time() - 100, "/");
header('Location: ../regist.php');
?>