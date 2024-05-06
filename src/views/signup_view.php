<!doctype html>
<html lang="pl">
<head>
    <?php require_once 'partial/default_head.php' ?>
    <title>Założ konto</title>
</head>
<body>
<?php require 'partial/messages.php' ?>
<div class="main-container">
    <div class="nav-bar">
        <a href="/">Home</a>
    </div>
    <h1><i>Signup</i></h1>
    <div class="form-container">
        <form method="post" action="/signup">
            <label>Login:</label>
            <input type="text" name="login" required>
            <label>Adres e-mail:</label>
            <input type="email" name="email" required>
            <label>Hasło:</label>
            <input type="password" name="password" required>
            <label>Powtórz hasło:</label>
            <input type="password" name="repeat_password" required>
            <input type="submit" value="Założ konto">
        </form>
    </div>
</div>
</html>