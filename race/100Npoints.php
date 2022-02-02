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
table {
    border-collapse: collapse;
}
td, th {
    padding: 1px 3px;
    border: 1px solid black;
    text-align: center;
    font-size: 16px;
}
input {
    border: 0;
    width: 40%;
    text-align: center;
    display: inline-block;
}
p {
    display: inline-block;
}

/* The snackbar - position it at the bottom and in the middle of the screen */
#snackbar {
  visibility: hidden; /* Hidden by default. Visible on click */
  min-width: 250px; /* Set a default minimum width */
  margin-left: -125px; /* Divide value of min-width by 2 */
  background-color: #333; /* Black background color */
  color: #fff; /* White text color */
  text-align: center; /* Centered text */
  border-radius: 2px; /* Rounded borders */
  padding: 16px; /* Padding */
  position: fixed; /* Sit on top of the screen */
  z-index: 1; /* Add a z-index if needed */
  left: 50%; /* Center the snackbar */
  bottom: 30px; /* 30px from the bottom */
  font-size: 16px;
}

/* Show the snackbar when clicking on a button (class added with JavaScript) */
#snackbar.show {
  visibility: visible; /* Show the snackbar */
  /* Add animation: Take 0.5 seconds to fade in and out the snackbar. 
  However, delay the fade out process for 2.5 seconds */
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

/* Animations to fade the snackbar in and out */

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}

input[type=number] {
	width: 40px!important;
	display: inline;
}
</style>
<?php if($_GET['type'] == 'print') { ?>
<style type="text/css">
body {
    max-width: 100%;
    padding: 100px 200px 0 10px;
}
#card-app {
    transform: scale(1);
}
input, textarea {
    border: 0!important;
}
</style>
<?php } ?>
</head>

