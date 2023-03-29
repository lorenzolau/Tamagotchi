<?PHP
class Food {

  private $id;
  private $name;
  private $quantity;

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

  public function setQuantity($quantity) {
    $this->quantity = $quantity;
  }

  public function getQuantity() {
    return $this->quantity;
  }
  
  public function feed(Tamagotchi $tamagotchi, $num_burgers) {
    $hunger = $tamagotchi->getHunger();
    $hunger += $num_burgers;
    
    if ($hunger > 4) {
      $hunger = 4;
    }
    
    $tamagotchi->setHunger($hunger);
    $tamagotchi->save();
  }

  
  public function save() {
    if ($this->id) {
      $query = $this->db_conn->prepare("UPDATE foods SET name = :name, quantity = :quantity WHERE id = :id");
      $query->bindParam(":id", $this->id);
    } else {
      $query = $this->db_conn->prepare("INSERT INTO foods (name, quantity) VALUES (:name, :quantity)");
    }
    $query->bindParam(":name", $this->name);
    $query->bindParam(":quantity", $this->quantity);

    $query->execute();

    if (!$this->id) {
      $this->id = $this->db_conn->lastInsertId();
    }
  }

  public function load($id) {
    $query = $this->db_conn->prepare("SELECT * FROM foods WHERE id = :id");
    $query->bindParam(":id", $id);
    $query->execute();

    if ($food_data = $query->fetch(PDO::FETCH_ASSOC)) {
      $this->id = $food_data['id'];
      $this->name = $food_data['name'];
      $this->quantity = $food_data['quantity'];
      return true;
    } else {
      return false;
    }
  }

}
