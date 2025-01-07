<?php
global $tplData;
?>
<link rel="stylesheet" href="public/MyCss/style-1.css">

<?php if (!isset($tplData['user'])): ?>
    <!-- Форма для входа -->
    <h2>Logged user</h2>
    <div id="inputForm" class="center">
        <form action="index.php?page=login" method="POST">
            <div id="logo" class="center">
                <img src="public/images/codeChar.png" width="100" alt="Code Academy Logo">
                codeAcademy
            </div>
            <label for="login">Login:</label>
            <input type="text" id="login" name="login" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="heslo" required>
            <input type="hidden" name="action" value="login">

            <input class="button" type="submit" name="potvrzeni" value="Sign in">

            <label class="center"> or </label>

            <a href="index.php?page=registration" class="button">REGISTRATION</a>
        </form>

        <?php if (isset($tplData['error'])): ?>
            <div class="error"><?= htmlspecialchars($tplData['error'], ENT_QUOTES) ?></div>
        <?php endif; ?>
    </div>
<?php else: ?>
    <!-- Данные для авторизованных пользователей -->
    <br>
    <h2 class="center">Logged user</h2>
    <b class="center">Login: <?= htmlspecialchars($tplData['user']['login'], ENT_QUOTES) ?></b><br>
    <b class="center">Name: <?= htmlspecialchars($tplData['user']['jmeno'], ENT_QUOTES) ?></b><br>
    <b class="center">E-mail: <?= htmlspecialchars($tplData['user']['email'], ENT_QUOTES) ?></b><br>
    <b class="center">Right: <?= htmlspecialchars($tplData['userRightName'], ENT_QUOTES) ?></b><br>
    <b class="center">Course: <?= htmlspecialchars($tplData['userCourse'], ENT_QUOTES) ?></b>
    <br><br>

    <form action="index.php?page=login" method="POST">
        <a href="index.php?page=user_update" class="button">Change</a>
        <input type="hidden" name="action" value="logout">
        <input class="button" type="submit" value="Odhlásit">
        <?php if ($tplData['userRightWeight'] < 2): ?>
            <a href="index.php?page=management" class="button">Modify users</a>
        <?php endif; ?>
        <a href="index.php?page=main" class="button">Back</a>
    </form>
<?php endif; ?>
