<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of role
 *
 * @author leo
 */

/**
 * Gére les rôles
 * @property Role_entity $role 
 */
class Role extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->orm();
        $this->load->model('user/entity/role_entity', 'role');
    }

    public function index() {
        $this->load->helper('form');

        $this->load->library('form_validation');


        $this->load->model('user/form/role_new_form', 'form');


        $this->twiggy->title("Tous les rôles");


        $this->query->setTableName('role')->fields('*');
        $this->twiggy->set('roles', $this->query->select());
        $this->twiggy->set('form', $this->form);

        if ($this->form_validation->run() == TRUE) {
            $this->_register();
        }
    }
    
    public function delete($id) {
        $this->query->delete($this->role, $id);
        redirect('role/index');
    }

    private function _register() {
        $this->role->name = $this->input->post('name');
        $this->role->nick_name = $this->input->post('nick_name');
        $this->role->description = $this->input->post('description');
        $this->dmo->saveObject($this->role);
        redirect('role/index');
    }

}

?>
