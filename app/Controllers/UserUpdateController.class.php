<?php

namespace kivweb\Controllers;

use kivweb\Models\DatabaseModel;

class UserUpdateController implements IController {
    private $db;

    public function __construct()
    {
        $this->db = DatabaseModel::getDatabaseModel();
    }

    public function show(string $pageTitle): array{
        $tplData = [];
        $tplData['title'] = $pageTitle;
        // Проверяем, авторизован ли пользователь
        if (!$this->db->isUserLogged()) {
            $tplData['isLogged'] = false;
            return $tplData;
        }
        $userData = $this->db->getLoggedUserData();

        $tplData['isLogged'] = true;
        $tplData['userData'] = $userData;
        $tplData['rights'] = $this->db->getAllRights();
        $tplData['courses'] = $this->db->getAllCourses();


        $tplData['kurz_id'] =
            $userData['id_kurz'];

//        $tplData['userData']['kurz_id'] =

        $tplData['message'] = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['potvrzeni'])) {
            $currentData = $tplData['userData'];

            $heslo = !empty($_POST['heslo']) ? $_POST['heslo'] : $currentData['heslo'];
            $jmeno = !empty($_POST['jmeno']) ? $_POST['jmeno'] : $currentData['jmeno'];
            $email = !empty($_POST['email']) ? $_POST['email'] : $currentData['email'];
            $pravo = !empty($_POST['pravo']) ? intval($_POST['pravo']) : $currentData['id_pravo'];
            $kurz = !empty($_POST['kurz']) ? intval($_POST['kurz']) : $currentData['kurz_id'];

            if (!empty($_POST['heslo_puvodni']) && $_POST['heslo_puvodni'] === $currentData['heslo']) {
                $res = $this->db->updateUser($currentData['id_uzivatel'], $currentData['login'], $heslo, $jmeno, $email, $pravo, $kurz);

                if ($res) {
                    $tplData['message'] = "OK: personal data was updated.";
                    $tplData['userData'] = $this->db->getLoggedUserData();
                } else {
                    $tplData['message'] = "ERROR. Cannot change user data";
                }
            } else {
                $tplData['message'] = "ERROR: incorrect password.";
            }
        }

        return $tplData;
    }

}
?>