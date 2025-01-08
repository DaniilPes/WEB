<?php
global $tplData;
?>
<link rel="stylesheet" href="public/MyCss/style-1.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<body class="choosingForm">
<?php if (!$tplData['isLogged']): ?>
    <form action="index.php?page=registration" method="POST" oninput="x.value=(pas1.value==pas2.value)?'OK':'Passwords are different'">
        <div id="logo">
            <img src="public/images/codeChar.png" width="100" alt="Code Academy Logo">
            codeAcademy
        </div>

        <?php if (isset($tplData['message'])): ?>
            <div class="alert <?= strpos($tplData['message'], 'ERROR') === false ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($tplData['message'], ENT_QUOTES) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required>

        <label for="pas1">Password:</label>
        <input type="password" id="pas1" name="heslo" required>

        <label for="pas2">Password 2:</label>
        <input type="password" id="pas2" name="heslo2" required>

        <label for="jmeno">Name:</label>
        <input type="text" id="jmeno" name="jmeno" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="kurz">Course:</label>
        <select id="kurz" name="kurz">
            <?php foreach ($tplData['courses'] as $course): ?>
                <option value="<?= htmlspecialchars($course['kurz_id'], ENT_QUOTES) ?>">
                    <?= htmlspecialchars($course['nazev'], ENT_QUOTES) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="submit" name="potvrzeni" value="Register" class="button">
        <a href="index.php?page=login" class="button">Continue</a>
    </form>
<?php else: ?>
    <div>
        <b>Already logged in. Registration is impossible.</b>
    </div>
<?php endif; ?>
</body>
