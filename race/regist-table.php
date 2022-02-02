<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CHINCHILLAS-SHOW - Таблица результатов</title>
<?php
    include_once "../components/import.html";
    include_once "../components/php-funs.php";

    $mysqli = BaseConect();

    $user = CheckUser($mysqli);
?>

<style type="text/css">
html {
    min-width: 1100px;
}
table {
    border: 1px solid black;
    border-collapse: collapse;
}
td {
    border: 1px solid black!important;
    text-align: center;
    padding: 4px 0;
    font-size: 0.8rem!important;
    line-height: 1;
}
.btn-outline-light:not(:disabled):not(.disabled).active {
    background-color: #e7c0ff!important;
}
label {
    height: initial!important;
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
</style>
<script type="text/javascript">
    Vue.component('Row', {
        props: ['chin', 'chin_data', 'old_group'],
        template: `<div class="d-block btn-group-toggle row position-relative m-0">
            <div @click="SelectChin()" class="d-block btn-outline-light btn-lg rounded-0 p-0 m-0 w-100 border-0" 
                :class="{'active': isActive}">
                <table class="w-100" style="color: black;">
                    <tr class="w-100">
                        <td style="width: 4%;" class="p-0">
                        <?php if(RightsCheck($user, ['a11'])) { ?>
                        	<input class="lead m-0 text-center" type="number" v-model="index" @change="UpdateIndex">
                        <?php } else { ?>
                            {{index}}
                        <?php } ?>
                        </td>
                        <td style="width: 8%;">{{chin.name_chin}}</td>
                        <td style="width: 20%;">
                            <div style="overflow: hidden; white-space: inherit; max-height: 100%;">{{color_chin}}</div>
                        </td>
                        <td style="width: 3%;">{{sex}}</td>
                        <td style="width: 3%;">{{old}}</td>
                        <td style="width: 6%;">{{group}}</td>
                        <td style="width: 8%;">{{farm}}</td>
                        <td style="width: 8%;">{{owner}}</td>
                        <td style="width: 8%;">{{chin.breader}}</td>
                        <td style="width: 8%; background-color: #a9ffbe">
                        <?php if(RightsCheck($user, ['a11']) || $user['id'] == 5) { ?>
                        	<input class="lead m-0 text-center" type="text" v-model="place[0]" @change="UpdatePlace(0)">
                        <?php } else { ?>
                            {{place[0]}}
                        <?php } ?>
                        </td>
                        <td style="width: 6%; background-color: #a9ffbe" v-html="result[0]"></td>
                        <td style="width: 8%; color: black;" class="alert-primary">
                        <?php if(RightsCheck($user, ['a11']) || $user['id'] == 6) { ?>
                        	<input class="lead m-0 text-center" type="text" v-model="place[1]" @change="UpdatePlace(1)">
                        <?php } else { ?>
                            {{place[1]}}
                        <?php } ?>
                        </td>
                        <td style="width: 6%; color: black;" class="alert-primary" v-html="result[1]"></td>
                        <td style="width: 4%; background: beige;">{{(chin.forCheckColor == "true")?"✓":""}}</td>
                    </tr>
                </table>
            </div>
        </div>`,
        data: function() {
        	return {
                index: (!!this.chin.index) ? this.chin.index : ""
        	};
        },
        computed: {
            color_chin: function() {
                let colors = this.chin.colors;
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
                let one_month = Number((6 > date.getDate())?"0":"1");
                let one_year;
                if(4 > (date.getMonth() + 1)) {
                    one_year = 0;
                } else {
                    one_year = 1;
                    one_month -= 12;
                }
                return (2019 - date.getFullYear() - one_year) + "/" + (4 - (date.getMonth() + 1) - one_month);
            },
            group: function() {
            	if (this.chin.name_chin == "Мамбо") return "Юниор";
                switch(this.old_group) {
                    case "baby":
                        return "Малыш";
                        break;
                    case "middle":
                        return "Юниор";
                        break;
                    case "older":
                        return "Взрослый";
                        break;
                }
            },
            farm: function() {
                if (this.chin_data.farm != "") {
                    return this.chin_data.farm;
                } else {
                    return this.chin_data.last_name + " " + this.chin_data.first_name;
                }
            },
            owner: function() {
                return this.chin_data.last_name + " " + this.chin_data.first_name;
            },
            isActive: function() {
                if(TableApp.redactedList.indexOf(this.chin_data.index_for_sort) > -1) {
                    return true;
                } else {
                    return false;
                }
            },
            place: function() {
                let place = ["", ""];
                if(!!this.chin.result) {
                    for (let res of this.chin.result) {
                        if(+res.ex == 5) {
                            place[0] = (!!res.place) ? res.place : "";
                        } else if(+res.ex == 6) {
                            place[1] = (!!res.place) ? res.place : "";
                        }
                    }
                }
                return place;
            },
            result: function() {
                let ans = ["", ""];
                if(!!this.chin.result) {
                    for (let res of this.chin.result) {
                        if(+res.ex == 5) {
                            let sum = 0;
                            for(let d in res.data) {
                                if(!isNaN(res.data[d])) {
                                    sum += +res.data[d];
                                }
                            }
                            ans[0] = `<a href="` + '100points.php?first_name=' + this.chin_data.first_name + 
                                '&last_name=' + this.chin_data.last_name + 
                                '&name_chin=' + this.chin.name_chin + 
                                '&birthday=' + this.chin.birthday + 
                                '&expert=5&type=print&index=' + this.chin.index + `" 
                                style="display: block; height: 18px; line-height: 18px; font-size: 14px;">${sum}</a>`;
                        } else if(+res.ex == 6) {
                            let sum = 0;
                            for(let d in res.data) {
                                if(!isNaN(res.data[d])) {
                                    sum += +res.data[d];
                                }
                            }
                            ans[1] = `<a href="` + '100Npoints.php?first_name=' + this.chin_data.first_name + 
                                '&last_name=' + this.chin_data.last_name + 
                                '&name_chin=' + this.chin.name_chin + 
                                '&birthday=' + this.chin.birthday + 
                                '&expert=6&type=print&index=' + this.chin.index + `" 
                                style="display: block; height: 18px; line-height: 18px; font-size: 14px;">${sum}</a>`;
                        }
                    }
                }
                if(!ans[0]) {
                    ans[0] = `<p class="m-0">✓</p>`;
                }
                if(!ans[1]) {
                    ans[1] = `<p class="m-0">✓</p>`;
                }
            	return ans;
            }
        },
        methods: {
            SelectChin: function() {
                this.$emit('toggle-chin', this.chin_data.index_for_sort);
            },
            UpdateIndex: function() {
            	for(let i in TableApp.registedChins) {
            		if(TableApp.registedChins[i].registedChins.name_chin == this.chin.name_chin &&
            			TableApp.registedChins[i].registedChins.birthday == this.chin.birthday) {
            			TableApp.$set(TableApp.registedChins[i].registedChins, 'index', this.index);
            		}
            	}
            },
            UpdatePlace: function(which) {
            	for(let i in TableApp.registedChins) {
            		if(TableApp.registedChins[i].registedChins.name_chin == this.chin.name_chin &&
            			TableApp.registedChins[i].registedChins.birthday == this.chin.birthday) {
                        let bool = false;
                        if(!!this.chin.result) {
                            for (let j in this.chin.result) {
                                if(+this.chin.result[j].ex == 5 && which == 0) {
            			            TableApp.$set(TableApp.registedChins[i].registedChins.result[j], 'place', this.place[0]);
                                    bool = true;
                                } else if(+this.chin.result[j].ex == 6 && which == 1) {
            			            TableApp.$set(TableApp.registedChins[i].registedChins.result[j], 'place', this.place[1]);
                                    bool = true;
                                }
                            }
                        }
                        if(!bool) this.place[which] = "";
            		}
            	}
            }
        }
    });
    Vue.component('table-group', {
        props: ['group', 'group_data', 'groups_list', 'old_group'],
        template: `<div class="container-fluid p-0">
            <div class="row alert-info m-0">
                <h2 class="text-center w-100 m-0">{{group_name}}</h2>
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

	var SaveData = () => {
	    var sendChins = [];
	    for (let i in TableApp.registedChins) {
	        let has = false;
	        for (let j in sendChins) {
	            if (sendChins[j].last_name == TableApp.registedChins[i].last_name && 
	            sendChins[j].first_name == TableApp.registedChins[i].first_name && 
	            sendChins[j].middle_name == TableApp.registedChins[i].middle_name) {
	                has = true;
	                sendChins[j].registedChins.push(TableApp.registedChins[i].registedChins);
	            }
	        }
	        if (!has) {
	            sendChins.push({});
	            for (let k in TableApp.registedChins[i]) {
	                if (k == "registedChins") {
	                    sendChins[sendChins.length - 1][k] = [TableApp.registedChins[i][k]];
	                } else {
	                    sendChins[sendChins.length - 1][k] = TableApp.registedChins[i][k];
	                }
	            }
	        }
	    }
	    
	    $.ajax({
	        url: '../php/regist_to_show.php',
	        type: 'POST',
	        data: {comand: "updata", len: JSON.stringify(sendChins).length, all_data: JSON.stringify(sendChins)},
	        success: function(data) {
	        	TableApp.redactedList = [];
	        	alert("Изменения сохранены.");
	        }
	    });
	}
</script>
</head>

<body>
<div id="TableApp" class="container-fluid p-0 pt-5">
    <div class="container-fluid position-fixed p-0 alert-primary" style="top: 0; z-index: 1;">
        <div class="row m-0">
            <div class="col-auto pl-0">
		        <a class="waves-effect waves-light btn-flat" href="/race/">
		            <i class="material-icons left">arrow_back</i><span class="d-none d-lg-inline">Назад</span>
		        </a>
            </div>
            <div class="col-auto pl-0">
                <div id="alert-message" class="alert alert-danger py-2 m-0" style="display: none;">
                    Данные обновлены, перезагрузите страницу
                </div>
            </div>
            <?php if(RightsCheck($user, ['a11'])) { ?>
            <div class="col-auto ml-auto align-self-end">
                <div class="input-group btn-group" style="flex-wrap: initial;">
                    <input type="text" class="form-control btn-lg m-0" placeholder="Группа" v-model="textFilter">
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary btn-lg dropdown-toggle" data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu dropdown-menu-right" style="max-height: 500px; overflow: auto;">
                            <button v-for="(group, index) in filtredGroups" @click="ToGroup(group[1])" class="dropdown-item btn-lg" type="button">{{group[0]}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="row m-0">
            <table id="legend" class="w-100" style="color: black;">
                <tr class="w-100">
                    <td style="width: 4%;" class="p-0">ID</td>
                    <td style="width: 8%;">Кличка</td>
                    <td style="width: 20%;">Окрас</td>
                    <td style="width: 3%;">Пол</td>
                    <td style="width: 3%;">Возраст</td>
                    <td style="width: 6%;">Группа</td>
                    <td style="width: 8%;">Питомник</td>
                    <td style="width: 8%;">Владелец</td>
                    <td style="width: 8%;">Заводчик</td>
                    <td style="width: 8%;"></td>
                    <td style="width: 6%;">РАЭШ</td>
                    <td style="width: 8%;"></td>
                    <td style="width: 6%;">ЕАЭШ</td>
                    <td style="width: 4%;">На проверку</td>
                </tr>
            </table>
    	</div>
    </div>

    <div v-if="(Object.keys(sortedRegistedChins.baby).length != 0)" class="row alert-warning m-0" style="margin-top: 26px!important;">
        <h1 class="text-center w-100 m-0">Малыши</h1>
    </div>
    <table-group v-for="(group, key) in sortedRegistedChins.baby" :key="key" :group="key" :group_data="group" 
        :old_group="'baby'" :groups_list="groups" @toggle-chin="SelectChin($event)"></table-group>
    <div v-if="(Object.keys(sortedRegistedChins.middle).length != 0)" class="row alert-warning m-0">
        <h1 class="text-center w-100 m-0">Юниоры</h1>
    </div>
    <table-group v-for="(group, key) in sortedRegistedChins.middle" :key="key" :group="key" :group_data="group" 
        :old_group="'middle'" :groups_list="groups" @toggle-chin="SelectChin($event)"></table-group>
    <div v-if="(Object.keys(sortedRegistedChins.older).length != 0)" class="row alert-warning m-0">
        <h1 class="text-center w-100 m-0">Взрослые</h1>
    </div>
    <table-group v-for="(group, key) in sortedRegistedChins.older" :key="key" :group="key" :group_data="group" 
        :old_group="'older'" :groups_list="groups" @toggle-chin="SelectChin($event)"></table-group>
        
	<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
	    <button class="btn-floating btn-large waves-effect waves-light teal" onclick="SaveData();">
	        <i class="material-icons" style="color: white;">done</i>
	    </button>
	</div>
</div>

<script type="text/javascript">
let start_time = new Date().getTime();

var TableApp = new Vue ({
    el: '#TableApp',
    data: {
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
                        TableApp.registedChins.push(new_chin);
                        delete new_chin;
                    }
                }
            }
        });

        setInterval(function() {
            $.ajax({
                url: 'last-updata.txt',
                type: 'GET',
                success: function(data) {
                    if(start_time < (+data + 1) * 1000) {
                        $('#alert-message').css('display', 'block');
                        $('.fixed-action-btn').css('display', 'none');
                    }
                }
            });
        }, 5000);
    },
    methods: {
        ToGroup: function(group) {
            for(let i = 0; i < this.registedChins.length; i++) {
                if(this.redactedList.indexOf(i) > -1) {
                    this.$set(this.registedChins[i].registedChins, 'group', group);
                }
            }
            this.redactedList = [];

            this.registedChins.sort(this.SortChins);
        },
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
                let old_group = this.old_group(this.registedChins[i].registedChins.birthday, this.registedChins[i].registedChins.name_chin);
                let group = this.registedChins[i].registedChins.group;
                if (typeof chinsCash[old_group][this.registedChins[i].registedChins.group] == 'undefined') {
                    chinsCash[old_group][group] = [];
                }
                chinsCash[old_group][group].push({});

                chinsCash[old_group][group][chinsCash[old_group][group].length - 1].index_for_sort = i;

                for(let key in this.registedChins[i]) {
                    chinsCash[old_group][group][chinsCash[old_group][group].length - 1][key] = this.registedChins[i][key];
                }
            }
            
            return chinsCash;
        },
        filtredGroups: function() {
            var textFilter = this.textFilter;
            return this.groups.filter(function(group) {
                return group[0].toLowerCase().indexOf(textFilter.toLowerCase()) > -1;
            });
        }
    }
});
</script>
</body>
</html>