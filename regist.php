<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CHINCHILLAS-SHOW - Регистрация на сайте</title>
<?php
    include_once "components/import.html";
?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<style type="text/css">
html {
    background: linear-gradient(to top left, #b2ebf2, #e1bee7);
    min-height: 100vh;
}
body {
    background-color: transparent;
}
    .centerBlock {
        margin: 150px auto 80px auto;
    }
    .titleBlock {
        padding: 0;
    }
    .titlePointedBlock {
        display: inline-block;
        border: 1px solid red;
        width: 50%;
        cursor: pointer;
    }
    .inputArea {
        width: 100%;
        margin: 10px 0;
        padding: 0;
    }
    nav a:hover {
        color: white;
    }
    a:hover {
        text-decoration: none;
    }
</style>
<script type="text/javascript">
</script>
</head>

<body>
<nav class="position-absolute teal lighten-2" style="top: 0; left: 0;">
    <div class="container nav-wrapper">
        <ul id="nav-mobile" class="right">
          <li><a href="../"><i class="material-icons white-text left">arrow_back</i>Главная</a></li>
        </ul>

        <p class="brand-logo left">Вход/Регистрация</p>
    </div>
</nav>

<div id="RegistApp" class="centerBlock card container p-0">
    <div class="btn-group btn-group-toggle w-100 row" data-toggle="buttons">
        <label class="btn btn-secondary active col s6" @click="is_enter_or_regist=true">
            <input type="radio" name="options" autocomplete="off" checked> Вход
        </label>
        <label class="btn btn-secondary col s6" @click="is_enter_or_regist=false">
            <input type="radio" name="options" autocomplete="off"> Регистрация
        </label>
    </div>
    <div v-show="!is_enter_or_regist" class="card-content white-text">
        <form action="../php/newUser.php">
            <div class="input-field">
                <i class="material-icons prefix black-text">account_circle</i>
                <input id="icon_prefix" name="login" type="text" class="validate black-text" v-model="login" required>
                <label for="icon_prefix">Логин</label>
            </div>
            <div class="input-field">
                <input id="icon_first_name" name="first_name" type="text" class="validate black-text" v-model="first_name" required>
                <label for="icon_first_name">Имя</label>
            </div>
            <div class="input-field">
                <input id="icon_last_name" name="last_name" type="text" class="validate black-text" v-model="last_name" required>
                <label for="icon_last_name">Фамилия</label>
            </div>
            <div class="input-field">
                <input id="icon_middle_name" name="middle_name" type="text" class="validate black-text" v-model="middle_name">
                <label for="icon_middle_name">Отчество</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix black-text">local_phone</i>
                <input id="icon_telephone" name="tel" type="tel" class="validate black-text" v-model="tel" required>
                <label for="icon_telephone">Телефон</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix black-text">email</i>
                <input id="icon_email" name="email" type="email" class="validate black-text" v-model="email" required>
                <label for="icon_email">email</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix black-text">account_balance</i>
                <input id="icon_country" name="country" type="text" class="validate black-text" v-model="country" required>
                <label for="icon_country">Страна</label>
            </div>
            <div class="input-field">
                <input id="icon_city" name="city" type="text" class="validate black-text" v-model="city" required>
                <label for="icon_city">Город</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix black-text">lock</i>
                <input id="icon_password" name="password" type="password" class="validate black-text" v-model="password" required>
                <label for="icon_password">Пароль</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix black-text">lock_outline</i>
                <input id="icon_pass_double" name="pass_double" type="password" class="validate black-text" v-model="pass_double" required>
                <label for="icon_pass_double">Повторите пароль</label>
            </div>
        </form>
    </div>
    <div v-show="is_enter_or_regist" class="card-content white-text">
        <form action="../php/enterUser.php">
            <div class="input-field">
                <i class="material-icons prefix black-text">account_circle</i>
                <input id="icon_login_enter" type="text" class="validate black-text" v-model="login_enter" required>
                <label for="icon_login_enter">Логин</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix black-text">lock</i>
                <input id="icon_password_enter" type="password" class="validate black-text" v-model="password_enter" required>
                <label for="icon_password_enter">Пароль</label>
            </div>
        </form>
    </div>
    <div v-if="(text_message!='')" class="container-fluid px-4">
        <div class="alert alert-warning" role="alert">{{text_message}}</div>
    </div>
    <div class="card-action">
        <button class="btn-flat waves-effect waves-light" @click="SingIn">{{text_enter_button}}</button>
    </div>
</div>

<script type="text/javascript">
var RegistApp = new Vue({
    el: "#RegistApp",
    data: {
        is_enter_or_regist: true,
        text_enter_button: "Вход",
        text_message: "",

        login: "",
        first_name: "",
        last_name: "",
        middle_name: "",
        tel: "",
        email: "",
        country: "",
        city: "",
        password: "",
        pass_double: "",

        login_enter: "",
        password_enter: ""
    }, 
    methods: {
        SingIn: function() {
            if(this.is_enter_or_regist) {
                $.ajax({
                    url: '../php/enterUser.php',
                    type: 'POST',
                    data: this.$data,
                    success: function(data) {
                        if(data.substring(0, 4) == "well") {
                            location.href = data.substring(6);
                        } else {
                            RegistApp.text_message = data;
                        }
                    }
                });
            } else {
                $.ajax({
                    url: '../php/newUser.php',
                    type: 'POST',
                    data: this.$data,
                    success: function(data) {
                        if(data.substring(0, 4) == "well") {
                            location.href = data.substring(6);
                        } else {
                            RegistApp.text_message = data;
                        }
                    }
                });
            }
        }
    },
    watch: {
        is_enter_or_regist: function (val) {
            if(val) {
                this.text_enter_button = "Вход";
            } else {
                this.text_enter_button = "Регистрация";
            }
        }
    }
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>