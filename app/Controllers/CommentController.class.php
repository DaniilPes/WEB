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

            // Добавление нового комментария
            if (isset($_POST['new_comment'], $_POST['comment_text'])) {
                $user = $this->db->getLoggedUserData();
                if (!$user) {
                    $_SESSION['message'] = "Chyba: Musíte být přihlášeni k přidání komentáře.";
                    header("Location: index.php?page=login");
                    exit();
                }

                // получаем «сырой» HTML-текст от CKEditor
                $rawHtml = $_POST['comment_text'];

                // 1) создаем конфигурацию Purifier
                $config = HTMLPurifier_Config::createDefault();
                // -- при необходимости добавить дополнительные настройки, например:
                //    $config->set('HTML.Allowed', 'p,strong,em,ul,li,a[href],img[src]');
                //    $config->set('AutoFormat.AutoParagraph', false);

                // 2) создаем объект Purifier
                $purifier = new HTMLPurifier($config);

                // 3) «очищаем» HTML
                $cleanHtml = $purifier->purify($rawHtml);

                // Теперь $cleanHtml содержит «безопасный» HTML,
                // в котором потенциально вредоносные теги/скрипты удалены.

                // Далее можно сохранять «очищенный» HTML в базу
                $text = $cleanHtml;

                $imagePath = null;
                // ... код обработки загрузки изображения ...

                $result = $this->db->addComment($user['id_uzivatel'], $text, $imagePath);

                if ($result) {
                    $_SESSION['message'] = "Komentář byl úspěšně přidán.";
                } else {
                    $_SESSION['message'] = "Chyba: Komentář se nepodařilo přidat.";
                }

                header("Location: index.php?page=comments");
                exit();
            }
        }
    }



}
?>