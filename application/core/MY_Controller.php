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
        $this->twiggy->set('false', FALSE);
        $this->twiggy->set('user_infos', $this->usersession->getAllUserInfos());
        
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
        $this->load->model('user/entity/user_entity', 'user');
        $this->load->orm();
        $this->dmo->setLoadOptions(Dmo::ALL_FIELDS, Dmo::MANY_TO_MANY);
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
        if ($user->banned) {
            redirect('error/banned');
        }
        if ($user->locked) {
            redirect('error/locked');
        }
        if (!$user->enabled) {
            echo $user->date_creation;
            
            die();
            $twoWeeks = 60 * 60 * 24 * 7 * 2;
            $diffTime = 23;
            if ($diffTime <= $twoWeeks) {
                $this->session->set_flashdata('msg_info', $this->lang->line('unactivated_title'));
            } else {
                redirect('error/enabled');
            }
        }
    }

}

?>
