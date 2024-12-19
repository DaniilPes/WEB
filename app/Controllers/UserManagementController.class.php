<?php

namespace kivweb\Controllers;

use kivweb\Models\DatabaseModel as MyDB;

class UserManagementController implements IController {

    private $db;

    public function __construct() {
        $this->db = MyDB::getDatabaseModel();
    }

    public function show(string $pageTitle): array {
        $tplData = [
            'title' => $pageTitle,
            'message' => ''
        ];

        $loggedUser = $this->db->getLoggedUserData();

        if (!$this->db->isUserLogged() || $loggedUser['id_pravo'] > 2) {
            $tplData['message'] = "Tato strána je dostupná pouze administrátorům.";
            return $tplData;
        }

        // Обработка запросов
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete_user'], $_POST['id_uzivatel'])) {
                $userId = intval($_POST['id_uzivatel']);
                if ($this->db->deleteUser($userId)) {
                    $tplData['message'] = "OK: Uživatel s ID {$userId} byl úspěšně smazán.";
                } else {
                    $tplData['message'] = "CHYBA: Nepodařilo se smazat uživatele s ID {$userId}.";
                }
            } elseif (isset($_POST['aktualizace_pravo'], $_POST['id_uzivatel'], $_POST['pravo'])) {
                $userId = intval($_POST['id_uzivatel']);
                $rightId = intval($_POST['pravo']);
                $user = $this->db->getUserById($userId);
                if ($user && $this->db->updateUser($user['id_uzivatel'], $user['login'], $user['heslo'], $user['jmeno'], $user['email'], $rightId, $user['id_kurz'])) {
                    $tplData['message'] = "OK: Právo uživatele s ID {$userId} bylo aktualizováno.";
                } else {
                    $tplData['message'] = "CHYBA: Nepodařilo se aktualizovat právo uživatele s ID {$userId}.";
                }
            } elseif (isset($_POST['aktualizace_kurz'], $_POST['id_uzivatel'], $_POST['kurz'])) {
                $userId = intval($_POST['id_uzivatel']);
                $courseId = intval($_POST['kurz']);
                $user = $this->db->getUserById($userId);
                if ($user && $this->db->updateUser($user['id_uzivatel'], $user['login'], $user['heslo'], $user['jmeno'], $user['email'], $user['id_pravo'], $courseId)) {
                    $tplData['message'] = "OK: Kurz uživatele s ID {$userId} byl aktualizován.";
                } else {
                    $tplData['message'] = "CHYBA: Nepodařilo se aktualizovat kurz uživatele s ID {$userId}.";
                }
            }
        }

        // Загрузка данных для шаблона
        $tplData['users'] = $this->db->getAllUsers();
        $tplData['rights'] = $this->db->getAllRights();
        $tplData['courses'] = $this->db->getAllCourses();

        return $tplData;
    }
}
