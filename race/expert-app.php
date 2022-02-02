<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CHINCHILLAS-SHOW - Приложение оценки</title>
<?php
    include_once "../components/import.html";
    include_once "../components/php-funs.php";

    $mysqli = BaseConect();

    $user = CheckUser($mysqli);

    $result = $mysqli->query("SELECT * FROM super_chin_all_shows;");
    $row = $result->fetch_assoc();

    /*if(!(($row['step'] == 'show' && RightsCheck($user, ['e5'])) || RightsCheck($user, ['a11']))) {
        header('Location: RACE.php');
    }*/
?>

<style type="text/css">
table {
    border: 1px solid black;
    border-collapse: collapse;
}
td {
    border: 1px solid black!important;
    text-align: center;
    padding: 4px 0;
    font-size: 1.2rem;
    line-height: 1;
}
.btn-outline-light:not(:disabled):not(.disabled).active {
    background-color: #e7c0ff!important;
}
h1 {
    font-size: 2.5rem!important;
}
h2 {
    font-size: 2rem!important;
}
@media print {
    td {
        background-color: #311199!important;
        -webkit-print-color-adjust: exact;
    }
    body {
        height: 500px;
        background-color: #399999!important;
        -webkit-print-color-adjust: exact; 
    }
}
@media (max-width: 992px) {
    #AppPlatform {
        width: 100%!important;
        max-width: 100%!important;
        flex: initial!important;
    }
    .sidenav-close {
        display: inline-block!important;
    }
}
</style>
<script type="text/javascript">
    Vue.component('Row', {
        props: ['chin', 'chin_data', 'old_group'],
        template: `<div v-if="isVisible" class="d-block btn-group-toggle row m-0">
            <label @click="SelectChin()" class="m-0 lead btn-light p-1 rounded-0 d-block" 
                :class="{'active': isActive}" style="overflow-x: hidden; white-space: inherit;">
                <span class="badge badge-info m-0" style="float: initial; color: white; min-width: initial;">
                	{{(!!chin.index) ? chin.index : 0}}</span>
                {{color_chin}} 
                <span style="color: red;">{{chin.forCheckColor == "true" ? '(Проверка)' : ''}}</span>
                {{sex}} 
                {{old}} 
            </label>
        </div>`,
        computed: {
            isVisible: function() {
                return (<?php echo $user['id']; ?> == 5 && this.chin.system[0] == "true") || 
                	(<?php echo $user['id']; ?> == 6 && this.chin.system[1] == "true");
            },
            color_chin: function() {
                let colors = JSON.parse(JSON.stringify(this.chin.colors).replace(new RegExp('u0','g'),'\\u0'));
                return fullChinColor(colors.standart, colors.white, colors.mosaic, colors.beige, 
                    colors.violet, colors.sapphire, colors.angora, colors.ebony, colors.velvet, 
                    colors.pearl, colors.california, colors.rex, colors.lova, colors.german, 
                    colors.blue, colors.fur);
            },
            sex: function() {
                return this.chin.sex[0].toUpperCase();
            }, 
            old: function() {
                let date = new Date(this.chin.birthday);
                let one_month = Number((15 > date.getDay())?"0":"1");
                let one_year;
                if(4 > date.getMonth()) {
                    one_year = 0;
                } else {
                    one_year = 1;
                    one_month -= 12;
                }
                return (2019 - date.getFullYear() - one_year) + "/" + (4 - (date.getMonth() + 1) - one_month);
            },
            isActive: function() {
                if(ExpertApp.redactedList.indexOf(this.chin_data.index_for_sort) > -1) {
                    return true;
                } else {
                    return false;
                }
            }
        },
        methods: {
            SelectChin: function() {
                this.$emit('toggle-chin', this.chin_data.index_for_sort);
            }
        }
    });
    Vue.component('table-group', {
        props: ['group', 'group_data', 'groups_list', 'old_group'],
        template: `<div class="container-fluid p-0">
            <div class="row m-0 alert-info pl-2">
                <h2 class="text-center w-100 m-0">{{group_name}}</h2>
                <!--div class="btn-group btn-group-toggle ml-auto" data-toggle="buttons">
                    <label class="btn px-2 btn-outline-success border-0" @click="$emit('select-system-points', [group, '100N', old_group])">
                        <input type="radio" name="options" autocomplete="off"> 100N
                    </label>
                    <label class="btn px-2 btn-outline-success border-0" @click="$emit('select-system-points', [group, 100, old_group])">
                        <input type="radio" name="options" autocomplete="off"> 100
                    </label>
                    <label class="btn px-2 btn-outline-success border-0" @click="$emit('select-system-points', [group, 81, old_group])">
                        <input type="radio" name="options" autocomplete="off"> 81
                    </label>
                    <label class="btn px-2 btn-outline-success border-0" @click="$emit('select-system-points', [group, 50, old_group])">
                        <input type="radio" name="options" autocomplete="off"> 50
                    </label>
                </div-->
            </div>
            <Row v-for="(chin, index) in group_data" :key="index" :chin_data="chin" :chin="chin.registedChins" 
                @toggle-chin="SelectChin($event)" :old_group="old_group"></Row>
        </div>`,
        computed: {
            group_name: function() {
                for (let i in this.groups_list) {
                    if(this.group == this.groups_list[i][1])
                        return this.groups_list[i][0];
                }
            }
        },
        methods: {
            SelectChin: function(data) {
                this.$emit('toggle-chin', data);
            }
        }
    });
    Vue.component('expert-frame', {
        props: ['chin', 'groups'],
        template: `<div v-if="IfCondition" class="w-100">
            <div class="container-fluid">
                <div class="row m-0">
                    <div class="col-auto lead h2 mt-1 pl-5 ml-5">{{index}}</div>
                    <div class="col text-center lead h2 mt-1">{{color_chin}}
                        <span style="color: red;">{{forCheckColor == "true" ? '(Проверка окраса)' : ''}}</span></div>
                    <div class="col-auto lead h2 mt-1">{{old}}</div>
                </div>
            </div>
            <iframe :id="'frame' + chin" class="border-0" :src="Src" width="100%" style="height: 95vh;"></iframe>
        </div>`,
        data: function() {
            let finded = false;
            let return_data = {};
            for(let i in ExpertApp.registedChins) {
                if(i == this.chin) {
                    return_data.chin_data = ExpertApp.registedChins[i];
                    
		            return_data.index = return_data.chin_data.registedChins.index;
		            return_data.forCheckColor = return_data.chin_data.registedChins.forCheckColor;

                    let colors = return_data.chin_data.registedChins.colors;
                    return_data.color_chin = fullChinColor(colors.standart, colors.white, colors.mosaic, colors.beige, 
                        colors.violet, colors.sapphire, colors.angora, colors.ebony, colors.velvet, 
                        colors.pearl, colors.california, colors.rex, colors.lova, colors.german, 
                        colors.blue, colors.fur);

                    let date = new Date(return_data.chin_data.registedChins.birthday);
                    let one_month = Number((15 > date.getDay())?"0":"1");
                    let one_year;
                    if(4 > date.getMonth()) {
                        one_year = 0;
                    } else {
                        one_year = 1;
                        one_month -= 12;
                    }
                    return_data.old = (2019 - date.getFullYear() - one_year) + "/" + (4 - (date.getMonth() + 1) - one_month);
                    
                    
		            let old = 4 - (date.getMonth() + 1) - one_month + (2019 - date.getFullYear() - one_year) * 12;
		            let old_gr;
		            if (old < 6) old_gr = "baby";
		            else if (old >= 9) old_gr = "older";
		            else old_gr = "middle";

                    for(let i in this.groups) {
                        if(this.groups[i][1] == return_data.chin_data.registedChins.group && !!this.groups[i][2][old_gr]) {
                            return_data.IfCondition = true;
                            return_data.Src = this.groups[i][2][old_gr] + 'points.php?first_name=' + return_data.chin_data.first_name + 
                                '&last_name=' + return_data.chin_data.last_name + 
                                '&name_chin=' + return_data.chin_data.registedChins.name_chin + 
                                '&birthday=' + return_data.chin_data.registedChins.birthday + 
                                '&expert=' + <?php echo $user['id']; ?>;
                        }
                    }
                    if(!return_data.IfCondition) {
                        return_data.IfCondition = fasle;
                        return_data.Src = "";
                    }
                }
            }
            return return_data;
        }
    });
