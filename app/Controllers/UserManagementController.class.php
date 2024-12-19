<?php

namespace kivweb\Controllers;

// ukazka aliasu
use kivweb\Models\DatabaseModel as MyDB;

// nactu rozhrani kontroleru
//require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");


/**
 * Ovladac zajistujici vypsani stranky se spravou uzivatelu.
 * @package kivweb\Controllers
 */
class UserManagementController implements IController {

    /** @var MyDB $db  Sprava databaze. */
    private $db;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        // inicializace prace s DB
        //require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = MyDB::getDatabaseModel();
    }

    /**
     * Vrati obsah stranky se spravou uzivatelu.
     * @param string $pageTitle     Nazev stranky.
     * @return array                Vytvorena data pro sablonu.
     */
    public function show(string $pageTitle):array {
        //// vsechna data sablony budou globalni
        $tplData = [];
        // nazev
        $tplData['title'] = $pageTitle;

//        $idUzivatel = $_POST['id_uzivatel'];
        $userData = $this->db->getLoggedUserData();
//        $idUzivatel = $user['id_uzivatel'];

//        $currentUserData = $this->db->getUserById($idUzivatel);

//        if(!$this->db->isUserLogged()){
//            $tplData['message']= "Tato strána je dostupná pouze přihlášeným uživatelům.";
//            return $tplData;
//        }

        if($userData['id_pravo'] > 2){
            $tplData['message']= "Tato strána je dostupná pouze přihlášeným uživatelům.";
            return $tplData;
        }

        if(isset($_POST['action']) and $_POST['action'] == "delete" and isset($_POST['id_user'])){
            // provedu smazani uzivatele
            $ok = $this->db->deleteUser(intval($_POST['id_user']));
            if($ok){
                $tplData['delete'] = "OK: Uživatel s ID:$_POST[id_user] byl smazán z databáze.";
            } else {
                $tplData['delete'] = "CHYBA: Uživatele s ID:$_POST[id_user] se nepodařilo smazat z databáze.";
            }
        }elseif (isset($_POST['id_uzivatel'], $_POST['pravo']) && !empty($_POST['aktualizace_pravo'])) {
            $idUzivatel = $_POST['id_uzivatel'];
            $idPravo = $_POST['pravo'];

            $currentUserData = $this->db->getUserById($idUzivatel);
            $ok = $this->db->updateUser($currentUserData['id_uzivatel'], $currentUserData['login'], $currentUserData['heslo'], $currentUserData['jmeno'], $currentUserData['email'], $idPravo, $currentUserData['id_kurz']);
            if ($ok) {
                $tplData['message'] = "OK: Právo uživatele s ID: {$_POST['id_uzivatel']} bylo aktualizováno.";
            } else {
                $tplData['message'] = "CHYBA: Právo uživatele s ID: {$_POST['id_uzivatel']} se nepodařilo aktualizovat.";
            }
            echo $tplData['message'];
        } elseif (isset($_POST['id_uzivatel'],$_POST['kurz']) && !empty($_POST['aktualizace_kurz'])) {
//            $kurz = $_POST['kurz'];
            $idUzivatel = $_POST['id_uzivatel'];
            $currentUserData = $this->db->getUserById($idUzivatel);
            // Обновление курса пользователя
//            $ok = $this->db->updateUserCourse(intval($_POST['id_user']), intval($_POST['id_course']));
            $ok = $this->db->updateUser($currentUserData['id_uzivatel'], $currentUserData['login'], $currentUserData['heslo'], $currentUserData['jmeno'], $currentUserData['email'], $currentUserData['id_pravo'], $_POST['kurz']);
            if ($ok) {
                $tplData['message'] = "OK: Kurz uživatele s ID: {$_POST['id_uzivatel']} byl aktualizován.";
            } else {
                $tplData['message'] = "CHYBA: Kurz uživatele s ID: {$_POST['id_uzivatel']} se nepodařilo aktualizovat.";
            }
        }


        //// nactu aktualni data uzivatelu
        $tplData['users'] = $this->db->getAllUsers();
        $tplData['rights'] = $this->db->getAllRights();
        $tplData['courses']= $this->db->getAllCourses();

        // vratim sablonu naplnenou daty
        return $tplData;
    }


}

?>
