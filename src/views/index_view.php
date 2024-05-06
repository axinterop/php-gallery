<!doctype html>
<html lang="pl">
<head>
    <?php require_once 'partial/default_head.php' ?>
    <title>Home</title>
</head>
<body>
<?php require 'partial/messages.php' ?>
<div class="main-container">
    <h1><i>Index PHP</i></h1>

    <div class="welcome-msg">
        <?php if ($user !== null): ?>
            Cześć, <b><?= $user['login'] ?>!</b>
        <?php else: ?>
            Nie jesteś zalogowany/-a.
        <?php endif; ?>
    </div>

    <div class="home-nav nav-bar">
        <ul>
            <li><a href="/gallery">Galeria</a></li>
            <li><a href="/image/upload">Dodaj zdjęcie</a></li>
            <li><a href="/gallery/remembered">Pokaż zapamiętane</a></li>
            <li><a href="/image/search">Szukaj</a></li>
            <br>
            <?php if (!$user): ?>
                <li><a href="/login">Zaloguj się</a></li>
                <li><a href="/signup">Załóż konto</a></li>
            <?php endif ?>
            <?php if ($user): ?>
                <li><a href="/logout">Wyloguj się</a></li>
            <?php endif ?>
        </ul>
    </div>
</div>
</html>