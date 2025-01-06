<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Academy - Courses</title>
    <link rel="stylesheet" href="public/MyCss/courses.css">
    <link rel="stylesheet" href="public/MyCss/style-2.css">
    <link rel="stylesheet" href="public/MyCss/responzivita2.css">
    <script src="https://kit.fontawesome.com/be98670a76.js" crossorigin="anonymous"></script>
    <style>
        /* Стили для модального окна */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* Уменьшено для вертикального центрирования */
            padding: 20px;
            border: 1px solid #888;
            width: 50%; /* Уменьшено для вертикального окна */
            max-height: 80%; /* Ограничение высоты */
            overflow-y: auto; /* Прокрутка, если контент превышает высоту */
            display: flex; /* Используем Flexbox для центрирования */
            flex-direction: column; /* Вертикальное направление */
            align-items: center; /* Центрирование по горизонтали */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        video {
            max-width: 100%; /* Ограничение ширины видео */
            height: auto; /* Автоматическая высота */
        }
    </style>
</head>
<body>
<div class="courses-section">
    <h2>Available Courses</h2>
    <div class="course-card">
        <h3>Web Development</h3>
        <img src="public/images/web-course.png" alt="Web Development">
        <p>Learn HTML, CSS, JavaScript, and more to build modern web applications.</p>
        <a href="#" class="course-link">Learn More</a>
    </div>
    <div class="course-card">
        <h3>C Programming</h3>
        <img src="public/images/c-course.png" alt="C Programming">
        <p>Master the fundamentals of C programming language and its applications.</p>
        <a href="#" class="course-link">Learn More</a>
    </div>
    <div class="course-card">
        <h3>Java Programming</h3>
        <img src="public/images/java-course.png" alt="Java Programming">
        <p>Get skilled in Java programming for web, mobile, and enterprise applications.</p>
        <a href="#" class="course-link">Learn More</a>
    </div>
</div>

<!-- Модальное окно -->
<div id="courseModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3 id="modalCourseTitle">Course Title</h3>
        <p id="modalCourseDescription">Course description goes here...</p>
        <video id="modalCourseVideo" controls autoplay muted>
            <source src="public/videos/presentation.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</div>

<script src="public/javaScript/script.js"></script>
<script>
    // Получаем модальное окно
    var modal = document.getElementById("courseModal");

    // Получаем элемент <span>, который закрывает модальное окно
    var span = document.getElementsByClassName("close")[0];

    // Получаем все кнопки "Learn More"
    var learnMoreButtons = document.querySelectorAll('.course-link');

    // Добавляем обработчик событий для каждой кнопки
    learnMoreButtons.forEach(function(button) {
        button.onclick = function(event) {
            event.preventDefault(); // Предотвращаем переход по ссылке

            // Получаем родительский элемент курса
            var courseCard = this.closest('.course-card');

            // Получаем заголовок курса из родительского элемента
            var courseTitle = courseCard.querySelector('h3').innerText;
            var courseDescription = "";

            if(courseTitle === "Java Programming") {
                courseDescription = "This course provides a deep understanding of the Java programming language, which is widely used for developing web applications, mobile apps, and enterprise software. You will learn the fundamental concepts of object-oriented programming and gain skills in working with modern frameworks.<br><br>" +
                    "Course Topics:<br>" +
                    "- Java Basics: syntax, data types, operators<br>" +
                    "- Object-Oriented Programming: classes, objects, inheritance, polymorphism<br>" +
                    "- Working with collections and streams<br>" +
                    "- Exceptions and error handling<br>" +
                    "- Basics of multithreading<br>" +
                    "- Creating graphical interfaces using JavaFX<br>" +
                    "- Introduction to Spring Framework for building web applications";
            } else if(courseTitle === "C Programming") {
                courseDescription = "The C course covers the fundamentals of programming in one of the most popular languages in the world. You will learn to write efficient and optimized code, as well as understand memory management principles.<br><br>" +
                    "Course Topics:<br>" +
                    "- Introduction to C: syntax, variables, operators<br>" +
                    "- Control structures: conditions and loops<br>" +
                    "- Functions and arrays<br>" +
                    "- Pointers and memory management<br>" +
                    "- Structures and unions<br>" +
                    "- File handling<br>" +
                    "- Basics of C development for embedded systems";
            } else if(courseTitle === "Web Development") {
                courseDescription = "This course is dedicated to creating modern web applications. You will study both front-end and back-end development, as well as gain skills in working with databases and APIs.<br><br>" +
                    "Course Topics:<br>" +
                    "- Basics of HTML, CSS, and JavaScript<br>" +
                    "- Responsive design and working with frameworks (Bootstrap, Tailwind CSS)<br>" +
                    "- Introduction to JavaScript frameworks (React, Vue.js)<br>" +
                    "- Basics of server-side development with Node.js<br>" +
                    "- Working with RESTful APIs<br>" +
                    "- Databases: SQL and NoSQL<br>" +
                    "- Basics of DevOps: deploying applications and CI/CD";
            }

            document.getElementById("modalCourseTitle").innerText = courseTitle;
            document.getElementById("modalCourseDescription").innerHTML = courseDescription;

            // Показываем модальное окно
            modal.style.display = "block";
        }
    });

    // Когда пользователь нажимает на <span> (x), закрываем модальное окно
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Когда пользователь нажимает в любом месте вне модального окна, закрываем его
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    // Получаем модальное окно
    var modal = document.getElementById("courseModal");
</script>



</body>
</html>
