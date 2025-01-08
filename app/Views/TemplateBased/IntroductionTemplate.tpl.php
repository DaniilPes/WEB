<?php
global $tplData;
?>
<!DOCTYPE html>
<html lang="cz">
<head>
    <meta name="viewport" charset="UTF-8" content="width=device-width, initial-scale=1.0">
    <title>Code Academy</title>


    <link rel="stylesheet" href="public/MyCss/style-1.css">
    <link rel="stylesheet" href="public/MyCss/style-2.css">
    <link rel="stylesheet" href="public/MyCss/responzivita2.css">

    <script src="https://kit.fontawesome.com/be98670a76.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"></script>

</head>
<body>
<!--<script>-->
<!--    function myFunction(x) {-->
<!--        x.classList.toggle("change");-->
<!--    }-->
<!--</script>-->

<?php
//$tplData['db']->addHeader();
?>

<div class="osnova1">

    <div class="osnova1.1">
        <img id="cmdPic" src="public/images/cmdPIC.png">
        <div class="cmdPicString">
            Here you can learn a wide range of skills in various IT fields.</br>
            Such as: </br>
            Data Scientist; </br>
            Tester;</br>
            Information Security Specialist;</br>
            Systems Analyst;</br>
            Game Designer;</br>
            and many more...</br>
            Or enhance your skills to boost your career or achieve other goals. </br>
        </div>
    </div>

    <div class="courses">
        <div class="pros">
            <h2 id="aboutUsH1">About Us</h2>
            <div id="aboutUs"> We offer a wide range of programming courses,
                designed for students of all levels - from beginners to experienced professionals.
                You will find interactive lessons, practical tasks, and projects
                that will help you master popular programming languages and technologies.
                Join our community and start your journey into the world of IT with the support of experienced mentors and
                a convenient learning platform.
            </div>
            <div class="test">
                <div class="professionals" id="prof1">
                    <img src="public/images/person1.png" class="img-circle" width="150" height="150"> <br>
                    <b>Emma Watson</b> <br>
                    <span style="font-size: 20px">Data Science Expert</span>
                    <hr style="color: black">
                </div>
                <div class="professionals" id="prof2">
                    <img src="public/images/person2.png" class="img-circle" width="150" height="150"> <br>
                    <b>Michael Johnson</b> <br>
                    <span style="font-size: 20px">Cybersecurity Analyst</span>
                    <hr style="color: black">
                </div>
                <div class="professionals" id="prof3">
                    <img src="public/images/person3.png" class="img-circle" width="150" height="150"> <br>
                    <b>Sophia Martinez</b> <br>
                    <span style="font-size: 20px">Cloud Computing Specialist</span>
                    <hr style="color: black">
                </div>
                <div class="professionals" id="prof4">
                    <img src="public/images/person4.jpg" class="img-circle" width="150" height="150"> <br>
                    <b>John Doe</b> <br>
                    <span style="font-size: 20px">Artificial Intelligence Engineer</span>
                    <hr style="color: black">
                </div>
            </div>
        </div>
    </div>
    <div class="price">
        <div class="priceItem">
            <strong>Web Development</strong>
            <hr/>
            Learn how to create modern web applications using HTML, CSS, and JavaScript.
            <hr/>
            <span>Price: $299</span>
        </div>
        <div class="priceItem">
            <strong>C Programming</strong>
            <hr/>
            Basics of C programming: from syntax to memory management and data structures.
            <span>Price: $249</span>
        </div>
        <div class="priceItem">
            <strong>Java for Beginners</strong>
            <hr/>
            Learn how to create applications in Java, including the basics of object-oriented programming.
            <span>Price: $279</span>
        </div>
        <div class="priceItem">
            <strong>Kotlin for Android</strong>
            <hr/>
            Develop Android mobile apps using Kotlin and Android Studio.
            <span>Price: $319</span>
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
