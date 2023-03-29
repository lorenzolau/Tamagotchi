<?PHP 

class Tamagotchi {

private $id;
private $user_id;
private $name;
private $hunger;
private $happiness;
private $age;
private $personality;
private $energy;
private $last_updated;

private $db_conn;

public function __construct($db_conn,$user_id) {
  $this->db_conn = $db_conn;
  $this->user_id = $user_id;
}

public function setAge($age) {
    $this->age = $age;
  }
  
  public function getAge() {
    return $this->age;
  }

  public function setPersonality($personality) {
    $this->personality = $personality;
  }
  
  public function getPersonality() {
    return $this->personality;
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

public function setLastUpdated($last_updated) {
  $this->last_updated = $last_updated;
}

public function getLastUpdated() {
  return $this->last_updated;
}

  
public function save() {
  if ($this->id) {
    $query = $this->db_conn->prepare("UPDATE tamagotchi_pets SET name = :name, hunger = :hunger, happiness = :happiness, age = :age, personality = :personality, energy = :energy,  last_updated = :last_updated WHERE id = :id AND user_id = :user_id");
    $query->bindParam(":id", $this->id);
  } else {
    $query = $this->db_conn->prepare("INSERT INTO tamagotchi_pets (id, user_id, name, hunger, happiness, age, energy, personality, last_updated) VALUES (:id, :user_id, :name, :hunger, :happiness, :age, :energy, :personality, :last_updated)");
  }
  $query->bindParam(":id", $this->id);
  $query->bindParam(":user_id", $this->user_id);
  $query->bindParam(":name", $this->name);
  $query->bindParam(":hunger", $this->hunger);
  $query->bindParam(":happiness", $this->happiness);
  $query->bindParam(":age", $this->age);
  $query->bindParam(":energy", $this->energy);
  $query->bindParam(":personality", $this->personality);
  $query->bindParam(":last_updated", $this->last_updated);

  $query->execute();

  if (!$this->id) {
    $this->id = $this->db_conn->lastInsertId();
  }
}

public function readOne($id,$user_id) {
  $query = $this->db_conn->prepare("SELECT * FROM tamagotchi_pets WHERE  id = :id AND user_id = :user_id");
  $query->bindParam(":id", $id);
  $query->bindParam(":user_id", $user_id);
  $query->execute();

  if ($tamagotchi_data = $query->fetch(PDO::FETCH_ASSOC)) {
    $this->id = $tamagotchi_data['id'];
    $this->user_id = $tamagotchi_data['user_id'];
    $this->age = $tamagotchi_data['age'];
    $this->name = $tamagotchi_data['name'];
    $this->happiness = $tamagotchi_data['happiness'];
    $this->hunger = $tamagotchi_data['hunger'];
    $this->energy = $tamagotchi_data['energy'];
    $this->happiness = $tamagotchi_data['happiness'];
    $this->last_updated = $tamagotchi_data['last_updated'];
    return true;
  } else {
    return false;
  }
}

}