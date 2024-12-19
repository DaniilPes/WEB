<?php

namespace kivweb\Models;

/**
 * Класс для работы с сессиями.
 * Отвечает за добавление, чтение и удаление данных сессий.
 */
class MySession {

    /**
     * Конструктор. Инициирует сессию.
     */
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Запускаем сессию, если она еще не запущена.
        }
    }

    /**
     * Добавляет значение в сессию.
     * @param string $name Имя ключа.
     * @param mixed $value Значение для сохранения.
     */
    public function addSession(string $name, $value) {
        $_SESSION[$name] = $value;
    }

    /**
     * Возвращает значение из сессии по ключу.
     * @param string $name Имя ключа.
     * @return mixed|null Возвращает значение или null, если ключ не существует.
     */
    public function readSession(string $name) {
        return $this->isSessionSet($name) ? $_SESSION[$name] : null;
    }

    /**
     * Проверяет, существует ли ключ в сессии.
     * @param string $name Имя ключа.
     * @return bool Возвращает true, если ключ существует, иначе false.
     */
    public function isSessionSet(string $name): bool {
        return isset($_SESSION[$name]);
    }

    /**
     * Удаляет значение из сессии по ключу.
     * @param string $name Имя ключа.
     */
    public function removeSession(string $name) {
        unset($_SESSION[$name]);
    }

    /**
     * Завершает текущую сессию и очищает данные.
     */
    public function destroySession(){
        session_destroy();
    }
}
