<?php

/**
 * La classe User_connect_form permet l'affichage du formulair de connection
 *
 * @author leo
 */
class User_connect_form {

    public function printForm() {

        echo validation_errors();

        echo form_open('user/connect');


        echo form_fieldset("Connexion");

        echo my_form('username', 'pseudo: ');
        echo my_form('password', 'mot de passe: ', 'password');
        
        echo "se souvenir de moi";
        echo form_checkbox('remeber_me', "asda", TRUE);
        echo '<br/>';

        echo form_submit('submit', "connexion!");
        echo form_fieldset_close();
        echo form_close();
    }

}

?>
