<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pub
 *
 * @author leo
 * @property Article_entity $article
 */
class Article extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->orm();
        $this->load->model('article/entity/article_entity', 'article');
    }

        public function _remap($method) {
        if($method=="new") {
            $this->newArticle();
        }
    }

        public function _makeArticle() {
        $_SESSION['edit'] = TRUE;
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('article/form/article_form', 'form');
        $this->form->setDefaultValue($this->article);
        $this->twiggy->set('form', $this->form);
        if(($result = $this->form_validation->run('article/edit'))==TRUE) {
            $this->article->titre = $this->input->post('titre');
            $this->article->description = $this->input->post('description');
            $this->article->key_word = $this->input->post('key_word');
            $this->article->chapo = $this->input->post('chapo');
            $this->article->text = cleanHtmlTMC($this->input->post('text'));
            $this->dmo->saveObject($this->article);
        }
        return $result;
    }
    
    public function show() {
        $this->query->setTableName('article')->fields('*');
        var_dump($this->query->getSelect());
        
        $this->twiggy->set('articles', '$articles');
    }

        public function newArticle() {
        if($this->_makeArticle()){
            redirect('admin/index');
        }
    }
}

?>
