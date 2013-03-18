<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Twiggy
 *
 * @author leo
 */
class TwiggyView {

    public function display() {
        $CI = & get_instance();
        $class = $CI->router->class;
        $method = $CI->router->method;
        if(!isset($CI->twiggy)) {
            return;
        }
        $CI->twiggy->display($class . '/' . $method);
    }

}

?>
