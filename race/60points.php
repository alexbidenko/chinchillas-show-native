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
    font-size: 16px;
}
input {
    border: 0;
    text-align: center;
    width: 60px;
}
.yellow {
    background-color: yellow;
}
</style>
</head>

<body>
    
<div id="card-app">
    <table>
        <thead>
            <tr>
                <th>Beschreibung</th><th><i>English</i></th><th colspan="7">Chinchilla Bewrtung EPVC</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Номер шиншиллы на выставке</td><td><i>Chinchilla number</i></td><td colspan="7"><strong>Tier-Number:</strong></td>
            </tr>
            <tr>
                <td>Чистота окраса</td><td><i>Color clarity</i></td><td><strong>Klarheit</strong></td><td @click="color=12"><strong>12</strong></td>
                <td @click="color=11"><strong>11</strong></td><td @click="color=10"><strong>10</strong></td>
                <td @click="color=8"><strong>8</strong></td><td @click="color=6"><strong>6</strong></td>
                <td><strong><input type="number" v-model="color"></strong></td>
            </tr>
            <tr>
                <td>Шелковистость</td><td><i>Veiling coverage</i></td><td><strong>Farbschleier</strong></td><td @click="veiling=10"><strong>10</strong></td>
                <td @click="veiling=9"><strong>9</strong></td><td @click="veiling=8"><strong>8</strong></td><td @click="veiling=6"><strong>6</strong></td>
                <td @click="veiling=4"><strong>4</strong></td><td><strong><input type="number" v-model="veiling"></strong></td>
            </tr>
            <tr>
                <td>Розетка</td><td><i>Bar</i></td><td colspan="4"><strong>Band</strong></td><td @click="bar=-1"><strong>-1</strong></td>
                <td @click="bar=-2"><strong>-2</strong></td><td><strong><input type="number" v-model="bar"></strong></td>
            </tr>
            <tr>
                <td>Размер тела</td><td><i>Size</i></td><td><strong>Größe</strong></td><td @click="size=6"><strong>6</strong></td>
                <td @click="size=5"><strong>5</strong></td><td @click="size=4"><strong>4</strong></td><td @click="size=3"><strong>3</strong></td>
                <td @click="size=2"><strong>2</strong></td><td><strong><input type="number" v-model="size"></strong></td>
            </tr>
            <tr>
                <td>Форма тела</td><td><i>Shape</i></td><td><strong>Körperform</strong></td><td @click="shape=6"><strong>6</strong></td>
                <td @click="shape=5"><strong>5</strong></td><td @click="shape=4"><strong>4</strong></td><td @click="shape=3"><strong>3</strong></td>
                <td @click="shape=2"><strong>2</strong></td><td><strong><input type="number" v-model="shape"></strong></td>
            </tr>
            <tr>
                <td>Текстура меха</td><td><i>Texture</i></td><td><strong>Textur</strong></td><td @click="texture=6"><strong>6</strong></td>
                <td @click="texture=5"><strong>5</strong></td><td @click="texture=4"><strong>4</strong></td><td @click="texture=3"><strong>3</strong></td>
                <td @click="texture=2"><strong>2</strong></td><td><strong><input type="number" v-model="texture"></strong></td>
            </tr>
            <tr>
                <td>Плотность меха</td><td><i>Density</i></td><td><strong>Dichte</strong></td><td @click="density=6"><strong>6</strong></td>
                <td @click="density=5"><strong>5</strong></td><td @click="density=4"><strong>4</strong></td><td @click="density=3"><strong>3</strong></td>
                <td @click="density=2"><strong>2</strong></td><td><strong><input type="number" v-model="density"></strong></td>
            </tr>
            <tr>
                <td>Окрас живота</td><td><i>Belly</i></td><td colspan="2"><strong>Wamme</strong></td><td @click="belly=4"><strong>4</strong></td>
                <td @click="belly=3"><strong>3</strong></td><td @click="belly=2"><strong>2</strong></td><td @click="belly=1"><strong>1</strong></td>
                <td><strong><input type="number" v-model="belly"></strong></td>
            </tr>
            <tr>
                <td>Сумма очков "Стандарта"</td><td><i>Sum of 50 Points</i></td><td colspan="5"><strong>Gesamt von 50 Punkten:</strong></td>
                <td colspan="2"><strong>{{total}}</strong></td>
            </tr>
            <tr class="yellow">
                <td>Дополнительно: классификация по цвету</td><td><i>Color group</i></td><td><strong>Farbklasse</strong></td><td @click="colorGroup=10"><strong>10</strong></td>
                <td @click="colorGroup=9"><strong>9</strong></td><td @click="colorGroup=6"><strong>6</strong></td><td @click="colorGroup=4"><strong>4</strong></td>
                <td @click="colorGroup=2"><strong>2</strong></td><td><strong><input type="number" class="yellow" v-model="colorGroup"></strong></td>
            </tr>
            <tr class="yellow">
                <td>Всего очков: классификация по окрасу</td><td><i>Sum of 60 points:</i></td><td colspan="5"><strong>Gesamt von 60 Punkten:</strong></td>
                <td colspan="2"><strong>{{totalColor}}</strong></td>
            </tr>
        </tbody>
    </table>
</div>

</body>
<script type="text/javascript">
const blurFun = (arr, elem) => {
    if (arr.indexOf(elem) == -1) alert(elem);
}
    var ChinForm = new Vue ({
        el: "#card-app",
        data: {
            color: "",
            veiling: "",
            bar: "",
            size: "",
            shape: "",
            texture: "",
            density: "",
            belly: "",
            colorGroup: ""
        },
        computed: {
            total: function() {
                return Number(this.color) + Number(this.veiling) + Number(this.bar) + Number(this.size) + Number(this.shape) +
                        Number(this.texture) + Number(this.density) + Number(this.belly);
            },
            totalColor: function() {
                return Number(this.color) + Number(this.veiling) + Number(this.bar) + Number(this.size) + Number(this.shape) +
                        Number(this.texture) + Number(this.density) + Number(this.belly) + Number(this.colorGroup);
            },
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
            }
        }
    });
</script>
</html>