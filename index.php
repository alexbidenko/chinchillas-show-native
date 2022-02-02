<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CHINCHILLAS-SHOW - Главная</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<style type="text/css">
body {
    overflow: hidden;
}
@media all and (orientation:landscape) {
    .mains-block {
        height: 100%;
        display: inline;
        position: absolute;
        transform: skew(170deg);
        transition-property: transform box-shadow z-index;
        transition: .3s ease-in-out;
        overflow: hidden;
    }
    .section-img {
        display: block;
        width: 200%;
        height: 100%;
        transform: translate(-25%, 0) skew(-170deg);
        text-align: center;
        padding: 240px 0 100px 0;
        font-size: 52px;
        text-decoration: none;
        color: white;
        font-weight: 300;
        text-shadow: 2px 2px 4px black;
    }
    #first-section {
        left: -20%;
        width: 52%;
    }
    #first-section-img {
        background: blue/*url('../Datas/site/dna-base-img/WhatsApp Image 2019-01-14 at 21.32.26.jpeg') no-repeat center / cover*/;
        padding-left: 200px;
    }
    #second-section {
        left: 50%;
        width: 40%;
        transform: translate(-50%, 0) skew(170deg);
    }
    #second-section-img {
        background: yellow/*url('../Datas/site/dna-base-img/WhatsApp Image 2019-01-14 at 21.33.32.jpeg') no-repeat center / cover*/;
    }
    #therd-section {
        right: -20%;
        width: 52%;
    }
    #therd-section-img {
        background: green/*url('../Datas/site/dna-base-img/WhatsApp Image 2019-01-15 at 12.34.27.jpeg') no-repeat center / cover*/;
        padding-right: 200px;
    }
    .mains-block:hover {
        z-index: 1;
        transform: skew(170deg) scale(1.1);
        text-decoration: none;
        box-shadow: 0px 0px 20px 0px black;
    }
    #second-section:hover {
        transform: translate(-50%, 0) skew(170deg) scale(1.1);
    }
    .silent {
        background-color: #00000050;
        width: 100%;
        height: 100%;
        z-index: 5;
        top: 0;
        left: 0;
        position: absolute;
        transition-property: background-color;
        transition: .3s ease-in-out;
    }
    .mains-block:hover .silent {
        background-color: #00000000;
    }
}
@media all and (orientation:portrait) {
    .mains-block {
        height: 40vh;
        width: 100vw;
        position: absolute;
        transform: skew(0, 170deg);
        transition-property: transform box-shadow z-index;
        transition: .3s ease-in-out;
        overflow: hidden;
    }
    .section-img {
        display: block;
        width: 100%;
        height: 120%;
        margin: 0;
        transform: translate(0, -10%) skew(0, -170deg);
        text-align: center;
        font-size: 88px;
        text-decoration: none;
        color: white;
        font-weight: 300;
        text-shadow: 2px 2px 4px black;
        padding-top: 35%;
    }
    #first-section {
        top: -10vh;
    }
    #first-section-img {
        padding-top: 45%;
        background: blue/*url('../Datas/site/dna-base-img/WhatsApp Image 2019-01-14 at 21.32.26.jpeg') no-repeat center / cover*/;
    }
    #second-section {
        top: 28vh;
    }
    #second-section-img {
        padding-top: 40%;
        background: yellow/*url('../Datas/site/dna-base-img/WhatsApp Image 2019-01-14 at 21.33.32.jpeg') no-repeat center / cover*/;
    }
    #therd-section {
        top: 65vh;
    }
    #therd-section-img {
        padding-top: 35%;
        background: green/*url('../Datas/site/dna-base-img/WhatsApp Image 2019-01-15 at 12.34.27.jpeg') no-repeat center / cover*/;
    }
    .mains-block:hover {
        z-index: 1;
        transform: skew(0, 170deg) scale(1.1);
        text-decoration: none;
        box-shadow: 0px 0px 20px 0px black;
    }
    #second-section:hover {
        transform: skew(0, 170deg) scale(1.1);
    }
    .silent {
        background-color: #00000050;
        width: 100%;
        height: 100%;
        z-index: 5;
        top: 0;
        left: 0;
        position: absolute;
        transition-property: background-color;
        transition: .3s ease-in-out;
    }
    .mains-block:hover .silent {
        background-color: #00000000;
    }
}
</style>
</head>

<body>
<a class="mains-block" href="../race" id="first-section">
    <h1 class="section-img" id="first-section-img">РАЭШ</h1>
    <div class="silent"></div>
</a>
<a class="mains-block" href="../auction" id="second-section">
    <h1 class="section-img" id="second-section-img">Аукцион</h1>
    <div class="silent"></div>
</a>
<a class="mains-block" href="../dna-base" id="therd-section">
    <h1 class="section-img" id="therd-section-img">Ген-база</h1>
    <div class="silent"></div>
</a>
</body>
</html>