<?php 

class User{

  private $id;
  private $user_id;
  private $pseudo;
  private $email;
  private $db_conn;

  
  public function __construct($db_conn,$user_id) {
    $this->db_conn = $db_conn;
    $this->user_id = $user_id;
  }
  
    public function setEmail($email) {
      $this->email = $email;
    }
    
    public function getEmail() {
      return $this->email;
    }
    public function setId($id) {
      $this->id = $id;
    }
    
    public function getId() {
      return $this->id;
    }
    public function setPseudo($pseudo) {
      $this->pseudo = $pseudo;
    }
    
    public function getPseudo() {
      return $this->pseudo;
    }

    public function save() {
      if ($this->id) {
        $query = $this->db_conn->prepare("UPDATE tamagotchi_pets SET pseudo = :pseudo, email = :email WHERE id = :id AND user_id = :user_id");
        $query->bindParam(":id", $this->id);
      } else {
        $query = $this->db_conn->prepare("INSERT INTO tamagotchi_pets (id, user_id, pseudo, email) VALUES (:id, :user_id, :name)");
      }
      $query->bindParam(":id", $this->id);
      $query->bindParam(":user_id", $this->user_id);
      $query->bindParam(":pseudo", $this->pseudo);
      $query->bindParam(":email", $this->email);
    
    
      $query->execute();
    
      if (!$this->id) {
        $this->id = $this->db_conn->lastInsertId();
      }
    }

}