<?php
require '../../vendor/autoload.php';

require_once '../dispatcher.php';
require_once '../routing.php';
require_once '../controllers.php';

//aspekty globalne
session_start();
if (!isset($_SESSION['errors']))
    $_SESSION['errors'] = [];
if (!isset($_SESSION['success']))
    $_SESSION['success'] = [];


//wybór kontrolera do wywołania:
$action_url = $_GET['action'];
dispatch($routing, $action_url);

