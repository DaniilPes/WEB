<?php
global $tplData;
?>

<link rel="stylesheet" href="public/MyCss/comments.css">
<link rel="stylesheet" href="public/MyCss/pre-main.css">
<link rel="stylesheet" href="public/MyCss/Responzivita.css">

<style>
    body {
        background: radial-gradient(
                farthest-corner at 100px 300px,
                #232a42 10%,
                #0e111a 90%
        );
        margin: 0;
        padding: 0;
        border: 0;
        height: 100%;
    }
    .divNav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #0e111a;
        background-image: linear-gradient(
                to right,
                rgba(145,30,30,0.9),
                rgba(30,30,165,0.8));
        height: 10vh;
    }
</style>

<div class="comments-section">
    <?php if ($tplData['isLogged']): ?>
        <?php foreach ($tplData['comments'] as $comment): ?>
            <div class="comment">
                <div class="comment-header">
                    <span class="author"><strong>Autor:</strong> <?= htmlspecialchars($comment['autor_name']) ?></span>
                    <span class="right"><strong>Pravo:</strong> <?= htmlspecialchars($comment['right']) ?></span>
                    <span class="course"><strong>Kurz:</strong> <?= htmlspecialchars($comment['course']) ?></span>
                </div>
                <div class="comment-text">
                    <?= htmlspecialchars($comment['text']) ?>
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
                            <input type="submit" name="delete_comment" value="Smazat">
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="new-comment">
            <form action="index.php?page=comments" method="POST" enctype="multipart/form-data">
                <textarea name="comment_text" placeholder="Your comment..." required></textarea>
                <input type="file" name="comment_image" accept="image/*">
                <input type="submit" name="new_comment" value="Add comment">
            </form>
        </div>
    <?php else: ?>
        <p>Please, <a href="index.php?page=login">Log in</a>, to leave a comment.</p>
    <?php endif; ?>
</div>
