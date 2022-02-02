<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CHINCHILLAS-SHOW - РАЭШ</title>
<?php
    include_once "../components/import.html";
    include_once "../components/php-funs.php";
    
    $mysqli = BaseConect();

    $result = $mysqli->query("SELECT * FROM super_chin_all_shows");

    $last_show_data = $result->fetch_assoc();

    $user = CheckUser($mysqli);
?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<style type="text/css">
body {
  background: linear-gradient(to right, #ffffff, #9fa8da);
}
nav a:hover {
  color: white;
}
a:hover {
  text-decoration: none;
}
</style>
</head>

<body>
	
<div id="RaceApp">

<div class="parallax-container">
    <div class="parallax"><img src="../Datas/site/dna-base-img/BackgroundTopNew.JPG"></div>
</div>

<nav class="position-absolute teal lighten-2" style="top: 0; left: 0;">
    <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    <div class="container nav-wrapper">
        <p class="brand-logo">{{t[lang].race}}</p>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="../"><i class="material-icons white-text left">arrow_back</i>{{t[lang].to_main}}</a></li>
            <?php if(!$user) {
                echo '<li><a href="../regist">{{t[lang].to_regist}}</a></li>';
            } else { 
                echo '<li><a href="../php/exit.php">Выход</a></li>';
            } ?>
            <li><a href="../dna-base">{{t[lang].to_dna}}</a></li>
            <?php if(RightsCheck($user, ['a11', 'e5'])) {
                echo '<li><a href="expert-app">{{t[lang].to_expert}}</a></li>';
                echo '<li><a href="regist-table">{{t[lang].to_table}}</a></li>';
            } ?>
            <?php if(RightsCheck($user, ['a11'])) {
                echo '<li><a href="print">Печать</a></li>';
            } ?>
        </ul>
    </div>

    <ul class="sidenav" id="mobile-demo">
        <li><a href="../">{{t[lang].to_main}}</a></li>
        <?php if(!$user) {
            echo '<li><a href="../regist">{{t[lang].to_regist}}</a></li>';
        } else { 
            echo '<li><a href="../php/exit.php">Выход</a></li>';
        } ?>
        <li><a href="../dna-base">{{t[lang].to_dna}}</a></li>
        <?php if(RightsCheck($user, ['a11', 'e5'])) {
            echo '<li><a href="expert-app">{{t[lang].to_expert}}</a></li>';
            echo '<li><a href="regist-table">{{t[lang].to_table}}</a></li>';
        } ?>
        <?php if(RightsCheck($user, ['a11'])) {
            echo '<li><a href="print">Печать</a></li>';
        } ?>
    </ul>
</nav>

<div class="container p-0" style="margin-top: -80px;">

    <div class="shadow jumbotron row">
    	<?php if($_GET['result'] == 'success') { ?>
    	<div class="alert alert-success w-100">{{t[lang].complete_regist}}</div>
    	<?php } ?>
        <div class="col-12 col-md-6">
            <h3>{{t[lang].title}}</h3>
            <p class="lead">АНОНС</p>
            <p class="lead">Зоошоу «Зверёк на ладошке» 6 апреля 2019г.</p>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <img class="img-fluid" src="../Datas/site/race-img/race_show_image.jpg">
        </div>
        <div class="row">
            <a class="btn btn-primary btn-lg mr-3 d-none" href="../race/show-regist" role="button">
            	{{t[lang].to_show_regist[0]}}
            	<span class="d-none d-md-inline">{{t[lang].to_show_regist[1]}}</span>
            </a>
          
            <button class="btn-flat waves-effect waves-light" type="button" data-toggle="collapse" data-target="#mode-info" aria-expanded="false">
                {{t[lang].learn_more}}
            </button>
        </div>

        <div class="collapse" id="mode-info">
            <hr />

            <p class="lead" style="white-space: pre-wrap;">
{{t[lang].show_ad_text[0]}}
<a href="http://zverek.ru/sponsors.php"> http://zverek.ru/sponsors.php</a>
{{t[lang].show_ad_text[1]}}
<a href="mailto: zverek-na-ladoshke2016@mail.ru">zverek-na-ladoshke2016@mail.ru</a>
{{t[lang].show_ad_text[2]}}<a href="http://zverek.ru/participant/anonce">http://zverek.ru/participant/anonce</a> 
{{t[lang].show_ad_text[3]}}
            </p>
        </div>
    </div>

</div>

</div>

<script type="text/javascript">
$(document).ready(function(){
    $('.parallax').parallax();
});
$(document).ready(function(){
    $('.sidenav').sidenav();
});

var RaceApp = new Vue({
	el: "#RaceApp",
	data: {
		t: {
			ru: {
				race: "РАЭШ",
				to_main: "Главная",
				to_regist: "Вход",
				to_dna: "Ген-база",
				to_table: "Таблица",
				to_expert: "Экспертиза",
				complete_regist: "Заявка на выставку успешно принята.",
				title: "<?php echo $last_show_data['title']; ?>",
				to_show_regist: ["Зарегистрироваться ", "на выставку"],
				learn_more: "Узнать больше",
				show_ad_text: [`УВАЖАЕМЫЕ ЗАВОДЧИКИ ШИНШИЛЛ !!! 

Приглашаем Вас принять участие в очередной международной выставке в рамках выставки "ЗООПАЛИТРА" 6 апреля 2019 г.

Экспертиза шиншилл будет проводиться с некоторыми изменениями. Участникам будет представлен выбор в прохождении оценки, а именно: 
1. Участие только в Российской оценке 
2. Участие только в Европейской оценке 
3. Участие одновременно в двух системах оценки 
Преимущества двойной экспертизы - возможность получить две оценки в один день, по одним ветеринарным документам, а также вдвое пополнить Вашу коллекцию “трофеев” и получить одновременно информацию от двух международных экспертов.

Цветные мутации и пленное направление проходят оценку независимо друг от друга. 

ЭКСПЕРТЫ: 

Rebecka Wolden (Норвегия)

Мазуров Виталий (Россия) 

Заявки на участие принимаются с 20 декабря 2018 г. по 20 марта 2019г. Возможна и дальнейшая регистрация без внесения в каталог. 
Выставка работает только один день 6 апреля 2019 г. (суббота) 
Выставка будет открыта: для посетителей с 10 утра до 18 часов; для участников с 08:00. 
Для посетителей вход на выставку бесплатный. 

МЕСТО ПРОВЕДЕНИЯ: г. Москва: Бизнес-центр «Амбер Плаза», ул. Краснопролетарская, 36 (ст. м. Новослободская) 

УСЛОВИЯ УЧАСТИЯ: 
1. Участники Выставки должны прибыть на место проведения Мероприятия с 8:00 до 10:00 для регистрации и прохождения ветконтроля. 
2. В день выставки при регистрации: 
Участники, не оплатившие участие, должны его оплатить. 
Каждый участник получает каталог выставки и регистрационные номера на каждое животное, которые необходимо прикрепить к переноске или клетке с животным и сохранять до конца выставки. 
На ветеринарном контроле владельцы животных должны предоставить ветеринарные справки формы №1, №4 или ветеринарные сертификаты на каждое животное, включая животных, предназначенных на продажу. Если в документе указано более пяти животных, то к нему должна быть приложена сопроводительная опись. 
Животные, не прошедшие ветконтроль, на территорию выставки не допускаются. 
3. В случае отсутствия участника на Мероприятии, денежные средства, внесенные им в счет своего участия, возврату не подлежат. 

ПРИЗОВОЙ ФОНД 
для Российской системы оценки - кубки, розетки, дипломы и подарки от спонсоров выставки `, `для Европейской системы оценки - кубки, розетки, дипломы 

РЕГИСТРАЦИЯ: 
для Российской и Европейской систем оценки заявки принимаются с 20 декабря 2018 г. на эл. почту: `, ` в таком формате: 
ФИО участника 
город 
эл. адрес 
моб. телефон 
шиншилла №1 (какая система оценки?)
кличка 
пол 
возраст (полных месяцев/лет на момент выставки) 
окрас (если требуется определение окраса, рядом указываете - “на подтверждение окраса”) 
заводчик (не путайте с владельцем) 
шиншилла №2 (какая система оценки?) 
кличка 
пол 
возраст (полных месяцев/лет на момент выставки) 
окрас (если требуется определение окраса, рядом указываете - “на подтверждение окраса”) 
заводчик (не путайте с владельцем) 
и так далее 

ВОЗРАСТНЫЕ КАТЕГОРИИ 
для Российской системы оценки 
от 4 до 6 малыши 
от 6 до 9 юниоры 
от 9 и старше взрослые 
для Европейской системы оценки 
от 4 до 6 малыши 
от 6 до 9 юниоры 
от 9 и старше взрослые 

!!! Каждая группа должна иметь как минимум 3 животных, в противном случае животные будут включены в другую группу на усмотрение эксперта. Возможно количество 2-х животных в группе в исключительных случаях. 

СТОИМОСТЬ УЧАСТИЯ 
Сбор с участника – 300 руб. (единоразовый) Участнику предоставляется выставочное место (стул и место на выставочном столе примерно 80х80 см), каталог выставки, подарочный пакет при регистрации. 
Дополнительное место - 300 руб. (не более одного на 1-го участника) 
Стоимость участия животного : 
1. Только в российской системе оценки - 350 руб. (за каждое животное) 
2. Только в европейской системе оценки – 750 руб. (за каждое животное) 
3. Одновременно в двух системах оценки – 900 руб. (за каждое животное) 
Ринговки 
Предоставляются организатором выставки (личные клетки/ринговки не допускаются) 
Стоимость аренды ринговки - 100 р/шт. 

СКИДКИ ДЛЯ УЧАСТНИКОВ: (распространяется только на зарубежную экспертизу) 
При регистрации 10 и более - 10% скидка 
Для стюардов - 50% скидка 
Для секретарей (заполнение дипломов) - 50% скидка 

ОПЛАТА: 
для Российской системы оценки и для Европейской системы оценки на карту Сбербанка РФ (высылается на эл. почту после регистрации) 

ТРЕБОВАНИЯ К ВНЕШНЕМУ ВИДУ ЖИВОТНЫХ: 
• мех животного должен быть без видимых повреждений, хорошо подготовленным 
• у животного не должно быть текущих глаз, диареи, грибковых заболеваний, беременности. 
• постарайтесь не использовать песок за два дня до выставки 
• все животные при обнаружении у них заболеваний будут дисквалифицированы без возврата оплаты. 

ПОРЯДОК ПРОХОЖДЕНИЯ РЕГИСТРАЦИИ В ДЕНЬ ВЫСТАВКИ: 
с 08:00 регистрация владельцев и животных по документам, подтверждающим оплату 
далее прохождение ветеринарного контроля по справкам 
получение ринговок 
размещение животных 
с 10:00 начало экспертизы 
в 16:00 окончание экспертизы 
в 17:00 награждение 
Важно! Возможны изменения во времени проведения мероприятия, но покинуть выставочные места участник может не ранее 17:00 

ОБЩАЯ ИНФОРМАЦИЯ: 
На выставке будет работать профессиональный переводчик 
Заранее узнавайте, где получить справки Ф1 (для иногородних) и Ф4 (для местных жителей) срок действия справок - 5 дней. 
Просьба не надевать яркую цветную одежду, если вы планируете наблюдать за оценкой возле экспертных столов. 

Организатор выставки: МА “РОДЕМАКС” 
Спонсоры выставки: `, `Организаторы секции шиншилл: 
Карташова Алла - заводчик шиншилл г.Ростов-на-Дону
Блинова Инна - заводчик шиншилл г.Тула`]
			},
			en: {
				race: "RAEC",
				to_main: "Home",
				to_regist: "Login",
				to_dna: "DNA-base",
				to_table: "Table",
				to_expert: "Experting",
				complete_regist: "Application for the exhibition was successfully accepted.",
				title: "<?php echo $last_show_data['title']; ?>",
				to_show_regist: ["Register ", "for the exhibition"],
				learn_more: "To learn more",
				show_ad_text: [`ANNOUNCEMENT

Zoo show "Animal on the palm" April 6, 2019.

Dear Chinchilla breeders !!!

We invite you to take part in the next international exhibition in the framework of the exhibition "ZOOPALITRA" on April 6, 2019.

Examination of chinchillas will be carried out with some changes. Participants will be presented with a choice in passing the assessment, namely:
1. Participation only in the Russian assessment
2. Participation only in the European assessment
3. Participation in two assessment systems simultaneously
The advantages of a double examination are the possibility to receive two assessments in one day, according to one veterinary documents, and also to double your collection of “trophies” and simultaneously receive information from two international experts.

Color mutations and captive direction are evaluated independently of each other.

EXPERTS:

Rebecka Wolden (Norway)

Mazurov Vitaliy (Russia)

Applications for participation are accepted from December 20, 2018 to March 20, 2019. Further registration is possible without cataloging.
The exhibition is open only one day April 6, 2019 (Saturday)
The exhibition will be open: for visitors from 10 am to 6 pm; for participants from 08:00.
For visitors the entrance to the exhibition is free.

PLACE OF CONDUCT: Moscow: Amber Plaza Business Center, ul. Krasnoproletarskaya, 36 (metro station Novoslobodskaya)

THE TERMS OF PARTICIPATION:
1. Exhibitors must arrive at the venue of the Event from 8:00 to 10:00 for registration and passing control.
2. On the day of the exhibition at registration:
Participants who have not paid for participation must pay for it.
Each participant receives an exhibition catalog and registration numbers for each animal, which must be attached to the carrier or animal cage and maintained until the end of the exhibition.
At the veterinary control, animal owners must provide veterinary certificates form № 1, № 4 or veterinary certificates for each animal, including animals intended for sale. If more than five animals are indicated in the document, an accompanying inventory should be attached to it.
Animals that have not passed veterinary control are not allowed on the territory of the exhibition.
3. In the absence of the participant at the Event, the funds contributed by him to his participation are not refundable.

PRIZE FUND
for the Russian rating system - cups, sockets, diplomas and gifts from exhibition sponsors`, `for the European evaluation system - cups, sockets, diplomas

CHECK IN:
For the Russian and European systems of evaluation, applications are accepted from December 20, 2018 to email. mail:`, `in this format:
Name of the participant
city
email address
mob phone
Chinchilla # 1 (what is the rating system?)
nickname
floor
age (full months / years at the time of the exhibition)
color (if you need to determine the color, next to indicate - “to confirm the color”)
breeder (not to be confused with the owner)
Chinchilla # 2 (what is the rating system?)
nickname
floor
age (full months / years at the time of the exhibition)
color (if you need to determine the color, next to indicate - “to confirm the color”)
breeder (not to be confused with the owner)
and so on

AGE CATEGORIES
for the Russian rating system
from 4 to 6 kids
from 6 to 9 juniors
from 9 and older adults
for the European Evaluation System
from 4 to 6 kids
from 6 to 9 juniors
from 9 and older adults

!!! Each group must have at least 3 animals, otherwise the animals will be included in the other group at the discretion of the expert. Perhaps the number of 2 animals in the group in exceptional cases.

COST OF PARTICIPATION
Collection from the participant - 300 rubles. (one-time) The exhibitor is provided with an exhibition space (a chair and a seat on the exhibition table approximately 80x80 cm), an exhibition catalog, a gift package upon registration.
Extra bed - 300 rubles. (no more than one per 1st participant)
Cost of animal participation:
1. Only in the Russian evaluation system - 350 rubles. (for each animal)
2. Only in the European evaluation system - 750 rubles. (for each animal)
3. At the same time, in two assessment systems - 900 rubles. (for each animal)
Ringovki
Provided by the exhibition organizer (personal box / ring are not allowed)
The cost of renting a ring - 100 p / pcs.

DISCOUNTS FOR PARTICIPANTS: (applies only to foreign expertise)
When registering 10 or more - 10% discount
For stewards - 50% discount
For secretaries (filling diplomas) - 50% discount

PAYMENT:
for the Russian rating system and for the European rating system on the Sberbank card (sent by email. after registration)

REQUIREMENTS FOR ANIMAL APPEARANCE:
• the animal's fur must be without visible damage, well prepared
• the animal should not have ongoing eyes, diarrhea, fungal diseases, pregnancy.
• Try not to use sand two days before the exhibition.
• All animals will be disqualified if they find diseases without refund.

PROCEDURE FOR REGISTRATION DAY ON THE EXHIBITION DAY:
from 08:00 registration of owners and animals according to the documents confirming payment
further veterinary control check in
getting rings
animal placement
from 10:00 the beginning of the examination
at 16:00 end of the examination
at 17:00 award
Important! There may be changes in the time of the event, but the participant can leave the exhibition space no earlier than 17:00

GENERAL INFORMATION:
A professional translator will work at the exhibition.
Find out in advance where to get certificates F1 (for non-residents) and F4 (for local residents) certificates validity period - 5 days.
Please do not wear bright colored clothes if you plan to monitor the assessment near the expert tables.

Exhibition Organizer: MA “RODEMAX”
Sponsors of the exhibition:`, `Organizers of the chinchilla section:
Alla Kartashova - breeder of Rostov-on-Don chinchillas
Blinova Inna - breeder of Tula chinchillas`]
			}
		}
	},
	computed: {
		lang: function() {
			let lang = (navigator.language || navigator.userLanguage).substring(0, 2);
			if(['ru', 'en'].indexOf(lang) > -1) {
				return lang;
			} else {
				return 'en';
			}
		}
	}
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>