<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of article_new_form
 *
 * @author leo
 */
class Article_form {
    
    private $defaultValue;
    
    public function printForm() {
        echo validation_errors();

        echo form_open();
        echo form_fieldset("modifier ou créer un article");
        echo my_form('titre', 'titre: ', '', $this->defaultValue);
        echo my_form('description', 'description de la rubrique (optionel): ', 'text', $this->defaultValue);
        echo my_form('key_word', 'mots-clés: ', '', $this->defaultValue);
        echo my_form('chapo', 'l\'en-tête: ', 'text', $this->defaultValue);
        echo my_form('text', 'corps de l\'article: ', 'tinymce');

        
        
        echo form_submit('submit', "Sauvegarder");
        echo form_fieldset_close();
        echo form_close();
    }
    
    public function getDefaultValue() {
        return $this->defaultValue;
    }

    public function setDefaultValue($defaultValue) {
        $this->defaultValue = $defaultValue;
    }
    


}

?>
