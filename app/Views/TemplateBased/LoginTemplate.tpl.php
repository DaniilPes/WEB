<?php
    global $tplData;
?>
<link rel="stylesheet" href="public/MyCss/style-1.css">


<?php if (!isset($tplData['user'])): ?>
    <!-- Форма для входа -->

    <h2>Přihlášení uživatele</h2>
    <div id="inputForm" class="center">
        <form action="" method="POST">
            <div id="logo" class="center">
                <img src="public/images/codeChar.png" width="100">
                codeAcademy
            </div>
            <label for="login">Login:</label>
            <input type="text" id="login" name="login">
            <label for="password">Password:</label>
            <input type="password" id="password" name="heslo">
            <input type="hidden" name="action" value="login">

            <input class="button" type="submit" name = "potvrzeni" value="Prihlasit">

            <label class="center"> nebo </label>

            <a href="index.php?page=registrace" class="button">REGISTRACE</a>
        </form>

        <?php if (isset($tplData['error'])): ?>
            <div class="error"><?= htmlspecialchars($tplData['error']) ?></div>
        <?php endif; ?>
    </div>

<?php else: ?>
    <!-- Данные для авторизованных пользователей -->
        <br>
        <h2 class="center">Přihlášený uživatel</h2>
<!--        <link rel="stylesheet" href="MyCss/style-1.css">-->
<!--        <script src ="script.js"></script>-->

        <b class="center"> Login: <?= htmlspecialchars($tplData['user']['login']) ?></b><br>
        <b class="center"> Jméno: <?= htmlspecialchars($tplData['user']['jmeno']) ?></b><br>
        <b class="center"> E-mail: <?= htmlspecialchars($tplData['user']['email']) ?></b><br>
        <b class="center"> Právo: <?= htmlspecialchars($tplData['userRight']) ?></b><br>
        <b class="center"> Kurz: <?= htmlspecialchars($tplData['userCourse']) ?></b>
        <br>
        <br>

<!--    </div>-->
    <form action="" method="POST">
        <a href="index.php?page=user_update" class="button"> Zmena</a>
        <input type="hidden" name="action" value="logout">
        <input class="button" type="submit" value="Odhlásit">
        <a href="index.php?page=management" class="button"> Sprava uzivatelu</a>
        <?php
            if($tplData['userRight'] < 2){
               ?>
                    <a href="index.php?page=management" class="button"> Sprava uzivatelu</a>

                <?php
            }
        ?>
        <a href="index.php?page=main" class="button"> Zpet</a>
    </form>
<?php endif; ?>
