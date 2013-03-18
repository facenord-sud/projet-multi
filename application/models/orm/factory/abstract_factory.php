<?php
/**
 * classe abstraite pour créer un nouveau module de gestion de base de données
 * Par exemple un module pour une bdd en XML.
 * <br/>
 * Toutes les classes qui l'étendent doivent être Nom_du_module_Factory.php
 *
 * @author leo
 */
abstract class AbstractFactory {

    private function _getRequirePath() {
        return APPPATH.'/models/orm';
    }

        protected function loadQueryBuilder() {
        require_once $this->_getRequirePath().'/db/query_builder.php';
    }
    
    protected function loadBDForge() {
        require_once $this->_getRequirePath().'/db/db_forge.php';
    }
    
    protected function loadDBDriver() {
        require_once $this->_getRequirePath().'/driver/db_driver.php';
    }

    public abstract function getQueryBuilder();
    
    public abstract function getDbForge();
    
    public abstract function getDbDriver();
    
    
}

?>
