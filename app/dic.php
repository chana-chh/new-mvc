<?php

if (is_readable(DIR . 'app/core/DiC.php')) {
    require_once DIR . 'app/core/DiC.php';
} else {
    greska('Nije pronađen fajl', 'app/core/DiC.php');
}

if (is_readable(DIR . 'app/core/Dependency.php')) {
    require_once DIR . 'app/core/Dependency.php';
} else {
    greska('Nije pronađen fajl', 'app/core/Dependency.php');
}

$dic = new DiC();

$dic->set('router', 'Router');
$dic->set('view', 'View');
$dic->set('db', 'Db');
$dic->set('csrf', 'Csrf');
