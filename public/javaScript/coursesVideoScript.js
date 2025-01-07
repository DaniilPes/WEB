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