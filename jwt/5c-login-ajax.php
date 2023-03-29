<?php
if (isset($_POST["email"]) && isset($_POST["password"])) {
  // (A) LOAD LIBRARY
  require "2-lib-users.php";

  // (B) VERIFY CREDENTIALS
  $jwt = $_USER->login($_POST["email"], $_POST["password"]);
  echo json_encode([
    "status" => $jwt===false ? false : true,
    "msg" => $jwt === false ? $_USER->error : $jwt
  ]);
} else {
  echo json_encode([
    "status" => false,
    "msg" => "Invalid email/password"
  ]);
}