</script>
</head>

<body>
<div id="ExpertApp" class="container-fluid p-0">

    <a href="#" data-target="mobile-demo" class="sidenav-trigger position-fixed teal btn-flat" style="top: 0; left: 0; z-index: 10;">
        <i class="material-icons" style="color: white;">menu</i>
    </a>
    <ul class="sidenav" id="mobile-demo">
        <li id="sidenav-panel"></li>
    </ul>

    <div class="row m-0">
        <div id="origin-panel" class="col-3 border p-0 hide-on-med-and-down" style="height: 100vh; overflow-y: auto; z-index: 20;">
            <div id="AppController">
                <div class="row m-0 teal">
                    <a class="waves-effect waves-light btn-flat text-center" href="/race/" style="color: white;">
                        <i class="material-icons left">arrow_back</i>Назад
                    </a>
                    <a class="waves-effect waves-light btn-flat ml-auto text-center sidenav-close d-none" style="color: white;">
                        <i class="material-icons right">close</i>Закрыть
                    </a>
                </div>
                <div v-if="(Object.keys(sortedRegistedChins.baby).length != 0)" class="row m-0 alert-warning">
                    <h1 class="text-center w-100 m-0">Малыши</h1>
                </div>
                <table-group v-for="(group, key) in sortedRegistedChins.baby" :key="key" :group="key" :group_data="group" 
                    :old_group="'baby'" :groups_list="groups" @toggle-chin="SelectChin($event)" 
                    @select-system-points="SelectSystemPoints($event)"></table-group>
                <div v-if="(Object.keys(sortedRegistedChins.middle).length != 0)" class="row m-0 alert-warning">
                    <h1 class="text-center w-100 m-0">Юниоры</h1>
                </div>
                <table-group v-for="(group, key) in sortedRegistedChins.middle" :key="key" :group="key" :group_data="group" 
                    :old_group="'middle'" :groups_list="groups" @toggle-chin="SelectChin($event)" 
                    @select-system-points="SelectSystemPoints($event)"></table-group>
                <div v-if="(Object.keys(sortedRegistedChins.older).length != 0)" class="row m-0 alert-warning">
                    <h1 class="text-center w-100 m-0">Взрослые</h1>
                </div>
                <table-group v-for="(group, key) in sortedRegistedChins.older" :key="key" :group="key" :group_data="group" 
                    :old_group="'older'" :groups_list="groups" @toggle-chin="SelectChin($event)" 
                    @select-system-points="SelectSystemPoints($event)"></table-group>
            </div>
        </div>

        <div class="col-12 col-md-9 border p-0" style="height: 100vh; overflow-y: auto;" id="AppPlatform">
            <expert-frame v-for="(chin, index) in redactedList" :key="chin" :chin="chin" :groups="groups"></expert-frame>
        </div>
    </div>
