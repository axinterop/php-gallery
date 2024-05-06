<?php

function set_backURL($url = null)
{
    try {
        $_SESSION['backURL'] = $url !== null ? $url : $_SERVER['REQUEST_URI'];
        return 1;
    } catch (Exception $e) {
        return 0;
    }
}

function get_backURL($default_url)
{
    $backURL = empty($_SESSION['backURL']) ? $default_url : $_SESSION['backURL'];
    unset($_SESSION['backURL']);
    return $backURL;
}

function flash($msg, $type)
{
    // err, suc, inf

    if (!isset($_SESSION['messages']))
        $_SESSION['messages'] = [];
    if (!array_key_exists($type, $_SESSION['messages'])) {
        $_SESSION['messages'][$type] = [];
    }
    $_SESSION['messages'][$type][] = $msg;
}

function is_authenticated()
{
    return isset($_SESSION['user_id']);
}

function check_mime_type(&$file)
{
    try {
        $file_tmp = $file['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file_tmp);
        if ($mime_type === 'image/jpeg' || $mime_type === 'image/png')
            return 1;
    } catch (Exception $e) {};
    return 0;
}

function check_file_size(&$file)
{
    $file_tmp = $file['tmp_name'];
    if (filesize($file_tmp) <= 1048576) {
        return 1;
    }
    return 0;
}

function img_remember($image_ids)
{
    if (!isset($_SESSION['img_memory']))
        $_SESSION['img_memory'] = [];
    foreach ($image_ids as $img_id) {
        if (!in_array($img_id, $_SESSION['img_memory']))
            $_SESSION['img_memory'][] = $img_id;
    }
}

function img_forget($image_ids)
{
    if (!isset($_SESSION['img_memory']))
        $_SESSION['img_memory'] = [];
    $_SESSION['img_memory'] = array_diff($_SESSION['img_memory'], $image_ids);
}

function get_img_memory()
{
    if (!isset($_SESSION['img_memory']))
        $_SESSION['img_memory'] = [];
    return $_SESSION['img_memory'];
}

