<?php
// (A) JWT COOKIE NOT SET!
if (!isset($_COOKIE["jwt"])) { header("Location: 3-login.php"); exit(); }

// (B) VERIFY JWT
require "2-lib-users.php";
$user = $_USER->validate($_COOKIE["jwt"]);
if ($user===false || isset($_POST["logout"])) {
  setcookie("jwt", null, -1);
  header("Location: 3-login.php");
  exit();
}