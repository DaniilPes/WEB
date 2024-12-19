<?php
global $tplData;
?>

<?php if (!$tplData['isLogged']): ?>
    <div>
        <b>Osobní údaje mohou měnit pouze přihlášení uživatelé.</b>
    </div>
<?php else: ?>
    <?php if (!empty($tplData['message'])): ?>
        <div class="message">
            <?= htmlspecialchars($tplData['message']) ?>
        </div>
    <?php endif; ?>
    <link rel="stylesheet" href="public/MyCss/style-1.css">
    <script src="public/script.js"></script>
    <h2>Osobní údaje</h2>
    <form action="" method="POST" autocomplete="off">
        <input type="hidden" name="id_uzivatel" value="<?= $tplData['userData']['id_uzivatel'] ?>">

        <label>Login: <?= htmlspecialchars($tplData['userData']['login']) ?></label>

        <label for="password">Password:</label>
        <input type="password" name="heslo">

        <label for="password2">Password 2:</label>
        <input type="password" name="heslo2">

        <label for="jmeno">Name:</label>
        <input type="text" name="jmeno" value="<?= htmlspecialchars($tplData['userData']['jmeno']) ?>">

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($tplData['userData']['email']) ?>">

        <label for="heslo_puvodni">Současné heslo:</label>
        <input type="password" name="heslo_puvodni" required>

        <label for="pravo">Právo:</label>
        <select name="pravo">
            <?php foreach ($tplData['rights'] as $right): ?>
                <option value="<?= $right['id_pravo'] ?>" <?= $tplData['userData']['id_pravo'] == $right['id_pravo'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($right['jemno']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="kurz">Kurz:</label>
        <select name="kurz">
            <?php foreach ($tplData['courses'] as $course): ?>
<!--                <option value="--><?php //= $course['kurz_id'] ?><!--"-->
<!--<!--                    -->--><?php ////= $tplData['userData']['kurz_id'] ==
////                    $course['kurz_id'] ? "selected" : "" ?><!--<!-->-->-->
<!--<!--                    -->--><?php ////= htmlspecialchars($course['nazev']) ?>
<!---->
<!--                -->
<!---->
<!--                </option>-->
                <?php
                $selected = ($tplData['kurz_id'] == $course['kurz_id']) ? "selected" : "";
                echo "<option value='$course[kurz_id]' $selected>$course[nazev]</option>";
                ?>
            <?php endforeach; ?>
        </select>

        <br>
        <input class="button" type="submit"  name="potvrzeni" value="Upravit osobní údaje">
        <a href="index.php?page=login" class="button">Zpět</a>
    </form>
<?php endif; ?>
