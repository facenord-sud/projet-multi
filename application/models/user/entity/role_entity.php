<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Role_entity{

    /**
     * @Type("int(11)")
     * @Key("PRIMARY KEY")
     * @NotNull(true)
     * @Extra("AUTO_INCREMENT")
     * @var int 
     */
    public $id;
    
    /**
     * @Type("varchar(255)")
     * 
     * @var string 
     */
    public $name;
    
    /**
     * @Type("varchar(255)")
     * 
     * @var string 
     */
    public $nick_name;
    
    /**
     * @Type("text")
     * 
     * @var string 
     */
    public $description;
}
