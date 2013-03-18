<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * La classe User qui gère n'importe quel utilisateur de base
 *
 * @table user
 * @author Numa
 * @since 22.11.2012
 * @version 0.2
 */
class User_entity {

    /**
     * L'id du membre
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
     * Psuedo du membre
     * 
     * @Type("varchar(255)")
     * 
     * @var String lettre de a-z et A-Z chiffre de 0-9 et ._(une seule fois)
     * YVES: Es-tu certain de ça ? Pourquoi ne pas tout accépter ? 
     * Souvant des gens s'appèle "S@m?" et ça ne pose pas de problème.
     */
    public $username = '';

    /**
     * Adresse email
     * 
     * @Type("varchar(255)")
     * @var String format adresse email
     */
    public $email = '';

    /**
     * Compte activé ou pas (activé l'adresse mail avec le mail de confirmation?)
     *
     * @Type("tinyint(1)")
     * 
     * @var boolean
     */
    public $enabled = false;

    /**
     * Mot de passe
     *
     * @Type("varchar(255)")
     * 
     * @var String lettre de a-z et A-Z chiffre de 0-9 et ._*:-
     * YVES : La aussi j'accépterais tout !
     */
    public $password = '';

    /**
     * Timestamp de la date d'inscription
     *
     * @Type("timestamp")
     * 
     * @var int
     */
    public $date_creation = null;

    /**
     * Timestamp de la dernière connexion
     *
     * @Type("timestamp")
     * 
     * @var int
     */
    public $last_login = null;

    /**
     * Compte blocké pour une certain temps ?
     * Yves, il faudrait donc ajouter une variable $locked_time, qui dit combien de temps il est lock ?
     *
     * @Type("tinyint(1)")
     * 
     * @var Boolean
     */
    public $locked = false;

    /**
     * Compte banni ?
     *
     * @Type("tinyint(1)")
     * 
     * @var Boolean
     */
    public $banned = false;

    /**
     * Le tableau de tous le roles que peut a voir un utilisateur (simple utilisateur,
     * modérateur, etc)
     * 
     * @Relation("MTM")
     * 
     * @table role
     * @var array par défaut tous le monde est simple utilisateur
     */
    private $role = array();

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function addRole($role) {
        array_push($this->role, $role);
    }

    public function removeRole($role) {
        array_pop($this->role, $role);
    }

    public function addPoints($points) {
        if ($points < 0) {
            log_message('error', 'utiliser removePoints() pour soustraire des points');
            return;
        }
        $this->points = $this->points + $points;
    }

    public function removePoints($points) {
        if ($points >= $this->points) {
            $this->points = $this->points - $points;
        } else {
            log_message('error', 'le nombre de points ne peut pas être négatif');
        }
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setEnabled($enabled) {
        $this->enabled = $enabled;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
    }

    public function setLast_login($last_login) {
        $this->last_login = $last_login;
    }

    public function setLocked($locked) {
        $this->locked = $locked;
    }

    public function setBanned($banned) {
        $this->banned = $banned;
    }

    public function setPoints($points) {
        $this->points = $points;
    }

    public function setGroupes($groupes) {
        $this->groupes = $groupes;
    }
}

/* end of class User */
?>
