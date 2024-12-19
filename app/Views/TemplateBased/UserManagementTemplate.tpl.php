<?php
///////////////////////////////////////////////////////////////////////////
/////////// Sablona pro zobrazeni stranky se spravou uzivatelu  ///////////
///////////////////////////////////////////////////////////////////////////

//// pozn.: sablona je samostatna a provadi primy vypis do vystupu:
// -> lze testovat bez zbytku aplikace.
// -> pri vyuziti Twigu se sablona obejde bez PHP.

/*
////// Po zakomponovani do zbytku aplikace bude tato cast odstranena/zakomentovana  //////
//// UKAZKA DAT: Uvod bude vypisovat informace z tabulky, ktera ma nasledujici sloupce:
// id, date, author, title, text
$tplData['title'] = "Sprava uživatelů (TPL)";
$tplData['users'] = [
    array("id_user" => 1, "first_name" => "František", "last_name" => "Noha",
            "login" => "frnoha", "password" => "Tajne*Heslo", "email" => "fr.noha@ukazka.zcu.cz", "web" => "www.zcu.cz")
];
$tplData['delete'] = "Úspěšné mazání.";
define("DIRECTORY_VIEWS", "../Views");
const WEB_PAGES = array(
    "uvod" => array("title" => "Sprava uživatelů (TPL)")
);
////// KONEC: Po zakomponovani do zbytku aplikace bude tato cast odstranena/zakomentovana  //////
*/

//// vypis sablony
// urceni globalnich promennych, se kterymi sablona pracuje
global $tplData;

?>
<!-- ------------------------------------------------------------------------------------------------------- -->
<link rel="stylesheet" href="public/MyCss/style_management.css">
<style>a{font-size: 25px;}</style>
<script src ="javaScript/management.js"></script>

<div class="alert-info">TemplateBased</div>

<!-- Vypis obsahu sablony -->
<div class="container">
    <h2>Seznam uživatelů</h2>
    <a href="index.php?page=login" class="button">Zpět</a>
    <!--            <input type="button" value="Zpet" onclick="location.href='new_page.php';">-->
    <table>
        <tr>
            <th>ID</th><th>Login</th><th>Jméno</th><th>E-mail</th><th>Právo</th><th>Kurz</th><th>Akce</th>
        </tr>
        <?php
//        $rights = $myDB->getAllRights();
//        $courses = $myDB->getAllCourses();
        $users = $tplData['users'];
        $rights = $tplData['rights'];
        $courses = $tplData['courses'];

        foreach ($users as $u) {
            echo "<tr>
                    <td>{$u['id_uzivatel']}</td>
                    <td class='login'>{$u['login']}</td>
                    <td class='name'>{$u['jmeno']}</td>
                    <td class='email'>{$u['email']}</td>
                    <td class='pravo'>
                        <form action='' method='POST'>
                            <input type='hidden' name='id_uzivatel' value='{$u['id_uzivatel']}'>
                            <select name='pravo'>
                ";
            foreach ($rights as $r) {
                $selected = ($u['id_pravo'] == $r['id_pravo']) ? "selected" : "";
                echo "<option value='{$r['id_pravo']}' $selected>{$r['jemno']}</option>";
            }
            echo "
                            </select>
                            <input type='submit' name='aktualizace_pravo' value='Aktualizovat'>
                        </form>
                    </td>
                    <td class='kurz'>
                        <form action='' method='POST'>
                            <input type='hidden' name='id_uzivatel' value='{$u['id_uzivatel']}'>
                            <select name='kurz'>
                ";
            foreach ($courses as $c) {
                $selected = ($u['id_kurz'] == $c['kurz_id']) ? "selected" : "";
                echo "<option value='{$c['kurz_id']}' $selected>{$c['nazev']}</option>";
            }
            echo "
                            </select>
                            <input type='submit' name='aktualizace_kurz' value='Aktualizovat'>
                        </form>
                    </td>
                    <td class='akce'>
                        <form action='' method='POST'>
                            <input type='hidden' name='id_uzivatel' value='{$u['id_uzivatel']}'>
                            <input type='submit' name='potvrzeni' value='Smazat'>
                        </form>
                    </td>
                </tr>";
        }
        ?>
    </table>
</div>
