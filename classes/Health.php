<?php

class Health {

    private $tamagotchi_id;
    private $user_id;
    private $hunger;
    private $happiness;
    private $energy;
  
    private $db_conn;
  
    public function __construct($db_conn) {
      $this->db_conn = $db_conn;
    }
  
    public function setId($tamagotchi_id) {
      $this->tamagotchi_id = $tamagotchi_id;
    }
  
    public function getId() {
      return $this->tamagotchi_id;
    }
  
    public function setTamagotchiId($tamagotchi_id) {
      $this->tamagotchi_id = $tamagotchi_id;
    }
  
    public function getTamagotchiId() {
      return $this->tamagotchi_id;
    }
  
    public function setHunger($hunger) {
      $this->hunger = $hunger;
    }
  
    public function getHunger() {
      return $this->hunger;
    }
  
    public function setHappiness($happiness) {
      $this->happiness = $happiness;
    }
  
    public function getHappiness() {
      return $this->happiness;
    }
  
    public function setEnergy($energy) {
      $this->energy = $energy;
    }
  
    public function getEnergy() {
      return $this->energy;
    }
  
    public function decreaseHunger() {
      $this->hunger -= 5;
      if ($this->hunger < 0) {
        $this->hunger = 0;
      }
    }
  
    public function increaseHappiness() {
      $this->happiness += 5;
      if ($this->happiness > 100) {
        $this->happiness = 100;
      }
    }
  
    public function decreaseEnergy() {
      $this->energy -= 5;
      if ($this->energy < 0) {
        $this->energy = 0;
      }
    }
    public function heel() {
        $this->energy += 5;
        if ($this->energy > 50) {
          $this->energy = 50;
        }
      }

    public function checkHealth() {
        $health = array(
          'hunger' => $this->hunger,
          'happiness' => $this->happiness,
          'energy' => $this->energy
        );
        return $health;
      }
  
    public function save() {
      if ($this->tamagotchi_id) {
        $query = $this->db_conn->prepare("UPDATE tamagotchi_pets SET hunger = :hunger, happiness = :happiness, energy = :energy WHERE id = :id AND user_id = :user_id");
        $query->bindParam(":id", $this->tamagotchi_id);
      } else {
        $query = $this->db_conn->prepare("INSERT INTO tamagotchi_pets (id, user_id, hunger, happiness, energy) VALUES (:user_id, :hunger, :happiness, :energy)");
      }
      $query->bindParam(":id", $this->tamagotchi_id);
      $query->bindParam(":user_id", $this->user_id);
      $query->bindParam(":hunger", $this->hunger);
      $query->bindParam(":happiness", $this->happiness);
      $query->bindParam(":energy", $this->energy);
  
      $query->execute();
  
      if (!$this->tamagotchi_id) {
        $this->tamagotchi_id = $this->db_conn->lastInsertId();
      }
    }
  
    public function load($tamagotchi_id) {
      $query = $this->db_conn->prepare("SELECT * FROM tamagotchi_pets WHERE id = :id AND user_id = :user_id");
      $query->bindParam(":id", $tamagotchi_id);
      $query->execute();
  
      if ($health_data = $query->fetch(PDO::FETCH_ASSOC)) {
        $this->tamagotchi_id = $health_data['id'];
        $this->user_id = $health_data['user_id'];
        $this->hunger = $health_data['happiness'];
        $this->energy = $health_data['energy'];
        }
        }
        }
  