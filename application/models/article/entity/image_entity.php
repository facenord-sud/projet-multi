<?php

/**
 * l'entité qui gère les images pour les articles
 *
 * @author leo
 */
class Image_entity {
    
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
     * nom de l'image
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $name = '';
    
    /**
     * la description de limage
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $description = '';
    
    /**
     * le chemin où se trouve l'image
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $path = '';
}

?>
