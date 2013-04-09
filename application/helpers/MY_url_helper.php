<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * url Helper qui contient des nouvelles fonctions pour les urls.
 * 
 *
 * @author Yves+numa
 */
/**
 * No Duplicate permet d'éviter les pages dupliquée.
 * En cas de possibilité de duplicate content, lancer cette fonction au début de la methode du controller
 *
 * @param $url est l'url que nous souhaitant pour la page en question.
 * @param $curentUrl est l'url actuel
 * 
 */
if (!function_exists('noDuplicate')) {

    function noDuplicate($url) {
// Verifier que l'url est correct
        if ($url != current_url()) {
// Si elle n'est pas correct, faire une redirection 301 permanente
            redirect($url, 'location', 301);
        }
    }

}

// ------------------------------------------------------------------------



/**
 * redirige vers la dernière page visitée
 * redirige vers la page choisie dans le fichier de config redirect, si on veut 
 * éviter la redirection sur une page
 * @autor leo
 */
if (!function_exists('redirectLastPage')) {

    function redirectLastPage() {
        $CI = & get_instance();
        $CI->config->load('redirection');
        $redirection = $CI->config->item('no_redirection');
        $url = $_SERVER['HTTP_REFERER'];
        $uri = substr($url, strlen(base_url()), strlen($url));
        
        if (array_search($uri, $redirection)!==TRUE) {
            redirect($CI->config->item('redirect_to'));
        }
        redirect($url);
    }

}