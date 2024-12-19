// script.js
document.addEventListener('DOMContentLoaded', function () {
    const deleteForms = document.querySelectorAll('form[id^="form_"]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (event) {
            const confirmDelete = confirm('Вы уверены, что хотите удалить этого пользователя?');
            if (!confirmDelete) {
                event.preventDefault();
            }
        });
    });
});
