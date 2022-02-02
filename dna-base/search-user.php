<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CHINCHILLAS-SHOW - Поиск пользователей</title>
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

nav a:hover {
  text-decoration: none;
  color          : white;
}
</style>
<?php

include_once "../components/php-funs.php";

$mysqli = BaseConect();

if (!isset($_COOKIE['login']) || !isset($_COOKIE['password'])) {
    setcookie('oldPage', 'Location: ../dna-base/search-user');
    header('Location: ../regist');
}

$result = $mysqli->query("SELECT * FROM super_chin_users_all_data WHERE login = '".$_COOKIE['login']."' AND password = '".$_COOKIE['password']."';");

if ($result->num_rows == 0) {
    setcookie('oldPage', 'Location: ../dna-base/search-user');
    header('Location: ../regist');
}
?>
<script type="text/javascript">
Vue.component("user-block", {
    props: ["user"],
    template: `<div class="card horizontal w-100 my-0">
            <div class="card-image">
                <img :src="user.avatar">
            </div>
            <div class="card-stacked">
                <div class="card-content">
                    <p>{{user.login}}</p>
                </div>
                <div class="card-action">
                    <a :href="'../dna-base/?profile=' + user.id">Перейти к профилю</a>
                </div>
            </div>
        </div>`
});
</script>
</head>

<body>
    
<div id="search-app">

<nav class="teal lighten-2">

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
        <li id="sidenav-panel"></li>
    </ul>
</nav>

    <div class="container-fluid py-4 position-fixed hide-on-med-and-down">
        <div class="row">
            <div id="origin-panel" class="col-4 col-sm-push-8 card my-0">
                <form class="w-100">
                    <div class="input-field">
                        <i class="material-icons prefix black-text">account_circle</i>
                        <input id="login" type="text" class="validate black-text" v-model="login">
                        <label for="login">Логин</label>
                    </div>
                    <div class="input-field">
                        <input id="firstName" type="text" class="validate black-text" v-model="first_name">
                        <label for="firstName">Имя</label>
                    </div>
                    <div class="input-field">
                        <input id="lastName" type="text" class="validate black-text" v-model="last_name">
                        <label for="lastName">Фамилия</label>
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
                    <div class="input-field">
                        <i class="material-icons prefix black-text">event</i>
                        <input id="olderChin" type="date" class="validate black-text" v-model="older_chin">
                        <label for="olderChin">Стаж не менее</label>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="container-fluid py-4">
        <div class="row" id="searched_result">
            <div class="col-md-8 col-12">
                <user-block v-for="(user, index) in filteredList" :key="index" :user="user"></user-block>
                </div>
            </div>
        </div>
    </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    
<script type="text/javascript">
$(document).ready(function(){
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
});

var SearchApp = new Vue ({
    el: '#search-app',
    data: {
        allUsers: [],
        login: "",
        first_name: "",
        last_name: "",
        country: "",
        city: "",
        older_chin: ""
    },
    created() {
        $.ajax({
            url: '../php/get_users.php',
            type: 'POST',
            data: {login: Cookies.get('login'), password: Cookies.get('password')},
            success: function(data) {
                SearchApp.allUsers = JSON.parse(data);
            }
        });
    }, 
    computed:{
        filteredList: function(){
            return this.allUsers.filter(function (elem) {
                return (elem.login.toLowerCase().indexOf(SearchApp.login.toLowerCase()) > -1) && (elem.first_name.toLowerCase().indexOf(SearchApp.first_name.toLowerCase()) > -1) &&
                    (elem.last_name.toLowerCase().indexOf(SearchApp.last_name.toLowerCase()) > -1) && (elem.country.toLowerCase().indexOf(SearchApp.country.toLowerCase()) > -1) &&
                    (elem.city.toLowerCase().indexOf(SearchApp.city.toLowerCase()) > -1) && ((SearchApp.older_chin == "") || (elem.olderChin <= SearchApp.older_chin));
            });
        }
    }
});

var sortByRating = function(d1, d2){return d1.id > d2.id ? 1 : -1; };

$(document).ready(function(){
    $('.sidenav').sidenav();
});
</script>

</body>
</html>