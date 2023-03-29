<?php

class Toy {

    private $id;
    private $name;
    private $game;
  
    private $db_conn;
  
    public function __construct($db_conn) {
      $this->db_conn = $db_conn;
    }
  
    public function setId($id) {
      $this->id = $id;
    }
  
    public function getId() {
      return $this->id;
    }
  
    public function setName($name) {
      $this->name = $name;
    }
  
    public function getName() {
      return $this->name;
    }
  
    public function setGame($game) {
      $this->game = $game;
    }
  
    public function getGame() {
      return $this->game;
    }
  
    public function playGame($guess) {
      $answer = rand(1, 9);
  
      if ($guess == $answer) {
        return "Bravo ! Vous avez deviné le nombre caché !";
      } else if ($guess < $answer) {
        return "Dommage, le nombre caché est plus grand que $guess.";
      } else {
        return "Dommage, le nombre caché est plus petit que $guess.";
      }
    }
  
    public function save() {
      if ($this->id) {
        $query = $this->db_conn->prepare("UPDATE toys SET name = :name, game = :game WHERE id = :id");
        $query->bindParam(":id", $this->id);
      } else {
        $query = $this->db_conn->prepare("INSERT INTO toys (name, game) VALUES (:name, :game)");
      }
      $query->bindParam(":name", $this->name);
      $query->bindParam(":game", $this->game);
  
      $query->execute();
  
      if (!$this->id) {
        $this->id = $this->db_conn->lastInsertId();
      }
    }
  
    public function load($id) {
      $query = $this->db_conn->prepare("SELECT * FROM toys WHERE id = :id");
      $query->bindParam(":id", $id);
      $query->execute();
  
      if ($toy_data = $query->fetch(PDO::FETCH_ASSOC)) {
        $this->id = $toy_data['id'];
        $this->name = $toy_data['name'];
        $this->game = $toy_data['game'];
        return true;
      } else {
        return false;
      }
    }
  
  }

  