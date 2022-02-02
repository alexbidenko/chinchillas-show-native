<!doctype html>
<html>
<head>
<meta charset="utf-8">
<?php
    include_once "../components/import.html";
?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<link href="../dna-base/css/dna-base.css" rel="stylesheet">

<style type="text/css">

</style>
<?php

include_once "../components/php-funs.php";

$mysqli = BaseConect();

$user = CheckUser($mysqli);

/*if(!RightsCheck($user, ['a11'])) {
    header('Location: regist');
    echo '<script type="text/javascript">
        location.href = "regist";
    </script>';
}*/

if (!$user) {
    setcookie('oldPage', 'Location: ../dna-base');
    header('Location: ../regist');
    echo '<script type="text/javascript">
        location.href = "../regist";
    </script>';
}

if (!isset($_GET['profile']) || $_GET['profile'] == "") {
    $_GET['profile'] = $user['id'];
}

$result = $mysqli->query("SELECT * FROM super_chin_users_all_data WHERE id = ".$_GET['profile']);

$profile = $result->fetch_assoc();

$login = $profile['login'];
$firstName = $profile['first_name'];
$lastName = $profile['last_name'];
$middleName = $profile['middle_name'];
$tel = $profile['tel'];
$email = $profile['email'];
$country = $profile['country'];
$city = $profile['city'];
$idUser = $profile['id'];
$avatarImage = $profile['avatar'];

?>
<title>CHINCHILLAS-SHOW - Профиль<?= " ".$login ?></title>

<script type="text/javascript">
    Vue.component('chin-block', {
        props: ['chin'],
        template: `<div class="portfolio-item col-lg-3 col-md-6 col-12">
            <div class="portfolio-item-wrap">
                <img :src="chin.avatar">
                <div class="portfolio-item-inner">
                    <div class="portfolio-heading">
                        <h3>{{chin.name_chin}}</h3>
                    </div>
                    <p>{{color_chin}}</p>
                </div>
                <a :href="'../dna-base/profile-chin.php?profile=<?php echo $_GET['profile']; ?>&chin='+chin.id"></a>
            </div>
        </div>`,
        computed: {
            color_chin: function() {
                let colors = JSON.parse(this.chin.colors.replace(new RegExp('u0','g'),'\\u0'));
                return fullChinColor(colors.standart, colors.white, colors.mosaic, colors.beige, 
                    colors.violet, colors.sapphire, colors.angora, colors.ebony, colors.velvet, 
                    colors.pearl, colors.california, colors.rex, colors.lova, colors.german, 
                    colors.blue, colors.fur);
            }
        }
    });
</script>
</head>

<body>
    <?php
    if ($result->num_rows == 0) {
        header('Location: ../no-page.php');
    } else {
        if ($user['type'] == 'a11') { ?>
            <!--div id="change-type">
            <label>
                <p>Изменить тип аккаунта</p>
                <select size="1" v-model="type">
                    <option value="u1" selected>Пользователь</option>
                    <option value="e6">Эксперт</option>
                    <option value="m10">Модератор</option>
                    <option value="a11">Администратор</option>
                </select>
            </label>
            </div-->
            <script type="text/javascript">
                var changeType = new Vue ({
                    el: '#change-type',
                    data: {
                        type: "<?php echo $profile['type']; ?>"
                    },
                    watch: {
                        type: function () {
                            $.ajax({
                                url: '../php/change_attr.php',
                                type: 'POST',
                                data: {user: "<?php echo $_GET['profile']; ?>", type: changeType.type}
                            });
                        }
                    }
                });
            </script>
        <?php }

        echo '<div class="chat-view container-fluid p-0" style="overflow: hidden;">';
        include_once "../components/messager/online_chat.html";
        echo '</div>';
    }
    ?>
<nav class="position-absolute teal lighten-2" style="top: 0; left: 0;">
    <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    <div class="container nav-wrapper">
        <p class="brand-logo">Профиль</p>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="../">Главная</a></li>
            <li><a href="../dna-base/search-user">Люди</a></li>
            <li><a href="../dna-base/search-chin">Шиншиллы</a></li>
            <li><a href="../dna-base/calculator">Калькулятор</a></li>
            <li><a href="../php/exit">Выход</a></li>
        </ul>
    </div>
</nav>

<ul class="sidenav" id="mobile-demo">
    <li><a href="../">Главная</a></li>
    <li><a href="../dna-base/search-user">Люди</a></li>
    <li><a href="../dna-base/search-chin">Шиншиллы</a></li>
    <li><a href="../dna-base/calculator">Калькулятор</a></li>
    <li><a href="../php/exit">Выход</a></li>
</ul>

<div class="circle-button d-block" onclick="openChat()">
    <i class="material-icons md-24">chat</i>
