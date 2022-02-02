<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CHINCHILLAS-SHOW - Поиск шиншиллы</title>
<?php
    include_once "../components/import.html";
?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<style type="text/css">
    .searchOptions {
        border: 2px solid yellow;
        padding: 20px;
    }
    .searchUserBlock {
        cursor: pointer;
        border: 2px solid yellow;
        height: 140px;
    }
    .searchUserBlock:hover {
        background-color: gray;
    }
    .searchUserImg {
        display: inline-block;
        float: left;
        max-width: 200px;
        max-height: 140px;
    }
    .card {
        flex-direction: initial;
    }
    .modal {
        background-color: initial;
    }

nav a:hover {
  text-decoration: none;
  color          : white;
}
</style>
<?php

include_once "../components/php-funs.php";

$mysqli = BaseConect();

if (!isset($_COOKIE['login']) || !isset($_COOKIE['password'])) {
    setcookie('oldPage', 'Location: ../dna-base/search-chin');
    header('Location: ../regist');
}

$result = $mysqli->query("SELECT * FROM super_chin_users_all_data WHERE login = '".$_COOKIE['login']."' AND password = '".$_COOKIE['password']."';");

if ($result->num_rows == 0) {
    setcookie('oldPage', 'Location: ../dna-base/search-chin.php');
    header('Location: regist.php');
}
?>
<script type="text/javascript">
Vue.component("chin-block", {
    props: ["chin"],
    template: `<div class="card horizontal w-100 my-0">
            <div class="card-image">
                <img :src="chin.avatar">
            </div>
            <div class="card-stacked">
                <div class="card-content">
                    <p>{{chin.name_chin}}</p>
                    <p>{{chin.id}}</p>
                    <p>{{chin.now_owner}}</p>
                </div>
                <div class="card-action">
                    <a :href="'../dna-base/profile-chin.php?profile=' + chin.now_owner + '&chin=' + chin.id">Перейти к профилю</a>
                </div>
            </div>
        </div>`
});
</script>
</head>

