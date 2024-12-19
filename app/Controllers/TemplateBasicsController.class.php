<?php

namespace App\Controllers;

use kivweb\Models\DatabaseModel;

global $tplData;

class TemplateController {
//    private $template;
    private $db;

    public function __construct() {
        // Создание экземпляра TemplateBasics и DatabaseModel
        $this->db = DatabaseModel::getDatabaseModel();
//        $this->template = new TemplateBasics();
    }



    /**
     * Генерация общей страницы с динамическим заголовком и содержимым.
     * @param string $pageType
     */
    public function show(string $pageType) {
        // Проверка статуса авторизации пользователя
        $isLogged = $this->db->isUserLogged();
        $userData = null;
        if ($isLogged) {
            $userData = $this->db->getLoggedUserData();
        }

        // Подготовка данных для шаблона
        $tplData = [
            'title' => 'Code Academy - ' . ucfirst($pageType), // Заголовок страницы
            'isLogged' => $isLogged,
            'user' => $userData
        ];

        // Вызов класса TemplateBasics для отображения
        return $tplData;
//        $this->template->printOutput($tplData, $pageType);
    }
}
