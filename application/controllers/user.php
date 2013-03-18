<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * le controlleur pour la gestion des utilisateurs
 * 
 * @property User_entity $user
 * @author leo
 */
class User extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user/entity/user_entity', 'user');
        $this->load->orm();
    }

    /**
     * Page d'index pour le userController
     *
     * 
     */
    public function index() {
        if ($this->usersession->isConnected()) {
            redirect('user/profil');
        } else {
            redirect('user/connect');
        }
    }

    /**
     * Page pour voir le profil du membre qui à l'id : $id
     *
     * @param int $id l'id d'un membre
     */
    public function profil($id = 0) {
        if (empty($id)) {
            $id = $this->usersession->getInfos(UserSession::ID);
        }
        $this->dmo->setLoadOptions('role', Dmo::MANY_TO_MANY);
        $this->dmo->loadObject($this->user, $id);

        $this->twiggy->set('user', $this->user);
        $this->twiggy->set('roles', $this->user->getRole());
    }

    /**
     * page pour une nouvelle inscription
     * @todo envoi email de confirmation
     */
    public function register() {
        if ($this->usersession->isConnected()) {
            redirect('main/index');
        }
        $this->load->helper('form');
        $this->load->helper('language');
        $this->load->helper('cookie');

        $this->load->library('form_validation');


        $this->load->model('user/form/user_new_form', 'form');

        /*
         * Twiggy
         */
        $this->twiggy->set('form', $this->form);
        $this->twiggy->title()->prepend('Nouvelle inscription');


        if ($this->form_validation->run() == TRUE) {
            $this->user->username = $this->input->post('username');
            $this->user->email = $this->input->post('email');
            $this->user->password = hash('sha512', $this->input->post('password'));
            $this->user->date_creation = date('Y-m-d H:i:s', mktime());
            $this->user->last_login = date('Y-m-d H:i:s', mktime());
            $this->user->enabled = TRUE;
            $this->user->banned = FALSE;
            $this->user->locked = FALSE;
            $this->user->addRole(array('id' => 1));
            $this->dmo->saveObject($this->user);
            $this->checkConnection();
            $this->session->set_flashdata('new_inscription', TRUE);
            redirect('user/confirm');
        }
    }

    public function checkSamePassword($str) {
        if ($this->input->post('password') != $str) {
            $this->form_validation->set_message('checkSamePassword', "la confirmation du mot de passe n'est pas le même que le mot de passe");
            return FALSE;
        }

        return TRUE;
    }

    public function checkUserName($str) {
        $this->query->setTableName('user')->fields('id');
        $this->query->where('username', $str);
        if ($this->query->select() != FALSE) {
            $this->form_validation->set_message('checkUserName', sprintf("L'utilisateur %s existe déjà", $str));
            return FALSE;
        }
        return TRUE;
    }

    public function checkEmail($str) {
        $this->query->setTableName('user')->fields('id')->where('email', $str);
        if ($this->query->select() != FALSE) {
            $this->form_validation->set_message('checkEmail', sprintf("Lâddresse e-mail %s existe déjà", $str));
            return FALSE;
        }
        return TRUE;
    }

    /**
     * page de confirmation pour une inscriptione réussie
     */
    public function confirm() {
        if (!$this->session->flashdata('new_inscription')) {
            redirect('main/index');
        }
    }

    /**
     * page pour modifier les données d'un membre
     * @param int $id du membre
     */
    public function edit($id) {

        $this->dmo->loadObject($this->user, $id);
        $this->user->addRole(array('id' => 3));
        $this->dmo->saveObject($this->user);
        $this->usersession->register($this->user);
    }

    public function connect() {
        $this->load->helper('form');
        $this->load->helper('language');

        $this->load->model('user/form/user_connect_form', 'form');

        $this->twiggy->set('form', $this->form);

        $this->load->library('form_validation');

        if ($this->form_validation->run() == TRUE) {
            $this->checkConnection();
        }
        $this->twiggy->set('msg', $this->session->flashdata('msg'));
    }

    public function logout() {
        $this->load->helper('cookie');
        delete_cookie('remeber_me');
        $this->usersession->logOut();
        $this->twiggy->set('user', FALSE);
    }

    /**
     * gère la connection
     */
    public function checkConnection() {
       

        if ($this->_connectUser()) {
            redirectLastPage();
        } else {
            $this->usersession->logOut();
            $this->session->set_flashdata('msg', "Le mot de passe ou le pseudo est faux");
            redirect('user/connect');
        }
    }
    
    private function _connectUser() {
        $this->load->helper('cookie');

        $this->dmo->setLoadOptions('role', Dmo::MANY_TO_MANY);
        $this->query->where('username', $this->input->post('username'));
        $this->query->where('password', hash('sha512', $this->input->post('password')));
        $isUser = $this->dmo->loadObject($this->user);

        if ($isUser) {
            $this->checkUserActivation($this->user);
            $this->usersession->register($this->user);
            $this->user->last_login = $this->usersession->getInfos(UserSession::START_TIME);
            $this->dmo->saveObject($this->user);
            if ($this->input->post('remeber_me')) {
                set_cookie('remeber_me', $this->user->id, 365 * 24 * 60 * 60);
            } else {
                delete_cookie('remeber_me');
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

}