<?php
global $tplData;
?>
<link rel="stylesheet" href="public/MyCss/style-1.css">
<script src="public/javaScript/script.js"></script>


<body class="choosingForm">
<?php if (!$tplData['isLogged']): ?>
<!--    <div id="RegisterInput" class="center">-->
        <form action="index.php?page=registration" method="POST" oninput="x.value=(pas1.value==pas2.value)?'OK':'Passwords are different'">

            <div id="logo" class="center">
                <img src="public/images/codeChar.png" width="100" alt="Code Academy Logo">
                codeAcademy
            </div>
            <?php if (isset($tplData['message'])): ?>
                <div class="<?= strpos($tplData['message'], 'ERROR') === false ? 'success-message' : 'error-message' ?>">
                    <?= htmlspecialchars($tplData['message'], ENT_QUOTES) ?>
                </div>
            <?php endif; ?>
    <!--        <h2>Registration form</h2>-->
            <label for="login">Login:</label>
            <input type="text" id="login" name="login" required>

            <label for="pas1">Password:</label>
            <input type="password" id="pas1" name="heslo" required>

            <label for="pas2">Password 2:</label>
            <input type="password" id="pas2" name="heslo2" required>

            <label for="jmeno">Name:</label>
            <input type="text" id="jmeno" name="jmeno" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required autocomplete="autocompleted input">

            <label for="kurz">Course:</label>
            <select id="kurz" name="kurz" style="height: 35px">
                <?php foreach ($tplData['courses'] as $course): ?>
                    <option value="<?= htmlspecialchars($course['kurz_id'], ENT_QUOTES) ?>">
                        <?= htmlspecialchars($course['nazev'], ENT_QUOTES) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>
            <input class="button" type="submit" name="potvrzeni" value="Register" >
            <label class="center" for="RegisterInput" >or</label>
            <a href="index.php?page=login" class="butn" id="linkReg">Continue</a>
        </form>
<!--    </div>-->
<?php else: ?>
    <div>
        <b>Already logged in. Registration is impossible.</b>
    </div>
<?php endif; ?>
</body>
