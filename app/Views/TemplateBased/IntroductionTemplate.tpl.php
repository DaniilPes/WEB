<?php

global $tplData;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" charset="UTF-8" content="width=device-width, initial-scale=1.0">
    <title> code academy</title>

    <link rel="stylesheet" href="public/MyCss/style-2.css">
    <link rel="stylesheet" href="public/MyCss/style-1.css">

    <link rel="stylesheet" href="public/MyCss/responzivita2.css">

    <script src ="public/javaScript/script.js"></script>
    <script src="https://kit.fontawesome.com/be98670a76.js" crossorigin="anonymous"></script>
</head>
<body>
<script>
    function myFunction(x) {
        x.classList.toggle("change");
    }
</script>

<?php
//$tplData['db']->addHeader();
?>

<div class="osnova1">

    <div class="osnova1.1">
        <img id="cmdPic" src="public/images/cmdPIC.png">
        <div class="cmdPicString">
            Here you can learn a large number of skills in a variety of IT areas.</br>
            Such as: </br>
            Data scientist; </br>
            Tester;</br>
            Information security specialist;</br>
            Systems Analyst;</br>
            Game designer;</br>
            and others....</br>
            Or improve your skills to advance your career or other goals </br>
        </div>
    </div>

    <div class="courses">
        <div class="pros">
            <h2 id="aboutUsH1"> About us </h2>
            <div id="aboutUs" > Nabízíme širokou škálu kurzů programování,
                navržených pro studenty všech úrovní - od začátečníků po zkušené profesionály.
                Najdete u nás interaktivní lekce, praktické úkoly a projekty,
                které vám pomohou zvládnout populární programovací jazyky a technologie.
                Připojte se k naší komunitě a začněte svou cestu do světa IT s podporou zkušených lektorů a
                pohodlné studijní platformy.
            </div>
            <div class ="test">
                <div class="professionals" id="prof1"> <img src="public/images/person1.png" class="img-circle" width="150" height="150"> <br>-->
                    <b> Pavel Verba </b> <br>
                    <span style="font-size: 20px"> Specialista z kybernetiky</span>
                    <hr style="color: black">
                </div>
                <div class="professionals" id="prof2"> <img src="public/images/person2.png" class="img-circle" width="150" height="150"> <br>
                    <b> Pavel Technik </b> <br>
                    <span style="font-size: 20px"> Specialista z xanaxu</span>
                    <hr style="color: black">
                </div>
                <div class="professionals" id="prof3"> <img src="public/images/person3.png" class="img-circle" width="150" height="150"> <br>
                    <b> Oleh Tabachinsky </b> <br>
                    <span style="font-size: 20px"> Pivni specialista</span>
                    <hr style="color: black">
                </div>
                <div class="professionals" id="prof4"> <img src="public/images/person4.jpg" class="img-circle" width="150" height="150"> <br>
                    <b> Evzen Dziakin </b> <br>
                    <span style="font-size: 20px"> Specialista snusu</span>
                    <hr style="color: black">
                </div>
            </div>
        </div>
    </div>
    <div class="price">
        <div class="priceItem">
            <strong>Web Development</strong>
            <hr/>
            Naučte se vytvářet moderní webové aplikace pomocí HTML, CSS a JavaScriptu.
            <hr/>
            <span>Cena: 299 $</span>
        </div>
        <div class="priceItem">
            <strong>Programování v C</strong>
            <hr/>
            Základy programování v C: od syntaxe po práci s pamětí a datovými strukturami.
            <span>Cena: 249 $</span>
        </div>
        <div class="priceItem">
            <strong>Java pro začátečníky</strong>
            <hr/>
            Naučte se vytvářet aplikace v Javě, včetně základů objektově orientovaného programování.
            <span>Cena: 279 $</span>
        </div>
        <div class="priceItem">
            <strong>Kotlin pro Android</strong>
            <hr/>
            Vývoj mobilních aplikací pro Android pomocí jazyka Kotlin a Android Studia.
            <span>Cena: 319 $</span>
        </div>
    </div>
</div>

<?php
//$tplData['db']->addFooter();
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous">

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous">
</script>
</body>
</html>