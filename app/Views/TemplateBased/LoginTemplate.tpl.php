<?php
global $tplData;
?>
<link rel="stylesheet" href="public/MyCss/style-1.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<body class="choosingForm">
<?php if (!isset($tplData['user'])): ?>
<!--    <h2>Logged user</h2>-->
    <?php if (isset($tplData['error'])): ?>
<!--        <div class="error">--><?php //= htmlspecialchars($tplData['error'], ENT_QUOTES) ?><!--</div>-->
            <h2 class="alert alert-danger" role="alert"><?= htmlspecialchars($tplData['error'], ENT_QUOTES) ?></h2>
    <?php endif; ?>
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

<!--        --><?php //if (isset($tplData['error'])): ?>
<!--            <div class="error">--><?php //= htmlspecialchars($tplData['error'], ENT_QUOTES) ?><!--</div>-->
<!--        --><?php //endif; ?>
    </div>
<?php else: ?>
    <!-- Данные для авторизованных пользователей -->
    <br>
    <div class="choosingForm">
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
            <input class="button" type="submit" value="Log out">
            <?php if ($tplData['userRightWeight'] < 2): ?>
                <a href="index.php?page=management" class="button">Modify users</a>
            <?php endif; ?>
            <a href="index.php?page=main" class="button">Back</a>
        </form>
    </div>
</body>
<?php endif; ?>
