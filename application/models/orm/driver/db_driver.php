<?php

/**
 * classe abstraite permettant le lien entre le php et la bdd
 * càd connection et exécution de requête
 *
 * @author leo
 */
abstract class DbDriver {

    /**
     *
     * @var string la connection à la bdd. utilisé pour interroger la bdd
     */
    private $bdd;
    
    /**
     *
     * @var string le nom de l'utilisateur 
     */
    private $host;
    
    /**
     *
     * @var string le nom de la base de donnée 
     */
    private $bddName;
    
    /**
     *
     * @var string le nom de l'utilisateur 
     */
    private $user;
    
    /**
     *
     * @var string l emot de passe 
     */
    private $mdp;

    /**
     * récupère les infos de connexion dans le fichier et se connect à la bonne bdd
     */
    public function __construct() {
        $configDb = & get_instance()->db;
        $this->host = $configDb->hostname;
        $this->bddName = $configDb->database;
        $this->user = $configDb->username;
        $this->mdp = $configDb->password;
        $this->connectDB();
    }

    public abstract function execute($query, $data = array());

    public abstract function count($query, array $data = array());

    public abstract function connectDb();

    /**
     * 
     * @return PDO
     */
    public function getBdd() {
        return $this->bdd;
    }

    public function setBdd($bdd) {
        $this->bdd = $bdd;
    }

    public function getHost() {
        return $this->host;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function getBddName() {
        return $this->bddName;
    }

    public function setBddName($bddName) {
        $this->bddName = $bddName;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getMdp() {
        return $this->mdp;
    }

    public function setMdp($mdp) {
        $this->mdp = $mdp;
    }

}

?>
