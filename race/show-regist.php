<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CHINCHILLAS-SHOW - Регистрация на выставку</title>
<?php
    include_once "../components/import.html";
    include_once "../components/php-funs.php";

    $mysqli = BaseConect();

    $user = CheckUser($mysqli);

    $result = $mysqli->query("SELECT * FROM super_chin_all_shows;");
    $row = $result->fetch_assoc();

    if(!($row['step'] == 'regist' || RightsCheck($user, ['a11']))) {
        header('Location: RACE.php');
    }
?>

<style type="text/css">
.card-deck .card {
    min-width: 220px;
    margin-bottom: 16px;
}
.media {
    cursor: pointer;
    background-color: white;
    
    transition-duration: .1s;
    transition-property: background-color;
}
.media:hover {
    background-color: #fbfbfb;
}
</style>
<script type="text/javascript">
    Vue.component('search-chin-block', {
        props: ['chin', 'index'],
        template: `<div class="media m-0" :class="{'border-top': (index!=0)}" @click="$emit('click')">
                <div class="mr-3 img-fluid" style="width: 100px; height: 80px; background-attachment: fixed;" 
                    :style="{background: 'url(' + chin.avatar + ') no-repeat center / cover'}"></div>
                <div class="media-body">
                    <h5 class="mt-0">{{chin.name_chin}} | {{chin.id}}</h5>
                    {{color_chin}}
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
if(!$user) { ?>
<ul class="nav justify-content-end">
  <li class="nav-item">
    <a class="nav-link" href="../regist">У меня есть аккаунт на сайте</a>
  </li>
</ul>
<?php } ?>
<div id="RegistApp" class="container">
    <div id="accordion">
        <div class="card m-0">
            <div class="card-header" id="headingOne">
            <h5 class="m-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Регистрация пользователя
                </button>
            </h5>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="form-group col-12 col-md-4">
                                <label for="InputLastName">Фамилия</label>
                                <input type="text" class="form-control" id="InputLastName" v-model="last_name" :disabled="(isAutoCompleted||is_finish)" required>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label for="InputFirstName">Имя</label>
                                <input type="text" class="form-control" id="InputFirstName" v-model="first_name" :disabled="(isAutoCompleted||is_finish)" required>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label for="InputMiddleName">Отчество</label>
                                <input type="text" class="form-control" id="InputMiddleName" v-model="middle_name" :disabled="(isAutoCompleted||is_finish)">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-md-4">
                                <label for="InputCity">Город</label>
                                <input type="text" class="form-control" id="InputCity" v-model="city" :disabled="(isAutoCompleted||is_finish)" required>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label for="InputEmail">email</label>
                                <input type="email" class="form-control" id="InputEmail" v-model="email" :disabled="(isAutoCompleted||is_finish)" required>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label for="InputTel">Телефон</label>
                                <input type="tel" class="form-control" id="InputTel" v-model="tel" :disabled="(isAutoCompleted||is_finish)" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="InputFarm">Питомник</label>
                                <input type="text" class="form-control" id="InputFarm" v-model="farm">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" @click="toRegistChins" :disabled="(isAutoCompleted||is_finish)">Принять участие в выставке</button>
                    </form>
                </div>
            </div>
        </div>
        <div v-for="(chin, index) in registedChins" class="card m-0">
            <div class="card-header" id="headingTwo">
            <h5 class="m-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" :data-target="('#collapse' + index)" aria-expanded="false" aria-controls="collapseTwo">
                Шиншилла № {{index + 1}}
                </button>
            </h5>
            </div>
            <div :id="('collapse' + index)" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    <button v-if="isAutoCompleted" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#SearchApp" @click="SearchChin(index)" :disabled="registedChins[index].is_finish">Выбрать из профиля</button>
                    
                    <form>
                        <div class="row my-4">
                            <h3 class="lead col-12 d-block">Выберите систему оценки</h3>
                            <div class="btn-group-toggle col-6" data-toggle="buttons">
                                <!--label @click="System($event, index, 0)" class="btn btn-outline-primary btn-lg btn-block" :class="{'active': registedChins[index].system[0]}">
                                    <input type="checkbox" autocomplete="off"> Российская
                                </label-->
							    <label @click="System($event, index, 0)">
							        <input type="checkbox" v-model="registedChins[index].system[0]" />
							        <span>Российская</span>
							    </label>
                            </div>
                            <div class="btn-group-toggle col-6" data-toggle="buttons">
                                <!--label @click="System($event, index, 1)" class="btn btn-outline-primary btn-lg btn-block" :class="{'active': registedChins[index].system[1]}">
                                    <input type="checkbox" autocomplete="off"> Европейская
                                </label-->
							    <label @click="System($event, index, 1)">
							        <input type="checkbox" v-model="registedChins[index].system[1]" />
							        <span>Европейская</span>
							    </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12 col-md-3">                                
                                <label :for="('InputNameChin' + index)">Кличка</label>
                                <input type="text" class="form-control" :id="('InputNameChin' + index)" v-model="registedChins[index].name_chin" :disabled="registedChins[index].is_finish" required>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label class="d-block w-100">Пол</label>
                                <label>
                                    <input type="radio" value="famale" v-model="registedChins[index].sex" checked :disabled="registedChins[index].is_finish" required />
                                    <span class="lead m-0">Самка</span>
                                </label>
                                <label>
                                    <input type="radio" value="male" v-model="registedChins[index].sex" :disabled="registedChins[index].is_finish" />
                                    <span class="lead m-0">Самец</span>
                                </label>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label :for="('InputMiddleName' + index)">Дата рождения</label>
                                <input type="date" class="form-control" id="('InputMiddleName' + index)" v-model="registedChins[index].birthday" :disabled="registedChins[index].is_finish" required>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label :for="('BreaderName' + index)">Заводчик</label>
                                <input type="text" class="form-control" id="('BreaderName' + index)" v-model="registedChins[index].breader" :disabled="registedChins[index].is_finish" required>
                            </div>
                        </div>

                        <div class="card-deck">
                            <div class="card">
                                <div class="card-header">
                                    <label for="standart-input">Стандарт</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="2" id="standart-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.standart" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="Есть" :disabled="registedChins[index].StandartOrColored=='colored'">Есть</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="white-input">Белый</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="2" id="white-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.white" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет" :disabled="registedChins[index].MosaicWhite">Нет</option>
                                        <option value="Есть" :disabled="registedChins[index].StandartOrColored=='standart'">Есть</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="mosaic-input">Мазаичность</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="2" id="mosaic-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.mosaic" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="Есть" :disabled="registedChins[index].StandartOrColored=='standart'">Есть</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="beige-input">Бежевый</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="3" id="beige-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.beige" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="Есть" :disabled="registedChins[index].StandartOrColored=='standart'">Есть</option>
                                        <option value="Двойной" :disabled="registedChins[index].StandartOrColored=='standart'">Двойной</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="violet-input">Афро фиолет</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="5" id="violet-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.violet" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="50%">50%</option>
                                        <option value="67%">67%</option>
                                        <option value="Носитель">Носитель</option>
                                        <option value="Есть" :disabled="registedChins[index].StandartOrColored=='standart'">Есть</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="sapphire-input">Сапфир</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="5" id="sapphire-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.sapphire" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="50%">50%</option>
                                        <option value="67%">67%</option>
                                        <option value="Носитель">Носитель</option>
                                        <option value="Есть" :disabled="registedChins[index].StandartOrColored=='standart'">Есть</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="angora-input">Ангора</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="5" id="angora-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.angora" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="50%">50%</option>
                                        <option value="67%">67%</option>
                                        <option value="Носитель">Носитель</option>
                                        <option value="Есть" :disabled="registedChins[index].AROrFur=='fur'">Есть</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="ebony-input">Эбони</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="8" id="ebony-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.ebony" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="Носитель">Носитель</option>
                                        <option value="Светлый" :disabled="registedChins[index].StandartOrColored=='standart'">Светлый</option>
                                        <option value="Средний" :disabled="registedChins[index].StandartOrColored=='standart'">Средний</option>
                                        <option value="Темный" :disabled="registedChins[index].StandartOrColored=='standart'">Темный</option>
                                        <option value="Экстра темный" :disabled="registedChins[index].StandartOrColored=='standart'">Экстра темный</option>
                                        <option value="Гомоэбони" :disabled="registedChins[index].StandartOrColored=='standart'">Гомоэбони</option>
                                        <option value="Затрудняюсь ответить">Затрудняюсь ответить</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="velvet-input">Бархат</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="3" id="velvet-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.velvet" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="Возможно">Возможно</option>
                                        <option value="Есть" :disabled="(registedChins[index].StandartOrColored=='standart')||(registedChins[index].BlueOrVelvet=='blue')">Есть</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="pearl-input">Черный жемчуг</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="5" id="pearl-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.pearl" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="50%">50%</option>
                                        <option value="67%">67%</option>
                                        <option value="Носитель">Носитель</option>
                                        <option value="Есть" :disabled="registedChins[index].StandartOrColored=='standart'">Есть</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="california-input">Калифорния</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="5" id="california-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.california" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="50%">50%</option>
                                        <option value="67%">67%</option>
                                        <option value="Носитель">Носитель</option>
                                        <option value="Есть">Есть</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="rex-input">Рекс</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="5" id="rex-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.rex" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="50%">50%</option>
                                        <option value="67%">67%</option>
                                        <option value="Носитель">Носитель</option>
                                        <option value="Есть" :disabled="registedChins[index].AROrFur=='fur'">Есть</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="lova-input">Белый лова</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="5" id="lova-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.lova" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="50%">50%</option>
                                        <option value="67%">67%</option>
                                        <option value="Носитель">Носитель</option>
                                        <option value="Есть" :disabled="registedChins[index].StandartOrColored=='standart'">Есть</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="german-input">Немецкий фиолет</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="5" id="german-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.german" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="50%">50%</option>
                                        <option value="67%">67%</option>
                                        <option value="Носитель">Носитель</option>
                                        <option value="Есть" :disabled="registedChins[index].StandartOrColored=='standart'">Есть</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="blue-input">Блю слейт</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="2" id="blue-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.blue" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="Есть" :disabled="(registedChins[index].StandartOrColored=='standart')||(registedChins[index].BlueOrVelvet=='velvet')">Есть</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <label for="fur-input">Меховой</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control border-0" size="2" id="fur-input" @change="CheckColors(index)" 
                                            v-model="registedChins[index].colors.fur" style="overflow: hidden;" :disabled="registedChins[index].is_finish">
                                        <option selected value="Нет">Нет</option>
                                        <option value="Есть" :disabled="registedChins[index].AROrFur=='ar'">Есть</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row px-1">
                            <!--div class="btn-group-toggle col p-0" data-toggle="buttons">
                                <label @click="ForCheckColor($event, index)" class="btn btn-outline-primary btn-lg" :class="{'active': registedChins[index].forCheckColor}">
                                    <input type="checkbox" autocomplete="off"> На проверку окраса
                                </label>
                            </div-->
							<label>
							    <input type="checkbox" v-model="registedChins[index].forCheckColor" />
							    <span>На проверку окраса</span>
							</label>
                            <button type="button" class="btn btn-primary btn-lg ml-auto" @click="RemoveChin(index)">Удалить шиншиллу</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card m-0">
            <div class="card-header" id="headingOne">
                <h5 class="m-0">
                    <button class="btn btn-link" @click="AddChin">
                    + Добавить шиншиллу
                    </button>
                </h5>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary btn-lg my-4 mr-0" style="float: right;" @click="FinishRegist">Закончить заполнение заявки</button>
</div>

<div class="modal fade in" id="SearchApp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Выбрать шиншиллу из профиля</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <search-chin-block v-for="(chin, index) in allChins" :key="index" :index="index" :chin="chin" @click="ChooseChin(index)"></search-chin-block>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
var RegistApp = new Vue({
    el: '#RegistApp',
    data: {
        user_id: "<?php echo (!$user)?'0':$user['id']; ?>",
        last_name: "<?php echo (!$user)?'':$user['last_name']; ?>",
        first_name: "<?php echo (!$user)?'':$user['first_name']; ?>",
        middle_name: "<?php echo (!$user)?'':$user['middle_name']; ?>",
        city: "<?php echo (!$user)?'':$user['city']; ?>",
        email: "<?php echo (!$user)?'':$user['email']; ?>",
        tel: "<?php echo (!$user)?'':$user['tel']; ?>",
        farm: "",
        isAutoCompleted: <?php echo (!$user)?'false':'true'; ?>,
        is_finish: <?php echo (!$user)?'false':'true'; ?>,
        registedChins: [],

    },
    methods: {
        toRegistChins: function() {
        	if(!this.last_name) {
        		alert("Не указана фамилия")
        	} else if(!this.first_name) {
        		alert("Не указано имя")
        	} else if(!this.city) {
        		alert("Не указан город")
        	} else if(!this.email) {
        		alert("Не указана почта")
        	} else if(!this.tel) {
        		alert("Не указан иелефон")
        	} else {
	            this.is_finish = true;
	            $.ajax({
	                url: '../php/check_user_regist_show.php',
	                type: 'POST',
	                data: {last_name: this.last_name, first_name: this.first_name, middle_name: this.middle_name},
	                success: function(data) {
	                    if (data == "well") {
	                        RegistApp.AddChin();
	                    } else {
	                        let all_data = JSON.parse(data.replace(new RegExp('u0','g'),'\\u0'));
	                        RegistApp.registedChins = JSON.parse(all_data.registedChins);
	                        for(let i in RegistApp.registedChins) {
	                        	RegistApp.$set(RegistApp.registedChins[i], 'is_finish', false);
	                        }
	                    }
	                }
	            });
        	}
        },
        AddChin: function() {
            this.registedChins.push({
                is_finish: false,
                system: [false, false],

                id: "0",
                name_chin: "",
                sex: "",
                birthday: "",
                breader: "",
                farm: "",
                forCheckColor: false,
                group: "none",

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
                
                StandartOrColored: "null",
                MosaicWhite: false,
                BlueOrVelvet: "null",
                AROrFur: "null",
            });
        },
        RemoveChin: function(index) {
            this.registedChins.splice(index, 1);
        },
        CheckColors: function(index) {
            if (this.registedChins[index].colors.standart == "Есть") {
                this.registedChins[index].StandartOrColored = "standart";
            } else if (this.registedChins[index].colors.white == "Есть" || this.registedChins[index].colors.mosaic == "Есть" || this.registedChins[index].colors.beige == "Есть" || 
                this.registedChins[index].colors.beige == "Двойной" || this.registedChins[index].colors.violet == "Есть" ||
                this.registedChins[index].colors.sapphire == "Есть" || (this.registedChins[index].colors.ebony != "Нет" && this.registedChins[index].colors.ebony != 
                "Носитель" && this.registedChins[index].colors.ebony != "Затрудняюсь ответить") || this.registedChins[index].colors.velvet == "Есть" ||
                this.registedChins[index].colors.pearl == "Есть" || this.registedChins[index].colors.lova == "Есть" || this.registedChins[index].colors.german == "Есть" || this.registedChins[index].colors.blue == "Есть") {
                this.registedChins[index].StandartOrColored = "colored";
            } else {
                this.registedChins[index].StandartOrColored = "null";
            }
            if (this.registedChins[index].colors.mosaic == "Есть") {
                this.registedChins[index].colors.white = "Есть";
                this.registedChins[index].MosaicWhite = true;
            } else {
                this.registedChins[index].MosaicWhite = false;
            }
            if (this.registedChins[index].colors.blue == "Есть") {
                this.registedChins[index].BlueOrVelvet = "blue";
            } else if (this.registedChins[index].colors.velvet == "Есть") {
                this.registedChins[index].BlueOrVelvet = "velvet";
            } else {
                this.registedChins[index].BlueOrVelvet = "null";
            }
            if (this.registedChins[index].colors.angora == "Есть" || this.registedChins[index].colors.rex == "Есть") {
                this.registedChins[index].AROrFur = "ar";
            } else if (this.registedChins[index].colors.fur == "Есть") {
                this.registedChins[index].AROrFur = "fur";
            } else {
                this.registedChins[index].AROrFur = "null";
            }
        },
        SearchChin: function(index) {
            SearchApp.index = index;
            $.ajax({
                url: '../php/get_chins.php',
                type: 'POST',
                data: {login: Cookies.get('login'), password: Cookies.get('password'), now_owner: RegistApp.user_id},
                success: function(data) {
                    SearchApp.allChins = [];
                    let chinGroups = JSON.parse(data.replace(new RegExp('u0','g'),'\\u0'));
                    for (let chins in chinGroups) {
                        for (let chin in chinGroups[chins]) {
                            SearchApp.allChins.push(chinGroups[chins][chin]);
                        }
                    }
                }
            });
        },
        FinishRegist: function() {
        	let bool = true;
        	
        	for(let i in this.registedChins) {
        		if(!this.registedChins[i].name_chin) {
        			bool = false;
        			alert("Шиншилла " + i + " не указана кличка");
        		} else if(!this.registedChins[i].sex) {
        			bool = false;
        			alert("Шиншилла " + i + " не указан пол");
        		} else if(!this.registedChins[i].birthday) {
        			bool = false;
        			alert("Шиншилла " + i + " не указана дата рождения");
        		} else if(!this.registedChins[i].breader) {
        			bool = false;
        			alert("Шиншилла " + i + " не указан заводчик");
        		}
        	}
        	
        	if(bool) {
	            $.ajax({
	                url: '../php/regist_to_show.php',
	                type: 'POST',
	                data: {comand: "add", all_data: RegistApp.$data},
	                success: function(data) {
	                    if(data == "well") {
	                        location.href="../race/?result=success";
	                    }
	                }
	            });
        	}
        },
        System: function(event, index, which) {
            this.$set(this.registedChins[index].system, which, !this.registedChins[index].system[which]);
        },
        ForCheckColor: function(index) {
            this.$set(this.registedChins[index], 'forCheckColor', !this.registedChins[index].forCheckColor);
        }
    },
    created() {
        <?php echo (!$user)?'':'this.toRegistChins();'; ?>
    }
});

var SearchApp = new Vue({
    el: '#SearchApp',
    data: {
        index: 0,
        allChins: []
    },
    methods: {
        ChooseChin: function(index) {
            this.$set(RegistApp.registedChins[this.index], 'id', this.allChins[index].id);
            this.$set(RegistApp.registedChins[this.index], 'name_chin', this.allChins[index].name_chin);
            this.$set(RegistApp.registedChins[this.index], 'sex', this.allChins[index].sex);
            let date = new Date(Number(this.allChins[index].birthday));
            let month = (date.getMonth() < 9)?("0" + (date.getMonth() + 1)):(date.getMonth() + 1);
            let day = (date.getDay() < 10)?("0" + date.getDay()):(date.getDay());
            this.$set(RegistApp.registedChins[this.index], 'birthday', (date.getFullYear() + "-" + month + "-" + day));
            this.$set(RegistApp.registedChins[this.index], 'breader', this.allChins[index].breader);

            for (let color in RegistApp.registedChins[this.index].colors) {
                this.$set(RegistApp.registedChins[this.index].colors, color, 
                JSON.parse(this.allChins[index].colors.replace(new RegExp('u0','g'),'\\u0'))[color]);
            }

            this.$set(RegistApp.registedChins[this.index], 'is_finish', true);

            $('#SearchApp').modal('hide')
        }
    }
});
</script>
</body>
</html>