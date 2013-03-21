<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->orm();
        $this->load->model('rubrique/entity/rubrique_entity', 'rubrique');
        $this->load->model('rubrique/entity/sub_rubrique_entity', 'sub_rubrique');
    }

    /**
     * 
     */
    public function index($rubName = '', $subName = '') {
        $this->query->setTableName('rubrique')->fields('*');
        $res = $this->query->select();
        if (!isset($res[0])) {
            $res = array($res);
        }
        $this->twiggy->set('rubriques', $res);
        $this->dmo->setLoadOptions('sub_rubrique', Dmo::MANY_TO_MANY);
        if (empty($rubName)) {
            $this->query->where('name', 'Magazine');
        } else {
            $this->query->where('url_name', $rubName);
        }
        $this->dmo->loadObject($this->rubrique);
        $this->twiggy->set('sub_rub', $this->rubrique);
    }

    public function contact() {
        
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */