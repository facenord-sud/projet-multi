<?php

/**
 * La classe Rser_new_form permet la création d'un nouveau rôle
 *
 * @author leo
 */
class Role_new_form {

    public function printForm() {
        echo validation_errors();

        echo form_open();

        echo form_fieldset("Nouveau rôle");

        echo my_form('name', 'nom public: ');
        echo my_form('nick_name', 'nom administrateur: ');
        echo my_form('description', 'courte description: ', 'text');

        echo form_submit('submit', "Sauvegarder");
        echo form_fieldset_close();
        echo form_close();
    }

}

?>
