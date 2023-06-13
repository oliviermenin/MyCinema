<?php
class Database
{
    private $host;
    private $user;
    private $password;
    private $db;
    protected $link;    
    
    public function __construct($host="127.0.0.1", $user="user", $password="password", $db="cinema") {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->db = $db;
        $this->link;
        try {
            $this->link = new PDO("mysql:host=".$this->host.";dbname=".$this->db, $this->user, $this->password);
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "Connecté à $this->db sur $this->host avec succès.";
        }
        catch (PDOException $e) {
  
            die("Impossible de se connecter à la base de données $this->db :" . $e->getMessage());
        }
    }

    public function getAllGenres() {
        $req = $this->link->prepare("SELECT id, name FROM genre");
        $req->execute();
        $genres = $req->fetchAll();
        // print($genres);
        return $genres;
    }
    
}

$bdd = new Database();
$bdd->getAllGenres();