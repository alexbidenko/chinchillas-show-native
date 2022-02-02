<?php
include_once "components/php-funs.php";

$mysqli = BaseConect();

$user = CheckUser($mysqli);

if(!RightsCheck($user, ['a11'])) {
    header('Location: regist.php');
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Купить шиншилл</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src="../components/js.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

</head>

<body>

<div id="Admin" class="container">
    <div class="row">
        <div class="col s4 card-panel light-blue lighten-3">
            <span class="teal-text text-darken-4">Настройки выставки</span>

            <button data-target="RedactShow" @click="RedactShow" class="waves-effect waves-light btn modal-trigger"
                >Настройки текущей выставки</button>
        </div>
    </div>



    <div id="RedactShow" class="modal">
        <div class="modal-content">
            <div class="row">
                <div class="col s1">
                    <h2>{{data_show.show_index}}</h2>
                </div>
                <div class="input-field col s11">
                    <input v-model="data_show.title" placeholder="Placeholder" type="text" class="validate">
                    <label for="first_name">Название выставки</label>
                </div>
            </div>
            <div class="divider"></div>
            <div class="input-field col s12">
                <select v-model="data_show.step">
                    <option value="regist">Регистрация</option>
                    <option value="show">Выставка</option>
                    <option value="result">Итоги</option>
                    <option value="silent">Нет выставки</option>
                </select>
                <label>Этап выставки</label>
            </div>

            <button class="waves-effect waves-light btn" @click="CreateResultShow">Подвести итоги выставки</button>
        </div>
        <div class="modal-footer">
            <a href="" class="modal-close waves-effect waves-green btn-flat">Отмена</a>
            <a href="" class="modal-close waves-effect waves-green btn-flat" @click="SaveRedactShow">Сохранить</a>
        </div>
    </div>

</div>

<script type="text/javascript">
$(document).ready(function(){
    $('.modal').modal();
});

var Admin = new Vue({
    el: "#Admin",
    data: {
        data_show: {}
    },
    methods: {
        RedactShow: function() {
            $.ajax({
                url: '../php/get_show_info.php',
                type: 'POST',
                data: {do: 'get'},
                success: function(data) {
                    Admin.data_show = JSON.parse(data);

                    Admin.$nextTick(function() {
                        $('select').formSelect();
                    });
                }
            });
        },
        SaveRedactShow: function() {
            $.ajax({
                url: '../php/get_show_info.php',
                type: 'POST',
                data: {do: 'set', data: this.data_show},
                success: function(data) {
                }
            });
        },
        CreateResultShow: function() {
            $.ajax({
                url: '../php/create_result_show.php',
                type: 'POST',
                data: {},
                success: function(data) {
                }
            });
        }
    }
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>