<body>
    <div id="search-app">

    <nav class="teal lighten-2 position-fixed" style="top: 0; z-index: 1;">

        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <div class="nav-wrapper">
            <p class="brand-logo">Поиск шиншилл</p>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="../">Главная</a></li>
                <li><a href="../dna-base">Мой профиль</a></li>
                <li><a href="../dna-base/search-user">Люди</a></li>
                <li><a href="../dna-base/calculator">Калькулятор</a></li>
                <li><a href="../php/exit.php">Выход</a></li>
            </ul>
        </div>

    </nav>

        <ul class="sidenav" id="mobile-demo">
            <li><a href="../">Главная</a></li>
            <li><a href="../dna-base">Мой профиль</a></li>
            <li><a href="../dna-base/search-user">Люди</a></li>
            <li><a href="../dna-base/calculator">Калькулятор</a></li>
            <li><a href="../php/exit.php">Выход</a></li>
            <li><hr /></li>
            <li id="sidenav-panel"></li>
        </ul>

    <div class="container-fluid py-4 position-fixed hide-on-med-and-down">
        <div class="row">
            <div id="origin-panel" class="col-4 col-sm-push-8 card my-0" style="max-height: 90vh; overflow-y: scroll; overflow-x: hidden;">
                <form class="w-100">
                    <div class="input-field">
                        <input id="name_chin" type="text" class="validate black-text" v-model="name_chin">
                        <label for="name_chin">Кличка</label>
                    </div>
                    <div class="input-field">
                        <input id="id" type="text" class="validate black-text" v-model="id">
                        <label for="id">Идентификатор</label>
                    </div>
                    <div class="input-field">
                        <input id="owner" type="text" class="validate black-text" v-model="owner">
                        <label for="owner">Владелец</label>
                    </div>
                    <div class="input-field">
                        <select name="status" v-model="status">
                            <option selected value="">Не важно</option>
                            <option value="baby">Малыш</option>
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
                    <div class="input-field">
                        <input id="breader" type="text" class="validate black-text" v-model="breader">
                        <label for="breader">Заводчик</label>
                    </div>
                    <div class="input-field">
                        <select name="sex" v-model="sex">
                            <option selected value="">Не важно</option>
                            <option value="famale">Самка</option>
                            <option value="male">Самец</option>
                        </select>
                        <label>Пол</label>
                    </div>
                    <div class="input-field">
                        <input id="birthdayFrom" type="date" autocomplete="off" 
                            name="birthdayFrom" v-model="birthdayFrom" required>
                        <label for="birthdayFrom">Дата рождения от</label>
                    </div>
                    <div class="input-field">
                        <input id="birthdayBefore" type="date" autocomplete="off" 
                            name="birthdayBefore" v-model="birthdayBefore" required>
                        <label for="birthdayBefore">Дата рождения до</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix black-text">account_balance</i>
                        <input id="country" type="text" class="validate black-text" v-model="country">
                        <label for="country">Страна</label>
                    </div>
                    <div class="input-field">
                        <input id="city" type="text" class="validate black-text" v-model="city">
                        <label for="city">Город</label>
                    </div>
                    
                    <!--p style="background-color: yellow" onclick="$('#dnaBlock').slideToggle(300)">Гены</p>
                    <div id="dnaBlock" style="display: none; overflow: auto;">
                        <label>
                            <p>Стандарт</p>
                            <select class="dnaSelect" size="1" v-model="colors.standart">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="Есть">Есть</option>
                            </select>
                        </label>
                        <label>
                            <p>Белый</p>
                            <select class="dnaSelect" size="1" v-model="colors.white">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="Есть">Есть</option>
                            </select>
                        </label>
                        <label>
                            <p>Мазаичность</p>
                            <select class="dnaSelect" size="1" v-model="colors.mosaic">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="Есть">Есть</option>
                            </select>
                        </label>
                        <label>
                            <p>Бежевый</p>
                            <select class="dnaSelect" size="1" v-model="colors.beige">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="Есть">Есть</option>
                                <option value="Двойной">Двойной</option>
                            </select>
                        </label>
                        <label>
                            <p>Афро фиолет</p>
                            <select class="dnaSelect" size="1" v-model="colors.violet">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="50%">50%</option>
                                <option value="67%">67%</option>
                                <option value="Носитель">Носитель</option>
                                <option value="Есть">Есть</option>
                            </select>
                        </label>
                        <label>
                            <p>Сапфир</p>
                            <select class="dnaSelect" size="1" v-model="colors.sapphire">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="50%">50%</option>
                                <option value="67%">67%</option>
                                <option value="Носитель">Носитель</option>
                                <option value="Есть">Есть</option>
                            </select>
                        </label>
                        <label>
                            <p>Ангора</p>
                            <select class="dnaSelect" size="1" v-model="colors.angora">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="50%">50%</option>
                                <option value="67%">67%</option>
                                <option value="Носитель">Носитель</option>
                                <option value="Есть">Есть</option>
                            </select>
                        </label>
                        <label>
                            <p>Эбони</p>
                            <select class="dnaSelect" size="1" v-model="colors.ebony">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="Носитель">Носитель</option>
                                <option value="Светлый">Светлый</option>
                                <option value="Средний">Средний</option>
                                <option value="Темный">Темный</option>
                                <option value="Экстра темный">Экстра темный</option>
                                <option value="Гомоэбони">Гомоэбони</option>
                            </select>
                        </label>
                        <label>
                            <p>Бархат</p>
                            <select class="dnaSelect" size="1" v-model="colors.velvet">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="Возможно">Возможно</option>
                                <option value="Есть">Есть</option>
                            </select>
                        </label>
                        <label>
                            <p>Черный жемчуг</p>
                            <select class="dnaSelect" size="1" v-model="colors.pearl">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="50%">50%</option>
                                <option value="67%">67%</option>
                                <option value="Носитель">Носитель</option>
                                <option value="Есть">Есть</option>
                            </select>
                        </label>
                        <label>
                            <p>Калифорния</p>
                            <select class="dnaSelect" size="1" v-model="colors.california">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="50%">50%</option>
                                <option value="67%">67%</option>
                                <option value="Носитель">Носитель</option>
                                <option value="Есть">Есть</option>
                            </select>
                        </label>
                        <label>
                            <p>Рекс</p>
                            <select class="dnaSelect" size="1" v-model="colors.rex">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="50%">50%</option>
                                <option value="67%">67%</option>
                                <option value="Носитель">Носитель</option>
                                <option value="Есть">Есть</option>
                            </select>
                        </label>
                        <label>
                            <p>Белый лова</p>
                            <select class="dnaSelect" size="1" v-model="colors.lova">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="50%">50%</option>
                                <option value="67%">67%</option>
                                <option value="Носитель">Носитель</option>
                                <option value="Есть">Есть</option>
                            </select>
                        </label>
                        <label>
                            <p>Немецкий фиолет</p>
                            <select class="dnaSelect" size="1" v-model="colors.german">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="50%">50%</option>
                                <option value="67%">67%</option>
                                <option value="Носитель">Носитель</option>
                                <option value="Есть">Есть</option>
                            </select>
                        </label>
                        <label>
                            <p>Блю слейт</p>
                            <select class="dnaSelect" size="1" v-model="colors.blue">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="Есть">Есть</option>
                            </select>
                        </label>
                        <label>
                            <p>Меховой</p>
                            <select class="dnaSelect" size="1" v-model="colors.fur">
                                <option selected value="">Не важно</option>
                                <option value="Нет">Нет</option>
                                <option value="Есть">Есть</option>
                            </select>
                        </label>
                    </div-->
                </form>
            </div>
        </div>
    </div>
    
    <div class="container-fluid py-4 mt-5">
        <div class="row" id="searched_result">
            <div class="col-md-8 col-12">
                <chin-block v-for="chin in filteredList" :chin="chin"></chin-block>
            </div>
        </div>
    </div>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('select').formSelect();

    if(window.innerWidth < 992) {
        $('form').appendTo('#sidenav-panel');
        $('#origin-panel>form').remove();
    } else {
        $('form').appendTo('#origin-panel');
        $('#sidenav-panel>form').remove();
    }
    $(window).resize(function() {
        if(window.innerWidth < 992) {
            $('form').appendTo('#sidenav-panel');
            $('#origin-panel>form').remove();
        } else {
            $('form').appendTo('#origin-panel');
            $('#sidenav-panel>form').remove();
        }
    })

        $('.datepicker').datepicker({
            format: "dd.mm.yyyy",
            firstDay: 1,
            i18n: {
                cancel: "Отмена",
                clear: "Очистить",
                done: "Ок",
                months: [
                    "Январь",
                    "Февраль",
                    "Март",
                    "Апрель",
                    "Май",
                    "Июнь",
                    "Июль",
                    "Август",
                    "Сентябрь",
                    "Октябрь",
                    "Ноябрь",
                    "Декабрь"
                ],
                monthsShort: [
                    "Янв",
                    "Фев",
                    "Мар",
                    "Апр",
                    "Май",
                    "Июн",
                    "Июл",
                    "Авг",
                    "Сен",
                    "Окт",
                    "Ноя",
                    "Дек"
                ],
                weekdays: [
                    "Воскресенье",
                    "Понедельник",
                    "Вторник",
                    "Среда",
                    "Четверг",
                    "Пятница",
                    "Суббота"
                ],
                weekdaysShort: [
                    "Вс",
                    "Пн",
                    "Вт",
                    "Ср",
                    "Чт",
                    "Пт",
                    "Сб"
                ],
                weekdaysAbbrev: [
                    "В",
                    "П",
                    "В",
                    "С",
                    "Ч",
                    "П",
                    "С"
                ]
            }
        });
    });

