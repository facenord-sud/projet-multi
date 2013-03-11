<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Controller
 *
 * @author leo
 */
class MY_Controller extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->spark('Twiggy/0.8.5');
        $this->twiggy->register_function('anchor');
        
        $this->twiggy->title('Le magazine des étudiants');
        
        
    }
}

?>
