<?php

require_once APPPATH.'/models/article/entity/article_entity.php';

/**
 * la sous-rubrique contient les articles
 *
 * @author leo
 */
class Sub_rubrique_entity {

    /**
     * L'id de la sous-rubrique
     * 
     * @Type("int(11)")
     * @Key("PRIMARY KEY")
     * @NotNull(true)
     * @Extra("AUTO_INCREMENT")
     * 
     * @var int
     */
    public $id = 0;

    /**
     * nom de la sous-rubrique
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $name = '';

    /**
     * la description de la sous-rubrique
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $description = '';

    /**
     * le nom pour l'url
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $url_name = '';

    /**
     * les articles d'une sous-rubriques
     * 
     * @Relation("MTM")
     * 
     * @var type array les articles
     */
    private $article = array();

    /**
     * l'article en une de la sous rubrique
     * 
     * @Type("int(11)")
     * 
     * @var Article_entity
     */
    public $article_une = 0;
    

    public function getArticle() {
        return $this->article;
    }

    public function setArticle(type $article) {
        $this->article = $article;
    }

}

?>