</div>
<div class="position-fixed" style="width: 100vw; height: 100vh; overflow-x: hidden; z-index: -1; top: 0; 
    background: url(../Datas/site/dna-base-img/BackgroundTopNew.JPG) no-repeat center / cover">
</div>
<header class="container-fluid" style="background-color: rgba(255, 255, 255, 0.5);">
    <div class="container top-block">
        <div class="row">
            <div class="col-lg-6 col-12">
                <!--img src="<?php echo $avatarImage; ?>" class="img-fluid img-thumbnail" style="width: 100%"-->
                <div class="transform-border modal-trigger" data-target="redact-info">
                    <div id="avatar" style="background-image: url(../<?= $avatarImage ?>);"></div>
                </div>
            </div>
            <div class="col-lg-3 col-3 text-right d-flex p-0">
                <div class="row justify-content-center m-auto py-4" style="border-right: 1px solid black;">
                    <p class="top-item-text top-item-text-left">Логин</p>
                    <p class="top-item-text top-item-text-left">Имя</p>
                    <p class="top-item-text top-item-text-left">Фамилия</p>
                    <p class="top-item-text top-item-text-left">Телефон</p>
                    <p class="top-item-text top-item-text-left">Почта</p>
                    <p class="top-item-text top-item-text-left">Страна</p>
                    <p class="top-item-text top-item-text-left">Город</p>
                    <p class="top-item-text top-item-text-left">Идентификатор</p>
                </div>
            </div>
            <div class="col-lg-3 col-9 d-flex p-0">
                <div class="row justify-content-center m-auto">
                    <p class="top-item-text top-item-text-right" id="profile-login"><?php echo $login; ?></p>
                    <p class="top-item-text top-item-text-right" id="profile-first_name"><?php echo $firstName; ?></p>
                    <p class="top-item-text top-item-text-right" id="profile-last_name"><?php echo $lastName; ?></p>
                    <p class="top-item-text top-item-text-right" id="profile-tel"><?php echo $tel; ?></p>
                    <p class="top-item-text top-item-text-right" id="profile-email"><?php echo $email; ?></p>
                    <p class="top-item-text top-item-text-right" id="profile-country"><?php echo $country; ?></p>
                    <p class="top-item-text top-item-text-right" id="profile-city"><?php echo $city; ?></p>
                    <p class="top-item-text top-item-text-right"><?php echo $idUser; ?></p>
                </div>
            </div>
        </div>
    </div>
</header>

<div id="profile" class="container-fluid p-0">

