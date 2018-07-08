<?php

function greska($opis, $parametar = null)
{
    echo '<h1 style="font-family: sans-serif; color: red">GREŠKA</h1>';
    if (defined('DEBUG') and DEBUG) {
        echo '<p style="font-family: sans-serif; font-size: 18px;">' . $opis . '</p>';
        if ($parametar) {
            echo '<p style="font-family: monospace; font-size: 18px;"><code>[' . $parametar . ']</code></p>';
        }
    }
    die();
}

function getStringBetween($string, $start, $end)
{
    $string = " " . $string;
    $ini = strpos($string, $start);
    if ($ini == 0)
        return "";
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function dv($param, $name = 'Neka promenjiva:')
{
    echo '<pre>';
    echo '<h5>' . $name . '</h5>';
    var_dump($param);
    echo '</pre>';
}

function dp($param, $name = 'Neka promenjiva:')
{
    echo '<pre>';
    echo '<h5>' . $name . '</h5>';
    print_r($param);
    echo '</pre>';
}

function ddv($param, $name = 'Neka promenjiva:')
{
    dv($param, $name);
    die();
}

function ddp($param, $name = 'Neka promenjiva:')
{
    dp($param, $name);
    die();
}
