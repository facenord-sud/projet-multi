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
class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->spark('Twiggy/0.8.5');

        $this->twiggy->title('Le magazine des étudiants');
        $this->_remeberMe();
    }

    private function _remeberMe() {
        if ($this->usersession->isConnected() == TRUE) {
            return;
        }
        $this->load->helper('cookie');
        $cookie = get_cookie('remeber_me');
        if (!$cookie) {
            return;
        }
        $this->load->model('orm_model');
        $this->load->model($this->entityFact->getUser(), 'user');
        $this->dmo->loadObject($this->user, $cookie);
        if (!$this->user) {
            return;
        }

        $this->checkUserActivation($this->user);
        $this->usersession->register($this->user);
    }

    /**
     * contrôle si l'utilisateur à le droit de se connecter
     * ie: son compte n'est ni bloqué, ni supprimé, ni temporarire
     * 
     * @param User_entity $user l'entité user
     */
    protected function checkUserActivation($user) {
//        if ($user->banned) {
//            show_error($this->lang->line('destroyed_msg'), 500, $this->lang->line('destroyed_title'));
//        }
//        if ($user->locked) {
//            show_error($this->lang->line('locked_msg'), 500, $this->lang->line('locked_title'));
//        }
//        if (!$user->enabled) {
////            echo $user->date_creation;
////            
////            die();
//            $twoWeeks = 60 * 60 * 24 * 7 * 2;
//            $diffTime = 23;
//            if ($diffTime <= $twoWeeks) {
//                $this->session->set_flashdata('msg_info', $this->lang->line('unactivated_title'));
//            } else {
//                show_error($this->lang->line('unactivated_msg'), 500, $this->lang->line('unactivated_title'));
//            }
//        }
    }

}

?>
