<!doctype html>
<html>
<head>
<?php
include_once "../components/php-funs.php";

$mysqli = BaseConect();

if (!isset($_COOKIE['login']) || !isset($_COOKIE['password'])) {
    setcookie('oldPage', 'Location: http://super-chin.h1n.ru/dna-base');
    header('Location: http://super-chin.h1n.ru/regist');
}

$result = $mysqli->query("SELECT * FROM super_chin_users_all_data WHERE login = '".$_COOKIE['login']."' AND password = '".$_COOKIE['password']."';");

if ($result->num_rows == 0) {
    setcookie('oldPage', 'Location: http://super-chin.h1n.ru/dna-base');
    header('Location: http://super-chin.h1n.ru/regist');
}

$row = $result->fetch_assoc();
$id_profile = $row['id'];
?>
<meta charset="utf-8">
<title>CHINCHILLAS-SHOW - Профиль шиншиллы</title>
<?php
    include_once "../components/import.html";
?>

<style type="text/css">
    .centerBlock {
        margin: 100px 30%;
        border: 2px solid red;
        border-radius: 5px;
    }
    .line {
        width: 100%;
        height: 10px;
        background-color: yellow;
    }
    .chin-block {
        border: 1px solid black;
        padding: 0;
        margin: 0;
        height: 240px;
    }
    .unknow {
        border: 1px solid black;
        padding: 0;
        margin: 0;
        height: 240px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card {
        flex-direction: initial;
        display: initial;
    }
    .row {
        margin-bottom: 0;
    }
    .modal {
        max-height: initial;
        background-color: initial;
        bottom: initial;
    }
    .carousel .carousel-item {
        visibility: initial;
        width: 100%;
        height: auto;
        position: initial;
    }
    @media (min-width: 800px) {
        .card-columns {
            column-count: 5;
        }
    }
    #avatar {
        width     : 100%;
        height    : 340px;
        margin    : 0;
    }
    
    .top-block {
        padding-top   : 80px;
        padding-bottom: 80px;
    }
    .top-item-text {
        display         : block;
        width           : 100%;
        font-size       : 16px;
        font-weight     : 200;
        background-color: rgba(8, 208, 255, 0.8);
    }
    .top-item-text-left {
        padding-right: 15px;
    }
    .top-item-text-right {
        padding-left: 15px;
    }
    .transform-border {
        position: relative;
        margin  : 0 auto;
    }
    .transform-border {
        transform: perspective(3000px) rotateY(29deg);
    }

    .transform-border div {
        display   : block;
        width     : 100%;
        box-shadow: -12px 11px 1px #f2f2f2;
    }
    .transform-border:after {
        content   : "";
        position  : absolute;
        width     : 100%;
        height    : 100%;
        left      : -22px;
        top       : 22px;
        background: #cccccc;
        z-index   : -1;
    }
    #more-photo {
        max-height: 200px; 
        overflow: hidden;
        box-shadow: 0 -40px 300px 0px #00000094 inset;

        transition-property: max-height, box-shadow;
        transition-duration: .5s;
    }
</style>
</head>

