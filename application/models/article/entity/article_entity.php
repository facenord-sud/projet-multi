<?php

/**
 * l'entité qui définit un article
 *
 * @author leo
 */
class Article_entity {

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
     * titre de l'article
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $titre = '';

    /**
     * description de l'article
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $description = '';

    /**
     * mots clés de l'article
     * 
     * @Type("varchar(255)")
     * 
     * @var string
     */
    public $key_word = '';

    /**
     * le texte lui-même
     * 
     * @Type("text")
     * 
     * @var string
     */
    public $text = '';

    /**
     * le chapo
     * 
     * @Type("text")
     * 
     * @var string
     */
    public $chapo = '';

    /**
     * les images de l'article
     * 
     * @Relation("MTM")
     * 
     * @var array
     */
    private $image = array();

    /**
     * les liens de l'article
     * 
     * @Relation("MTM")
     * 
     * @var array
     */
    private $links = array();

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getLinks() {
        return $this->links;
    }

    public function setLinks($links) {
        $this->links = $links;
    }

    public function addKeyWords($keyWord) {
        $this->key_word.=', ' . $keyWord;
    }

    public function removeKeyWords($keyWord) {
        $this->key_word = str_replace($this->key_word, '', $keyWord . ', ');
    }

    public function isKeyWord($keyWord) {
        $keyWords = explode(', ', $this->key_word);
        return isset($keyWords[$keyWord]);
    }

}

?>
