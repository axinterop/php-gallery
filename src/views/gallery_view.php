<!doctype html>
<html lang="pl">
<head>
    <?php require_once 'partial/default_head.php' ?>
    <title>Galeria</title>
</head>
<body>
<?php require 'partial/messages.php' ?>
<div class="main-container">
    <div class="nav-bar">
        <a href="/">Home</a>
    </div>
    <h1><i>Galeria</i></h1>
    <?php
    if (count($images) !== 0): ?>
        <?php require 'partial/gallery_count_pages.php'; ?>
        <?php require_once 'partial/gallery_show_images.php'; ?>
        <div>
            <form id="rem_img_form" method="post" action="/image/remember">
                <input type="submit" value="Zapamiętaj wybrane">
            </form>
        </div>
    <?php else: ?>
        <div>Nie ma zdjęć w galerii :(</div>
    <?php endif; ?>
</div>
</body>
</html>