<body>
    <!--if ($chinData[$_GET['id']]['weight'] != 'Не указано') echo '<p>Вес шиншиллы: '.$chinData[$_GET['id']]['weight'].'</p>';
    if ($chinData[$_GET['id']]['brothers'] != 'Не указано') echo '<p>Шиншилл в помёте: '.$chinData[$_GET['id']]['brothers'].'</p>';
    if ($chinData[$_GET['id']]['winer'] != 'Не указано') echo '<p>Награды: '.$chinData[$_GET['id']]['winer'].'</p>';
    if ($chinData[$_GET['id']]['about'] != 'Не указано') echo '<p>Дополнительно: '.$chinData[$_GET['id']]['about'].'</p>';-->
    <?php 
    if ($file[$_COOKIE['login']]['type'] == 'a11') { ?>
        <div id="redact-window" style="position: fixed; top: 30px; right: 0; z-index: 10; margin: 0;">
            <div id="lever-redact" style="background-color: gray; height: 30px; width: 400px; margin: 0;">
                <p style="margin-right: 0; width: 90px; display: inline-block; font-size: 18px;" onclick="$('iframe').toggle(300)">Свернуть</p>
                <p style="right: 0; width: 60px; display: inline-block; font-size: 18px;" onclick="fastenRedact(this)">
                    <?php echo ((isset($_COOKIE['redactedID']))?"Открепить":"Закрепить"); ?></p>
            </div>
            <iframe <?php echo ((isset($_COOKIE['redactedID']))?"":'style="display: none;"'); ?> src="redact-chin.php?id=<?php echo ((isset($_COOKIE['redactedID']))?$_COOKIE['redactedID']:$_GET['id']).
                "&login=".((isset($_COOKIE['redactedLogin']))?$_COOKIE['redactedLogin']:$_GET['user']); ?>" width="400" height="400">
                Ваш браузер не поддерживает плавающие фреймы!
            </iframe>
        </div>
    <?php } ?>
    
    <script type="text/javascript">
    /*$(document).ready(function(){
        $('#lever-redact').css('max-width', $(window).width());
        var mouseXY = null;
        $("#lever-redact").on('mousedown touchstart', function(e) {
            if (typeof e.pageX == "undefined") {
                mouseXY = [e.touches[0].pageX, e.touches[0].pageY];
            } else {
                mouseXY = [e.pageX, e.pageY];
            }
            e.preventDefault();
            windowXY = [$('#redact-window').offset().left, $('#redact-window').offset().top];
        });
        $(document).on('mousemove touchmove', function(e) {
            if (mouseXY != null) {
                if (typeof e.pageX == "undefined") {
                    $('#redact-window').offset({top: windowXY[1] + e.touches[0].pageY - mouseXY[1],
                        left: windowXY[0] + e.touches[0].pageX - mouseXY[0]});
                } else {
                    $('#redact-window').offset({top: windowXY[1] + e.pageY - mouseXY[1],
                        left: windowXY[0] + e.pageX - mouseXY[0]});
                }
            }
        });
        $(document).on('mouseup touchend', function(e){
            mouseXY = null;
        });
    });
    
    const fastenRedact = (el) => {
        if ($(el).text() == "Закрепить") {
            document.cookie = "redactedLogin=<?php echo $_GET['user']; ?>";
            document.cookie = "redactedID=<?php echo $_GET['id']; ?>";
            $(el).text("Открепить");
        } else {
            Cookies.remove("redactedLogin");
            Cookies.remove("redactedID");
            $(el).text("Закрепить");
        }
    }
            
    $('#fullColor').text('Окрас шиншиллы: ' + fullChinColor(<?php
    $i = 0;
    foreach ($chinData[$_GET['id']]['colors'] as $nameColor => $color) {
        if ($i != 0) echo ', ';
        echo '"'.$color.'"';
        $i++;
    } ?>));*/

    Vue.component('relation-block', {
        props: ['chin'],
        template: `<a class="d-block col-12 chin-block" :href="'profile-chin.php?profile=' +
        chin.breader + '&chin=' + chin.id">
            <img class="img-fluid" :src="chin.avatar"/>
            <p>{{chin.name_chin}} | {{chin.id}}</p>
        </a>`
    })

    const search = (step, line, mother, father) => {
        step++;

        var arr_chin = [];

        if (mother != "Не указано" && step < 4) {
            var fline = line + "f";
            $.ajax({
                url: '../php/get_chins.php',
                type: 'POST',
                data: {login: Cookies.get('login'), password: Cookies.get('password'), id: mother},
                success: function(data) {
                    let mother = JSON.parse(data);

                    $('#' + fline + '-container-' + step).html(`<div class="card` + ((step == 1)?` horizontal`:``) + ` m-0">
                            <div class="card-image">
                                <img src="` + mother.avatar + `">
                                <span class="card-title">` + mother.name_chin + `</span>
                            </div>
                            ` + ((step == 1)?`<div class="card-stacked">`:``) + `
                                <div class="card-content">
                                    <p>` + mother.name_chin + ` | ` + mother.id + `</p>
                                </div>
                                <div class="card-action">
                                    <a href="profile-chin.php?profile=` +
                            mother.breader + `&chin=` + mother.id + `">Перейти</a>
                                </div>
                            ` + ((step == 1)?`</div>`:``) + `
                    </div>`);
                    arr_chin = arr_chin.concat(JSON.parse(mother.childrens));

                    if(step == 1) {
                            $.ajax({
                                url: '../php/get_chins.php',
                                type: 'POST',
                                data: {login: Cookies.get('login'), password: Cookies.get('password'), array_id: JSON.stringify(arr_chin)},
                                success: function(data) {
                                    let chins = JSON.parse(data);
                                    for (let i in chins) {
                                        if (+chins[i].id != <?= $_GET['chin'] ?>) {
                                            profileChin.$set(profileChin.brothers, chins[i].id, chins[i]);
                                        }
                                    }
                                }
                            });
                        }

                    search (step, fline, mother.mother, mother.father);
                }
            });
        };
        if (father != "Не указано" && step < 4) {
            var mline = line + "m";
            
            $.ajax({
                url: '../php/get_chins.php',
                type: 'POST',
                data: {login: Cookies.get('login'), password: Cookies.get('password'), id: father},
                success: function(data) {
                    let father = JSON.parse(data);
                    
                    $('#' + mline + '-container-' + step).html(`<div class="card` + ((step == 1)?` horizontal`:``) + ` m-0">
                            <div class="card-image">
                                <img src="` + father.avatar + `">
                                <span class="card-title">` + father.name_chin + `</span>
                            </div>
                            ` + ((step == 1)?`<div class="card-stacked">`:``) + `
                                <div class="card-content">
                                    <p>` + father.name_chin + ` | ` + father.id + `</p>
                                </div>
                                <div class="card-action">
                                    <a href="profile-chin.php?profile=` +
                                    father.breader + `&chin=` + father.id + `">Перейти</a>
                                </div>
                            ` + ((step == 1)?`</div>`:``) + `
                    </div>`);
                        
                        arr_chin = arr_chin.concat(JSON.parse(father.childrens));

                        if(step == 1) {
                            $.ajax({
                                url: '../php/get_chins.php',
                                type: 'POST',
                                data: {login: Cookies.get('login'), password: Cookies.get('password'), array_id: JSON.stringify(arr_chin)},
                                success: function(data) {
                                    let chins = JSON.parse(data);
                                    for (let i in chins) {
                                        if (+chins[i].id != <?= $_GET['chin'] ?>) {
                                            profileChin.$set(profileChin.brothers, chins[i].id, chins[i]);
                                        }
                                    }
                                }
                            });
                        }

                    search (step, mline, father.mother, father.father);
                }
            });
        };
    }

    const removeSrc = (src) => {
        let index =  profileChin.chinData.images.indexOf(src);
        profileChin.chinData.images.splice(index, 1);
    }

    Vue.component("chin-block", {
        props: ['chin'],
        template: `<div class="card col-3 m-0 p-0">
                            <div class="card-image">
                                <img :src="chin.avatar">
                                <span class="card-title">{{chin.name_chin}}</span>
                            </div>
                            <div class="card-content p-0">
                                <p>{{chin.name_chin}} | {{chin.id}}</p>
                            </div>
                            <div class="card-action">
                                <a :href="'profile-chin.php?profile=' + chin.breader + '&chin=' + chin.id">Перейти</a>
                            </div>
                    </div>`
    });

    Vue.component("photo-block", {
        props: ['src', 'num'],
        data: function () {
            return {
                srcImage: this.src,
                thisNum: this.num
            }
        },
        methods: {
            <?php
            if ($_GET['profile'] == $id_profile) { ?>
            deleteImage: function () {
                if (confirm("Удалить фотографию?")) {
                    let srcImage = this.srcImage;
                    $.ajax({
                        url: '../php/remove_image.php',
                        type: 'POST',
                        data: {src: srcImage, chin: chinID, login: Cookies.get('login'), password: Cookies.get('password')},
                        success: function(data) {
                            removeSrc(srcImage);
                        }
                    });
                }
            },
            toAvatar: function () {
                let srcImage = this.srcImage;
                $.ajax({
                    url: '../php/to_avatar.php',
                    type: 'POST',
                    data: {src: srcImage, chin: chinID, login: Cookies.get('login'), password: Cookies.get('password')},
                    success: function(data) {
                        profileChin.$set(profileChin.chinData, 'avatar', srcImage);
                    }
                });
            },
            <?php
            } ?>
            showModal: function() {
                this.$emit('activing-photo', this.thisNum);
                this.$nextTick(function () {
                    M.Modal.getInstance(document.getElementById('photoModal')).open();
                });
            }
        },
        template: `<div class="card p-0">
                <div class="card-image">
                    <img :src="src" @click="showModal">
                </div>
            <?php
            if ($_GET['profile'] == $id_profile) { ?>
                <div class="card-action">
                    <a href="" @click="deleteImage">Удалить</a>
                    <a href="" @click="toAvatar">На аватар</a>
                </div>
        <?php
        } ?>
        </div>`
    });
    </script>
    
    <script type="text/javascript">
        const setStatus = () => {
            if (confirm("Изменить статус?")) {
                $.ajax({
                    url: '../php/add_status.php',
                    type: 'POST',
                    data:  {status: $('#set-status').val(), cost: $('#cost').val(), 
                        currency: $('#currency').val(), chin: chinID, 
                        login: Cookies.get('login'), password: Cookies.get('password')},
                    success: function(data) {
                        // Получаем ответ с сервера с помощью ajax
                        $('#more-status').prepend('<div>' + Date() + ' - ' + $('#set-status').val() + '</div>');
                    }
                });
            }
        }
    </script>
    
    <?php
    echo '<script type="text/javascript">
    var profile = "'.$_GET['profile'].'";
    var chinID = "'.$_GET['chin'].'";
    </script>'; ?>

