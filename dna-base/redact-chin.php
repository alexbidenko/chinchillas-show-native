<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CHINCHILLAS-SHOW - Редактирование шиншиллы</title>
<?php
    include_once "../components/import.html";
?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<style type="text/css">
    .centerBlock {
        margin: 100px 30%;
        border: 2px solid red;
        border-radius: 5px;
    }
    label {
        font-weight: 400; 
    }
    .col {
        flex-basis: initial;
    }
    .inputForm {
        border: 2px solid yellow;
        margin: 20px auto;
        padding: 30px auto;
        width: 900px;
    }
    #dnaBlockInput {
        margin: 0 auto;
        border: 2px solid yellow;
        padding: 20px auto;
        width: 800px;
    }
    .dnaSelect {
        overflow: hidden;
        border: 0;
        width: 200px;
        margin: 10px 30px;
    }
    .placeholderArea {
        position: absolute;
        border: 1px solid gray;
        max-height: 500px;
        background-color: white;
    }
    .choose-line {
        margin: 0;
    }
    .choose-line:hover {
        background-color: gray;
    }

    .hide-area {
        opacity: 0;
    }
    .anim-hint-area {
        transition-property: opacity;
        transition-duration: .2s;
    }
    .modal {
        background-color: initial;
        bottom: initial;
    }
    #chin-full-form {
        background: linear-gradient(to top left, #b2ebf2, #e1bee7); 
        padding: 60px;
    }
    #main-form {
        animation: main_form_create 0.5s
    }
    @keyframes main_form_create {
        from {margin-top: 20px;}
        to {margin-top: -200px;}
    }
</style>
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

$user = $result->fetch_assoc();

if (!isset($_GET['user']) or $_GET['user'] == "") {
    header('Location: http://super-chin.h1n.ru/dna-base');
}

?>
</head>

<body>
	
<nav class="position-absolute teal lighten-2" style="top: 0; left: 0;">
    <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    <div class="container nav-wrapper">
        <p class="brand-logo">Профиль</p>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="../">Главная</a></li>
            <li><a href="../dna-base">Мой профиль</a></li>
            <li><a href="../dna-base/search-user">Люди</a></li>
            <li><a href="../dna-base/search-chin">Шиншиллы</a></li>
            <li><a href="../dna-base/calculator">Калькулятор</a></li>
            <li><a href="../php/exit">Выход</a></li>
        </ul>
    </div>
</nav>

<ul class="sidenav" id="mobile-demo">
    <li><a href="../">Главная</a></li>
    <li><a href="../dna-base">Мой профиль</a></li>
    <li><a href="../dna-base/search-user">Люди</a></li>
    <li><a href="../dna-base/search-chin">Шиншиллы</a></li>
    <li><a href="../dna-base/calculator">Калькулятор</a></li>
    <li><a href="../php/exit">Выход</a></li>
</ul>

<div style="background: url('../Datas/site/to_redact_image.jpeg') no-repeat center / cover;
    height: 500px; position: fixed; z-index: -1; width: 100%;"></div>
<div class="container-fluid" style="background-color: rgba(255, 255, 255, 0.35); 
        height: 500px;"></div>

<div id="chin-full-form" class="container-fluid">
    <?php/* if (!($file[$_COOKIE['login']]['type'] == "a11" &&
        isset($_GET['login'])));
        else {
            echo '<button type="button" class="btn btn-primary btn-lg btn-block" @click="save">Войти</button>';
    } */?>
