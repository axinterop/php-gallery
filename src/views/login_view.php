<!doctype html>
<html lang="pl">
<head>
    <?php require_once 'partial/default_head.php' ?>
    <title>Zaloguj się</title>
</head>
<body>
<?php require 'partial/messages.php' ?>
<div class="main-container">
    <div class="nav-bar">
        <a href="/">Home</a>
    </div>
    <h1><i>Login</i></h1>
    <div class="form-container">
        <form method="post" action="/login">
            <input type="text" name="login" placeholder="Login..." required>
            <br>
            <input type="password" name="password" placeholder="Hasło..." required>
            <br>
            <input type="submit" value="Zaloguj się">
        </form>
    </div>
</div>
</html>