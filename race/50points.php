<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Купить шиншилл</title>
<?php
    include_once "../components/import.html";
?>

<style type="text/css">
table {
    border-collapse: collapse; /* Убираем двойные линии между ячейками */
}
td, th {
    padding: 3px;
    border: 1px solid black;
    text-align: center;
    font-size: 16px;
}
input {
    border: 0;
    text-align: center;
}
p {
    display: inline-block;
}
.gold {
    background-color: gold;
}
.silver {
    background-color: silver;
}
.bronze {
    background-color: #cd7f32;
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
</head>

<body>
    
<div id="card-app">
    <!--h1><?php echo ((int)$_GET['chin'] + 1); ?></h1-->
    <table>
        <tr>
            <td colspan="2" rowspan="2">Размер/Size</td><td colspan="2">Малый/small</td><td colspan="2">Средний/medium</td><td colspan="4">Большой/grand</td>
            <td rowspan="2"><input type="number" min="5" max="10" step="1" v-model="size" @blur="sizeBlur">
            	<input id="sizeAdd" type="number" step="0.5" v-model="sizeAdd"></td>
        </tr>
        <tr>
            <td @click="size=5">5</td><td @click="size=6">6</td><td @click="size=7">7</td><td @click="size=8">8</td>
            <td colspan="2" @click="size=9">9</td><td colspan="2" @click="size=10">10</td>
        </tr>
        <tr>
            <td rowspan="2">Окрас/Color</td><td rowspan="2">Стандарт/насыщенность</td><td colspan="2">Светлый/Light</td><td colspan="2">Средний/medium</td>
            <td colspan="2">Темный/Dark</td><td colspan="2">Экстра темный/Extra dark</td>
            <td rowspan="2"><input type="number" min="5" max="10" step="1" v-model="color" @blur="colorBlur">
            	<input id="colorAdd" type="number" step="0.5" v-model="colorAdd"></td>
        </tr>
        <tr>
            <td @click="color=3">3</td><td @click="color=4">4</td><td @click="color=5">5</td><td @click="color=6">6</td>
            <td @click="color=7">7</td><td @click="color=8">8</td><td @click="color=9">9</td><td @click="color=10">10</td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2">Чистота окраса/Clarity color</td><td colspan="2">Коричневый/Brown</td><td colspan="2">Бурый/красный/fulvous/red</td>
            <td colspan="2">Серый/желтый/Gray/yellow</td><td colspan="2">Голубой/Blue</td>
            <td rowspan="2"><input type="number" min="5" max="10" step="1" v-model="clarity" @blur="clarityBlur">
            	<input id="clarityAdd" type="number" step="0.5" v-model="clarityAdd"></td>
        </tr>
        <tr>
            <td @click="clarity=3">3</td><td @click="clarity=4">4</td><td @click="clarity=5">5</td><td @click="clarity=6">6</td>
            <td @click="clarity=7">7</td><td @click="clarity=8">8</td><td @click="clarity=9">9</td><td @click="clarity=10">10</td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2">Живот/Belly</td><td colspan="2">Кант/Edging</td><td colspan="2">Серый/Gray</td>
            <td colspan="2">Желтый/Yellow</td><td colspan="2">Белый/White</td>
            <td rowspan="2"><input type="number" min="5" max="10" step="1" v-model="belly" @blur="bellyBlur">
            	<input id="bellyAdd" type="number" step="0.5" v-model="bellyAdd"></td>
        </tr>
        <tr>
            <td colspan="2" @click="belly=0">0</td><td colspan="2" @click="belly=1">1</td><td colspan="2" @click="belly=2">2</td>
            <td colspan="2" @click="belly=3">3</td>
        </tr>
        <tr>
            <td colspan="2">Шелковистость/Silken</td><td colspan="2" @click="silken=0">0</td><td colspan="3" @click="silken=1">1</td>
            <td colspan="3" @click="silken=2">2</td><td><input type="number" min="5" max="10" step="1" v-model="silken" @blur="silkenBlur">
            	<input id="stwrrAdd" type="number" step="0.5" v-model="stwrrAdd"></td>
        </tr>
        <tr>
            <td rowspan="3">Мех/Fur</td><td colspan="4">Уравненность/Equalized</td><td @click="equalized=1">1</td><td @click="equalized=2">2</td>
            <td @click="equalized=3">3</td><td @click="equalized=4">4</td><td @click="equalized=5">5</td>
            <td rowspan="3">{{equalized + elastic + density}}
            	<input id="eedAdd" type="number" step="0.5" v-model="eedAdd"></td>
        </tr>
        <tr>
            <td colspan="4">Упругость/Elastic</td><td @click="elastic=1">1</td><td @click="elastic=2">2</td>
            <td @click="elastic=3">3</td><td @click="elastic=4">4</td><td @click="elastic=5">5</td>
        </tr>
        <tr>
            <td colspan="4">Густота/Density</td><td @click="density=1">1</td><td @click="density=2">2</td>
            <td @click="density=3">3</td><td @click="density=4">4</td><td @click="density=5">5</td>
        </tr>
        <tr>
            <td rowspan="2">Пороки/Defects</td><td colspan="3">Мех/Fur</td><td colspan="2" @click="furDefect=-1">-1</td>
            <td colspan="2" @click="furDefect=-2">-2</td><td colspan="2" @click="furDefect=-3">-3</td>
            <td rowspan="2">{{furDefect + colorDefect}}
            	<input id="fdcdAdd" type="number" step="0.5" v-model="fdcdAdd"></td>
        </tr>
        <tr>
            <td colspan="3">Окрас/Color</td><td colspan="2" @click="colorDefect=-1">-1</td><td colspan="2" @click="colorDefect=-2">-2</td>
            <td colspan="2" @click="colorDefect=-3">-3</td>
        </tr>
    </table>
    
    <table>
        <tr>
            <td :class="{'gold': (total >= 43)}">43-50</td><td :class="{'silver': (total < 43 && total >= 36)}">36-42</td><td :class="{'bronze': (total < 36 && total >= 32)}">35-32</td>
        </tr>
        <tr>
            <td :class="{'gold': (total >= 43)}">gold</td><td :class="{'silver': (total < 43 && total >= 36)}">silver</td><td :class="{'bronze': (total < 36 && total >= 32)}">bronze</td>
        </tr>
    </table>
    
    <table>
        <tr>
            <td>Итого баллов/Total points</td><td>{{total}}</td>
        </tr>
    </table>

    <button type="button" class="btn btn-success btn-block" @click="SaveAll">Сохранить</button>

    <div id="snackbar">Сохранено</div>

</div>

</body>
<script type="text/javascript">
    var Chins = {};

    var ChinForm = new Vue ({
        el: "#card-app",
        data: {
            size: "",
            color: "",
            clarity: "",
            belly: "",
            silken: "",
            equalized: 0,
            elastic: 0,
            density: 0,
            furDefect: 0,
            colorDefect: 0,
            
            sizeAdd: "",
            colorAdd: "",
            clarityAdd: "",
            bellyAdd: "",
            silkenAdd: "",
            eedAdd: "",
            fdcdAdd: "",
        },
        created() {
            $.ajax({
                url: '../php/get_regist_to_show.php',
                type: 'POST',
                data: {first_name: "<?php echo $_GET['first_name']; ?>", 
                       last_name: "<?php echo $_GET['last_name']; ?>"},
                success: function(data) {
                    Chins = JSON.parse(data);

                    Chins.registedChins = JSON.parse(Chins.registedChins);

                    for (let i in Chins.registedChins) {
                        if (Chins.registedChins[i].name_chin == "<?php echo $_GET['name_chin']; ?>" && 
                                Chins.registedChins[i].birthday == "<?php echo $_GET['birthday']; ?>") {
                            console.log(Chins.registedChins[i]);
                            if(!!Chins.registedChins[i].result) {
                            	for(let result of Chins.registedChins[i].result) {
                            		if(result.ex == "<?php echo $_GET['expert']; ?>" && result.system == "50") {
		                                for (let type in ChinForm.$data) {
		                                    let val = result.data[type];
		                                    if(!isNaN(val) && !(typeof val == 'undefined')) {
		                                        ChinForm.$data[type] = val;
		                                    }
		                                }
                            		}
                            	}
                            }
                        }
                    }
                }
            });
        },
        computed: {
            total: function() {
                return Number(this.size) + Number(this.color) + Number(this.clarity) + Number(this.belly) + Number(this.silken) +
                        this.equalized + this.elastic + this.density + this.furDefect + this.colorDefect;
            }
        },
        methods: {
            sizeBlur: function() {
                if (Number(this.size) < 5 || Number(this.size) > 10) this.size = "";
            },
            colorBlur: function() {
                if (Number(this.size) < 3 || Number(this.size) > 10) this.color = "";
            },
            clarityBlur: function() {
                if (Number(this.size) < 3 || Number(this.size) > 10) this.clarity = "";
            },
            bellyBlur: function() {
                if (Number(this.size) < 0 || Number(this.size) > 3) this.belly = "";
            },
            silkenBlur: function() {
                if (Number(this.size) < 0 || Number(this.size) > 2) this.silken = "";
            },

            SaveAll: function() {
                SaveAll();
            }
        }
    });
    
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
		                        Chins.registedChins[i].result[ex].system = "50";
		                        Chins.registedChins[i].result[ex].data = ChinForm.$data;
                    		}
                    		bool = true;
                    	}
                    }
                    if(!bool) {
                    	Chins.registedChins[i].result.push({
                    		ex: "<?= $_GET['expert']; ?>",
                    		system: "50",
                    		data: ChinForm.$data
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
</script>
</html>