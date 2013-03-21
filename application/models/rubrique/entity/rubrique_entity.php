<?php

require_once APPPATH.'/models/article/entity/article_entity.php';
/**
 * Description of rubrique_entity
 *
 * @author leo
 */
class Rubrique_entity {
    
    /**
     * L'id de la rubrique
     * 
     * @Type("int(11)")
     * @Key("PRIMARY KEY")
     * @NotNull(true)
     * @Extra("AUTO_INCREMENT")
     * 
     * @var int >0 index
     */
    public $id = 0;
    
    /**
     * nom de la rubrique
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $name = '';
    
    /**
     * la description de la rubrique
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $description = '';
    
    /**
     * le nom url
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $url_name = '';
    
    /**
     * les sous-rubriques
     * 
     * @Relation("MTM")
     * 
     * @var array
     */
    private $sub_rubrique = array();
    
    /**
     * l'article en une de la rubrique
     * 
     * @Type("int(11)")
     * 
     * @var Article_entity
     */
    public $article_une = 0;
    
    
    public function getSub_rubrique() {
        return $this->sub_rubrique;
    }

    public function setSub_rubrique($sub_rubrique) {
        $this->sub_rubrique = $sub_rubrique;
    }
    
    public function addSub_rubrique($sub_rubrique) {
        array_push($this->sub_rubrique, $sub_rubrique);
        
    }

}

?>
