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
            <td>KVAL.<br />качество</td><td @click="kval=20">20</td><td @click="kval=19">19</td>
            <td @click="kval=18">18</td><td @click="kval=17">17</td><td @click="kval=16">16</td>
            <td @click="kval=14">14</td><td @click="kval=12">12</td><td @click="kval=10">10</td>
            <td @click="kval=8">8</td><td><input type="number" min="8" max="20" step="1" v-model="kval" @blur="kvalBlur">
            	<input id="kvalAdd" type="number" step="0.5" v-model="kvalAdd"></td>
        </tr>
        <tr>
            <td>KOPENHAGEN FUR</td><td colspan="2">Purple</td><td colspan="3">Platinum</td><td colspan="2">Burgundy</td><td colspan="3">Kval. II</td>
        </tr>
        <tr>
            <td>Silkethed<br />шелковистость</td><td colspan="2" @click="silkethed=1">1</td><td colspan="3" @click="silkethed=1">1</td>
            <td colspan="2"></td><td colspan="2"></td>
            <td><input type="number" min="0" max="1" step="1" v-model="silkethed" @blur="silkethedBlur">
            	<input id="silkethedAdd" type="number" step="0.5" v-model="silkethedAdd"></td>
        </tr>
        <tr>
            <td>RENHED.<br />чистота окраса</td><td @click="renhed=20">20</td><td @click="renhed=19">19</td>
            <td @click="renhed=18">18</td><td @click="renhed=17">17</td><td @click="renhed=16">16</td>
            <td @click="renhed=14">14</td><td @click="renhed=12">12</td><td @click="renhed=10">10</td>
            <td @click="renhed=8">8</td><td><input type="number" min="8" max="20" step="1" v-model="renhed" @blur="renhedBlur">
            	<input id="renhedAdd" type="number" step="0.5" v-model="renhedAdd"></td>
        </tr>
        <tr>
            <td>KOPENHAGEN FUR</td><td colspan="2">1<br />Blielig</td><td colspan="2">2<br />Grelig</td><td colspan="3">3<br />Brunlig</td><td colspan="3">4<br/>Brun</td>
        </tr>
        <tr>
            <td>FARVE.<br />окрас</td><td @click="farve=20">20</td><td @click="farve=19">19</td>
            <td @click="farve=18">18</td><td @click="farve=17">17</td><td @click="farve=16">16</td>
            <td @click="farve=14">14</td><td @click="farve=12">12</td><td @click="farve=10">10</td>
            <td @click="farve=8">8</td><td><input type="number" min="8" max="20" step="1" v-model="farve" @blur="farveBlur">
            	<input id="farveAdd" type="number" step="0.5" v-model="farveAdd"></td>
        </tr>
        <tr>
            <td colspan="3">XXX Dk</td><td colspan="2">XX Dk</td><td colspan="2">X Dk</td><td colspan="2">Dk</td><td>Med</td><td></td>
        </tr>
        <tr>
            <td>STШRR.<br />размер</td><td @click="stwrr=20">20</td><td @click="stwrr=19">19</td>
            <td @click="stwrr=18">18</td><td @click="stwrr=17">17</td><td @click="stwrr=16">16</td>
            <td @click="stwrr=14">14</td><td @click="stwrr=12">12</td><td @click="stwrr=10">10</td>
            <td @click="stwrr=8">8</td><td><input type="number" min="8" max="20" step="1" v-model="stwrr" @blur="stwrrBlur">
            	<input id="stwrrAdd" type="number" step="0.5" v-model="stwrrAdd"></td>
        </tr>
        <tr>
            <td>KOPENHAGEN FUR</td><td>40</td><td colspan="2">30</td><td colspan="2">00</td><td colspan="2">0</td><td colspan="3">1</td>
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
    var ChinForm = new Vue ({
        el: "#card-app",
        data: {
            kval: "",
            silkethed: "",
            renhed: "",
            farve: "",
            stwrr: "",
            
            kvalAdd: "",
            silkethedAdd: "",
            renhedAdd: "",
            farveAdd: "",
            stwrrAdd: ""
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
                            		if(result.ex == "<?php echo $_GET['expert']; ?>" && result.system == "81") {
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
                return Number(this.kval) + Number(this.silkethed) + Number(this.renhed) + 
                    Number(this.farve) + Number(this.stwrr);
            }
        },
        methods: {
            kvalBlur: function() {
                if (Number(this.kval) < 8 || Number(this.kval) > 20) this.kval = "";
            },
            silkethedBlur: function() {
                if (Number(this.silkethed) < 0 || Number(this.silkethed) > 1) this.silkethed = "";
            },
            renhedBlur: function() {
                if (Number(this.renhed) < 8 || Number(this.renhed) > 20) this.renhed = "";
            },
            farveBlur: function() {
                if (Number(this.farve) < 8 || Number(this.farve) > 20) this.farve = "";
            },
            stwrrBlur: function() {
                if (Number(this.stwrr) < 8 || Number(this.stwrr) > 20) this.stwrr = "";
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
		                        Chins.registedChins[i].result[ex].system = "81";
		                        Chins.registedChins[i].result[ex].data = ChinForm.$data;
                    		}
                    		bool = true;
                    	}
                    }
                    if(!bool) {
                    	Chins.registedChins[i].result.push({
                    		ex: "<?= $_GET['expert']; ?>",
                    		system: "81",
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