</div>

<script type="text/javascript">

$(document).ready(function(){
    $('.sidenav').sidenav();

    if(window.innerWidth < 992) {
        $('#AppController').appendTo('#sidenav-panel');
        $('#origin-panel>#AppController').remove();
    } else {
        $('#AppController').appendTo('#origin-panel');
        $('#sidenav-panel>#AppController').remove();
    }
    $(window).resize(function() {
        if(window.innerWidth < 992) {
            $('#AppController').appendTo('#sidenav-panel');
            $('#origin-panel>#AppController').remove();
        } else {
            $('#AppController').appendTo('#origin-panel');
            $('#sidenav-panel>#AppController').remove();
        }
    })
});

let system = "";
if(<?= $user['id'] ?> == 5) {
    system = 100;
} else if(<?= $user['id'] ?> == 6) {
    system = '100N';
}

var ExpertApp = new Vue ({
    el: '#ExpertApp',
    data: {
        groups: [
            ["Стандарты", "st", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Стандарты КПА", "st_RPA", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Белые", "wt", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Белорозовые", "wt_p", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Белые эбони", "wt_e", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Белые рецессивы", "wt_r", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Бело-розовые эбони", "wt_p_e", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Белый КПА", "wt_RPA", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Бежевые", "bei", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Гомобежевые", "gbei", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Коричневые бархаты", "br_vel", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Бежевые рецесивы", "bei_r", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Бежевые КПА", "bei_RPA", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Пастели", "pas", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Бежевые рецесивные эбони", "bei_r_e", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Пастели КПА", "pas_RPA", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Фиолеты", "vio", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Сапфиры/Фиолеты", "sph_vio", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Сапфиры/Фиолеты/Бриллианты", "sph_vio_dia", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Эбони", "e", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Эбони КПА", "e_RPA", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Черный жемчуг/Черный бархат", "per", {
                baby: system,
                middle: system,
                older: system
            }],
            ["КПА (Смешанная группа)", "RPA_mixed", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Смешанная группа", "mixed", {
                baby: system,
                middle: system,
                older: system
            }],
            ["Без группы", "none", {
                baby: system,
                middle: system,
                older: system
            }]
        ],
        registedChins: [],
        textFilter: "",
        redactedList: []
    },
    created() {
        $.ajax({
            url: '../php/get_regist_to_show.php',
            type: 'POST',
            data: {},
            success: function(data) {
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
                        Object.freeze(new_chin);
                        ExpertApp.registedChins.push(new_chin);
                        delete new_chin;
                    }
                }
            }
        });
    },
    methods: {
        SortChins: function(d1, d2) {
            let d1_group, d2_group;
            for(let i = 0; i < this.groups.length; i++) {
                if(d1.registedChins.group == this.groups[i][1]) {
                    d1_group = i;
                }
                if(d2.registedChins.group == this.groups[i][1]) {
                    d2_group = i;
                }
            }
            if(d1_group > d2_group) return 1;
            else if(d1_group < d2_group) return -1;
            else {
                return d1.registedChins.birthday < d2.registedChins.birthday ? 1 : -1;
            }
        }, 
        SelectChin: function (data) {
            if(this.redactedList.indexOf(data) > -1) {
                this.redactedList.splice(this.redactedList.indexOf(data), 1);
            } else {
                this.redactedList.push(data);
            }
        },
        old_group: function(birthday, name_chin) {
        	if(name_chin != "Мамбо") {
	            let date = new Date(birthday);
	            let one_month = Number((6 > date.getDate())?"0":"1");
	            let one_year;
	            if(4 > (date.getMonth() + 1)) {
	                one_year = 0;
	            } else {
	                one_year = 1;
	                one_month -= 12;
	            }
	            let old = 4 - (date.getMonth() + 1) - one_month + (2019 - date.getFullYear() - one_year) * 12;
	            if (old < 6) return "baby";
	            else if (old >= 9) return "older";
	            else return "middle";
        	} else return "older";
        },
        SelectSystemPoints: function(data) {
            for(let i in this.groups) {
                if (this.groups[i][1] == data[0]) {
                    if(!this.groups[i][2]) {
                        this.groups[i].push({});
                    }
                    this.$set(this.groups[i][2], data[2], data[1]);
                }
            }
        }
    },
    computed: {
        sortedRegistedChins: function() {
            this.registedChins.sort(this.SortChins);
            let chinsCash = {};
            chinsCash.baby = {};
            chinsCash.middle = {};
            chinsCash.older = {};

            for (let i = 0; i < this.registedChins.length; i++) {
            	let cash_data = {};
                let old_group = this.old_group(this.registedChins[i].registedChins.birthday, this.registedChins[i].registedChins.name_chin);
                let group = this.registedChins[i].registedChins.group;
                if (!chinsCash[old_group][group]) {
                    chinsCash[old_group][group] = [];
                }
                cash_data.index_for_sort = i;
                cash_data.index = i;
                for(let key in this.registedChins[i]) {
                    cash_data[key] = this.registedChins[i][key];
                }
                chinsCash[old_group][group].push(cash_data);
            }
            
            return chinsCash;
        }
    }
});
</script>
</body>
</html>