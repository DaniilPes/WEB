<?php

namespace kivweb\Controllers;

use kivweb\Models\DatabaseModel;

/**
 * Контроллер для обработки логики входа и выхода пользователей.
 */
class LoginController implements IController {

    private $db;

    public function __construct() {
        // Инициализация модели базы данных
        $this->db = DatabaseModel::getDatabaseModel();
    }

    private function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
            $login = trim($_POST['login'] ?? '');
            $password = trim($_POST['heslo'] ?? '');

            if ($this->db->userLogin($login, $password)) {
                header("Location: index.php?page=login");
                exit;
            } else {
                return ['error' => 'Неверный логин или пароль.'];
            }
        }

        return [];
    }

    private function handleLogout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
            $this->db->userLogout();
            header("Location: index.php?page=login");
            exit;
        }
    }

    public function show(string $pageTitle): array {
        // Обработка входа и выхода
        $loginErrors = $this->handleLogin();
        $this->handleLogout();

        $tplData = [];
        $tplData['title'] = $pageTitle;

        if ($this->db->isUserLogged()) {
            $user = $this->db->getLoggedUserData();
            $userRight = $this->db->getRightById($user['id_pravo']);
            $userCourse = $this->db->getCourseById($user['id_kurz']);

            $tplData['user'] = $user;
            $tplData['userRight'] = $userRight['jemno'] ?? '*Neznámé*';
            $tplData['userCourse'] = $userCourse['nazev'] ?? '*Neznámé*';
        }

        // Соединяем ошибки с данными для шаблона
        return array_merge($tplData, $loginErrors);
    }
}
