<?
/* Выбор страна, регион, город с использованием технологии Ajax
Взято http://htmlweb.ru/ajax/example/region.php
Разрешается использование в любых своих разработках.
Размешение кода в открытом доступе разрешается только с сохранением активной ссылки на источник.
Все остальные права принадлежат Колесникову Дмитрию Геннадьевичу.
Полная платная версия с базой доступна здесь: http://htmlweb.ru/geo/geo_pay.php.
*/

include_once $_SERVER['DOCUMENT_ROOT'].'/geo/geo.inc.php';
// подключаемся к БД
$link = mysqli_connect(HostName, UserName, Password, DBName);


if(!isset($geo))$geo = new Geo(); // запускаем класс без параметров
if($geo->ip=='127.0.0.1') $geo->get_for_ip('93.178.64.171'); // для отладки
echo "<br>\nВаш IP: <b>".$geo->ip."</b>. <a href=\"/analiz/whois_ip.php?ip=".$geo->ip."\">Информация об IP адресе ".$geo->ip."</a><br /> <br />";

define("db_prefix","geo_");

function sql($query) {
    global $link;
    $res=mysqli_query ( $link, $query );
    if(!$res)die("Запрос:\n".$query."\n");
    return $res;
}

// capital - ссылка на город столица государства
// telcod - телефонный код страны
sql('CREATE TABLE IF NOT EXISTS '.db_prefix.'country (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        PRIMARY KEY ( id ),
        name VARCHAR(64) NOT NULL UNIQUE,
        fullname VARCHAR(64) NOT NULL,
        english VARCHAR(64) NOT NULL,
        country_code2 CHAR(2) NOT NULL,
        country_code3 CHAR(3) NOT NULL,
        iso CHAR(3) NOT NULL,
        telcod CHAR(4) NOT NULL,
        location ENUM("Азия", "Океания", "Европа", "Африка", "Антарктика", "Америка"),
        capital INT UNSIGNED NOT NULL
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_bin');

// capital - ссылка на город, обласной центр
sql('CREATE TABLE IF NOT EXISTS '.db_prefix.'area (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        PRIMARY KEY ( id ),
        name VARCHAR(64) NOT NULL,
        okrug VARCHAR(64) NOT NULL,
        country INT UNSIGNED NOT NULL,
        autocod VARCHAR(12) NOT NULL,
        capital INT UNSIGNED NOT NULL
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_bin');

sql('CREATE TABLE IF NOT EXISTS '.db_prefix.'city (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        PRIMARY KEY ( id ),
        name VARCHAR(64) NOT NULL,
        area INT UNSIGNED NOT NULL,
        telcod CHAR(7) NOT NULL,
        latitude FLOAT(10,6),
        longitude FLOAT(10,6),
        country INT UNSIGNED NOT NULL
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_bin');

// ip - начальный IP адрес диаппазона ip-адресов одного провайдера
// count - количество ip-адресов
sql('CREATE TABLE IF NOT EXISTS '.db_prefix.'geo_ip (
        ip1 BIGINT UNSIGNED NOT NULL UNIQUE,
        ip2 BIGINT UNSIGNED NOT NULL UNIQUE,
        city INT UNSIGNED NOT NULL,
        country INT UNSIGNED NOT NULL,
        upd DATETIME COMMENT "актуальность"
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_bin');

if(isset($_GET['country'])){
   echo "<option value='0'>выбрать регион</option>\n";
   $res = sql('SELECT * FROM '.db_prefix.'area WHERE country="'.addslashes(param('country')).'"');
   while($row = mysqli_fetch_assoc($res))
    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>\n";
   die;
   }
elseif(isset($_GET['region'])){
   echo "<option value='0'>выбрать город</option>\n";
   $res = sql('SELECT * FROM '.db_prefix.'city WHERE area="'.addslashes(param('region')).'"');
    while($row = mysqli_fetch_assoc($res))
    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>\n";
   die;
   }
elseif(isset($_GET['city'])){
$city=addslashes(param('city')); LoadGeo();
echo "
<div style='border: #C5D3DC 1px solid; padding: 10px; width: 97%;'>
Город: <b>". $geo['city']."</b><br />
Регион: <b>". $geo['region']."</b><br />
Округ: <b>". $geo['okrug']."</b><br />
Страна: <b>".$geo['country']."</b><br />
Код страны: <b>".$geo['country_code2']."</b><br />
Код страны: <b>".$geo['country_code3']."</b><br />
Широта: <b>".$geo['latitude']."</b><br />
Долгота: <b>".$geo['longitude']."</b><br />
Телефонный код страны:<b>".$geo['telcod']."</b><br />
Телефонный код города:<b>".$geo['country_telcod']."</b><br />
Автомобильный код региона:<b>".$geo['autocod']."</b><br />
Столица <b>". $geo['capital']."</b><br />
Областной центр <b>". $geo['capital']."</b><br />
</div>";
   die;
}

function LoadGeo() // для $city заполняет $geo и переменные $region, $country
{global $link, $geo, $city, $region, $country;
   $res = sql('SELECT * FROM '.db_prefix.'city WHERE id='.$city.' LIMIT 1');
   if($row = mysqli_fetch_assoc($res)){
     $geo['city']=$row['name'];
     $region=$row['area'];
     $geo['city_telcod']=$row['telcod'];
     $geo['latitude']=$row['latitude'];
     $geo['longitude']=$row['longitude'];
     $res = sql('SELECT * FROM '.db_prefix.'area WHERE id='.$region.' LIMIT 1');
     if($row = mysqli_fetch_assoc($res)){
    $geo['region']=$row['name'];
    $geo['okrug']=$row['okrug'];
    $geo['autocod']=$row['autocod'];
    $country=$row['country'];
    $res = sql('SELECT * FROM '.db_prefix.'country WHERE id='.$country.' LIMIT 1');
    if($row = mysqli_fetch_assoc($res)){
       $geo['country']=$row['name'];
       $geo['fullname']=$row['fullname'];
       $geo['english']=$row['english'];
       $geo['country_code2']=$row['country_code2'];
       $geo['country_code3']=$row['country_code3'];
       $geo['iso']=$row['iso'];
       $geo['country_telcod']=$row['telcod'];
       $geo['location']=$row['location'];
       }
    }
     }
}

$ip2=ip2long(getenv('REMOTE_ADDR'));
$f_add=false;
if($ip2>0){
   $res = sql('SELECT * FROM '.db_prefix.'geo_ip where '.$ip2.' BETWEEN ip1 and ip2 LIMIT 1');
   if ($geo = mysqli_fetch_assoc($res)) {$city=$geo['city']; LoadGeo();}
   }
?>
<br /><br />
<select name="country" id="country" onLoad="this.focus = false;"
    onChange="ajaxLoad('region', '/ajax/example/region.php?country='+this.options[this.selectedIndex].value, '','',''); document.getElementById('region').disabled='';">
<option value="0">выбрать страну</option>

<?
$res = sql('SELECT * FROM '.db_prefix.'country');
while($row = mysqli_fetch_assoc($res)){
   if($row['id']==@$country){
        echo "<option value='" . $row['id'] . "' selected='selected'>" . $row['name'] . "</option>\n";
        $country=$row['id'];}
   else
        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>\n";
}
?>
</select>

<select name="region" id="region" &lt;?=(@$country?'':'disabled="disabled"')?>
    onChange="ajaxLoad('city', '/ajax/example/region.php?region='+this.options[this.selectedIndex].value, '','',''); document.getElementById('city').disabled='';">
<option value="0" disabled="disabled">выбрать регион</option>
<?
if(@$country){
$res = sql('SELECT * FROM '.db_prefix.'area WHERE country='.$country);
while($row = mysqli_fetch_assoc($res)){
   if($row['id']==@$region){
        echo "<option value='" . $row['id'] . "' selected='selected'>" . $row['name'] . "</option>\n";
        $region=$row['id'];}
   else
        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>\n";
   }
}
?>

</select>


<select name="city" id="city" &lt;?=(@$region?'':'disabled="disabled"')?>
    onChange="ajaxLoad('info', '/ajax/example/region.php?city='+this.options[this.selectedIndex].value, '','','');">

<option value="0" disabled="disabled">выбрать город</option>

<?
if(@$region){
$res = sql('SELECT * FROM '.db_prefix.'city WHERE area='.$region);
while($row = mysqli_fetch_assoc($res)){
   if($row['id']==@$city){
        echo "<option value='" . $row['id'] . "' selected='selected'>" . $row['name'] . "</option>\n";
        $region=$row['id'];}
   else
        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>\n";
   }
}
?>
</select>

<div id="info">
</div>

<script type="text/javascript"><!--
function ajaxLoad(obj,url,defMessage,post,callback){
  var ajaxObj;
  if (defMessage) document.getElementById(obj).innerHTML=defMessage;
  if(window.XMLHttpRequest){
      ajaxObj = new XMLHttpRequest();
  } else if(window.ActiveXObject){
      ajaxObj = new ActiveXObject("Microsoft.XMLHTTP");
  } else {
      return;
  }
  ajaxObj.open ((post?'POST':'GET'), url);
  if (post&&ajaxObj.setRequestHeader)
      ajaxObj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=windows-1251;");

  ajaxObj.onreadystatechange = ajaxCallBack(obj,ajaxObj,(callback?callback:null));
  ajaxObj.send(post);
  return false;
  }
function updateObj(obj, data, bold, blink){
   if(bold)data=data.bold();
   if(blink)data=data.blink();
   document.getElementById(obj).innerHTML = data; // упрощенный вариант, работает не во всех браузерах
  }
function ajaxCallBack(obj, ajaxObj, callback){
return function(){
    if(ajaxObj.readyState == 4){
       if(callback) if(!callback(obj,ajaxObj))return;
       if (ajaxObj.status==200)
        updateObj(obj, ajaxObj.responseText);
       else updateObj(obj, ajaxObj.status+' '+ajaxObj.statusText,1,1);
    }
}}

//--></script>