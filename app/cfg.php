<?php

/*
 * PODESAVANJA APLIKACIJE
 */

// Naziv aplikacije
define('APP_NAME', 'New MVC');

// Url dodatak [http://localhost/new-mvc/pub]
define('BASE', '/new-mvc/pub');

// Url dodatak za admina [http://localhost/new-mvc/pub/admin]
define('ADMIN', '/admin');

// Prikaz gresaka
define('DEBUG', true);

// Baza podataka
define('DB_TYPE', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'sakila');
define('DB_USER', 'root');
define('DB_PASS', '');
// Data Source Name
define('DSN', DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME);

// PDO opcije
$PDO_OPCIJE = [
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
];
define('PDO_OPCIJE', serialize($PDO_OPCIJE));

// Direktorijumi za automatsko uzitavanje klasa
$AUTOLOAD = [
    'app/core/',
    'app/controllers/',
    'app/orm/',
    'app/models/',
    'app/librarys/',
    'app/helpers/',
];
define('AUTOLOAD', serialize($AUTOLOAD));

// Vremenska zona
date_default_timezone_set('Europe/Belgrade');

// Stranicenje
define('PER_PAGE', 18);
define('PAGE_SPAN', 5);

/*
 * PODESAVANJA PHP-a
 */

// Podesavanje prikaza i logovanja gresaka
if (defined('DEBUG')) {
    if (DEBUG) {
        error_reporting(-1);
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
    } else {
        error_reporting(0);
        ini_set('display_errors', '0');
    }
} else {
    greska('Okruzenje nije ispravno podeseno.');
}

ini_set('log_errors', '1');
ini_set('log_errors_max_len', '10K');
ini_set('error_log', realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR
        . 'app' . DIRECTORY_SEPARATOR
        . 'tmp' . DIRECTORY_SEPARATOR
        . 'err' . DIRECTORY_SEPARATOR
        . 'errors.log');

// Globalna podesavanja
ini_set('default_charset', 'UTF-8');
ini_set('magic_quotes_gpc', '0');
ini_set('register_globals', '0');
ini_set('expose_php', '0');
ini_set('allow_url_fopen', '0');
ini_set('allow_url_include', '0');

// Podesavanje memorije
ini_set('memory_limit', '512M');

// File upload podesavanja
ini_set('file_uploads', 0);
ini_set('upload_max_filesize', '2M');
ini_set('upload_tmp_dir', realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR
        . 'app' . DIRECTORY_SEPARATOR
        . 'tmp');

// Podesavanja sesija
$hash = 'sha512';
if (in_array($hash, hash_algos())) {
    ini_set('session.hash_function', $hash);
}
ini_set('session.hash_bits_per_character', 5);

ini_set('session.use_trans_sid', 0);
ini_set('session.use_only_cookies', 1);
ini_set('session.save_path', realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR
        . 'app' . DIRECTORY_SEPARATOR
        . 'tmp' . DIRECTORY_SEPARATOR
        . 'ses');
