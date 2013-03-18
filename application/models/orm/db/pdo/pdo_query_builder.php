<?php

/**
 * Crée une requête et gère SQL
 *
 * @test fait en majeure parite. encore tester tous les cas possible des méthodes fields et join
 * @see QueryBuilder
 * @author leo
 */
class Pdo_query_builder extends QueryBuilder {

    /**
     * indique quels champs de la tables on veut afficher
     * 
     * @param string $fieldsData le nom des champs de la table
     */
    public function fields($fieldsData) {
        array_push($this->select, $fieldsData);
        return $this;
    }

    /**
     * enregistre les données pour la création de la partie where de la requête
     * 
     * @param String $name le nom du champ de la table
     * @param var $var La valeure du champ
     * @param String[optional] $op L'opéreande i.e: OR ou AND AND par défaut
     * @param String[optional] $rel La relation entre le champ de la table et sa valeure i.e: =, <=, etc
     * @param boolean[optional] $noTable si on veut utiliser un champ d'une autre table
     * @return void
     */
    public function where($name, $var, $op = 'AND', $rel = '=', $noTable = FALSE) {
        $name = (string) $name;
        if ($noTable) {
            $this->whereVars[str_replace('.', '_', $name)] = $var;
        } else {
            $this->whereVars[$name] = $var;
        }
        array_push($this->where, array('name' => $name, 'var' => $var, 'op' => $op, 'rel' => $rel, 'no_table' => $noTable));
        return $this;
    }

    /**
     * crée la partie JOIN de la requête.
     * Quand le paramètre <code>$leftEquality</code> est un tableau. Utilise une requêtze préparé avec
     * la valeure de ce paramètre 
     * 
     * @param string $tableName le nom de la table dans la partie ... JOIN nom_de_la_table ON ...
     * @param string $leftEquality la partie gauche de la compraison
     * @param string ou mixed $rightEquality la partie droite de la comparaiso 
     * @param string $join le type de jointure (INNER, LEFTm ...)
     * @param string $rel la relation (= >= etc)
     */
    public function join($tableName, $leftEquality, $rightEquality, $join = 'INNER', $rel = '=') {
        if (is_array($rightEquality)) {
            $this->rightEqualityValues[$rightEquality] = $rightEquality;
            $rightEquality = ':' . $rightEquality;
        }
        $this->joinON.="$join JOIN $tableName ON $leftEquality $rel $rightEquality ";
        return $this;
    }

    /**
     * Pour créer une requête de type INSERT
     * quand $field et $var sont des tableaux c'est équivalent à appeler plusieurs fois la requête
     * @param string ou mixed $field le ou les champs dans les quels on veut insérer une
     * nouvelle valeure
     * @param string ou mixed $var la valeure du champ inséré
     */
    public function insertData($field, $var) {
        if (is_array($field) and is_array($var)) {
            foreach ($field as $key => $f) {
                $this->insertFields.=$f . ', ';
                $this->insertVars.= ":$f, ";
                $this->insertValue[$field] = $var[$key];
            }
        } else {
            $this->insertFields.=$field . ', ';
            $this->insertVars.=":$field, ";
            $this->insertValue[$field] = $var;
        }
        return $this;
    }

    /**
     * Crée la partie UPDATE de la requête. Si des tableaux sont passés en paramètre,
     * équivalent à plusieurs appels de cet méthode
     * @param string ou mixed $field le nom du champ à mettre à jour
     * @param string ou array $var la valeure du champ à mettre à jour
     */
    public function updateData($field, $var) {
        if (is_array($field) and is_array($var)) {
            foreach ($field as $key => $f) {
                $this->update.="$f=:$f, ";
                $this->updateValue[$f] = $var[$key];
            }
        }
        $this->update.="$field=:$field, ";
        $this->updateValue[$field] = $var;
        return $this;
    }

    /**
     * exécute une requête de type DELETE
     * 
     * @param Object[optional] $entity l'entité à supprimer dans la table
     * @param int[optional] $id l'id de l'entité
     * @return mixed le résultat de la requête
     */
    public function delete($entity = NULL, $id = -1) {
        $this->_useEntity($entity, $id);
        $this->getDelete();
        $deleteRes = $this->dbForge->getDriver()->execute($this->query, $this->whereVars);
        $this->flushQuery();
        return $deleteRes;
    }

    /**
     * exécute une requête de type INSERT
     * 
     * @param Object[optional] $entity l'entité à insérer dans la table
     * @return mixed le résultat de la requête
     */
    public function insert($entity = NULL) {
        if ($entity != NULL and is_object($entity)) {
            $this->setTableName($this->dbForge->getTable($entity));
        }
        $this->getInsert();
        $insertRes = $this->dbForge->getDriver()->execute($this->query, $this->insertValue);
        $this->flushQuery();
        return $insertRes;
    }

