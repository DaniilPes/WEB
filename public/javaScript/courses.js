// Получаем модальное окно
var modal = document.getElementById("courseModal");

// Получаем элемент <span>, который закрывает модальное окно
var span = document.getElementsByClassName("close")[0];

// Получаем все кнопки "Learn More"
var learnMoreButtons = document.querySelectorAll('.course-link');

// Добавляем обработчик событий для каждой кнопки
learnMoreButtons.forEach(function(button) {
    button.onclick = function() {
        // Устанавливаем заголовок и описание курса
        var courseTitle = this.previousElementSibling.previousElementSibling.innerText;
        var courseDescription = this.previousElementSibling.innerText;

        document.getElementById("modalCourseTitle").innerText = courseTitle;
        document.getElementById("modalCourseDescription").innerText = courseDescription;

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
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
