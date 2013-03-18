<?php

/**
 * classe abstraite définissant les méthodes pour intérargir avec les tables
 * utiliser u driver pour excuter les requêtes
 *
 * @property DbDriver $driver
 * @author leo
 */
abstract class DbForge {

    /**
     *
     * @var DbDriver le driver qui s'occupe de la connection à la bdd et de l'excution des requêtes 
     */
    protected $driver;

    public abstract function isTable($tabelName);

    public abstract function getFields($tableName);

    public function setDriver($driver) {
        $this->driver = $driver;
    }

    public function getDriver() {
        return $this->driver;
    }

    /**
     * Ca va chercher le nom de table grâce à la class (car elle porte le même nom)
     * @return string
     */
    public function getTable($object) {
        // ça met en minuscul, ça enlève le _entity à la fin
        if (is_object($object)) {
            $object = get_class($object);
        }
        return str_replace('_entity', '', strtolower($object));
    }

}

?>
