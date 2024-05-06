<!doctype html>
<html lang="en">
<head>
    <?php require_once 'partial/default_head.php' ?>
    <title>Zapamiętane zdjęcia</title>
</head>
<body>
<?php require 'partial/messages.php' ?>
<div class="main-container">
    <div class="nav-bar">
        <a href="/">Home</a>
    </div>
    <h1><i>Zapamiętane</i></h1>
    <?php if (count($images) != 0): ?>
        <div class="images">
            <?php require_once 'partial/gallery_show_images.php'; ?>
        </div>
        <div>
            <form id="rem_img_form" method="post" action="/image/forget">
                <input type="submit" value="Usuń zaznaczone z zapamiętanych">
            </form>
        </div>
    <?php else: ?>
        <div>Nie ma zapamiętanych zdjęć :(</div>
    <?php endif; ?>
</div>
</body>
</html>