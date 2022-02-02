<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Купить шиншилл</title>
<?php
    include_once "../components/import.html";
    include_once "../components/php-funs.php";

    $mysqli = BaseConect();

    $user = CheckUser($mysqli);
?>

<style type="text/css">
#print {
    transform: rotate(90deg);
}
input, span, label {
    color: black!inportant;
    weight: 400!inportant;
}
input {
    margin: 0;
}

@media print {
    #setting-panel {
        display: none;
    }
}
</style>
</head>

<body>

<div id="PrintApp">

<div class="container-fluid position-fixed teal lighten-3 p-0" id="setting-panel" style="z-index: 10;">
    <div class="row m-0">
        <div class="col-auto">
	        <a class="waves-effect waves-light btn-flat" href="/race/">
		        <i class="material-icons left">arrow_back</i><span class="d-none d-lg-inline">Назад</span>
		    </a>
        </div>
        <div class="col-auto pt-2">
            <div class="input-field m-0" style="width: 60px;">
                <input type="number" class="validate" v-model="px_convert">
            </div> 
        </div>
        <div class="col p-0">
            <div class="row m-0">
                <div class="input-field col-3 px-1 m-0">
                    <input placeholder="№ зверя" type="number" class="validate" v-model="index">
                </div> 
                <div class="input-field col-3 px-1 m-0">
                    <select v-model="old_group">
                        <option value="" selected>Без возраста</option>
                        <option value="baby">Малыши</option>
                        <option value="middle">Юниоры</option>
                        <option value="older">Взрослые</option>
                    </select>
                    <label>Возрастная группа</label>
                </div>
                <div class="input-field col-3 px-1 m-0">
                    <select v-model="group">
                        <option value="" selected>Все</option>
                        <option v-for="(group, index) in groups" :value="group[1]">{{group[0]}}</option>
                    </select>
                    <label>Категория</label>
                </div>
                <div class="input-field col-3 px-1 m-0">
                    <label class="position-relative">
                        <input type="checkbox" v-model="expert[0]" />
                        <span>РАЭШ</span>
                    </label>
                    <label class="position-relative">
                        <input type="checkbox" v-model="expert[1]" />
                        <span>ЕАЭШ</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-auto pt-2">
	        <button class="waves-effect waves-light btn-flat" @click="FilterChinsData">
		        <i class="material-icons">done</i>
		    </button>
        </div>
    </div>
</div>

<div id="print">
    <div class="container-fluid p-0" style="margin-left: -60px;"
        :style="'width: ' + (chins_data_print.length * px_convert) + 'px;'">
        <div class="row m-0" id="print-row">
            <div v-for="(chin, index) in chins_data_print" :key="index" class="col p-0" 
                :style="'width: ' + (100 / chins_data_print.length) + '%;'">

                <iframe :src="'https://chinchillas-show.com/race/100' + (chin.registedChins.result == 5 ? '' : 'N') + 
                    'points.php?first_name=' + 
                    chin.first_name + '&last_name=' + chin.last_name + 
                    '&name_chin=' + chin.registedChins.name_chin + 
                    '&birthday=' + chin.registedChins.birthday + '&expert=' + 
                    chin.registedChins.result + '&type=print&index=' + chin.registedChins.index" 
                    width="100%" height="1260px" class="border-0"></iframe>
            
            </div>
        </div>
    </div>
</div>

<div v-for="(chin, index) in chins_data_print" :key="index" v-if="(index % 2 == 0)" class="w-100 position-absolute"
    style="height: 0; background: black; border-bottom: 1px solid black;" :style="'top: ' + ((index + 1) * px_convert - 17) + 'px;'"></div>

</div>

</body>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, {});
});

