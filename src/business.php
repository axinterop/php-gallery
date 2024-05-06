<?php


use MongoDB\BSON\ObjectID;

const IMG_DIR = "images/";
const IMG_DIR_SHORT = "../images/";

function get_db()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);

    $db = $mongo->wai;

    return $db;
}


function save_img_db($file, $watermark, $author, $title, bool $private)
{
    $db = get_db();

    $clean_name = pathinfo(basename($file['name']), PATHINFO_FILENAME);

    $target = [
        "author" => $author,
        "title" => $title,
        "watermark" => $watermark,
        "private" => $private,
        'path_no_ext' => IMG_DIR_SHORT . $clean_name,
    ];

    $db->images->insertOne($target);
}

function &get_img_by_ids(array $img_ids)
{
    $db = get_db();
    $images = [];
    foreach ($img_ids as $id) {
        $q = ['_id' => new ObjectID($id)];
        $image = $db->images->findOne($q);
        $images[] = $image;
    }
    return $images;
}

function get_img_pages($page, $pageSize)
{
    $db = get_db();
    $q = [
        '$or' => [
            ['private' => false],
            [
                'author' => get_authenticated_user()['login'],
                'private' => true,
            ]
        ]
    ];
    $opts = [
        'skip' => ($page - 1) * $pageSize,
        'limit' => $pageSize
    ];
    $images = $db->images->find($q, $opts);
    return $images;
}

function get_img_by_title($title)
{
    $db = get_db();
    $query = [
        '$and' => [
            ['title' => [
                '$regex' => ".*$title.*",
                '$options' => 'i',
            ]],
            ['$or' => [
                ['private' => false],
                [
                    'author' => get_authenticated_user()['login'],
                    'private' => true,
                ]
            ]],
        ]


    ];
    $images = $db->images->find($query);
    return $images;
}

function get_img_count()
{
    $db = get_db();
    $q = [
        '$or' => [
            ['private' => false],
            [
                'author' => get_authenticated_user()['login'],
                'private' => true,
            ]
        ]
    ];
    return $db->images->count($q);
}

function get_user_by_login($login)
{
    $db = get_db();
    $user = $db->users->findOne(['login' => $login]);
    return $user;
}

//function get_user_by_id($id)
//{
//    $db = get_db();
//    $user = $db->users->findOne(['_id' => $id]);
//    return $user;
//}


function add_user_db($login, $email, $hash)
{
    $db = get_db();
    try {
        $db->users->insertOne([
            'login' => $login,
            'email' => $email,
            'password' => $hash,
        ]);
        return 1;
    } catch (Exception $e) {
        return 0;
    }
}


function get_authenticated_user()
{
    $user_id = is_authenticated() ? $_SESSION['user_id'] : null;
    if ($user_id === null)
        return null;
    $db = get_db();
    $user = $db->users->findOne(['_id' => $user_id]);
    return $user;
}


function watermark_mini(&$file, $watermark)
{
    // Get info about image
    $file_name = basename($file['name']);
    $clean_name = pathinfo($file_name, PATHINFO_FILENAME);
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);

    // Get uploaded image into memory
    if ($ext == "png")
        $im = imagecreatefrompng(IMG_DIR . $file_name);
    else
        $im = imagecreatefromjpeg(IMG_DIR . $file_name);

    $ory = imagesy($im);
    $orx = imagesx($im);

    // Create ghost-images in memory
    $mini = imagecreatetruecolor(200, 125);
    $stamp = imagecreatetruecolor($orx, $ory);
    $watermark_len = strlen($watermark) * 30;
    $font = 'static/fonts/arial.ttf';
    imagettftext($stamp, 40, 0, ($orx - $watermark_len) / 2, $ory / 2, 0x0000FF, $font, $watermark);

    $marge_right = 10;
    $marge_bottom = 10;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);

    // Create miniature
    imagecopyresampled($mini, $im, 0, 0, 0, 0, 200, 125, $orx, $ory);
    // Create clone of image with watermark
    imagecopymerge($im, $stamp, 0, 0, 0, 0, imagesx($stamp), imagesy($stamp), 50);

    // Save to disk ...
    imagepng($im, IMG_DIR . $clean_name . '-wm.png');
    imagejpeg($mini, IMG_DIR . $clean_name . '-min.jpeg');
    // ... and remove from memory
    imagedestroy($mini);
    imagedestroy($im);
}


function upload_img_server(&$file, $watermark)
{
    $tmp_path = $file['tmp_name'];
    $file_name = basename($file['name']);
    $target = IMG_DIR . $file_name;
    if (move_uploaded_file($tmp_path, $target)) {
        watermark_mini($file, $watermark);
        return 1;
    }
    return 0;
}

