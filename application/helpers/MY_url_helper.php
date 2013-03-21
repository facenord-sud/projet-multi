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

        if (array_search($uri, $redirection) !== TRUE) {
            redirect($CI->config->item('redirect_to'));
        }
        redirect($url);
    }

}


/**
 * Create URL Title
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with a "separator" string 
 * as the word separator.
 * 
 * enlève les accents et les remplace par la même lettre
 *
 * @author Numa de Montmollin <numae.demontmollin@unifr.ch>
 * @access	public
 * @param	string	the string
 * @param	string	the separator
 * @return	string
 */
if (!function_exists('url_title')) {

    function url_title($str, $separator = '-', $lowercase = FALSE) {
        
        	// On remplace les Y
	$y = array("ý", "ÿ", "Ý");
	$str = str_replace ($y, "y", $str);
	
	// On remplace les C
	$c = array("Ç", "ç");
	$str = str_replace ($c, "c", $str);
	
	//On remplace les A avec accent par un A normal
	$a = array("ä", "â", "à", "ã", "ä", "å", "À", "Á", "Â", "Ã", "Ä", "Å", "@");
	$str = str_replace ($a, "a", $str);
		
	//On remplace les E avec accent par un E normal
	$e = array("é", "è", "ê", "ë", "È", "É", "Ê", "Ë");
	$str = str_replace ($e, "e", $str);
	
	//On remplace les I avec accent par un I normal
	$i = array("ï", "î", "ì", "í", "Ì", "Í", "Î", "Ï");
	$str = str_replace ($i, "i", $str);
	
	//On remplace les O avec accent par un O normal
	$o = array("ö", "ô", "õ", "ó", "ò", "ð", "Ò", "Ó", "Ô", "Õ", "Õ", "Ö");
	$str = str_replace ($o, "o", $str);
	
	//On remplace les U avec accent par un U normal
	$u = array("ù", "û", "ü", "ú", "Ù", "Ú", "Û", "Ü");
	$str = str_replace ($u, "u", $str);
        
        if ($separator == 'dash') {
            $separator = '-';
        } else if ($separator == 'underscore') {
            $separator = '_';
        }

        $q_separator = preg_quote($separator);

        $trans = array(
            '&.+?;' => '',
            '[^a-z0-9 _-]' => '',
            '\s+' => $separator,
            '(' . $q_separator . ')+' => $separator
        );

        $str = strip_tags($str);

        foreach ($trans as $key => $val) {
            $str = preg_replace("#" . $key . "#i", $val, $str);
        }

        if ($lowercase === TRUE) {
            $str = strtolower($str);
        }

        return trim($str, $separator);
    }

}