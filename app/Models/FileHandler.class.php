<?php
namespace kivweb\Models;

class FileHandler {
    public static function processImageUpload($file): ?string {
        if ($file['error'] == UPLOAD_ERR_OK) {
            $imageTmpPath = $file['tmp_name'];
            $imageName = $file['name'];

            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileMimeType = mime_content_type($imageTmpPath);

            if (!in_array($fileMimeType, $allowedMimeTypes)) {
                return null; // Неподдерживаемый формат файла
            }

            list($width, $height) = getimagesize($imageTmpPath);

            $maxWidth = 800;
            $maxHeight = 600;

            if ($width > $maxWidth || $height > $maxHeight) {
                $ratio = $width > $height ? $maxWidth / $width : $maxHeight / $height;
                $newWidth = $width * $ratio;
                $newHeight = $height * $ratio;

                $srcImage = imagecreatefromstring(file_get_contents($imageTmpPath));
                $dstImage = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                $uploadDir = 'uploads/comments/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                $imagePath = $uploadDir . uniqid() . '-' . basename($imageName);
                imagejpeg($dstImage, $imagePath);

                imagedestroy($srcImage);
                imagedestroy($dstImage);
            } else {
                $uploadDir = 'uploads/comments/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                $imagePath = $uploadDir . uniqid() . '-' . basename($imageName);
                move_uploaded_file($imageTmpPath, $imagePath);
            }

            return $imagePath;
        }

        return null;
    }

}

?>