<?php

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

}

?>
