<?php

function can_upload($file){
		// если имя пустое, значит файл не выбран
		if($file['name'] == '')
				return 'Вы не выбрали файл.';
		
		/* если размер файла 0, значит его не пропустили настройки 
		сервера из-за того, что он слишком большой */
		if($file['size'] == 0)
				return 'Файл слишком большой.';
		
		// разбиваем имя файла по точке и получаем массив
		$getMime = explode('.', $file['name']);
		// нас интересует последний элемент массива - расширение
		$mime = strtolower(end($getMime));
		// объявим массив допустимых расширений
		$types = array('jpg', 'png', 'bmp', 'jpeg');
		
		// если расширение не входит в список допустимых - return
		if(!in_array($mime, $types))
				return 'Недопустимый тип файла.';
		
		return true;
		}
  
function make_upload($mysqli, $file, $user, $id){
		$result = $mysqli->query("SELECT * FROM super_chin_all_chins_data WHERE id = ".$id.";");

		// формируем уникальное имя картинки: случайное число и name

		$row = $result->fetch_assoc();

		$key = ((int)$row['id'] + 10000) * 13873 + 1777;

		$getMime = explode('.', $file['name']);
		// нас интересует последний элемент массива - расширение
		$mime = strtolower(end($getMime));

		$name = mt_rand(0, 10000) . mt_rand(0, 10000) . mt_rand(0, 10000) . "." . $mime;
		mkdir('../Datas/'.$key, 0777);
		copy($file['tmp_name'], '../Datas/'.$key.'/'.$name);
		echo '../Datas/'.$key.'/'.$name;

		$images = json_decode($row['images']);
		array_push($images, '../Datas/'.$key.'/'.$name);
		$images = array_unique($images);
		$images = json_encode($images);
		$mysqli->query("UPDATE super_chin_all_chins_data SET images = '".$images."' WHERE id = ".$id.";");
}
	
include_once "../components/php-funs.php";

$mysqli = BaseConect();

		$result = $mysqli->query("SELECT * FROM super_chin_users_all_data WHERE login = '".$_POST['login']."' AND password = '".$_POST['password']."';");
    
		if($result->num_rows > 0)
		{
				$row = $result->fetch_assoc();
      	// проверяем, можно ли загружать изображение
      	$check = can_upload($_FILES['files']);
    
      	if($check === true){
        // загружаем изображение на сервер
        		make_upload($mysqli, $_FILES['files'], $row['id'], $_POST['chin']);
      	}
  	}
?>