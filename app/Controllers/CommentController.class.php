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
        $comments = $this->db->getAllComments(); // getAllComments save
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

        return $tplData;
    }

    public function handleCommentActions() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Добавление нового комментария
            if (isset($_POST['new_comment'], $_POST['comment_text'])) {
                $user = $this->db->getLoggedUserData();
                if (!$user) {
                    $_SESSION['message'] = "ERROR: Log in to add a comment.";
                    header("Location: index.php?page=login");
                    exit();
                }

                // Получаем и обрабатываем данные
                $rawHtml = $_POST['comment_text'];

                $config = HTMLPurifier_Config::createDefault();
                $config->set('HTML.Allowed', 'p,strong,em,a[href],img[src],ul,ol,li,br,s,del');
                $config->set('Cache.SerializerPath', __DIR__ . '/../cache/htmlpurifier');
                $purifier = new HTMLPurifier($config);
                $cleanHtml = $purifier->purify($rawHtml);

                // Сохраняем очищенные данные
                $text = $cleanHtml;
                $imagePath = null;

                if (!empty($_FILES['comment_image']['tmp_name'])) {
                    $imagePath = $this->processImageUpload($_FILES['comment_image']);
                }

                $result = $this->db->addComment($user['id_uzivatel'], $text, $imagePath);
                if ($result) {
                    $_SESSION['message'] = "Comment is added.";
                } else {
                    $_SESSION['message'] = "Error: cannot add a comment.";
                }

                header("Location: index.php?page=comments");
                exit();
            }

            // Удаление комментария
            if (isset($_POST['delete_comment'], $_POST['id_comment'])) {
                $user = $this->db->getLoggedUserData();
                if (!$user || $user['id_pravo'] >= 2) {
                    $_SESSION['message'] = "Error: You have no permissions to delete a comment.";
                    header("Location: index.php?page=comments");
                    exit();
                }

                $commentId = intval($_POST['id_comment']); // Приводим к числу для безопасности
                $result = $this->db->deleteCommentById($commentId);

                if ($result) {
                    $_SESSION['message'] = "Succesfully deleted.";
                } else {
                    $_SESSION['message'] = "Error: cannot add a comment.";
                }

                header("Location: index.php?page=comments");
                exit();
            }
        }
    }

}
?>