<div id="profile-chin">

<nav class="teal lighten-2" style="top: 0;">

<a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
<div class="nav-wrapper">
    <p class="brand-logo">Поиск пользователей</p>
    <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="../">Главная</a></li>
        <li><a href="../dna-base">Мой профиль</a></li>
        <li><a href="../dna-base/search-user">Люди</a></li>
        <li><a href="../dna-base/search-chin">Шиншиллы</a></li>
        <li><a href="../dna-base/calculator">Калькулятор</a></li>
        <li><a href="../php/exit.php">Выход</a></li>
    </ul>
</div>

<ul class="sidenav" id="mobile-demo">
    <li><a href="../">Главная</a></li>
    <li><a href="../dna-base">Мой профиль</a></li>
    <li><a href="../dna-base/search-user">Люди</a></li>
    <li><a href="../dna-base/search-chin">Шиншиллы</a></li>
    <li><a href="../dna-base/calculator">Калькулятор</a></li>
    <li><a href="../php/exit.php">Выход</a></li>
    <li><hr /></li>
</ul>

</nav>

<?php 
if ($_GET['profile'] == $id_profile) {
    //echo '<a href="redact-chin.php?profile='.$_GET["profile"].'&chin='.$_GET["chin"].'">Редактировать</a>';
}
?>

