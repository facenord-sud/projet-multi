<?php

/**
 * l'entité qui gère les liens intéressants pour chaque articles
 *
 * @author leo
 */
class Link_entity {
    
    /**
     * L'id du lien
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
     * nom du lien
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $name = '';
    
    /**
     * le nom pour l'url du lien
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $url_name = '';
    
    /**
     * la description du lien
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $description = '';
    
    /**
     * le lien
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $link = '';
}

?>
