<?php
global $tplData;
?>
<body class="choosingForm">
<?php if (!$tplData['isLogged']): ?>
    <div>
        <b>Only logged-in users can edit personal information.</b>
    </div>
<?php else: ?>

    <link rel="stylesheet" href="public/MyCss/style-1.css">
    <script src="public/script.js"></script>
<!--    <h2>Personal Information</h2>-->

    <form action="" method="POST" autocomplete="off">
        <br>
        <input type="hidden" name="id_uzivatel" value="<?= $tplData['userData']['id_uzivatel'] ?>">
        <?php if (!empty($tplData['message'])): ?>
<!--            <div class="message">-->
<!--                --><?php //= htmlspecialchars($tplData['message']) ?>
<!--            </div>-->
            <div class="<?= strpos($tplData['message'], 'ERROR') === false ? 'success-message' : 'error-message' ?>">
                <?= htmlspecialchars($tplData['message'], ENT_QUOTES) ?>
            </div>
        <?php endif; ?>
        <label>Login: <?= htmlspecialchars($tplData['userData']['login']) ?></label>

        <label for="password">New Password:</label>
        <input type="password" name="heslo">

        <label for="password2">Confirm Password:</label>
        <input type="password" name="heslo2">

        <label for="jmeno">Name:</label>
        <input type="text" name="jmeno" value="<?= htmlspecialchars($tplData['userData']['jmeno']) ?>">

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($tplData['userData']['email']) ?>">

        <label for="heslo_puvodni">Current Password:</label>
        <input type="password" name="heslo_puvodni" required>

        <label for="pravo">Role:</label>
        <select name="pravo">
            <?php foreach ($tplData['rights'] as $right): ?>
                <option value="<?= $right['id_pravo'] ?>" <?= $tplData['userData']['id_pravo'] == $right['id_pravo'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($right['jemno']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="kurz">Course:</label>
        <select name="kurz">
            <?php foreach ($tplData['courses'] as $course): ?>
                <?php
                $selected = ($tplData['kurz_id'] == $course['kurz_id']) ? "selected" : "";
                echo "<option value='$course[kurz_id]' $selected>$course[nazev]</option>";
                ?>
            <?php endforeach; ?>
        </select>

        <br>
        <input class="button" type="submit" name="potvrzeni" value="Update Personal Information">
        <a href="index.php?page=login" class="button">Back</a>
    </form>
</body>
<?php endif; ?>