<body>
<div id="card-app">

    <table class="w-100">
	<?php if($_GET['type'] == 'print') { ?>
        <thead>
            <tr>
                <td colspan="3">Judging card for chinchilla<br />Predigree class<br />КАРТОЧКА ЭКСПЕРТНОЙ ОЦЕНКИ ШИНШИЛЛЫ</td>
            </tr>
            <tr>
                <td>Date of the exhibition/Дата проведения выставки:<br /><b>6 апреля 2019</b></td>
                <td>Location/Место проведения:<br /><b>г.Москва: "ЗооПалитра"</b></td>
                <td>Number in show/Номер на выставке:<br /><b><?= $_GET['index'] ?></b></td>
            </tr>
            <tr>
                <td>Colour/Окрас<br /><b id="data-color"></b></td>
                <td>Age/Возраст<br /><b id="data-age"></b></td>
                <td>Owner/Владелец<br /><b id="data-owner"></b></td>
            </tr>
        </thead>
    <?php } ?>
        <tbody>
            <tr>
                <td class="text-left">Quallity/Качество меха</td>
                <td style="font-size: 0;">
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="quality=10">10</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="quality=12">12</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="quality=14">14</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="quality=16">16</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="quality=17">17</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="quality=18">18</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="quality=19">19</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="quality=20">20</button>
                </td>
                <td><input id="quality" type="number" min="10" max="20" step="1" v-model="quality" @blur="qualityBlur">
                <input id="qualityAdd" type="number" step="0.5" v-model="qualityAdd"></td>
            </tr>
            <tr>
                <td class="text-left">Size/Размер</td>
                <td style="font-size: 0;">
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="size=10">10</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="size=12">12</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="size=14">14</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="size=16">16</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="size=17">17</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="size=18">18</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="size=19">19</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="size=20">20</button>
                </td>
                <td><input id="size" type="number" min="10" max="20" step="1" v-model="size" @blur="sizeBlur">
                <input id="sizeAdd" type="number" step="0.5" v-model="sizeAdd"></td>
            </tr>
            <tr>
                <td class="text-left">Body shape/Форма тела</td>
                <td style="font-size: 0;">
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="shape=1">1</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="shape=2">2</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="shape=3">3</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="shape=4">4</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="shape=5">5</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="shape=6">6</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="shape=7">7</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="shape=8">8</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="shape=9">9</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="shape=10">10</button>
                </td>
                <td><input id="shape" type="number" min="1" max="10" step="1" v-model="shape" @blur="shapeBlur">
                <input id="shapeAdd" type="number" step="0.5" v-model="shapeAdd"></td>
            </tr>
            <tr>
                <td class="text-left">Head/Голова</td>
                <td style="font-size: 0;">
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="head=1">1</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="head=2">2</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="head=3">3</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="head=4">4</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="head=5">5</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="head=6">6</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="head=7">7</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="head=8">8</button>
                </td>
                <td><input id="head" type="number" min="1" max="8" step="1" v-model="head" @blur="headBlur">
                <input id="headAdd" type="number" step="0.5" v-model="headAdd"></td>
            </tr>
            <tr>
                <td class="text-left">Colour/Patarn/Окрас</td>
                <td style="font-size: 0;">
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="color=10">10</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="color=12">12</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="color=14">14</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="color=16">16</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="color=17">17</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="color=18">18</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="color=19">19</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="color=20">20</button>
                </td>
                <td><input id="color" type="number" min="10" max="20" step="1" v-model="color" @blur="colorBlur">
                <input id="colorAdd" type="number" step="0.5" v-model="colorAdd"></td>
            </tr>
            <tr>
                <td class="text-left">Clearlines/Чистота окраса</td>
                <td style="font-size: 0;">
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="clearlines=8">8</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="clearlines=10">10</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="clearlines=12">12</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="clearlines=14">14</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="clearlines=16">16</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="clearlines=17">17</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="clearlines=18">18</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="clearlines=19">19</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="clearlines=20">20</button>
                </td>
                <td><input id="clearlines" type="number" min="10" max="20" step="1" v-model="clearlines" @blur="clearlinesBlur">
                <input id="clearlinesAdd" type="number" step="0.5" v-model="clearlinesAdd"></td>
            </tr>
            <tr>
                <td class="text-left">(Colour tone)</td>
                <td style="font-size: 0;">
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="tone='Brown'">Brown</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="tone='Yellow'">Yellow</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="tone='Gray'">Gray</button>
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="tone='Blue'">Blue</button>
                </td>
                <td><input id="tone" type="text" min="0" max="3" step="1" v-model="tone"></td>
            </tr>
            <tr>
                <td class="text-left">Silkines/Шелковистость</td>
                <td style="font-size: 0;">
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="silkines=1">1</button>
                </td>
                <td><input id="silkines" type="number" min="0" max="1" v-model="silkines" @blur="silkinesBlur">
                <input id="silkinesAdd" type="number" step="0.5" v-model="silkinesAdd"></td>
            </tr>
            <tr>
                <td class="text-left">Belly (White/ Ebony allovercovering)/Живот</td>
                <td style="font-size: 0;">
                    <button type="button" class="btn-flat m-0 px-1 d-inline-block" @click="belly=1">1</button>
                </td>
                <td><input id="belly" type="number" min="0" max="1" v-model="belly" @blur="bellyBlur">
                <input id="bellyAdd" type="number" step="0.5" v-model="bellyAdd"></td>
            </tr>
            <tr>
                <td class="text-left">итого/total</td>
                <td>
                    <p>100</p>
                </td>
                <td><p>{{total}}</p></td>
            </tr>
            <tr>
                <td colspan="2" class="text-left">Comments/Комментарий:
                    <div class="input-field m-0">
                        <textarea id="comments" class="materialize-textarea m-0" v-model="comments"></textarea>
                    </div>
                </td>
                <td>Place/Место: <span id="place"></span></td>
            </tr>
        </tbody>
    </table>

	<?php if($_GET['type'] == 'print') { ?>
    <div class="container-fluid">
        <div class="row my-5">
            <div class="col-4">
                <p class="d-block mb-1">Gold(Certificate)</p>
                <p class="d-block mb-1">82-75</p>
                <p class="d-block mb-1" :class="{'border': (total >= 87.5)}">100-88</p>
            </div>
            <div class="col-3">
                <p class="d-block mb-1">Silver</p>
                <p class="d-block mb-1">74-67</p>
                <p class="d-block mb-1" :class="{'border': (total < 87.5 && total >= 76.5)}">87-76</p>
            </div>
            <div class="col-3">
                <p class="d-block mb-1">Bronze</p>
                <p class="d-block mb-1">66-60</p>
                <p class="d-block mb-1" :class="{'border': (total < 76.5 && total >= 59.5)}">75-60</p>
            </div>
        </div>
    </div>

    <p>Judger/Судья: <img src="../Datas/site/podpis_wolder.jpg" style="display: inline-block;
        margin: 0 80px; width: 140px; height: 80px;"> Rebecka Wolder.</p>
    <?php } ?>

	<?php if(!isset($_GET['type']) && RightsCheck($user, ['a11', 'e5'])) { ?>
    <button type="button" class="btn btn-success btn-block" @click="SaveAll">Сохранить</button>

    <div id="snackbar">Сохранено</div>
    <?php } ?>

