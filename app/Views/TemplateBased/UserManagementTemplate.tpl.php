<?php
global $tplData;
?>

<link rel="stylesheet" href="public/MyCss/style_management.css">
<style>
    a { font-size: 25px; }
</style>
<script src="public/javaScript/management.js"></script>

<div class="container">
    <h2>Seznam uživatelů</h2>
    <a href="index.php?page=login" class="button">Zpět</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Login</th>
            <th>Jméno</th>
            <th>E-mail</th>
            <th>Právo</th>
            <th>Kurz</th>
            <th>Akce</th>
        </tr>
        <?php foreach ($tplData['users'] as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id_uzivatel']) ?></td>
                <td class="login"><?= htmlspecialchars($user['login']) ?></td>
                <td class="name"><?= htmlspecialchars($user['jmeno']) ?></td>
                <td class="email"><?= htmlspecialchars($user['email']) ?></td>
                <td class="pravo">
                    <form action="index.php?page=management" method="POST">
                        <input type="hidden" name="id_uzivatel" value="<?= htmlspecialchars($user['id_uzivatel']) ?>">
                        <select name="pravo">
                            <?php foreach ($tplData['rights'] as $right): ?>
                                <option value="<?= htmlspecialchars($right['id_pravo']) ?>"
                                    <?= $user['id_pravo'] == $right['id_pravo'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($right['jemno']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" name="aktualizace_pravo" value="Aktualizovat">
                    </form>
                </td>
                <td class="kurz">
                    <form action="index.php?page=management" method="POST">
                        <input type="hidden" name="id_uzivatel" value="<?= htmlspecialchars($user['id_uzivatel']) ?>">
                        <select name="kurz">
                            <?php foreach ($tplData['courses'] as $course): ?>
                                <option value="<?= htmlspecialchars($course['kurz_id']) ?>"
                                    <?= $user['id_kurz'] == $course['kurz_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($course['nazev']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" name="aktualizace_kurz" value="Aktualizovat">
                    </form>
                </td>
                <td class="akce">
                    <form action="index.php?page=management" method="POST">
                        <input type="hidden" name="id_uzivatel" value="<?= htmlspecialchars($user['id_uzivatel']) ?>">
                        <input type="submit" name="delete_user" value="Smazat">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
