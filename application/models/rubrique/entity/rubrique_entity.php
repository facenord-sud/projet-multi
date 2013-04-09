<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

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
     * les sous-rubriques
     * 
     * @Relation("MTM")
     * 
     * @var array
     */
    private $sub_rubrique = array();
    
    public function getSub_rubrique() {
        return $this->sub_rubrique;
    }

    public function setSub_rubrique($sub_rubrique) {
        $this->sub_rubrique = $sub_rubrique;
    }

}

?>