    /**
     * exécute une requête de type SELECT
     * 
     * @param Object[optional] $entity l'entité à rechercher dans la table
     * @param int[optional] $id l'id de l'entité
     * @return mixed le résultat de la requête
     */
    public function select($entity = NULL, $id = -1) {
        $this->_useEntity($entity, $id);
        $this->getSelect();
        $selectRes = $this->dbForge->getDriver()->execute($this->query, $this->whereVars);
        $this->flushQuery();
        return $selectRes;
    }

    /**
     * exécute une requête de type UPDATE
     * 
     * @param Object[optional] $entity l'entité à mettre à jour dans la table
     * @param int[optional] $id l'id de l'entité
     * @return mixed le résultat de la requête
     */
    public function update($entity = NULL, $id = -1) {
        $this->_useEntity($entity, $id);
        $this->getUpdate();
        $updateRes = $this->dbForge->getDriver()->execute($this->query, array_merge($this->whereVars, $this->updateValue));
        $this->flushQuery();
        return $updateRes;
    }

    /**
     * retourne une requête SQL de type DELETE
     * 
     * @return string une requête SQL
     */
    public function getDelete() {
        if (empty($this->whereVars)) {
            $this->query = "DELETE FROM $this->tableName";
        } else {
            $this->query = "DELETE FROM $this->tableName WHERE " . $this->getWhere();
        }
        return $this->query;
    }

    /**
     * retourne une requête SQL de type INSERT
     * 
     * @return string une requête SQL
     */
    public function getInsert() {
        $this->query = "INSERT INTO $this->tableName (" . substr($this->insertFields, 0, -2) . ") VALUES (" . substr($this->insertVars, 0, -2) . ')';
        return $this->query;
    }

    /**
     * retourne une requête SQL de type SELECT
     * 
     * @return string une requête SQL
     */
    public function getSelect() {
        if (empty($this->whereVars)) {
            $this->query = "SELECT " . $this->getFields() . " FROM $this->tableName " . $this->joinON;
        } else {
            $this->query = "SELECT " . $this->getFields() . " FROM $this->tableName " . $this->joinON . " WHERE " . $this->getWhere();
        }
        return $this->query;
    }

    /**
     * retourne une requête SQL de type UPDATE
     * 
     * @return string une requête SQL
     */
    public function getUpdate() {
        if (empty($this->whereVars)) {
            $this->query = "UPDATE $this->tableName SET ".substr($this->update, 0, -2);
        } else {
            $this->query = "UPDATE $this->tableName SET ".substr($this->update, 0, -2)." WHERE " . $this->getWhere();
        }
        return $this->query;
    }

    /**
     * contrôle si l'entité peut vraiment être utilisé
     * 
     * @param Object $entity une entité
     * @param int $id l'id de l'entité
     */
    private function _useEntity($entity, $id) {
        if ($entity != NULL and is_object($entity)) {
            $this->setTableName($this->dbForge->getTable($entity));
            if ($id == -1) {
                if (!isset($entity->id)) {
                    log_message('error', 'Une entité à besoin d\'un id', TRUE);
                }
                $id = $entity->id;
            }
            $this->where('id', $id);
        }
    }

    /**
     * renvoie la partie WHERE de la requête
     * 
     * @return string la clause where d'une requête
     */
    protected function getWhere() {
        $whereClause = "";
        foreach ($this->where as $where) {
            if ($where['no_table'] == TRUE) {
                $whereTableName = $where['name'];
                $relRight = str_replace('.', '_', $where['name']);
            } else {
                $whereTableName = $this->tableName . "." . $where['name'];
                $relRight = $where['name'];
            }
            $whereClause.=$whereTableName . " " . $where['rel'] . " :" . $relRight . " " . $where['op']." ";
        };
        return substr($whereClause, 0, -4);
    }

    /**
     * permet de construire la clause de séléction.
     * i.e: user.username, user.id ->la requête va retourner le username et l'id 
     * de la table user
     * 
     * @author leo
     * @test pas fait
     * @return string le ou les fields
     */
    protected function getFields() {
        $fields = '';
        foreach ($this->select as $field) {
            if (is_array($field)) {
                foreach ($field as $subField) {
                    if ((string) $subField == "*") {
                        return '*';
                    } else {
                        $fields.="$this->tableName.$subField, ";
                    }
                }
            } else if (is_string($field)) {
                if ($field == '*') {
                    return '*';
                    break;
                } else {
                    $fields .= "$this->tableName.$field, ";
                }
            }
        }
        if (empty($fields)) {
            return '*';
        }

        return substr($fields, 0, -2);
    }

}

?>