var PrintApp = new Vue({
    el: '#PrintApp',
    data: {
        index: "",
        old_group: "",
        group: "",
        expert: [false, false],

        chins_data: [],
        chins_data_print: [],

        groups: [
            ["Стандарты", "st"],
            ["Стандарты КПА", "st_RPA"],
            ["Белые", "wt"],
            ["Белорозовые", "wt_p"],
            ["Белые эбони", "wt_e"],
            ["Белые рецессивы", "wt_r"],
            ["Бело-розовые эбони", "wt_p_e"],
            ["Белый КПА", "wt_RPA"],
            ["Бежевые", "bei"],
            ["Гомобежевые", "gbei"],
            ["Коричневые бархаты", "br_vel"],
            ["Бежевые рецесивы", "bei_r"],
            ["Бежевые КПА", "bei_RPA"],
            ["Пастели", "pas"],
            ["Бежевые рецесивные эбони", "bei_r_e"],
            ["Пастели КПА", "pas_RPA"],
            ["Фиолеты", "vio"],
            ["Сапфиры/Фиолеты", "sph_vio"],
            ["Сапфиры/Фиолеты/Бриллианты", "sph_vio_dia"],
            ["Эбони", "e"],
            ["Эбони КПА", "e_RPA"],
            ["Черный жемчуг/Черный бархат", "per"],
            ["КПА (Смешанная группа)", "RPA_mixed"],
            ["Смешанная группа", "mixed"],
            ["Без группы", "none"]
        ],
        px_convert: 832
    },
    created() {
        $.ajax({
            url: '../php/get_regist_to_show.php',
            type: 'POST',
            data: {},
            success: function(data) {
                for(let iter = 0; iter < 2; iter++) {
                    for (let i in JSON.parse(data)) {
                        let all_data = JSON.parse(data)[i];

                        let chin = JSON.parse(all_data.registedChins.replace(new RegExp('u0','g'),'\\u0'));

                        for (let j in chin) {
                            let new_chin = {};
                            for (let k in all_data) {
                                if (k != "registedChins") {
                                    new_chin[k] = all_data[k];
                                } else {
                                    new_chin[k] = chin[j];
                                }
                            }
                            /*if(!!new_chin.registedChins.result) {
                                if(!!new_chin.registedChins.result[iter]) {
                                    let new_chin_r;
                                    new_chin_r = new_chin;
                                    new_chin_r.registedChins.result = new_chin.registedChins.result[iter].ex;

                                    Object.freeze(new_chin_r);
                                    PrintApp.chins_data.push(new_chin_r);
                                    delete new_chin_r;
                                }
                            }*/
                                    let new_chin_r;
                                    new_chin_r = new_chin;
                                    //new_chin_r.registedChins.result = new_chin.registedChins.result[iter].ex;

                                    Object.freeze(new_chin_r);
                                    PrintApp.chins_data.push(new_chin_r);
                                    delete new_chin_r;
                            delete new_chin;
                        }
                    }
                }
            }
        });
    },
    methods: {
        FilterChinsData: function() {
            this.chins_data_print = this.chins_data.filter(function(chin) {
                if(!!PrintApp.index)
                    return chin.registedChins.index == PrintApp.index && 
                        ((PrintApp.expert[0] && chin.registedChins.result == 5) || 
                        (PrintApp.expert[1] && chin.registedChins.result == 6));
                else {
                    let bool = true;

                    if(!!PrintApp.old_group) {
                        let date = new Date(chin.registedChins.birthday);
                        let one_month = Number((6 > date.getDate())?"0":"1");
                        let one_year;
                        if(4 > (date.getMonth() + 1)) {
                            one_year = 0;
                        } else {
                            one_year = 1;
                            one_month -= 12;
                        }
                        let old = 4 - (date.getMonth() + 1) - one_month + (2019 - date.getFullYear() - one_year) * 12;
                        if (old < 6) bool = PrintApp.old_group == "baby";
                        else if (old >= 9) bool = PrintApp.old_group == "older";
                        else bool = PrintApp.old_group == "middle";
                    }

                    if(!!PrintApp.group) {
                        bool = bool && PrintApp.group == chin.registedChins.group;
                    }

                    bool = bool && ((PrintApp.expert[0] && chin.registedChins.result == 5) || 
                        (PrintApp.expert[1] && chin.registedChins.result == 6));

                    return bool;
                }
            });
        }
    }
})
</script>
</html>