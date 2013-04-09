<?php

/**
 * Permet de créer une requête SQL en utilisant certaines méthodes
 * classe abstraite
 *
 * @property DbForge $dbForge
 * @author leo
 */
abstract class QueryBuilder {

    /**
     *
     * @var String contient la parite select de la requête
     */
    protected $select = array('main_table' => array(), 'other_tables' => array());

    /**
     *
     * @var String contient la partie where de la requête. Sous forme PDO 
     */
    protected $where = array();

    /**
     *
     * @var String toute la requête. Prête pour PDO 
     */
    protected $query = '';

    /**
     *
     * @var mixed les variables de la partie where sous forme de tableau pour PDO 
     */
    protected $whereVars = array();

    /**
     *
     * @var String le nom de la table
     */
    protected $tableName = '';

    /**
     *
     * @var string le nom des champs de la table que l'on veut insérer 
     */
    protected $insertVars = '';

    /**
     *
     * @var array les valeures à utiliser pour une requête INSERT 
     */
    protected $insertValue = array();

    /**
     *
     * @var string le nom des champs pour une requête INSERT 
     */
    protected $insertFields = '';

    /**
     *
     * @var string le nom des champs pour une requête UPDATE 
     */
    protected $update = '';

    /**
     *
     * @var array les valeures à utiliser pour une requête UPDATE 
     */
    protected $updateValue = array();

    /**
     *
     * @var DbForge la classe qui gère les rapports avec les tables 
     */
    protected $dbForge = NULL;

    /**
     *
     * @var boolean pour savoir si il faut mémoriser le nom de la table entre deux requêtes
     */
    protected $keepTableName = FALSE;

    /**
     *
     * @var string contient la partie de la requête avec des jointures 
     */
    protected $joinON = '';

    /**
     *
     * @var arrray pour si on veut utiliser des valeures peut-être corrompues dans un JOIN 
     */
    protected $rightEqualityValues = array();

    /**
     *
     * @var string définit quel champs de la table en fonction de la langue aller chercher.
     */
    protected $language = '';

    /**
     * initialise les variables avec les bonnes valeures
     */
    public function __construct() {
        $this->flushQuery();
        $this->dbForge = NULL;
        $this->keepTableName = FALSE;
    }

    /**
     * pour enregistrer les données de la partie WHERE de la requête
     */
    public abstract function where($name, $var, $op = '', $rel = '=', $noTable = FALSE);

    /**
     * pour retourner la partie WHERE de la requête
     */
    protected abstract function getWhere();

    /**
     * retourner la partie des champs séléctioné de la requête ie: ...user.id, user.username...
     */
    protected abstract function getFields();

    /**
     * @return $this
     */
    public abstract function fields($fieldsData);

    public abstract function insertData($field, $var);

    public abstract function updateData($field, $var);

    public abstract function select($entity = NULL, $id = -1);

    public abstract function insert($entity = NULL);

    public abstract function delete($entity = NULL, $id = -1);

    public abstract function update($entity = NULL, $id = -1);

    public abstract function getSelect();

    public abstract function getInsert();

    public abstract function getUpdate();

    public abstract function getDelete();

    public abstract function join($tableName, $leftEquality, $rightEquality, $join = 'LEFT', $rel = '=');

    public abstract function getLangId($iso);
    
    public abstract function findReferenceLang();

    /**
     * 
     * @return array les valeures de la partie where et de la partie join 
     */
    public function getWhereVars() {
        return array_merge($this->whereVars, $this->rightEqualityValues);
    }

    /**
     * 
     * @return string le nom de la table
     */
    public function getTableName() {
        return $this->tableName;
    }

    /**
     * 
     * défini le nom de la table pour construire la requête
     * si le nom est un objet, obtien son nom avec la méthode <code>getTable()</code>
     * 
     * @param string ou object $tableName le nom de la table ou l'entité qui s'y refère
     * @param boolean $keepIt$ pour mémoriser le nom entre deux requêtes
     */
    public function setTableName($tableName, $keepIt = FALSE) {
        if (is_object($tableName)) {
            $this->tableName = $this->getDbForge()->getTable($tableName);
        } else {
            $this->tableName = $tableName;
        }
        $this->keepTableName = $keepIt;
        return $this;
    }

    /**
     * retourne toutes les valeures possibles d'une requête.
     * Même celle qui sont inutilisées
     * @return array toutes les valeures d'une requête
     */
    public function getAllValues() {
        $allValues = array();
        $allValues = array_merge($this->whereVars, $allValues);
        $allValues = array_merge($this->insertValue, $allValues);
        $allValues = array_merge($this->updateValue, $allValues);
        return $allValues;
    }

    /*
     * accesseur
     * @return la requête
     */

    public function getQuery() {
        return $this->query;
    }

    /**
     * mutateur enrgistre le requête
     * @param string $query le requête
     */
    public function setQuery($query) {
        $this->query = $query;
    }

    /**
     * mutateur renseigne la classe sur quelle DBForge utiliser
     * @param DbForge $dbForge
     */
    public function setDBForge($dbForge) {
        $this->dbForge = $dbForge;
    }

    /**
     * accesseur
     * @return DbForge
     */
    public function getDbForge() {
        return $this->dbForge;
    }

    /**
     * réinitialise tous les champs pour créer une nouvelle requête
     */
    public function flushQuery() {
        $this->select = array('main_table' => array(), 'other_tables' => array());
        $this->where = array();
        $this->query = '';
        $this->whereVars = array();
        $this->insertVars = '';
        $this->insertValue = array();
        $this->update = '';
        $this->updateValue = array();
        $this->query = '';
        $this->joinON = '';
        $this->insertFields = '';
        $this->rightEqualityValues = array();
        $this->language = '';
        if (!$this->isTableNameKepped()) {
            $this->tableName = '';
        }
    }

    public function isTableNameKepped() {
        return $this->keepTableName;
    }

    public function setKeepTableName($keepTableName) {
        $this->keepTableName = $keepTableName;
    }

    public function getInsertValue() {
        return $this->insertValue;
    }

    public function getUpdateValue() {
        return $this->updateValue;
    }

    public function isNoFields() {
        return empty($this->select);
    }

    public function isEmptyWhereClause() {
        return empty($this->whereVars);
    }
    
    public function getLanguage() {
        return $this->language;
    }

    public function setLanguage($language) {
        $this->language = $language;
    }
}

?>
