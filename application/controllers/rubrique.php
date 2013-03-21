<?php

/**
 * La gestion des différents rubriques
 *
 * @property Sub_rubrique_entity $sub_rubrique
 * @property Rubrique_entity $rubrique
 * @author leo
 */
class Rubrique extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->orm();
        $this->load->model('rubrique/entity/rubrique_entity', 'rubrique');
        $this->load->model('rubrique/entity/sub_rubrique_entity', 'sub_rubrique');
    }

    public function index() {
        redirect('main/index');
    }

    public function admin() {
         $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('rubrique/form/change_name_form', 'form');
        $this->twiggy->title('Gestion des rubriques');
        $this->query->setTableName('rubrique')->fields('*');
        $res = $this->query->select();
        if (!isset($res[0])) {
            $res = array($res);
        }
        $this->twiggy->set('rubriques', $res);
        $this->twiggy->set('form', $this->form);
        if ($this->form_validation->run('rubrique/changeName') == TRUE) {
            $this->rubrique->name = $this->input->post('name_rubrique');
            $this->rubrique->description = $this->input->post('description');
            $this->rubrique->url_name = url_title($this->rubrique->name, '-', TRUE);
            $this->dmo->saveObject($this->rubrique);
            redirect('rubrique/admin');
        }
    }
    
    public function delete($id) {
        $this->dmo->setLoadOptions(Dmo::ALL_FIELDS, Dmo::MANY_TO_MANY);
        $this->dmo->deleteObject($this->rubrique, $id);
        redirect('rubrique/admin');
    }

    public function modify($id) {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->twiggy->title('Mdifier une rubrique');
        $this->load->model('rubrique/form/change_name_form', 'form_change');
        $this->dmo->setLoadOptions(Dmo::ALL_FIELDS, Dmo::MANY_TO_MANY);
        $this->dmo->setLoadOptions(Dmo::ALL_FIELDS, Dmo::MANY_TO_ONE);
        $this->dmo->loadObject($this->rubrique, $id);
        
        $this->form_change->setDefaultValue(array(
            'name_rubrique' => $this->rubrique->name,
            'description' => $this->rubrique->description
        ));
        
        $this->twiggy->set('rubrique', $this->rubrique);
        $this->twiggy->set('form_change', $this->form_change);
        if ($this->form_validation->run('rubrique/changeName') == TRUE) {
            $this->rubrique->name = $this->input->post('name_rubrique');
            $this->rubrique->description = $this->input->post('description');
            $this->rubrique->url_name = url_title($this->rubrique->name, '-', TRUE);
            $this->dmo->saveObject($this->rubrique);
            redirect('rubrique/modify/' . $id);
        }
    }

    public function add_sub($id) {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->twiggy->title('Mdifier une rubrique');
        $this->load->model('rubrique/form/new_sub_rubrique_form', 'form_new');

        $this->twiggy->set('form_new', $this->form_new);

        if ($this->form_validation->run('rubrique/add_sub')) {
            $this->sub_rubrique->name = $this->input->post('name');
            $this->sub_rubrique->description = $this->input->post('description');
            $this->sub_rubrique->url_name = url_title($this->sub_rubrique->name, '-', TRUE);
            $this->dmo->saveObject($this->sub_rubrique);
            $this->dmo->loadObject($this->rubrique, $id);
            $this->rubrique->SetSub_rubrique(array($this->sub_rubrique));
            $this->dmo->saveObject($this->rubrique);
            redirect('rubrique/modify/' . $id);
        }
    }
    
    public function delete_sub($idRu, $id) {
        $this->query->setTableName('sub_rubrique_rubrique')->where('id_rubrique', $idRu)->where('id_sub_rubrique', $id)->delete();
        $this->dmo->deleteObject($this->sub_rubrique, $id);
        redirect('rubrique/modify/'.$idRu);
    }
    
    public function modify_sub($idRu, $id) {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('rubrique/form/change_name_form', 'form');
        
        $this->dmo->loadObject($this->sub_rubrique, $id);
        
        $this->form->setDefaultValue(array(
            'name_rubrique' => $this->sub_rubrique->name,
            'description' => $this->sub_rubrique->description
        ));
        
        $this->twiggy->set('form', $this->form);
        
        if ($this->form_validation->run('rubrique/changeName') == TRUE) {
            $this->sub_rubrique->name = $this->input->post('name_rubrique');
            $this->sub_rubrique->description = $this->input->post('description');
            $this->sub_rubrique->url_name = url_title($this->sub_rubrique->name, '-', TRUE);
            $this->dmo->saveObject($this->sub_rubrique);
            redirect('rubrique/modify/'.$idRu);
        }
    }

}

?>
