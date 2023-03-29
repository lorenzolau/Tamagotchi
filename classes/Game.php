<?php
class Game {

   
    private Tamagotchi $tamagotchi;
    private $health;
  
    public function __construct($tamagotchi, $health) {
      $this->tamagotchi = $tamagotchi;
      $this->health = $health;
    }
  
    
    public function play($userChoice) {
         $attempts = 0;
         switch($userChoice){
            case '+';
            
            break;
            case '-';
            break;
            default:
            break;
    
        }
    
        while ($attempts < 5) {
            do {
                $number1 = rand(1, 9);
                $number2 = rand(1, 9);
              } while ($number2 === $number1);
              echo "Jeu : Devine le nombre entre 1 et 9\n";
              echo "Est-il plus petit ou plus grand que $number1 ?\n";
          
    
          if ($userChoice < $number2) {
            echo "Le nombre est plus grand que $userChoice\n";
          } elseif ($userChoice > $number2) {
            echo "Le nombre est plus petit que $userChoice\n";
          } else {
            echo "Bravo, vous avez trouvé le nombre $userChoice !\n";
            $this->health->increaseHappiness();
            $this->health->decreaseHunger();
            break;
          }
    
          $attempts++;
        }
    
        if ($number1 != $number2) {
          echo "Dommage, vous avez perdu. Le nombre était $number2\n";
          $this->health->decreaseHappiness();
          $this->health->decreaseEnergy();
        }
 
        $this->tamagotchi->save();
        $this->health->save();
      }
    
  }
  