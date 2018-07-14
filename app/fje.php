<?php

/**
 * Prikazuje gresku u aplikaciji
 * @param type $opis Opis greske
 * @param type $parametar Parametar greske (npr. neka promenjiva, putanja ...)
 */
function greska($opis, $parametar = null) {
    // TODO Error handling umesto ovoga
    echo '<h1 style="font-family: sans-serif; color: red">GREŠKA</h1>';
    if (defined('DEBUG') and DEBUG) {
        echo '<p style="font-family: sans-serif; font-size: 18px;">' . $opis . '</p>';
        if ($parametar) {
            echo '<p style="font-family: monospace; font-size: 18px;"><code>[' . $parametar . ']</code></p>';
        }
    }
    die();
}

/**
 * Izdvaja i vraca deo stringa izmedju dva stringa
 * @param string $string String koji se pretrazuje
 * @param string $start Strong od koga se izdvaja deo
 * @param string $end String do koga se izdvaja deo
 * @return string Deo stringa koji se nalazi izmedju $start i $end
 */
function getStringBetween($string, $start, $end) {
    $string = " " . $string;
    $ini = strpos($string, $start);
    if ($ini == 0)
        return "";
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

/**
 * "Dezinfikuje" parametar na osnovu njedovog tipa
 * @param mixed $param
 * @return mixed
 */
function sanitize($param) {
    $type = gettype($param);
    switch ($type) {
        case 'boolean':
            return $param;
        case 'integer':
            return (int) filter_var($param, FILTER_SANITIZE_NUMBER_INT);
        case 'double':
            return (float) filter_var($param, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        case 'string':
            return filter_var($param, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW);
        case 'array':
            foreach ($param as $key => $value) {
                $param[$key] = sanitize($value);
            }
            return $param;
        case 'object':
            return $param;
        case 'NULL':
            return null;
        default:
            return null;
    }
}

/**
 * Priprema za prikazivanje u html
 * @param mixed $param Parametar koji se prikazuje
 * @return string
 */
function e($param) {
    return htmlspecialchars($param, ENT_QUOTES, 'UTF-8', false);
}

/*
 * DEBUG funkcije
 */

function dv($param, $name = 'Neka promenjiva:') {
    echo '<pre>';
    echo '<h5>' . $name . '</h5>';
    var_dump($param);
    echo '</pre>';
}

function dp($param, $name = 'Neka promenjiva:') {
    echo '<pre>';
    echo '<h5>' . $name . '</h5>';
    print_r($param);
    echo '</pre>';
}

function ddv($param, $name = 'Neka promenjiva:') {
    dv($param, $name);
    die();
}

function ddp($param, $name = 'Neka promenjiva:') {
    dp($param, $name);
    die();
}
