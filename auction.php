<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CHINCHILLAS-SHOW - Аукцион</title>
<?php
    include_once "components/import.html";
?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<link href="../css/no-page.css" rel="stylesheet">

<style type="text/css">

</style>
<script type="text/javascript">
</script>
</head>

<body>

<nav class="position-absolute teal lighten-2" style="top: 0; left: 0;">
    <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    <div class="container nav-wrapper">
        <p class="brand-logo">Аукцион</p>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="../"><i class="material-icons white-text left">arrow_back</i>Главная</a></li>
            <li><a href="../regist">Вход</a></li>
            <li><a href="../race">РАЭШ</a></li>
            <li><a href="../dna-base">Ген-база</a></li>
        </ul>
    </div>

    <ul class="sidenav" id="mobile-demo">
        <li><a href="../">Главная</a></li>
        <li><a href="../regist">Вход</a></li>
        <li><a href="../race">РАЭШ</a></li>
        <li><a href="../dna-base">Ген-база</a></li>
    </ul>
</nav>

<div class="stage">
    <div class="sun"></div>
    <div class="grass"></div>
    <div class="square"></div>
    <div class="round"></div>
</div>

<div class="container-fluid position-absolute" style="top: 0; height: 100vh; z-index: -1;">
    <div class="row justify-content-center align-items-center m-0" style="height: 100vh;">
        <div class="col-auto px-0">

            <div id="spinningTextG">
                <div id="spinningTextG_1" class="spinningTextG">4</div>
                <div id="spinningTextG_2" class="spinningTextG">0</div>
                <div id="spinningTextG_3" class="spinningTextG">4</div>
            </div>

        </div>
        <div class="col-sm-6 col-12 px-0">
            <h1 class="display-4 text-white mt-0" style="max-width: 100vw;">Данный раздел сайта находится в разработке</h1>
            <h2 class="lead text-white mb-0">Приносим извинения за неудобства</h2>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('.sidenav').sidenav();
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>