<?php
    if ($_GET['profile'] == $user['id']) { ?>

        <div id="redact-info" class="modal" style="max-height: initial; bottom: initial;">
            <div class="modal-content container-fluid p-0 border-0 rounded-0" style="box-shadow: initial;">
                <div class="row m-0">
                    <div class="col-6">
                        <img class="img-fluid" src="../<?= $avatarImage ?>">
                    </div>
                    <div class="col-6">
                        <div class="input-field">
                            <input id="first_name" type="text" class="validate" v-model="first_name">
                            <label for="first_name">Имя</label>
                        </div>
                        <div class="input-field">
                            <input id="last_name" type="text" class="validate" v-model="last_name">
                            <label for="last_name">Фамилия</label>
                        </div>
                        <div class="input-field">
                            <input id="middle_name" type="text" class="validate" v-model="middle_name">
                            <label for="middle_name">Отчество</label>
                        </div>
                    </div>
                </div>
                <div class="row m-0">
                    <div class="col-6">
                        <div class="input-field">
                            <input id="login" type="text" class="validate" v-model="login">
                            <label for="login">Логин</label>
                        </div>
                        <div class="input-field">
                            <input id="tel" type="text" class="validate" v-model="tel">
                            <label for="tel">Телефон</label>
                        </div>
                        <div class="input-field">
                            <input id="email" type="text" class="validate" v-model="email">
                            <label for="email">Почта</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-field">
                            <input id="country" type="text" class="validate" v-model="country">
                            <label for="country">Страна</label>
                        </div>
                        <div class="input-field">
                            <input id="city" type="text" class="validate" v-model="city">
                            <label for="city">Город</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <a href="#!" class="modal-close waves-effect waves-green btn-flat">Закрыть</a>
              <button class="waves-effect waves-green btn" @click="UpdataProfile">Сохранить</button>
            </div>
        </div>

    <div class="container-fluid" style="border-bottom: 2px solid white">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="dbl-border">
                        <div id="btn_to_redact_block" class="image-wrapper">
                            <div id="img_to_redact"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 d-flex">
                    <div class="row justify-content-center m-auto">
                        <a :href="redact_href" class="learn-more btn_to_redact">
                            <div class="circle">
                            <span class="icon arrow"></span>
                            </div>
                            <p class="a-text">Добавьте в профиль шиншиллу</p>
                        </a>
                    </div>
                </div>
            </div>
    </div>
<?php } ?>
    <!--div class="container-fluid d-flex chins-profile-block"><div class="chins-profile-title">Шиншиллы профиля</div></div>
    <div class="parallax-container">
        <div class="parallax"><img src="../../Datas/site/dna-base-img/WhatsApp Image 2019-01-14 at 21.32.26.jpeg"></div>
        <div class="my-auto title-group-text">На аукционе</div>
    </div>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.auction" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.auction" class="empty-group">Нет шишлилл на аукционе</p>
    </div>
    <div class="parallax-container">
        <div class="parallax"><img src="../../Datas/site/dna-base-img/WhatsApp Image 2019-01-15 at 12.34.27.jpeg"></div>
        <div class="my-auto title-group-text">Продаются</div>
    </div>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.sale" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.sale" class="empty-group">Шиншиллы не продаются</p>
    </div>
    <div class="parallax-container">
        <div class="parallax"><img src="../../Datas/site/dna-base-img/WhatsApp Image 2019-01-14 at 21.33.49.jpeg"></div>
        <div class="my-auto title-group-text">Самки</div>
    </div>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.famale" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.famale" class="empty-group">Нет самок в разведении</p>
    </div>
    <div class="parallax-container">
        <div class="parallax"><img src="../../Datas/site/dna-base-img/WhatsApp Image 2019-01-14 at 23.34.11.jpeg"></div>
        <div class="my-auto title-group-text">Самцы</div>
    </div>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.male" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.male" class="empty-group">Нет самцов в разведении</p>
    </div>
    <div class="parallax-container">
        <div class="parallax"><img src="../../Datas/site/dna-base-img/WhatsApp Image 2019-01-14 at 21.33.32.jpeg"></div>
        <div class="my-auto title-group-text">Малыши</div>
    </div>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.baby" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.baby" class="empty-group">Нет маленьких шиншиллят</p>
    </div>
    <div class="parallax-container">
        <div class="parallax"><img src="../../Datas/site/dna-base-img/WhatsApp Image 2019-01-15 at 13.09.35.jpeg"></div>
        <div class="my-auto title-group-text">Проданы</div>
    </div>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.sold" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.sold" class="empty-group">Нет проданных шиншилл</p>
    </div>
    <div class="parallax-container">
        <div class="parallax"><img src="../../Datas/site/dna-base-img/WhatsApp Image 2019-01-15 at 12.34.57.jpeg"></div>
        <div class="my-auto title-group-text">Трансфер</div>
    </div>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.transfer" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.transfer" class="empty-group">Нет шишлилл в пути</p>
    </div>
    <div class="parallax-container">
        <div class="parallax"><img src="../../Datas/site/dna-base-img/WhatsApp Image 2019-01-15 at 13.04.50.jpeg"></div>
        <div class="my-auto title-group-text">В резерве</div>
    </div>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.reserve" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.reserve" class="empty-group">Нет зарезервированных шиншилл</p>
    </div>
    <div class="parallax-container">
        <div class="parallax"><img src="../../Datas/site/dna-base-img/WhatsApp Image 2019-01-15 at 13.04.51.jpeg"></div>
        <div class="my-auto title-group-text">Не в разведении</div>
    </div>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.not_breeding" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.not_breeding" class="empty-group">Нет не в разведении</p>
    </div>
    <div class="parallax-container">
        <div class="parallax"><img src="../../Datas/site/dna-base-img/WhatsApp Image 2019-01-15 at 13.24.54.jpeg"></div>
        <div class="my-auto title-group-text">Умерли</div>
    </div>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.died" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.died" class="empty-group">Все шиншиллы живы</p>
    </div-->



    <div class="container-fluid d-flex chins-profile-block"><div class="chins-profile-title">Шиншиллы профиля</div></div>
    <section class="sec1 d-flex"><div class="my-auto title-group-text">На аукционе</div></section>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.auction" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.auction" class="empty-group">Нет шишлилл на аукционе</p>
    </div>
    <section class="sec2 d-flex"><div class="my-auto title-group-text">Продаются</div></section>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.sale" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.sale" class="empty-group">Шиншиллы не продаются</p>
    </div>
    <section class="sec3 d-flex"><div class="my-auto title-group-text">Самки</div></section>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.famale" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.famale" class="empty-group">Нет самок в разведении</p>
    </div>
    <section class="sec4 d-flex"><div class="my-auto title-group-text">Самцы</div></section>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.male" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.male" class="empty-group">Нет самцов в разведении</p>
    </div>
    <section class="sec5 d-flex"><div class="my-auto title-group-text">Малыши</div></section>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.baby" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.baby" class="empty-group">Нет маленьких шиншиллят</p>
    </div>
    <section class="sec6 d-flex"><div class="my-auto title-group-text">Проданы</div></section>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.sold" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.sold" class="empty-group">Нет проданных шиншилл</p>
    </div>
    <section class="sec7 d-flex"><div class="my-auto title-group-text">Трансфер</div></section>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.transfer" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.transfer" class="empty-group">Нет шишлилл в пути</p>
    </div>
    <section class="sec8 d-flex"><div class="my-auto title-group-text">В резерве</div></section>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.reserve" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.reserve" class="empty-group">Нет зарезервированных шиншилл</p>
    </div>
    <section class="sec9 d-flex"><div class="my-auto title-group-text">Не в разведении</div></section>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.not_breeding" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.not_breeding" class="empty-group">Нет не в разведении</p>
    </div>
    <section class="sec10 d-flex"><div class="my-auto title-group-text">Умерли</div></section>
    <div class="row px-4 sec-text">
        <chin-block v-for="(chin, index) in all_chins.died" :key="index" :chin="chin"></chin-block>
        <p v-if="!all_chins.died" class="empty-group">Все шиншиллы живы</p>
    </div>
