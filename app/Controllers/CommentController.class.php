<?php
namespace kivweb\Controllers;

use kivweb\Models\DatabaseModel;
use kivweb\Models\FileHandler;

class CommentController implements IController {
    private $db;

    public function __construct() {
        $this->db = DatabaseModel::getDatabaseModel();
    }

    public function handleComments(): array {
        // Получаем комментарии
        $comments = $this->db->getAllComments();
        $result = [];

        foreach ($comments as $comment) {
            $commentUser = $this->db->getUserById($comment['autor_id']);
            $result[] = [
                'id_comment' => $comment['id_comment'],
                'text' => $comment['text'],
                'image_path' => $comment['image_path'],
                'autor_name' => $commentUser['jmeno'],
                'right' => $commentUser['id_pravo'],
                'course' => $commentUser['id_kurz']
            ];
        }

        return $result;
    }

    public function handleCommentActions() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Удаление комментария
            if (isset($_POST['delete_comment'], $_POST['id_comment'])) {
                $commentId = intval($_POST['id_comment']);
                $result = $this->db->deleteCommentById($commentId);

                if ($result) {
                    $_SESSION['message'] = "Komentář byl úspěšně smazán.";
                } else {
                    $_SESSION['message'] = "Chyba: Komentář se nepodařilo smazat.";
                }

                header("Location: index.php?page=comments");
                exit();
            }

            // Добавление нового комментария
            if (isset($_POST['new_comment'], $_POST['comment_text'])) {
                $user = $this->db->getLoggedUserData();
                if (!$user) {
                    $_SESSION['message'] = "Chyba: Musíte být přihlášeni k přidání komentáře.";
                    header("Location: index.php?page=login");
                    exit();
                }

                $text = htmlspecialchars($_POST['comment_text'], ENT_QUOTES);
                $imagePath = null;

                // Обработка изображения через FileHandler
                if (!empty($_FILES['comment_image']['tmp_name'])) {
                    $imagePath = FileHandler::processImageUpload($_FILES['comment_image']);
                    if (!$imagePath) {
                        $_SESSION['message'] = "Chyba: Obrázek se nepodařilo nahrát.";
                        header("Location: index.php?page=comments");
                        exit();
                    }
                }

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




}
?>