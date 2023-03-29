<?php
require_once 'includes/config.php';
require_once 'classes/JWT.php';
include_once 'head.php';
 
 // On crée le contenu (payload)
 $payload = [
     'user_id' => 123,
     'roles' => [
         'ROLE_ADMIN',
         'ROLE_USER'
     ],
     'email' => 'contact@demo.fr'
 ];
 
 $jwt = new JWT();
 
 $token = $jwt->generate($payload, SECRET);
 
 echo $token;

 include_once 'footer.php';