var SearchApp = new Vue ({
    el: '#search-app',
    data: {
        allChins: [],
        name_chin: "",
        id: "",
        owner: "",
        status: "",
        breader: "",
        sex: "",
        birthdayFrom: "",
        birthdayBefore: "",
        country: "",
        city: "",
        colors: {
            standart: "",
            white: "",
            mosaic: "",
            beige: "",
            violet: "",
            sapphire: "",
            angora: "",
            ebony: "",
            velvet: "",
            pearl: "",
            california: "",
            rex: "",
            lova: "",
            german: "",
            blue: "",
            fur: ""
        }
    },
    created () {
        $.ajax({
            url: '../php/get_chins.php',
            type: 'POST',
            data: {login: Cookies.get('login'), password: Cookies.get('password')},
            success: function(data) {
                SearchApp.allChins = JSON.parse(data.replace(new RegExp('u0','g'),'\\u0'));
                for(let i in SearchApp.allChins) {
                    SearchApp.allChins[i].colors = JSON.parse(SearchApp.allChins[i].colors)
                }
            }
        });
    },
    computed:{
        filteredList: function(){
            return this.allChins.filter(function (elem) {
                let bool = true;
                for (let i = 0; i < Object.keys(SearchApp.colors).length; i++) {
                    bool = (elem.colors[Object.keys(SearchApp.colors)[i]].indexOf(SearchApp.colors[Object.keys(SearchApp.colors)[i]]) > -1) && bool;
                }
                return (elem.name_chin.indexOf(SearchApp.name_chin) > -1) && (elem.id.indexOf(SearchApp.id) > -1) && (elem.now_owner.indexOf(SearchApp.owner) > -1) &&
                (elem.now_status.indexOf(SearchApp.status) > -1) && (elem.breader.indexOf(SearchApp.breader) > -1) &&
                ((SearchApp.sex == "") || (elem.sex == SearchApp.sex)) && /*(elem.country.indexOf(SearchApp.country) > -1) && (elem.city.indexOf(SearchApp.city) > -1) &&*/
                ((SearchApp.birthdayFrom == "") || elem.birthday >= (new Date(SearchApp.birthdayFrom).getTime())) &&
                ((SearchApp.birthdayBefore == "") || elem.birthday <= (new Date(SearchApp.birthdayBefore).getTime())) && bool;
            });
        }
    }
});
var sortById = function(d1, d2){return d1.id < d2.id ? 1 : -1; };

$(document).ready(function(){
    $('.sidenav').sidenav();
});
</script>
</html>