<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rubrique
 *
 * @author leo
 */
class Rubrique extends MY_Controller {

    public function index($rubrique=0, $subRubrique=0) {
    }
    
    public function admin() {
        $this->twiggy->title('Gestion des rubriques');
    }
}

?>
