<?php

/**
 * La classe User_new_form permet l'affichage du formulair d'inscription d'un 
 * nouveau membre
 *
 * @author leo
 */
class User_new_form {

    public function printForm() {
        echo validation_errors();

        echo form_open();

        echo form_fieldset("Nouvelle inscription");

        echo my_form('username', 'pseudo: ');
        echo my_form('email', 'email: ');
        echo my_form('password', 'mot de passe: ', 'password');
        echo my_form('password2', 'confirmation mot de passe: ', 'password');

        echo "Se souvenir de moi";
        echo form_checkbox('remeber_me', "asda", TRUE);
        echo '<br/>';

        echo form_submit('submit', "Inscription!");
        echo form_fieldset_close();
        echo form_close();
    }

}

?>
