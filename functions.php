<?php
include 'connexion.php';

class Database {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $conn;

    public function __construct($host, $dbname, $username, $password) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getAllMemories() {
        $db = new PDO('mysql:host=localhost;dbname=examenphp', 'root', '');
        $sql = "SELECT * FROM memoire";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $memories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
        return $memories;
    }

    public function deleteMemory($memory_id) {
      try {
        $sql = "DELETE FROM memoire WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $memory_id);
        $stmt->execute();
        echo "Mémoire supprimée avec succès.";
    } catch(PDOException $e) {
        echo "Erreur lors de la suppression du mémoire: " . $e->getMessage();
    }
      
    }

    public function modifyMemory($memory_id, $new_title, $new_theme, $new_owner, $new_name) {
        $db = new PDO('mysql:host=localhost;dbname=examenphp', 'your_username', 'your_password');
        $sql = "UPDATE memoire SET titre = :titre, theme = :theme, proprietaire = :proprietaire WHERE id_memoire = :id_memoire";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_memoire', $id_memoire);
        $stmt->bindParam(':titre', $nouveau_titre);
        $stmt->bindParam(':theme', $nouveau_theme);
        $stmt->bindParam(':proprietaire', $nouveau_proprietaire);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "Mémoire modifiée avec succès : " . $id_memoire . "<br>";
        } else {
            echo "Échec de la modification de la mémoire : " . $id_memoire . "<br>";
        }
    
        $db = null;
    }
}
?>