</div>

</body>
<script type="text/javascript">
    var Chins = {};
    
    var LoadData = (chin_data, chin) => {
        let date = new Date(chin.birthday);
        let one_month = Number((6 > date.getDate())?"0":"1");
        let one_year;
        if(4 > (date.getMonth() + 1)) {
            one_year = 0;
        } else {
            one_year = 1;
            one_month -= 12;
        }
    	$('#data-age').text((2019 - date.getFullYear() - one_year) + "/" + (4 - (date.getMonth() + 1) - one_month));
    	
    	
        let colors = chin.colors;
        $('#data-color').text(fullChinColor(colors.standart, colors.white, colors.mosaic, colors.beige, 
            colors.violet, colors.sapphire, colors.angora, colors.ebony, colors.velvet, 
            colors.pearl, colors.california, colors.rex, colors.lova, colors.german, 
            colors.blue, colors.fur));
            
    	$('#data-owner').text((!!chin_data.farm) ? chin_data.farm : (chin_data.last_name + " " + chin_data.first_name));
    }

    var ChinForm = new Vue ({
        el: "#card-app",
        data: {
            quality: "",
            size: "",
            shape: "",
            head: "",
            color: "",
            clearlines: "",
            tone: "",
            silkines: "",
            belly: "",
            
            qualityAdd: "",
            sizeAdd: "",
            shapeAdd: "",
            headAdd: "",
            colorAdd: "",
            clearlinesAdd: "",
            silkinesAdd: "",
            bellyAdd: "",

            comments: ""
        },
        created() {
            $.ajax({
                url: '../php/get_regist_to_show.php',
                type: 'POST',
                data: {first_name: "<?php echo $_GET['first_name']; ?>", 
                       last_name: "<?php echo $_GET['last_name']; ?>"},
                success: function(data) {
                    Chins = JSON.parse(data);

                    Chins.registedChins = JSON.parse(Chins.registedChins.replace(new RegExp('u0','g'),'\\u0'));

                    for (let i in Chins.registedChins) {
                        if (Chins.registedChins[i].name_chin == "<?php echo $_GET['name_chin']; ?>" && 
                                Chins.registedChins[i].birthday == "<?php echo $_GET['birthday']; ?>") {
                            console.log(Chins.registedChins[i]);
                            
                    		LoadData(Chins, Chins.registedChins[i]);

                            if(!!Chins.registedChins[i].result) {
                            	for(let result of Chins.registedChins[i].result) {
                            		if(result.ex == "<?php echo $_GET['expert']; ?>" && result.system == "100N") {
		                                for (let type in ChinForm.$data) {
		                                    let val = result.data[type];
		                                    ChinForm.$data[type] = val;
                                        }
                                        if(!!result.place) {
                                            $('#place').text(result.place);
                                            /*let cash = result.place.split(",")[0];
                                            let bool = true;
                                            for(let k of cash) {
                                                if(!isNaN(k) && k != " " && bool) {
                                                    bool = false;
                                                    $('#place').text(k);
                                                }
                                            }*/
                                        }
                            		}
                            	}
                            }
                            $('#tone').val(ChinForm.tone);
                            $('#comments').val(ChinForm.comments);
                            M.textareaAutoResize($('#comments'));
                        }
                    }
                }
            });
        },
        computed: {
            total: function() {
                return Number(this.quality) + Number(this.size) + Number(this.shape) + Number(this.head) + Number(this.color) + Number(this.clearlines) +
                    Number(this.silkines) + Number(this.belly) + 
                    Number(this.qualityAdd) + Number(this.sizeAdd) + Number(this.shapeAdd) + Number(this.headAdd) + Number(this.colorAdd) +
                    Number(this.clearlinesAdd) + Number(this.silkinesAdd) + Number(this.bellyAdd);
            }
        },
        methods: {
            qualityBlur: function() {
                let arr = [10,12,14,16,17,18,19,20];
                if (arr.indexOf(Number(this.quality)) == -1) this.quality = "";
            },
            sizeBlur: function() {
                let arr = [10,12,14,16,17,18,19,20];
                if (arr.indexOf(Number(this.size)) == -1) this.size = "";
            },
            shapeBlur: function() {
                let arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
                if (arr.indexOf(Number(this.shape)) == -1) this.shape = "";
            },
            headBlur: function() {
                let arr = [1, 2, 3, 4, 5, 6, 7, 8];
                if (arr.indexOf(Number(this.head)) == -1) this.head = "";
            },
            colorBlur: function() {
                let arr = [10,12,14,16,17,18,19,20];
                if (arr.indexOf(Number(this.color)) == -1) this.color = "";
            },
            clearlinesBlur: function() {
                let arr = [8, 10,12,14,16,17,18,19,20];
                if (arr.indexOf(Number(this.clearlines)) == -1) this.clearlines = "";
            },
            silkinesBlur: function() {
                let arr = [0, 1];
                if (arr.indexOf(Number(this.silkines)) == -1) this.silkines = "";
            },
            bellyBlur: function() {
                let arr = [0, 1];
                if (arr.indexOf(Number(this.belly)) == -1) this.belly = "";
            },

            SaveAll: function() {
            	SaveAll();
            }
        }
    });
    
	<?php if(!isset($_GET['type']) && RightsCheck($user, ['a11', 'e5'])) { ?>
    var SaveAll = () => {
        for (let i in Chins.registedChins) {
            if (Chins.registedChins[i].name_chin == "<?php echo $_GET['name_chin']; ?>" && 
                    Chins.registedChins[i].birthday == "<?php echo $_GET['birthday']; ?>") {
                    	
                if(!Chins.registedChins[i].result) {
                	Chins.registedChins[i].result = [];
                }
                    	
                if(!!Chins.registedChins[i].result) {
                	let bool = false;
                    for (let ex in Chins.registedChins[i].result) {
                    	if(Chins.registedChins[i].result[ex].ex == "<?= $_GET['expert']; ?>") {
                    		for(let type in ChinForm.$data) {
		                        Chins.registedChins[i].result[ex].system = "100N";
		                        Chins.registedChins[i].result[ex].data = ChinForm.$data;
                    		}
                    		bool = true;
                    	}
                    }
                    if(!bool) {
                    	Chins.registedChins[i].result.push({
                    		ex: "<?= $_GET['expert']; ?>",
                    		system: "100N",
                            data: ChinForm.$data,
                            place: ""
                    	});
                    }
                }
            }
        }
        
        let dataC = JSON.stringify(Chins);

        $.ajax({
            url: '../php/regist_to_show.php',
            type: 'POST',
            data: {comand: "updata", len: dataC.length, data: dataC},
            success: function(data) {
            	if(data == "well") {
	                var x = document.getElementById("snackbar");
	
	                // Add the "show" class to DIV
	                x.className = "show";
	
	                // After 3 seconds, remove the show class from DIV
	                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 1500);
            	} else {
            		SaveAll();
            	}
            }
        });
    }
    <?php } ?>
</script>
</html>