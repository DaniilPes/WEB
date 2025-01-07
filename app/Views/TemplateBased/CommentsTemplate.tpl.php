<?php
global $tplData;
?>

<link rel="stylesheet" href="public/MyCss/comments.css">
<link rel="stylesheet" href="public/MyCss/pre-main.css">
<link rel="stylesheet" href="public/MyCss/Responzivita.css">
<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<div class="comments-section">
    <?php if ($tplData['isLogged']): ?>
        <?php foreach ($tplData['comments'] as $comment):
            $commentClass = '';
            if ($comment['right'] == 'SuperAdmin') { // Суперадмин
                $commentClass = 'superadmin-comment';
            } elseif ($comment['right'] == 'Admin') { // Админ
                $commentClass = 'admin-comment';
            }

        ?>


            <div class="comment <?= $commentClass ?>">
                <div class="comment-header">
                    <span class="author"><strong>Autor:</strong> <?= htmlspecialchars($comment['autor_name']) ?></span>
                    <span class="right"><strong>Rights:</strong> <?= htmlspecialchars($comment['right']) ?></span>
                    <span class="course"><strong>Course:</strong> <?= htmlspecialchars($comment['course']) ?></span>
                </div>
                <div class="comment-text">
<!--                    --><?php //= htmlspecialchars($comment['text']) ?>
                    <?= $comment['text'] ?>
<!--                    --><?php //= html_entity_decode($comment['text'], ENT_QUOTES | ENT_HTML5, 'UTF-8') ?>
<!--                    --><?php //= htmlspecialchars_decode($comment['text'], ENT_QUOTES) ?>
                    <?php if (!empty($comment['image_path'])): ?>
                        <div class="comment-image">
                            <img src="<?= htmlspecialchars($comment['image_path']) ?>" alt="Comment Image">
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($tplData['user']['id_pravo'] < 2): ?>
                    <div class="comment-actions">
                        <form action="index.php?page=comments" method="POST">
                            <input type="hidden" name="id_comment" value="<?= htmlspecialchars($comment['id_comment']) ?>">
                            <input type="submit" name="delete_comment" value="Delete">
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="new-comment">
            <form action="index.php?page=comments" method="POST" enctype="multipart/form-data">
                <textarea id="comment_text" name="comment_text" placeholder="Your comment..." required></textarea>
                <input type="file" name="comment_image" accept="image/*">
                <input type="submit" name="new_comment" value="Add comment">
            </form>
        </div>
    <?php else: ?>
        <p>Please, <a href="index.php?page=login">Log in</a>, to leave a comment.</p>
    <?php endif; ?>


</div>
<script>
    // Инициируем CKEditor на нашем textarea
    CKEDITOR.replace('comment_text');
</script>