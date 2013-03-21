<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of change_name_form
 *
 * @author leo
 */
class Change_name_form {

    private $defaultValue;
    
    public function printForm() {
        echo validation_errors();

        echo form_open();
        echo form_fieldset("modifier la rubrique");
        echo my_form('name_rubrique', 'nouveau nom: ', '', $this->defaultValue);
        echo my_form('description', 'description de la rubrique: ', 'text', $this->defaultValue);

        echo form_submit('submit', "Changer");
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
