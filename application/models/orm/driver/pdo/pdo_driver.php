<?php

/**
 * Description of PDO
 *
 * @property PDO $bdd
 * @author leo
 */
class Pdo_driver extends DbDriver {

    /**
     * connection à la bdd en utilisant pdo
     * gestion des erreures
     */
    public function connectDb() {
        try {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $bdd = new PDO('mysql:host=' . $this->getHost() . ';dbname=' . $this->getBddName() . '', $this->getUser(), $this->getMdp(), $pdo_options);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage() . '<br />
                N° : ' . $e->getCode());
        }
        $bdd->exec('SET NAMES utf8');
        $this->setBdd($bdd);
    }

    /**
     * execute la requête sql. utilise les proprieté de pdo pour linsertion de variables dans la requête
     * si une entité est passée en paramètre, rempli cette entitée
     * retourn un tableau associatif par défaut
     * 
     * @param string $query la requête PDO à excutée
     * @param aray[optional] $data les valeures à insérer dans la requête
     * @param Object[optional] $object l'entité à remplir avec la requête
     * @param int[optianl] $fetchMode la façon dont la requête est retournée
     * @return mixed <code>FALSE</code> si une erreure, sinon le résultat de l'exécution de la requête
     */
    public function execute($query, $data = array(), $object = NULL, $fetchMode = PDO::FETCH_ASSOC) {
        try {
            echo '<br>'.$query;
            print_r($data);
            echo '<br>';
            if (empty($data)) {
                $req = $this->getBdd()->query($query);
            } else {
                $req = $this->getBdd()->prepare($query);
                $req->execute($data);
            }
            if ($object == NULL) {
                $req->setFetchMode($fetchMode);
            } else {
                $req->setFetchMode(PDO::FETCH_INTO, $object);
            }

            if ($req->rowCount() == 0) {
                return FALSE;
            }

            $result = array();
            if (stripos($query, 'INSERT') !== FALSE or stripos($query, 'UPDATE') !== FALSE or stripos($query, 'DELETE') !== FALSE) {
                return TRUE;
            }
            if ($req->rowCount() == 1) {
                $result = $req->fetch();
            } else {
                $result = $req->fetchAll();
            }
            $req->closeCursor();
        } catch (Exception $e) {
            foreach ($e->getTrace() as $trace) {
                echo '<br/>';
                if (isset($trace['file']) and isset($trace['line'])) {
                    echo $trace['file'] . ' ' . $trace['line'];
                }
                echo'<br/>';
            }
            die('Erreur: ' . $e->getMessage() . '<br />
                N° : ' . $e->getCode() . '<br/> 
                    A la ligne:' . $e->getLine() . '<br/>');
        }

        return $result;
    }

    /**
     * compte le nombre de lignes retournées par la requête
     * @param string $query la requête
     * @param array $data les valeures à insérer dans la requête
     * @return int le nombre de ligne
     */
    public function count($query, array $data = array()) {
        try {
            $req = $this->getBdd()->prepare($query);
            $req->execute($data);
            $count = $req->rowCount();
            $req->closeCursor();
        } catch (Exception $e) {
            foreach ($e->getTrace() as $trace) {
                echo '<br/>';
                if (isset($trace['file']) and isset($trace['line'])) {
                    echo $trace['file'] . ' ' . $trace['line'];
                }
                echo'<br/>';
            }
            die('Erreur: ' . $e->getMessage() . '<br />
                N° : ' . $e->getCode() . '<br/> 
                    A la ligne:' . $e->getLine() . '<br/>');
        }
        return $count;
    }

}

?>
