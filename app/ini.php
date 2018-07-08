<?php

if (is_readable(DIR . 'app/cfg.php')) {
    require_once DIR . 'app/cfg.php';
} else {
    echo '<h1 style="font-family: sans-serif; color: red;">GREŠKA:</h1>';
    echo '<p style="font-family: sans-serif;">Nije pronađen konfiguracioni fajl.</p>';
    die();
}

if (is_readable(DIR . 'app/fje.php')) {
    require_once DIR . 'app/fje.php';
} else {
    echo '<h1 style="font-family: sans-serif; color: red;">GREŠKA:</h1>';
    echo '<p style="font-family: sans-serif;">Nije pronađen fajl sa funkcijama.</p>';
    die();
}

if (is_readable(DIR . 'app/dic.php')) {
    require_once DIR . 'app/dic.php';
} else {
    greska('Nije pronađen fajl sa Dependencies.', 'app/dic.php');
}

if (is_readable(DIR . 'app/core/App.php')) {
    require_once DIR . 'app/core/App.php';
} else {
    greska('Nije pronađena aplikacija.', 'app/core/App.php');
}
