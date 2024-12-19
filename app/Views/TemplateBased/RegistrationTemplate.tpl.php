<?php
global $tplData;
?>

<link rel="stylesheet" href="public/MyCss/style-1.css">
<script src="public/javaScript/script.js"></script>

<?php if (isset($tplData['error'])): ?>
    <div class="error-message">
        <?= htmlspecialchars($tplData['error']) ?>
    </div>
<?php endif; ?>

<?php if (!$tplData['isLogged']): ?>
    <h2>Регистрационная форма</h2>
    <form action="" method="POST" oninput="x.value=(pas1.value==pas2.value)?'OK':'Пароли не совпадают'">
        <div id="logo" class="center">
            <img src="public/images/codeChar.png" width="100">
            codeAcademy
        </div>

        <label for="login">Логин:</label>
        <input type="text" id="login" name="login" required>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="heslo" required>

        <label for="password">Подтвердите пароль:</label>
        <input type="password" id="password2" name="heslo2" required>

        <label for="jmeno">Имя:</label>
        <input type="text" id="jmeno" name="jmeno" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="kurz">Курс:</label>
        <select name="kurz" style="height: 35px">
            <?php foreach ($tplData['courses'] as $course): ?>
                <option value="<?= $course['kurz_id'] ?>"><?= htmlspecialchars($course['nazev']) ?></option>
            <?php endforeach; ?>
        </select>

        <input class="button" type="submit" name="potvrzeni" value="Зарегистрироваться">
        <label class="center">или</label>
        <a href="index.php?page=login" class="btn" id="linkReg">Войти</a>
    </form>
<?php else: ?>
    <div>
        <b>User already exists. Registration is impossible.</b>
    </div>
<?php endif; ?>
