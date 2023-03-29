<?php

include_once 'head.php';
include_once 'classes/Database.php';
 
try {
    $conn = new Database();
    $database = $conn->getConnection();
    
    }
    catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
// if pour la completude du formulaire 

   if(!empty($_POST)){

// if pour la connexion

    if(isset($_POST["user"],$_POST["pass"]) && !empty($_POST["user"]) && !empty($_POST["pass"])){
        $pseudo = strip_tags($_POST["user"]);
echo "Bonjour ". $pseudo;
    }
   
// if pour l'inscription

    if(isset($_POST["user"],$_POST["pass"],$_POST["pass2"],$_POST["email"]) && !empty($_POST["user"])&& !empty($_POST["pass2"])&& !empty($_POST["email"]) && !empty($_POST["pass"]) && $_POST["pass2"] === $_POST["pass"]){

        $pseudo = strip_tags($_POST["user"]);

        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $error = "Email incorrecte";
        }
       


        $sql = "INSERT INTO tamagotchi_users (pseudo, password, email) VALUES(:pseudo, '$pass', :email)";
      
        $query = $database->prepare($sql);
        $query->bindValue(":pseudo", $pseudo, PDO::PARAM_STR);
        $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
        $query->execute();
        $id = $database->lastInsertId();

        include_once 'classes/Tamagotchi.php';
        $Tamagotchi =  new Tamagotchi($conn,$id);
        //hash du mdp
        $pass = password_hash($_POST["pass"], PASSWORD_ARGON2ID);
        $Tamagotchi->$name = "Test";
        $hunger = "Test";
        $happiness = "Test";
        $age = "Test";
        $energy = "Test";
        $personality = "Test";
        $last_updated = time();

        $sql2 = "INSERT INTO tamagotchi_pets (id, name, hunger, happiness, age, energy, personality, last_updated) VALUES('$id',:name,:hunger,:happiness,:age,:energy,:personality,:last_updated)";

        $query2 = $database->prepare($sql2);

        $query2->bindValue(":name", $name, PDO::PARAM_STR);
        $query2->bindValue(":hunger", $hunger, PDO::PARAM_STR);
        $query2->bindValue(":happiness", $happiness, PDO::PARAM_STR);
        $query2->bindValue(":age", $age, PDO::PARAM_STR);
        $query2->bindValue(":energy", $energy, PDO::PARAM_STR);
        $query2->bindValue(":personality", $personality, PDO::PARAM_STR);
        $query2->bindValue(":last_updated", $last_updated, PDO::PARAM_STR);
       
        $query2->execute();

        echo "Insertion du Tamagotchi : ". $name. "créée !";
    }
   }
    
    if (isset($_SESSION["user"]["pseudo"]))
    {
      include_once 'game.php';
   
    } else { ?>
    <div class="registration-form">
      <div class="selectType">

        <button onclick="login()" id="loginBtn" type="button" class="toggle-btn btnstyle">Se connecter</button>
        <button onclick="register()" id="registerBtn" type="button" class="toggle-btn">S'inscrire</button>
      
      </div>
      <div class="forms">
      <form method="$_POST" id="myFormLogin" enctype="multipart/form-data" class="input-group">
      <div id="response_message"></div>
              <input type="text" class="form-control " name="user" required placeholder="login">
              <input type="password" class="form-control " placeholder="Mot de passe" name="pass" autocomplete="new-password" required>
         
              <button type="submit"  id="btnSignIp" class="submit-btn " value="connexion">Connexion</button> 
      </form>
      <form method="$_POST" id="myFormRegister" enctype="multipart/form-data" class="input-group">
      <div id="response_message"></div>
              <input type="text" class="form-control " name="user" required placeholder="login">
     
              <input type="password" class="form-control " placeholder="Mot de passe" name="pass" autocomplete="new-password" required>
       
              <input type="password" class="form-control " id="pass2" placeholder="Mot de passe identique" name="pass2" >
  
              <input type="email" class="form-control" id="email" placeholder="Adresse mail" name="email" >
         
              <button type="submit"  id="btnSignUp" class="submit-btn " value="S'inscrire">S'inscrire</button>    
      </form>
      </div>
      <div class="errors">
        <?php echo $error; ?>
      </div>
  </div>
    <?php }
    
    
   
        
include_once 'footer.php';


    ?>

      
    

