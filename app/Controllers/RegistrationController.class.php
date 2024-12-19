<?php

namespace kivweb\Controllers;

use kivweb\Models\DatabaseModel;

class RegistrationController implements IController {
    private $db;

    public function __construct() {
        $this->db = DatabaseModel::getDatabaseModel();
    }


    private function processRegistration($postData) {
        // Проверка данных
        if (empty($postData['login']) || empty($postData['heslo']) || empty($postData['heslo2']) ||
            empty($postData['jmeno']) || empty($postData['email']) || empty($postData['kurz']) ||
            $postData['heslo'] !== $postData['heslo2']
        ) {
            return "ERROR: Не были заполнены все обязательные поля или пароли не совпадают.";
        }

        // Добавление пользователя
        $success = $this->db->addNewUser(
            $postData['login'],
            $postData['heslo'],
            $postData['jmeno'],
            $postData['email'],
            3, // Роль пользователя по умолчанию
            $postData['kurz']
        );

        if ($success) {
            return "OK: Пользователь был успешно зарегистрирован.";
        } else {
            return "ERROR: Ошибка регистрации пользователя.";
        }
    }

    public function show(string $pageTitle): array{
        $tplData['title'] = $pageTitle;
        $tplData['isLogged'] = $this->db->isUserLogged();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['potvrzeni'])) {
                $tplData['error'] = $this->processRegistration($_POST);
            }
        }

        if (!$tplData['isLogged']) {
            $tplData['courses'] = $this->db->getAllCourses();
        }
        return $tplData;
    }
}
