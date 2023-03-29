<?php
class Database {
    private $host = 'pimalofrnigame.mysql.db';
    private $db_name = 'pimalofrnigame';
    private $username = 'pimalofrnigame';
    private $password = 'Lalola04021985';
    private $conn;
  
    public function getConnection() {
      $this->conn = null;
  
      try {
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $exception) {
        echo 'Erreur de connexion à la base de données : ' . $exception->getMessage();
      }
  
      return $this->conn;
    }
  }
  