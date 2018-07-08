<?php

define('DIR', realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR);

if (is_readable(DIR . 'app/ini.php')) {
    require_once DIR . 'app/ini.php';
} else {
    echo '<h1 style="font-family: sans-serif; color: red;">GREŠKA:</h1>';
    echo '<p style="font-family: sans-serif;">Nije pronađen inicijalni fajl.</p>';
    die();
}

session_start();

$app = App::instance();
$app->setDic($dic);
$app->run();
