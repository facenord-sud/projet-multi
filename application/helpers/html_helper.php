<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('img')) {

    function img($path, $alt = 'l\'image ne peut être affichée') {
        return '<img src="' . base_url() . 'www/img/' . $path . '" alt="' . $alt . '"/>'."\n";
    }

}

if (!function_exists('css')) {

    function css($path, $media = 'screen') {
        return '<link rel="stylesheet" href="' . base_url() . 'www/css/' . $path . '" media="' . $media . '"/>'."\n";
    }

}

if (!function_exists('js')) {

    function js($path) {
        return '<script src="' . base_url() . 'www/js/' . $path . '"></script>'."\n";
    }

}
?>
