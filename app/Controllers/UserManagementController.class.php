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
            $tplData['message'] = "This page is only available for administrators.";
            return $tplData;
        }

        // Request handling
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete_user'], $_POST['id_uzivatel'])) {
                $userId = intval($_POST['id_uzivatel']);
                if ($this->db->deleteUser($userId)) {
                    $tplData['message'] = "OK: User with ID {$userId} was successfully deleted.";
                } else {
                    $tplData['message'] = "ERROR: Failed to delete user with ID {$userId}.";
                }
            } elseif (isset($_POST['aktualizace_pravo'], $_POST['id_uzivatel'], $_POST['pravo'])) {
                $userId = intval($_POST['id_uzivatel']);
                $rightId = intval($_POST['pravo']);
                $user = $this->db->getUserById($userId);
                if ($user && $this->db->updateUser($user['id_uzivatel'], $user['login'], $user['heslo'], $user['jmeno'], $user['email'], $rightId, $user['id_kurz'])) {
                    $tplData['message'] = "OK: The rights of user with ID {$userId} were updated.";
                } else {
                    $tplData['message'] = "ERROR: Failed to update rights for user with ID {$userId}.";
                }
            } elseif (isset($_POST['aktualizace_kurz'], $_POST['id_uzivatel'], $_POST['kurz'])) {
                $userId = intval($_POST['id_uzivatel']);
                $courseId = intval($_POST['kurz']);
                $user = $this->db->getUserById($userId);
                if ($user && $this->db->updateUser($user['id_uzivatel'], $user['login'], $user['heslo'], $user['jmeno'], $user['email'], $user['id_pravo'], $courseId)) {
                    $tplData['message'] = "OK: The course of user with ID {$userId} was updated.";
                } else {
                    $tplData['message'] = "ERROR: Failed to update course for user with ID {$userId}.";
                }
            }
        }

        // Load data for template
        $tplData['users'] = $this->db->getAllUsers();
        $tplData['rights'] = $this->db->getAllRights();
        $tplData['courses'] = $this->db->getAllCourses();

        return $tplData;
    }
}
