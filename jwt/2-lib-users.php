<?php
class User {
  // (A) CONNECT TO DATABASE
  public $error = "";
  private $pdo = null;
  private $stmt = null;
  function __construct () {
    $this->pdo = new PDO(
      "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
      DB_USER, DB_PASSWORD, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  }

  // (B) CLOSE CONNECTION
  function __destruct () {
    if ($this->stmt!==null) { $this->stmt = null; }
    if ($this->pdo!==null) { $this->pdo = null; }
  }

  // (C) RUN SQL QUERY
  function query ($sql, $data=null) {
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute($data);
  }

  // (D) SAVE USER
  function save ($name, $email, $password, $id=null) {
    $data = [$name, $email, password_hash($password, PASSWORD_DEFAULT)];
    if ($id===null) {
      $sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES (?,?,?)";
    } else {
      $sql = "UPDATE `users` SET `name`=?, `email`=?, `password`=? WHERE `id`=?";
      $data[] = [$id];
    }
    $this->query($sql, $data);
    return true;
  }

  // (E) GET USER
  function get ($id) {
    $this->query(
      sprintf("SELECT * FROM `users` WHERE `%s`=?", is_numeric($id) ? "id" : "email" ),
      [$id]
    );
    return $this->stmt->fetch();
  }

  // (F) VERIFY USER LOGIN
  // RETURNS FALSE IF INVALID EMAIL/PASSWORD
  // RETURNS JWT IF VALID
  function login ($email, $password) {
    // (F1) GET USER
    $user = $this->get($email);
    $valid = is_array($user);

    // (F2) CHECK PASSWORD
    if ($valid) { $valid = password_verify($password, $user["password"]); }

    // (F3) RETURN JWT IF OK, FALSE IF NOT
    if ($valid) {
      require "vendor/autoload.php";
      $now = strtotime("now");
      return Firebase\JWT\JWT::encode([
        "iat" => $now, // issued at - time when token is generated
        "nbf" => $now, // not before - when this token is considered valid
        "exp" => $now + 3600, // expiry - 1 hr (3600 secs) from now in this example
        "jti" => base64_encode(random_bytes(16)), // json token id
        "iss" => JWT_ISSUER, // issuer
        "aud" => JWT_AUD, // audience
        "data" => ["id" => $user["id"]] // whatever data you want to add
      ], JWT_SECRET, JWT_ALGO);
    } else {
      $this->error = "Invalid user/password";
      return false;
    }
  }

  // (G) VALIDATE JWT
  // RETURN USER IF VALID
  // RETURN FALSE IF INVALID
  function validate ($jwt) {
    // (G1) "UNPACK" ENCODED JWT
    require "vendor/autoload.php";
    try {
      $jwt = Firebase\JWT\JWT::decode($jwt, new Firebase\JWT\Key(JWT_SECRET, JWT_ALGO));
      $valid = is_object($jwt);
    } catch (Exception $e) {
      $this->error = $e->getMessage();
      return false;
    }

    // (G2) GET USER
    if ($valid) {
      $user = $this->get($jwt->data->id);
      $valid = is_array($user);
    }

    // (G3) RETURN RESULT
    if ($valid) {
      unset($user["password"]);
      return $user;
    } else {
      $this->error = "Invalid JWT";
      return false;
    }
  }
}

// (H) DATABASE SETTINGS - CHANGE TO YOUR OWN!
define("DB_HOST", "localhost");
define("DB_NAME", "test");
define("DB_CHARSET", "utf8mb4");
define("DB_USER", "root");
define("DB_PASSWORD", "");

// (I) JWT STUFF - CHANGE TO YOUR OWN!
define("JWT_SECRET", "SECRET-KEY");
define("JWT_ISSUER", "YOUR-NAME");
define("JWT_AUD", "site.com");
define("JWT_ALGO", "HS512");

// (J) NEW USER OBJECT
$_USER = new User();