<div id="main-form" class="container card mx-auto" style="margin-top: -200px;">
    <form class="row w-100 pt-4" @submit="onSubmit" action="../../php/createChin.php?user=<?php echo $_GET['user'];/* ($file[$_COOKIE['login']]['type'] == "a11" &&
        isset($_GET['login']))?$_GET['login']:$_COOKIE['login']; echo "&id=".$_GET['id']; */?>" method="post">
        <?php /*echo ($file[$_COOKIE['login']]['type'] == "a11" &&
        isset($_GET['login']))?"":'';*/ ?>
        <div class="input-field col s4">
            <select name="redacted" v-model="redacted">
                <option value="false" selected>Редактирую</option>
                <option value="true">Готов к проверке</option>
            </select>
            <label>Готовность профиля</label>
        </div>
        <div class="input-field col s4">
            <select name="status" v-model="status">
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
        <div class="input-field col s4">
            <input class="validate black-text" id="name_chin" type="text" autocomplete="off" name="name_chin" required v-model="name_chin">
            <label for="name_chin">Кличка</label>
        </div>
        <div class="input-field col s4">
            <input id="birthday" type="text" class="datepicker" autocomplete="off" name="birthday" v-model="birthday" required>
            <label for="birthday">Дата рождения</label>
        </div>
        <div class="col s4">
            Пол
            <p>
                <label>
                    <input class="with-gap" name="sex" type="radio" value="famale" checked v-model="sex" />
                    <span>Самка</span>
                </label>
            </p>
            <p>
                <label>
                    <input class="with-gap" name="sex" type="radio" value="male" v-model="sex" />
                    <span>Самец</span>
                </label>
            </p>
        </div>
        <div class="input-field col s4">
            <select name="type_breader" id="selectBreader" v-model="type_breader">
                <option selected value="owner<?php/* echo ($file[$_COOKIE['login']]['type'] == "a11" &&
        isset($_GET['login']))?$_GET['login']:$_COOKIE['login']; */?>">Владелец</option>
                <option value="in_site">Выбрать на сайте</option>
                <option value="no_site">Нет на сайте</option>
                <option value="unknow">Неизвестен</option>
            </select>
            <label>Заводчик</label>
        </div>
        <!--div id="searchBreader">
            <p>Поиск заводчика</p>
            <label>
                <p><input id="inputLogin" autocomplete="off" type="text" name="breader" v-model="breader" @focus="usersHint=true" @blur="usersHint=false"> Логин</p>
                <div class="placeholderArea anim-hint-area" :class="{'hide-area':!usersHint}" id="placeholderArea">
                    <p class="choose-line" v-for="(user, index) in filteredUsersList" :key="index" @click="breader=user.id">{{user.login + " | " + user.id}}</p>
                </div>
            </label>
            <p id="login-error" class="d-none" style="color: red">Не правильно указан логин!</p>
        </div-->
        <div class="input-field col s4 fade show" :class="{'in': (type_breader == 'in_site')}">
            <i class="material-icons prefix">account_circle</i>
            <input type="text" class="autocomplete" id="inputLogin" autocomplete="off" type="text" name="breader" 
                v-model="breader">
            <label for="inputLogin">Поиск заводчика</label>
        </div>
        <div id="searchParents col s8">
            <div class="input-field col s6 fade show" :class="{'in': search_parents}">
                <input type="text" class="autocomplete" id="inputMother" autocomplete="off" type="text" name="mother" v-model="mother">
                <label for="inputMother">Мама</label>
            </div>
            <div class="input-field col s6 fade show" :class="{'in': search_parents}">
                <input type="text" class="autocomplete" id="inputFather" autocomplete="off" type="text" name="father" v-model="father">
                <label for="inputFather">Папа</label>
            </div>

            <!--p>Поиск родителей</p>
            <label>
                <p><input id="inputMother" type="text" name="mother" autocomplete="off" value="Не указано" v-model="mother" @focus="motherHint=true" @blur="motherHint=false"> Мама</p>
                <div class="placeholderArea anim-hint-area" :class="{'hide-area':!motherHint}" id="placeholderMotherArea">
                    <p class="choose-line" @click="mother='Не указано'">Не указано</p>
                    <p class="choose-line" v-for="mother in mothers" :key="index" @click="mother=mother.name_chin">{{mother.name_chin + " | " + mother.id}}</p>
                </div>
                <p id="mother-error" class="d-none" style="color: red">Не правильно указан родитель!</p>
            </label>
            <label>
                <p><input id="inputFather" type="text" name="father" autocomplete="off" value="Не указано" v-model="father" @focus="fatherHint=true" @blur="fatherHint=false"> Папа</p>
                <div class="placeholderArea anim-hint-area" :class="{'hide-area':!fatherHint}" id="placeholderFatherArea">
                    <p class="choose-line" @click="father='Не указано'">Не указано</p>
                    <p class="choose-line" v-for="father in fathers" :key="index" @click="father=father.name_chin">{{father.name_chin + " | " + father.id}}</p>
                </div>
                <p id="father-error" class="d-none" style="color: red;">Не правильно указан родитель!</p>
            </label-->
        </div>
        <!--p id="dnaBlockPlus" style="background-color: red;">Гены</p-->

        <div class="w-100 divider"></div>

        <div class="card-content px-0">
            <div class="input-field col s3">
                <select name="standart" v-model="colors.standart">
                    <option selected value="Нет">Нет</option>
                    <option value="Есть" :disabled="StandartOrColored=='colored'">Есть</option>
                </select>
                <label>Стандарт</label>
            </div>
            <div class="input-field col s3">
                <select name="white" v-model="colors.white">
                    <option selected value="Нет" :disabled="MosaicWhite">Нет</option>
                    <option value="Есть" :disabled="StandartOrColored=='standart'">Есть</option>
                </select>
                <label>Белый</label>
            </div>
            <div class="input-field col s3">
                <select name="mosaic" v-model="colors.mosaic">
                    <option selected value="Нет">Нет</option>
                    <option value="Есть" :disabled="StandartOrColored=='standart'">Есть</option>
                </select>
                <label>Мазаичность</label>
            </div>
            <div class="input-field col s3">
                <select name="beige" v-model="colors.beige">
                    <option selected value="Нет">Нет</option>
                    <option value="Есть" :disabled="StandartOrColored=='standart'">Есть</option>
                    <option value="Двойной" :disabled="StandartOrColored=='standart'">Двойной</option>
                </select>
                <label>Бежевый</label>
            </div>
            <div class="input-field col s3">
                <select name="violet" v-model="colors.violet">
                    <option selected value="Нет">Нет</option>
                    <option value="50%">50%</option>
                    <option value="67%">67%</option>
                    <option value="Носитель">Носитель</option>
                    <option value="Есть" :disabled="StandartOrColored=='standart'">Есть</option>
                </select>
                <label>Афро фиолет</label>
            </div>
            <div class="input-field col s3">
                <select name="sapphire" v-model="colors.sapphire">
                    <option selected value="Нет">Нет</option>
                    <option value="50%">50%</option>
                    <option value="67%">67%</option>
                    <option value="Носитель">Носитель</option>
                    <option value="Есть" :disabled="StandartOrColored=='standart'">Есть</option>
                </select>
                <label>Сапфир</label>
            </div>
            <div class="input-field col s3">
                <select name="angora" v-model="colors.angora">
                    <option selected value="Нет">Нет</option>
                    <option value="50%">50%</option>
                    <option value="67%">67%</option>
                    <option value="Носитель">Носитель</option>
                    <option value="Есть" :disabled="AROrFur=='fur'">Есть</option>
                </select>
                <label>Ангора</label>
            </div>
            <div class="input-field col s3">
                <select name="ebony" v-model="colors.ebony">
                    <option selected value="Нет">Нет</option>
                    <option value="Носитель">Носитель</option>
                    <option value="Светлый" :disabled="StandartOrColored=='standart'">Светлый</option>
                    <option value="Средний" :disabled="StandartOrColored=='standart'">Средний</option>
                    <option value="Темный" :disabled="StandartOrColored=='standart'">Темный</option>
                    <option value="Экстра темный" :disabled="StandartOrColored=='standart'">Экстра темный</option>
                    <option value="Гомоэбони" :disabled="StandartOrColored=='standart'">Гомоэбони</option>
                    <option value="Затрудняюсь ответить">Затрудняюсь ответить</option>
                </select>
                <label>Эбони</label>
            </div>
            <div class="input-field col s3">
                <select name="velvet" v-model="colors.velvet">
                    <option selected value="Нет">Нет</option>
                    <option value="Возможно">Возможно</option>
                    <option value="Есть" :disabled="(StandartOrColored=='standart')||(BlueOrVelvet=='blue')">Есть</option>
                </select>
                <label>Бархат</label>
            </div>
            <div class="input-field col s3">
                <select name="pearl" v-model="colors.pearl">
                    <option selected value="Нет">Нет</option>
                    <option value="50%">50%</option>
                    <option value="67%">67%</option>
                    <option value="Носитель">Носитель</option>
                    <option value="Есть" :disabled="StandartOrColored=='standart'">Есть</option>
                </select>
                <label>Черный жемчуг</label>
            </div>
            <div class="input-field col s3">
                <select name="california" v-model="colors.california">
                    <option selected value="Нет">Нет</option>
                    <option value="50%">50%</option>
                    <option value="67%">67%</option>
                    <option value="Носитель">Носитель</option>
                    <option value="Есть">Есть</option>
                </select>
                <label>Калифорния</label>
            </div>
            <div class="input-field col s3">
                <select name="rex" v-model="colors.rex">
                    <option selected value="Нет">Нет</option>
                    <option value="50%">50%</option>
                    <option value="67%">67%</option>
                    <option value="Носитель">Носитель</option>
                    <option value="Есть" :disabled="AROrFur=='fur'">Есть</option>
                </select>
                <label>Рекс</label>
            </div>
            <div class="input-field col s3">
                <select name="lova" v-model="colors.lova">
                    <option selected value="Нет">Нет</option>
                    <option value="50%">50%</option>
                    <option value="67%">67%</option>
                    <option value="Носитель">Носитель</option>
                    <option value="Есть" :disabled="StandartOrColored=='standart'">Есть</option>
                </select>
                <label>Белый лова</label>
            </div>
            <div class="input-field col s3">
                <select name="german" v-model="colors.german">
                    <option selected value="Нет">Нет</option>
                    <option value="50%">50%</option>
                    <option value="67%">67%</option>
                    <option value="Носитель">Носитель</option>
                    <option value="Есть" :disabled="StandartOrColored=='standart'">Есть</option>
                </select>
                <label>Немецкий фиолет</label>
            </div>
            <div class="input-field col s3">
                <select name="blue" v-model="colors.blue">
                    <option selected value="Нет">Нет</option>
                    <option value="Есть" :disabled="(StandartOrColored=='standart')||(BlueOrVelvet=='velvet')">Есть</option>
                </select>
                <label>Блю слейт</label>
            </div>
            <div class="input-field col s3">
                <select name="fur" v-model="colors.fur">
                    <option selected value="Нет">Нет</option>
                    <option value="Есть" :disabled="AROrFur=='ar'">Есть</option>
                </select>
                <label>Блю слейт</label>
            </div>
        </div>

        <div class="w-100 divider"></div>
        
        <div class="row w-100">
            <div class="input-field col s6">
                <input id="weight" type="text" name="weight" v-model="weight" class="validate">
                <label for="weight">Вес при рождении</label>
            </div>
            <div class="input-field col s6">
                <input id="brothers" type="text" name="brothers" v-model="brothers" class="validate">
                <label for="brothers">Щенков в помете</label>
            </div>
            <div class="input-field col s12">
                <i class="material-icons prefix">grade</i>
                <textarea id="winer" class="materialize-textarea" name="winer" v-model="winer"></textarea>
                <label for="winer">Награды</label>
            </div>
            <div class="input-field col s12">
                <i class="material-icons prefix">mode_edit</i>
                <textarea id="about" class="materialize-textarea" name="about" v-model="about"></textarea>
                <label for="about">Описание</label>
            </div>
        </div>
        <button class="waves-effect waves-light btn w-100" type="submit">Сохранить</button>
        <?php /*echo ($file[$_COOKIE['login']]['type'] == "a11" &&
        isset($_GET['login']))?"":'';*/ ?>
    </form>
