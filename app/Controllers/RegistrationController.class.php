<?php

namespace kivweb\Controllers;

use kivweb\Models\DatabaseModel;

class RegistrationController implements IController {
    private $db;

    public function __construct() {
        $this->db = DatabaseModel::getDatabaseModel();
    }

    private function processRegistration(array $postData): string {
        // Проверка данных
        if (
            empty($postData['login']) ||
            empty($postData['heslo']) ||
            empty($postData['heslo2']) ||
            empty($postData['jmeno']) ||
            empty($postData['email']) ||
            empty($postData['kurz']) ||
            $postData['heslo'] !== $postData['heslo2']
        ) {
            return "ERROR: Все поля должны быть заполнены, и пароли должны совпадать.";
        }

        // Проверка уникальности логина
        if ($this->db->getUserByLogin($postData['login'])) {
            return "ERROR: Пользователь с таким логином уже существует.";
        }

        // Добавление пользователя
        $success = $this->db->addNewUser(
            htmlspecialchars($postData['login'], ENT_QUOTES),
            htmlspecialchars($postData['heslo'], ENT_QUOTES),
            htmlspecialchars($postData['jmeno'], ENT_QUOTES),
            htmlspecialchars($postData['email'], ENT_QUOTES),
            3, // Роль пользователя по умолчанию
            intval($postData['kurz'])
        );

        return $success ? "OK: Пользователь успешно зарегистрирован." : "ERROR: Ошибка регистрации пользователя.";
    }

    public function show(string $pageTitle): array {
        $tplData = [
            'title' => $pageTitle,
            'isLogged' => $this->db->isUserLogged(),
            'message' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['potvrzeni'])) {
            $tplData['message'] = $this->processRegistration($_POST);
        }

        if (!$tplData['isLogged']) {
            $tplData['courses'] = $this->db->getAllCourses();
        }

        return $tplData;
    }
}
