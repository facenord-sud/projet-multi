<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of new_sub_rubrique_form
 *
 * @author leo
 */
class New_sub_rubrique_form {
    
    public function printForm() {
        echo validation_errors();

        echo form_open();

        echo form_fieldset("Nouvelle sous rubrique");

        echo my_form('name', 'nom: ');
        echo my_form('description', 'courte description: ', 'text');

        echo form_submit('submit', "Sauvegarder");
        echo form_fieldset_close();
        echo form_close();
    }
}

?>
