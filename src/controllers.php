<?php
require_once 'business.php';
require_once 'controller_utils.php';

function home_show(&$model)
{
    $model['user'] = get_authenticated_user();
    return 'index_view';
}

function image_upload(&$model)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $file = $_FILES['image'];

        $err = 0;
        if (!check_mime_type($file)) {
            flash('Niepoprawny format pliku.', 'err');
            $err += 1;
        }

        if (!check_file_size($file)) {
            flash('Plik jest za duży.', 'err');
            $err += 1;
        }

        if ($err === 0) {
            if (isset($_POST['author']) && !is_authenticated())
                $author = $_POST['author'];
            else
                $author = get_authenticated_user()['login'];

            $title = $_POST['title'];
            $watermark = $_POST['watermark'];

            $private = false;
            if (isset($_POST['visibility'])) {
                $visibility = $_POST['visibility'];
                if ($visibility === "private")
                    $private = true;
            }

            upload_img_server($file, $watermark);
            save_img_db($file, $watermark, $author, $title, $private);
            flash("Zdjęcie zostało dodane!", 'suc');
            return "redirect:/gallery";
        }

        return 'redirect:/image/upload';
    }
    $model['user'] = get_authenticated_user();
    return 'upload_image_view';
}


function gallery_show(&$model)
{
    $page_size = 3;
    if (!empty($_GET['page']))
        $page = $_GET['page'];
    else
        $page = 1;
    $images = get_img_pages($page, $page_size)->toArray();

    $pages = intdiv(get_img_count() - 1, $page_size) + 1;
    $img_memory = get_img_memory();

    $model['images'] = $images;
    $model['current_page'] = $page;
    $model['page_size'] = $page_size;
    $model['pages'] = $pages;
    $model['img_memory'] = $img_memory;

    set_backURL(); // for remember_images()
    return 'gallery_view';
}

function gallery_remembered(&$model)
{
    $imgs_in_mem = get_img_memory();
    $images = &get_img_by_ids($imgs_in_mem);
    $model['images'] = $images;
    $model['img_memory'] = [];
    return "remember_gallery_view";
}

function image_remember(&$model)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['images']))
            $post_imgs = $_POST['images'];
        else
            $post_imgs = [];
        img_remember($post_imgs);
        flash("Zdjęcia zostały zapamiętane", 'suc');
    }

    $backURL = get_backURL("gallery"); // redirect back to gallery page
    return "redirect:$backURL";
}

function image_forget(&$model)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['images']))
            $post_imgs = $_POST['images'];
        else
            $post_imgs = [];
        if (empty($post_imgs)) {
            flash("Nie wybrano żadnych zdjęć.", 'inf');
        } else {
            img_forget($post_imgs);
            flash("Zdjęcia zostały usunięte!", 'suc');
        }
    }
    return "redirect:/gallery/remembered";
}

function image_ajax_search(&$model) {
    $model['images'] = [];
    if (!empty($_GET['title_part'])) {
        $title = $_GET['title_part'];
        $images = get_img_by_title($title);
        $model['images'] = $images;
    }
    return 'partial/gallery_show_images';
}

function image_search(&$model)
{
    $model['images'] = [];
    return "search_view";
}


function login(&$model)
{
    if (is_authenticated())
        return "redirect:/home";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = $_POST['login'];
        $pass = $_POST['password'];

        $user = get_user_by_login($login);
        if ($user === null) {
            flash("Użytkownik z podanym loginem nie istnieje: $login.", 'err');
            return "redirect:login";
        }

        if (!password_verify($pass, $user['password'])) {
            flash("Niepoprawne hasło.", 'err');
            return "redirect:login";
        }

        session_regenerate_id();
        $_SESSION['user_id'] = $user['_id'];
        flash("Zostałeś zalogowany!", 'suc');
        return "redirect:/home";
    }
    return 'login_view';
}

function signup(&$model)
{
    if (is_authenticated())
        return "redirect:/home";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = $_POST['login'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $rep_pass = $_POST['repeat_password'];

        $user = get_user_by_login($login);
        if ($user !== null) {
            flash("Podany login już istnieje: $login.", 'err');
            return "redirect:signup";
        }

        if ($pass != $rep_pass) {
            flash('Hasła są różne', 'err');
            return "redirect:signup";
        }

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        if (add_user_db($login, $email, $hash)) {
            flash("Konto zostało pomyślnie stworzone! Zaloguj się.", 'suc');
            return "redirect:login";
        } else {
            flash('Wystąpił błąd podczas tworzenia użytkownika.', 'err');
            return "redirect:/home";
        }
    }
    return 'signup_view';
}

function logout(&$model)
{
    if (is_authenticated()) {
        session_destroy();
        session_unset();
        flash("Zostałeś wylogowany!", 'suc');
    }
    return "redirect:/home";
}