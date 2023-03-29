<?php
include_once 'head.php';
// Inclure les classes nécessaires
require_once 'classes/Database.php';
require_once 'classes/Food.php';
require_once 'classes/Game.php';
require_once 'classes/Health.php';
require_once 'classes/Tamagotchi.php';


// define variables and set to empty values
$pseudoErr = $emailErr = $passErr = "";
$pseudo = $email = $pass = "";

if (!isset($_SESSION["user"]))
{
  header("location: index.php");

} else {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["type"])) {
     
    }
    else{
      $posteType = $_POST["type"];
      switch($posteType){
        case 'eat':
            echo 'La réponse est eat';
          break;
          case 'light':
            echo 'La réponse est light';
             
          break;
          case 'play':
            echo 'La réponse est play';
          break;
          case 'heal':
            echo 'La réponse est heal';
          break;
          case 'wash':
            echo 'La réponse est wash';
          break;
          case 'stat':
            echo 'La réponse est stat';
          break;
          case 'scold':
            echo 'La réponse est scold';
          break;
      }
    }
  }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["pseudo"])) {
    $pseudoErr = "Name is required";
  } else {
    $pseudo = test_input($_POST["pseudo"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$pseudo)) {
      $pseudoErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
  if (empty($_POST["pass"])) {
    $passErr = "Password is required";
  } else {
    $pass = test_input($_POST["pass"]);
  
  }
}



function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function encryptpass($user, $pass) {
    $user = strtoupper($user);
    $pass = strtoupper($pass);
    return sha1($user.':'.$pass);
  }
  try {
  $conn = new Database();
  $database = $conn->getConnection();
    $stmt = $database->prepare("SELECT id FROM tamagotchi_users WHERE pseudo = '.$pseudo.' AND password = '.$password.'");
    $stmt->execute();
    $resultPets = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $stmtPets = $database->prepare("SELECT id FROM tamagotchi_pets WHERE idj = '.$id.'");
    $stmtPets->execute();
var_dump($result);

    $_SESSION["pseudo"] = $pseudo;

  }
  catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
    $password = encryptpass($username, $pass);
    $tamagotchiName = $_POST['tamagotchiName'];
     
 
  $response = array('success' => false);
  
  if(isset($_POST['user']) && $_POST['user']!='' && isset($_POST['pass']) && $_POST['pass']!='' && isset($_POST['email']) && $_POST['email']!='')
  {
  
      $sql = "INSERT INTO tamagotchi_users (id, pseudo, password, email) VALUES('".addslashes($_POST['pseudo'])."', '".$password."', '".addslashes($_POST['email'])."')";
      
      $sql2 = "INSERT INTO tamagotchi_pets (id, user_id, name, hunger, happiness, age, energy, personality, last_updated) VALUES('".addslashes($tamagotchiName)."', '".$password."', '".addslashes($_POST['email']).", '".$exp."')";
      
 
  }
  
 json_encode($response);

$id_SESSION = 1;
$idUserSession = 1;

// Créer une instance de connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Créer une instance de Tamagotchi avec l'ID 1
$tamagotchi = new Tamagotchi($db,$idUserSession);
$id_tama = $tamagotchi->readOne($id_SESSION,$idUserSession);

// Vérifier si le formulaire de nourriture a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['food'])) {
  // Créer une instance de nourriture et nourrir le Tamagotchi
  $food = new Food($db);
  $food->feed($tamagotchi,$id_tama);
}

// Vérifier si le formulaire de jouet a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['soigner'])) {
  // Créer une instance de jouet et jouer avec le Tamagotchi
  $heel = new Health($db);
  $heel->heel($tamagotchi);
}

// Vérifier si le formulaire de jeu a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['game'])) {
  // Créer une instance de jeu et jouer avec le Tamagotchi
  $game = new Game($tamagotchi,$health);
  $game->play($tamagotchi);
}

// Vérifier l'état de santé du Tamagotchi
$health = new Health($db);
$health->checkHealth();

?>

<div class="game">
<div class="game-stats">
      <h5 class="stats">Tamagotchi</h5>
      <div class="item">
      <div class="stats">Nom : <?php echo $tamagotchi->getName(); ?></div>
      </div>
      <div class="item">
      <div class="stats">Niveau d'énergie : <?php echo $tamagotchi->getEnergy() ?></div>
      </div>
      <div class="item">
      <div class="stats">Faim : <?php echo $tamagotchi->getHunger() ?></div>
      </div>
      <div class="item">
      <div class="stats">Age : <?php 
      $timestamp = time();
      $ageTime = round(($timestamp - $tamagotchi->getAge())*100/(3600*24),0);
      echo  $ageTime." ans";  ?>
      </div>
      </div>
      <div class="item">
      <div class="stats">Humeur : <?php echo $tamagotchi->getHappiness(); ?></div>
      </div>
      </div>
    
  
  <div class="tamagotchi">
  <div class="icons">
  <div class="icon eat" id="eat"></div>
  <div class="icon light" id="light"></div>
  <div class="icon play" id="play"></div>
  <div class="icon heal" id="heal"></div>
</div>
<div class="screen">
 </div>
<div class="icons">
  <div class="icon wash" id="wash"></div>
  <div class="icon stat" id="stat"></div>
  <div class="icon scold" id="scold"></div>
  <div class="icon help" id="help"></div>
</div>
  </div>
  <div class="buttons">
  <div onclick="buttonAClicked();" class="button" id="buttonA"></div>
  <div onclick="buttonBClicked();" class="button" id="buttonB"></div>
  <div onclick="buttonCClicked();" class="button" id="buttonC"></div>
  </div>
</div>
<?php }
    
    session_destroy();
    setcookie('PHPSESSID', '', time() - 3600);
        
include_once 'footer.php';


    ?>