</div>

    <p class="d-none">{{allColors}}</p>
</div>
    
<script type="text/javascript">
    var ChinForm = new Vue ({
        el: "#chin-full-form",
        data: {
        	redacted: "false",
            status: "baby",
            name_chin: null,
            birthday: null,
            sex: 'famale',
            type_breader: "owner",
            breader: "<?php /*echo ($file[$_COOKIE['login']]['type'] == "a11" &&
        isset($_GET['login']))?$_GET['login']:$_COOKIE['login'];*/ ?>",
            search_parents: true,
            mother: null,
            father: null,
            colors: {
                standart: "Нет",
                white: "Нет",
                mosaic: "Нет",
                beige: "Нет",
                violet: "Нет",
                sapphire: "Нет",
                angora: "Нет",
                ebony: "Нет",
                velvet: "Нет",
                pearl: "Нет",
                california: "Нет",
                rex: "Нет",
                lova: "Нет",
                german: "Нет",
                blue: "Нет",
                fur: "Нет"
            },
            weight: null,
            brothers: null,
            winer: null,
            about: null,

            StandartOrColored: "null",
            MosaicWhite: false,
            BlueOrVelvet: "null",
            AROrFur: "null",

            users: [], 
            mothers: [], 
            fathers: [],

            usersHint: false, 
            motherHint: false, 
            fatherHint: false
        },
        created () {
            axios.get('../php/get_users.php').then(response => {
                this.users = response.data;

                var cash_data = {
                    "Не известно": null
                };
                for (let user in response.data) {
                    cash_data[response.data[user].login + " | " + response.data[user].id] = null;
                }

                $('#inputLogin').autocomplete({
                    data: cash_data,
                    onAutocomplete: function(val) {
                        ChinForm.breader = val;
                    },
                    limit: 10,
                    minLength: 0
                });
                
                SearchParent(<?= $user['id'] ?>);
            });

            /*if (chinID != null) {
                $.ajax({
                    url: '../php/get_chins.php',
                    type: 'POST',
                    data: {src: srcChin},
                    success: function(data) {
                        let thisChin = JSON.parse(data);
                        ChinForm.status = thisChin[chinID].status[0].status;
                        ChinForm.nameChin = thisChin[chinID].nameChin;
                        ChinForm.birthday = thisChin[chinID].birthday;
                        ChinForm.sex = thisChin[chinID].sex;
                        if (thisChin[chinID].breader != user && thisChin[chinID].breader != "Нет на сайте" && thisChin[chinID].breader != "Неизвестен") {
                            $('#inSite').val(thisChin[chinID].breader);
                            $('#searchParents').removeAttr("hidden");
                            $('#inputLogin').val(thisChin[chinID].breader);
                            $('#searchBreader').removeAttr("hidden");
                        } else if (thisChin[chinID].breader != "Нет на сайте" && thisChin[chinID].breader != "Неизвестен") {
                            $('#searchParents').attr("hidden", "hidden");
                        }
                        ChinForm.breader = thisChin[chinID].breader;
                        ChinForm.mother = thisChin[chinID].mother;
                        ChinForm.father = thisChin[chinID].father;
                        ChinForm.colors = thisChin[chinID].colors;
                        ChinForm.weight = thisChin[chinID].weight;
                        ChinForm.brothers = thisChin[chinID].brothers;
                        ChinForm.winer = thisChin[chinID].winer;
                        ChinForm.about = thisChin[chinID].about;
                    }
                });
            }*/
        },
        computed: {
            allColors: function() {
                if (this.colors.standart == "Есть") {
                    this.StandartOrColored = "standart";
                } else if (this.colors.white == "Есть" || this.colors.mosaic == "Есть" || this.colors.beige == "Есть" || this.colors.beige == "Двойной" || this.colors.violet == "Есть" ||
                    this.colors.sapphire == "Есть" || (this.colors.ebony != "Нет" && this.colors.ebony != "Носитель" && this.colors.ebony != "Затрудняюсь ответить") || this.colors.velvet == "Есть" ||
                    this.colors.pearl == "Есть" || this.colors.lova == "Есть" || this.colors.german == "Есть" || this.colors.blue == "Есть") {
                    this.StandartOrColored = "colored";
                } else {
                    this.StandartOrColored = "null";
                }
                if (this.colors.mosaic == "Есть") {
                    this.colors.white = "Есть";
                    this.MosaicWhite = true;
                } else {
                    this.MosaicWhite = false;
                }
                if (this.colors.blue == "Есть") {
                    this.BlueOrVelvet = "blue";
                } else if (this.colors.velvet == "Есть") {
                    this.BlueOrVelvet = "velvet";
                } else {
                    this.BlueOrVelvet = "null";
                }
                if (this.colors.angora == "Есть" || this.colors.rex == "Есть") {
                    this.AROrFur = "ar";
                } else if (this.colors.fur == "Есть") {
                    this.AROrFur = "fur";
                } else {
                    this.AROrFur = "null";
                }
                return this.colors.standart + this.colors.white + this.colors.mosaic + this.colors.beige + this.colors.violet + this.colors.sapphire +
                    this.colors.angora + this.colors.ebony + this.colors.velvet + this.colors.pearl + this.colors.california +
                    this.colors.rex + this.colors.lova + this.colors.german + this.colors.blue + this.colors.fur;
            }
        },
        methods: {
            save: function() {
                momemtUpdata();
            },
            onSubmit: function () {
                let owner;
                if (this.type_breader == 'owner') {
                    owner = <?= $user['id'] ?>;
                } else if (this.type_breader == 'owner') {
                    owner = this.breader;
                } else {
                    owner = 'Не известно';
                }
                for (let user in this.users) {
                    if (owner == this.users[user].id || 
                        owner == this.users[user].login || 
                        owner == (this.users[user].login + " | " + this.users[user].id)) {
                        owner = this.users[user].id;
                    }
                }
                this.breader = owner;

                if(this.mother == "") this.mother = "Не указано";
                if (this.mother != "Не указано") {
                    for (let i in this.mothers) {
                        if (owner == this.mothers[i].id || 
                            owner == this.mothers[i].name_chin || 
                            owner == (this.mothers[i].name_chin + " | " + this.mothers[i].id)) {
                            owner = this.mothers[i].id;
                        }
                    }
                }
                this.mother = this.mothers[i].id;

                if(this.father == "") this.father = "Не указано";
                if (this.father != "Не указано") {
                    for (let i in this.fathers) {
                        if (owner == this.fathers[i].id || 
                            owner == this.fathers[i].name_chin || 
                            owner == (this.fathers[i].name_chin + " | " + this.fathers[i].id)) {
                            owner = this.fathers[i].id;
                        }
                    }
                }
                this.father = this.fathers[i].id;
            }
        }, 
        watch: {
            breader: function(val) {
                SearchParent(val);
            },
            type_breader: function(val) {
                if (val == "owner") {
                    SearchParent(<?= $user['id'] ?>);
                } else if (val != 'in_site') {
                    ChinForm.search_parents = false;
                } else {
                    SearchParent (ChinForm.breader);
                }
            }
        }
    });

    function SearchParent (val) {
        val += "";
        let bool = false;
        for (let user in ChinForm.users) {
                    if (val == ChinForm.users[user].id || val == ChinForm.users[user].login || val == (ChinForm.users[user].login + " | " + ChinForm.users[user].id)) {

                        bool = true;

                        $.ajax({
                            url: '../php/get_chins.php',
                            type: 'POST',
                            data: {login: Cookies.get('login'), password: Cookies.get('password'), breader: ChinForm.users[user].id},
                            success: function(data) {
                                ChinForm.mothers = JSON.parse(data).famale;
                                ChinForm.fathers = JSON.parse(data).male;
                                
                                var cash_data = {
                                    "Не известно": null
                                };
                                for (let user in ChinForm.mothers) {
                                    cash_data[ChinForm.mothers[user].name_chin + " | " + ChinForm.mothers[user].id] = null;
                                }

                                var elem = document.getElementById('inputMother');
                                var instance = M.Autocomplete.getInstance(elem);
                                if (typeof instance != 'undefined') {
                                    instance.updateData(cash_data);
                                }

                                $('#inputMother').autocomplete({
                                    data: cash_data,
                                    onAutocomplete: function(val) {
                                        ChinForm.mother = val;
                                    },
                                    limit: 10,
                                    minLength: 0
                                });
                                
                                var cash_data = {
                                    "Не известно": null
                                };
                                for (let user in ChinForm.fathers) {
                                    cash_data[ChinForm.fathers[user].name_chin + " | " + ChinForm.fathers[user].id] = null;
                                }

                                var elem = document.getElementById('inputFather');
                                var instance = M.Autocomplete.getInstance(elem);
                                if (typeof instance != 'undefined') {
                                    instance.updateData(cash_data);
                                }

                                $('#inputFather').autocomplete({
                                    data: cash_data,
                                    onAutocomplete: function(val) {
                                        ChinForm.father = val;
                                    },
                                    limit: 10,
                                    minLength: 0
                                });
                            }
                        });
                    } else if (val != "Не известно") {
                        ChinForm.search_parents = false;
                    }
                }
                if (!bool) {
                    ChinForm.search_parents = false;
                } else {
                    ChinForm.search_parents = true;
                }
    }

    $(document).ready(function(){
        $('select').formSelect();
    });

    $(document).ready(function(){
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
            },
            onClose: function() {
                ChinForm.birthday = $('#birthday').val();
            }
        });
    });
    
    /*const momemtUpdata = () => {
        <?php if ($file[$_COOKIE['login']]['type'] == "a11" &&
                isset($_GET['login'])) { ?>
        $.ajax({
            url: '../php/createChin.php?login=<?php echo ($file[$_COOKIE['login']]['type'] == "a11" &&
                isset($_GET['login']))?$_GET['login']:$_COOKIE['login']; echo "&id=".$_GET['id']; ?>',
            type: 'POST',
            data: {status: ChinForm.status, nameChin: ChinForm.nameChin, birthday: ChinForm.birthday, sex: ChinForm.sex, breader: ChinForm.breader, mother: ChinForm.mother,
                father: ChinForm.father, standart: ChinForm.colors.standart, white: ChinForm.colors.white, mosaic: ChinForm.colors.mosaic, beige: ChinForm.colors.beige,
                violet: ChinForm.colors.violet, sapphire: ChinForm.colors.sapphire, angora: ChinForm.colors.angora, ebony: ChinForm.colors.ebony, velvet: ChinForm.colors.velvet,
                pearl: ChinForm.colors.pearl, california: ChinForm.colors.california, rex: ChinForm.colors.rex, lova: ChinForm.colors.lova, german: ChinForm.colors.german,
                blue: ChinForm.colors.blue, fur: ChinForm.colors.fur, weight: ChinForm.weight, brothers: ChinForm.brothers, winer: ChinForm.winer, about: ChinForm.about},
            success: function(data) {}
        });
        <?php } ?>
    }*/
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>