<div class="position-fixed" style="width: 100vw; height: 100vh; overflow-x: hidden; z-index: -1; top: 0; 
    background: url(../Datas/site/dna-base-img/BackgroundTopNew.JPG) no-repeat center / cover">
</div>
<header class="container-fluid" style="background-color: rgba(255, 255, 255, 0.5);">
    <div class="container top-block">
        <div class="row">
            <div class="col-lg-6 col-12 p-0">
                <!--img src="<?php echo $avatarImage; ?>" class="img-fluid img-thumbnail" style="width: 100%"-->
                <div class="transform-border modal-trigger" data-target="redact-info">
                    <div id="avatar" :style="'background: url(' + chinData.avatar + ') no-repeat center / cover;'"></div>
                </div>
            </div>
            <div class="col-lg-3 col-3 text-right d-flex p-0">
                <div class="row justify-content-center m-auto py-4" style="border-right: 1px solid black;">
                    <p class="top-item-text top-item-text-left">id шиншиллы</p>
                    <p class="top-item-text top-item-text-left">Кличка</p>
                    <p class="top-item-text top-item-text-left">Дата рождения</p>
                    <p class="top-item-text top-item-text-left">Пол</p>
                    <p class="top-item-text top-item-text-left m-0">Заводчик</p>
                </div>
            </div>
            <div class="col-lg-3 col-9 d-flex p-0">
                <div class="row justify-content-center m-auto">
                    <p class="top-item-text top-item-text-right" id="profile-login">{{chinData.id}}</p>
                    <p class="top-item-text top-item-text-right" id="profile-first_name">{{chinData.name_chin}}</p>
                    <p class="top-item-text top-item-text-right" id="profile-last_name">{{chinData.birthday}}</p>
                    <p class="top-item-text top-item-text-right" id="profile-tel">{{(chinData.sex=="famale")?"Самка":"Самец"}}</p>
                    <p class="top-item-text top-item-text-right m-0" id="profile-email">{{chinData.breader}}</p>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container-fluid" style="background: #fff;">

    <p id="fullColor"></p>
    <ul class="collapsible popout">
        <li>
            <div class="collapsible-header">{{chinData.status[0].date}} - {{chinData.status[0].status}}<p 
                v-if="chinData.status[0].status=='sale'" class="m-0"
                >{{chinData.status[0].cost}} {{chinData.status[0].currency}}</p></div>
            <div class="collapsible-body p-0">
                <ul class="collection">
                    <li class="collection-item" v-for="(status, index) in chinData.status" v-if="index != 0" 
                        :key="index">{{status.date}} - {{status.status}}<p v-if="status.status=='sale'"> {{status.cost}} {{status.currency}}</p></li>
                </ul>  
            </div>
        </li>
    </ul>
    <?php
    if ($_GET['profile'] == $id_profile) { ?>
        <div class="row">
            <div class="input-field">
                <select id="set-status" name="status" v-model="status">
                    <option selected value="baby">Малыш</option>
                    <option value="not_breeding">Не в разведении</option>
                    <option value="breeding">В разведении</option>
                    <option value="sale">Продается</option>
                    <option value="sold">Продан</option>
                    <option value="reserve">В резерве</option>
                    <option value="transfer">Трансфер</option>
                    <option value="died">Умер</option>
                </select>
                <label>Статус</label>
            </div>
            <div class="input-field" v-show="status=='sale'">
                <input id="cost" type="number" class="validate black-text">
                <label for="cost">Стоимость</label>
            </div>
            <div class="input-field" v-show="status=='sale'">
                <select id="currency" name="currency">
                    <option selected value="ruble">&#8381;</option>
                    <option value="dollar">&#36;</option>
                    <option value="euro">&euro;</option>
                </select>
                <label>Валюта</label>
            </div>
            <button class="waves-effect waves-light btn" onClick="setStatus()">Добавить статус</button>
        </div>
    <?php
    } ?>

    <div class="container-fluid">

        <div class="modal" id="photoModal" style="width: 85%; margin-top: -50px;">
            <div class="modal-content p-0 border-0 rounded-0" style="box-shadow: initial; 
                background: linear-gradient(to right, #ccc 0%, #fff 30%, #fff 70%, #ccc 100%);">

<div id="carouselExampleControls" class="carousel slide carousel-fade" style="height: 540px;" data-ride="carousel" data-interval="false">
  <div class="carousel-inner">
    <div v-for="(photo, index) in chinData.images" style="height: 540px;" :key="index" class="carousel-item" :class="{'active': (index == activedPhoto)}">
      <div class="d-block w-100" style="height: 540px;" :style="{background: 'url(' + photo + ') no-repeat center / contain' }"></div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" style="transform: scale(2);" aria-hidden="true"></span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" style="transform: scale(2);" aria-hidden="true"></span>
  </a>
</div>
                        <!--a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a-->
                </div>
                <div class="modal-footer">
                    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Закрыть</a>
            </div>
        </div>
        <h4 @click="MorePhoto">Больше</h4>
        <div id="more-photo">
            <div class="card-columns">
                <photo-block v-for="(photo, index) in chinData.images" :key="index" :num="index" :src="photo" @activing-photo="activedPhoto = $event"></photo-block>
            </div>
        </div>
        <?php
        if ($_GET['profile'] == $id_profile) { ?>
        <div class="file-field input-field" :disabled="isWait">
            <div class="btn">
                <span>Загрузить фотографии</span>
                <input id="new-photo" @change="uploadPhoto" name="picture" type="file" 
                    accept="image/jpeg,image/png,image/jpg" multiple>
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Выберите файлы">
            </div>
        </div>
        <div v-show="isWait" id="wait" class="progress">
            <div class="indeterminate"></div>
        </div>
        <?php
        } ?>
    </div>
    
    <div class="row parents-data">
        <div class="container-fluid" style="background-color: yellow">Родители</div>
        <div id="f-container-1" class="col-6 p-0" style="padding: 0;">
                    <p class="col-12 unknow">Неизвесно</p>
                </div>
        <div id="m-container-1" class="col-6 p-0" style="padding: 0;">
                    <p class="col-12 unknow">Неизвесно</p>
                </div>
        <div class="container-fluid" style="background-color: yellow">Пра-родители</div>
        <div id="ff-container-2"  class="col-3 p-0" style="padding: 0;">
                    <p class="col-12 unknow">Неизвесно</p>
                </div>
        <div id="fm-container-2"  class="col-3 p-0" style="padding: 0;">
                    <p class="col-12 unknow">Неизвесно</p>
                </div>
        <div id="mf-container-2"  class="col-3 p-0" style="padding: 0;">
                    <p class="col-12 unknow">Неизвесно</p>
                </div>
        <div id="mm-container-2"  class="col-3 p-0" style="padding: 0;">
                    <p class="col-12 unknow">Неизвесно</p>
                </div>
        <div class="container-fluid" style="background-color: yellow">Пра-пра-родители</div>
        <div class="col-3 p-0">
            <div class="row">
                <div id="fff-container-3"  class="col-12" style="padding: 0;">
                    <p class="col-12 unknow">Неизвесно</p>
                </div>
                <div id="ffm-container-3"  class="col-12" style="padding: 0;">
                    <p class="col-12 unknow">Неизвесно</p>
                </div>
            </div>
        </div>
        <div class="col-3 p-0">
            <div class="row">
                <div id="fmf-container-3"  class="col-12" style="padding: 0;">
                    <p class="col-12 unknow">Неизвесно</p>
                </div>
                <div id="fmm-container-3"  class="col-12" style="padding: 0;">
                    <p class="col-12 unknow">Неизвесно</p>
                </div>
            </div>
        </div>
        <div class="col-3 p-0">
            <div class="row">
                <div id="mff-container-3"  class="col-12" style="padding: 0;">
                    <p class="col-12 unknow">Неизвесно</p>
                </div>
                <div id="mfm-container-3"  class="col-12" style="padding: 0;">
                    <p class="col-12 unknow">Неизвесно</p>
                </div>
            </div>
        </div>
        <div class="col-3 p-0">
            <div class="row">
                <div id="mmf-container-3"  class="col-12" style="padding: 0;">
                    <p class="col-12 unknow">Неизвесно</p>
                </div>
                <div id="mmm-container-3"  class="col-12" style="padding: 0;">
                    <p class="col-12 unknow">Неизвесно</p>
                </div>
            </div>
        </div>
        <div class="container-fluid" style="background-color: yellow">Дети</div>
        <div id="childrens-block" class="container-fluid row p-0">
            <chin-block v-for="(children, index) in childrens" :key="index" :chin="children">
            </chin-block>
        </div>
        <div class="container-fluid" style="background-color: yellow">Братья и сестры</div>
        <div id="brothers-block" class="container-fluid row p-0">
            <chin-block v-for="(brother, index) in brothers" :key="index" :chin="brother">
            </chin-block>
        </div>
    </div>

    </div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript">

/*document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.carousel');
    var instances = M.Carousel.init(elems, {
        duration: 500,
        numVisible: 1,
        fullWidth: true,
        indicators: true
    });
});*/

    var profileChin = new Vue ({
        el: '#profile-chin',
        data: {
            activedPhoto: 0,
            isWait: false,
            
            chinData: {},
            childrens: [],
            brothers: {},

            status: "baby"
        },
        created () {
            let step = 0;

            $.ajax({
                url: '../php/get_chins.php',
                type: 'POST',
                data: {login: Cookies.get('login'), password: Cookies.get('password'), id: chinID},
                success: function(data) {
                    let thisChin = JSON.parse(data);
                    let date = new Date(+thisChin.birthday);
                    thisChin.birthday = date.getDate() + "." + (date.getMonth() < 9 ? "0" : "") + (date.getMonth() + 1) + "." + date.getFullYear();
                    thisChin.status = JSON.parse(thisChin.status);
                    for (let i in thisChin.status) {
                        date = new Date(+thisChin.status[i].date);
                        thisChin.status[i].date = date.getDate() + "." + (date.getMonth() < 9 ? "0" : "") + (date.getMonth() + 1) + "." + date.getFullYear();
                    }
                    thisChin.images = JSON.parse(thisChin.images);
                    profileChin.chinData = thisChin;

                    search (step, "", thisChin.mother, thisChin.father);

                    $.ajax({
                        url: '../php/get_chins.php',
                        type: 'POST',
                        data: {login: Cookies.get('login'), password: Cookies.get('password'), array_id: thisChin.childrens},
                        success: function(data) {
                            profileChin.childrens = JSON.parse(data);
                        }
                    });
                }
            });
            $(document).ready(function(){
                $('select').formSelect();

                $('.modal').modal();

                $('.collapsible').collapsible();
            });
        }, 
        methods: {
            MorePhoto: function() {
                if($('#more-photo').css('max-height') == "200px") {
                    $('#more-photo').css('max-height', "2000px");
                    $('#more-photo').css('box-shadow', "0 0 0 0 #00000094 inset");
                    setTimeout(() => {
                        $('#more-photo').css('overflow', "auto");
                    }, 500);
                } else {
                    $('#more-photo').css('max-height', "200px");
                    $('#more-photo').css('overflow', "hidden");
                    $('#more-photo').css('box-shadow', "0 -40px 300px 0 #00000094 inset");
                }
            }
        <?php
        if ($_GET['profile'] == $id_profile) {?>
                , uploadPhoto: function (event) {
                    var files = $('#new-photo').get(0).files;
                    for (let i = 0; i < files.length; i++) {
                        var fd = new FormData;
                    
                        fd.append('files', files[i]);
                        fd.append('login', Cookies.get('login'));
                        fd.append('password', Cookies.get('password'));
                        fd.append('chin', chinID);
            
                        profileChin.isWait = true;
                        $.ajax({
                            url: '../php/add_photo.php',
                            type: 'POST',
                            data: fd,
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                // Получаем ответ с сервера с помощью ajax
                                profileChin.chinData.images.push(data);
                                profileChin.isWait = false;
                            }
                        });
                    }
                }
        <?php
        } ?>
        }
    });
</script>
</body>
</html>