</div>

<div class="back_href_opacity"></div>
<div class="new_page"></div>

<script type="text/javascript">
$(document).ready(function(){
    //$('.parallax').parallax();
});
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.parallax');
    var instances = M.Parallax.init(elems);
});

    var profile = new Vue ({
        el: '#profile', 
        data: {
            all_chins: {},

            id: <?= $idUser ?>,
            login: "<?= $login ?>",
            tel: "<?= $tel ?>",
            email: "<?= $email ?>",
            first_name: "<?= $firstName ?>",
            last_name: "<?= $lastName ?>",
            middle_name: "<?= $middleName ?>",
            country: "<?= $country ?>",
            city: "<?= $city ?>"
        }, 
        created() {
            $.ajax({
                url: '../php/get_chins.php',
                type: 'POST',
                data: {login: Cookies.get('login'), password: Cookies.get('password'), now_owner: <?php echo $_GET['profile']; ?>},
                success: function(data) {
                    profile.all_chins = JSON.parse(data);
                }
            });
        }, 
        computed: {
            redact_href: function() {
                return "../dna-base/redact-chin.php?user=<?php echo $_GET['profile']; ?>";
            }
        },
        methods: {<?php
    if ($_GET['profile'] == $user['id']) { ?>
            UpdataProfile: function() {
                $.ajax({
                    url: '../php/updata_profile.php',
                    type: 'POST',
                    data: this.$data,
                    success: function(data) {
                        alert("Данные профиля успешно обновлены.");
                        Cookies.set('login', profile.login);

                        for(let key in profile.$data) {
                            $('#profile-' + key).text(profile[key]);
                        }
                    }
                });
            } <?php } ?>
        }
    });

    $('.btn_to_redact').click(function(event) {
        event.preventDefault();
        var href = this.href;
        $('body').css('overflow', 'hidden')
        $('.new_page').css('top', $(window).height());

        $('#btn_to_redact_block').css("width", $('#img_to_redact').width());
        $('#btn_to_redact_block').css("height", $('#img_to_redact').height());

        $('#img_to_redact').css("position", "fixed");
        $('#img_to_redact').css("z-index", 100);
        $('#img_to_redact').css("top", $('#btn_to_redact_block').offset().top - $(window).scrollTop());
        $('#img_to_redact').css("left", $('#btn_to_redact_block').offset().left);
        $('#img_to_redact').css("width", $('#btn_to_redact_block').width());
        $('#img_to_redact').css("height", $('#btn_to_redact_block').height());
        $('#img_to_redact').addClass('img_anim_to_redact');
        $('#img_to_redact').css("top", 0);
        $('#img_to_redact').css("left", 0);
        $('#img_to_redact').css("width", $(window).width());
        $('#img_to_redact').css("height", "100vh");
        setTimeout(function() {
            $('#buttons-show-hide').removeClass('buttons-hide');
            $('#buttons-show-hide').addClass('buttons-show');

            $('.back_href_opacity').css('z-index', 2);
            $('.back_href_opacity').css('opacity', 0.35);

            $('.new_page').css('z-index', 5);
            $('.new_page').css('top', 500);

            setTimeout(function() {
                $.ajax({
                    url: href,
                    type: 'GET',
                    success: function(data) {
                        window.location.assign(href);
                    }
                });
            }, 400);
        }, 600);
    });

    $(document).ready(function(){
        $('.sidenav').sidenav();
        $('.modal').modal();
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>