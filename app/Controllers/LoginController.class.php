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

    public function handleLogin() {
        // Обработка входа
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'login') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['heslo'] ?? '';

            if ($this->db->userLogin($login, $password)) {
                header("Location: index.php?page=login");
                exit;
            } else {
                return ['error' => 'Неверный логин или пароль.'];
            }
        }

        return [];
    }

    public function handleLogout() {
        // Обработка выхода
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'logout') {
            $this->db->userLogout();
            header("Location: index.php?page=login");
            exit;
        }
    }

    public function show(string $pageTitle): array{
        $this->handleLogin();
        $this->handleLogout();
        $tplData = [];
        // nazev
        $tplData['title'] = $pageTitle;
        // Проверка, авторизован ли пользователь
        if ($this->db->isUserLogged()) {
            $user = $this->db->getLoggedUserData();
            $userRight = $this->db->getRightById($user['id_pravo']);
            $userCourse = $this->db->getCourseById($user['id_kurz']);

            $tplData['user'] = $user;
            $tplData['userRight'] = $userRight['jemno'] ?? '*Neznámé*';
            $tplData['userCourse'] =  $userCourse['nazev'] ?? '*Neznámé*';

        }

        return $tplData;
    }
}
