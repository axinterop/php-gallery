<!doctype html>
<html lang="pl">
<head>
    <?php require_once 'partial/default_head.php' ?>
    <title>Wyślij zdjęcie</title>
</head>
<body>
<?php require 'partial/messages.php' ?>
<div class="main-container">
    <div class="nav-bar">
        <a href="/">Home</a>
    </div>
    <h1><i>Upload image</i></h1>
    <div class="form-container">
        <form id="upload-image" method="POST" action="/image/upload" enctype="multipart/form-data">
            <label>Autor:</label>
            <?php if ($user): ?>
                <input type="text" name="author" placeholder="<?= $user['login'] ?>" disabled>
            <?php else: ?>
                <input type="text" name="author" required>
            <?php endif; ?>
            <label>Tytuł:</label>
            <input type="text" name="title" required>
            <label>Znak wodny:</label>
            <input type="text" name="watermark" required maxlength="20">
            <label>Zdjęcie (max 1 MB, jpg/png):</label>
            <input type="file" name="image" required>
            <?php if ($user): ?>
                <div class="radio-group">
                    <input id="public" type="radio" name="visibility" value="public" checked>
                    <label for="public">Publiczne</label>
                    <input id="private" type="radio" name="visibility" value="private">
                    <label for="private">Prywatne</label>
                </div>
            <?php endif; ?>
            <input type="submit" value="Wyślij">
        </form>
    </div>
</div>
</body>
</html>