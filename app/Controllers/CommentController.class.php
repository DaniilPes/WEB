<?php
namespace kivweb\Controllers;

use kivweb\Models\DatabaseModel;
use kivweb\Models\FileHandler;
use HTMLPurifier;
use HTMLPurifier_Config;


class CommentController implements IController {
    private $db;

    public function __construct() {
        $this->db = DatabaseModel::getDatabaseModel();
    }

    public function handleComments(): array {
        $comments = $this->db->getAllComments(); // getAllComments уже использует защищенные запросы
        $result = [];

        foreach ($comments as $comment) {
            $result[] = [
                'id_comment' => htmlspecialchars($comment['id_comment'], ENT_QUOTES),
//                'text' => htmlspecialchars($comment['text'], ENT_QUOTES),
                'text' => $comment['text'],
                'image_path' => htmlspecialchars($comment['image_path'], ENT_QUOTES),
                'autor_name' => htmlspecialchars($comment['autor_name'], ENT_QUOTES),
                'right' => htmlspecialchars($comment['right'], ENT_QUOTES),
                'course' => htmlspecialchars($comment['course'], ENT_QUOTES),
            ];
        }

        return $result;
    }

    private function processImageUpload(array $fileData): ?string {
        $uploadDir = 'uploads/comments/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $tmpPath = $fileData['tmp_name'];
        $fileName = uniqid() . '-' . basename($fileData['name']);
        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($tmpPath, $destination)) {
            return $destination;
        }

        return null;
    }

    public function show(string $pageTitle): array{
        $this->handleCommentActions();
        $tplData = [];
        $tplData['title'] = $pageTitle;
        $tplData['isLogged'] = $this->db->isUserLogged();
        $tplData['comments'] = $this->handleComments();
        $tplData['user'] = $this->db->getLoggedUserData();

        return $tplData; // Возвращаем данные для шаблона
    }

    public function handleCommentActions() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['new_comment'], $_POST['comment_text'])) {
                $user = $this->db->getLoggedUserData();
                if (!$user) {
                    $_SESSION['message'] = "Ошибка: Вы должны быть авторизованы, чтобы добавить комментарий.";
                    header("Location: index.php?page=login");
                    exit();
                }

                // Проверяем входящие данные
                $rawHtml = $_POST['comment_text'];

                // Настройка HTMLPurifier
                $config = HTMLPurifier_Config::createDefault();
                $config->set('HTML.Allowed', 'p,strong,em,a[href],img[src],ul,ol,li,br');
                $config->set('Cache.SerializerPath', __DIR__ . '/../cache/htmlpurifier');
                $purifier = new HTMLPurifier($config);
                $cleanHtml = $purifier->purify($rawHtml);


                // Сохраняем очищенный HTML
                $text = $cleanHtml;
                $imagePath = null;

                if (!empty($_FILES['comment_image']['tmp_name'])) {
                    $imagePath = $this->processImageUpload($_FILES['comment_image']);
                }

                $result = $this->db->addComment($user['id_uzivatel'], $text, $imagePath);
                if ($result) {
                    $_SESSION['message'] = "Комментарий успешно добавлен.";
                } else {
                    $_SESSION['message'] = "Ошибка: Не удалось добавить комментарий.";
                }

                header("Location: index.php?page=comments");
                exit();
            }
        }
    }


//    public function handleCommentActions() {
//        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//            if (isset($_POST['new_comment'], $_POST['comment_text'])) {
//                $user = $this->db->getLoggedUserData();
//                if (!$user) {
//                    $_SESSION['message'] = "Ошибка: Вы должны быть авторизованы, чтобы добавить комментарий.";
//                    header("Location: index.php?page=login");
//                    exit();
//                }
//
//                // Проверяем входящие данные
//                $rawHtml = $_POST['comment_text'];
//                var_dump($rawHtml); // Отладка: проверьте сырые данные
//                die();
//
//                // Настройка HTMLPurifier
//                $config = HTMLPurifier_Config::createDefault();
//                $config->set('HTML.Allowed', 'p,strong,em,a[href],img[src],ul,ol,li,br');
//                $config->set('Cache.SerializerPath', __DIR__ . '/../cache/htmlpurifier');
//                $purifier = new HTMLPurifier($config);
//                $cleanHtml = $purifier->purify($rawHtml);
//                var_dump($cleanHtml); // Отладка: проверьте очищенные данные
//                die();
//
//                // Сохраняем очищенный HTML
//                $text = $cleanHtml;
//                $imagePath = null;
//
//                if (!empty($_FILES['comment_image']['tmp_name'])) {
//                    $imagePath = $this->processImageUpload($_FILES['comment_image']);
//                }
//
//                $result = $this->db->addComment($user['id_uzivatel'], $text, $imagePath);
//                if ($result) {
//                    $_SESSION['message'] = "Комментарий успешно добавлен.";
//                } else {
//                    $_SESSION['message'] = "Ошибка: Не удалось добавить комментарий.";
//                }
//
//                header("Location: index.php?page=comments");
//                exit();
//            }
//        }
//    }




}
?>