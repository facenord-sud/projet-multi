<?php

/*
 * Ce fichier permet de mettre les règle de validation des formulaires
 * 
 */

$config = array(
    /*
     * Création d'un nouveau domaine
     */
    'domain/create' => array(
        array(
            'field' => 'name',
            'label' => 'lang:form_name',
            'rules' => 'required|min_length[3]|max_length[255]'
        ),
        array(
            'field' => 'description',
            'label' => 'lang:form_description',
            'rules' => ''
        ),
        array(
            'field' => 'domain',
            'label' => 'lang:form_domain'
            //@todo Il faut ajouter une règle pour voir si l'id fait parti d'un champ dans la table
            //'rules' => 'is_natural'
        ),
        array(
            'field' => 'mode',
            'label' => 'lang:form_mode',
            'rules' => 'enum[ES,YS,BB,LB,F]'
        )
    ),
    /*
     * Edition d'un domaine
     * @todo, faire que cette règle va pour 'domain/edit/:num'
     */
    'domain/edit' => array(
        array(
            'field' => 'name',
            'label' => 'lang:form_name',
            'rules' => 'required|min_length[3]|max_length[255]'
        ),
        array(
            'field' => 'description',
            'label' => 'lang:form_description',
            'rules' => ''
        ),
    ),
    /*
     * supression d'un domaine
     */
    'domain/delete' => array(
        array(
            'field' => 'domain',
            'label' => 'lang:form_domain',
            //@todo Il faut ajouter une règle pour voir si l'id fait parti d'un champ dans la table
            'rules' => 'is_natural'
        ),
        array(
            'field' => 'mode',
            'label' => 'lang:form_mode',
            'rules' => 'enum[0,1]'
        )
    ),
    /*
     * Création d'un nouveau membre
     */
    'user/register' => array(
        array(
            'field' => 'username',
            'label' => 'lang:pseudo',
            'rules' => 'required|min_length[3]|max_length[255]|callback_checkUserName'
        ),
        array(
            'field' => 'email',
            'label' => 'lang:email',
            'rules' => 'required|valid_email|max_length[255]|callback_checkEmail'
        ),
        array(
            'field' => 'password',
            'label' => 'lang:password',
            'rules' => 'required|min_length[5]|max_length[255]'
        ),
        array(
            'field' => 'password2',
            'label' => 'lang:password2',
            'rules' => 'required|min_length[5]|max_length[255]|callback_checkSamePassword'
        )
    ),
    'user/connect'=>array(
        array(
            'field' => 'username',
            'label' => 'lang:pseudo',
            'rules' => 'required|min_length[3]'
        ),
        array(
            'field' => 'password',
            'label' => 'lang:password',
            'rules' => 'required|min_length[3]'
        ),
    ),
    'role/index'=>array(
        array(
            'field' => 'name',
            'label' => 'nom public: ',
            'rules' => 'required|min_length[3]|max_length[255]'
        ),
        array(
            'field' => 'description',
            'label' => 'courte description: ',
            'rules' => 'required|min_length[3]|max_length[255]'
        ),
        array(
            'field' => 'nick_name',
            'label' => 'nom administrateur: ',
            'rules' => 'required|min_length[3]|max_length[255]'
        ),
    ),
    /*
     * Formulaire de contact
     */
    'main/contact' => array(
        array(
            'field' => 'emailaddress',
            'label' => 'EmailAddress',
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|alpha'
        ),
        array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'required'
        ),
        array(
            'field' => 'message',
            'label' => 'MessageBody',
            'rules' => 'required'
        )
    )
);

