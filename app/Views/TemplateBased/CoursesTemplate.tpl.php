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
<!--    <link rel="stylesheet" href="public/MyCss/Responzivita.css">-->
    <link rel="stylesheet" href="public/MyCss/responzivita2.css">
    <script src="https://kit.fontawesome.com/be98670a76.js" crossorigin="anonymous"></script>

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
<script src="public/javaScript/coursesVideoScript.js"></script>

</body>
</html>
