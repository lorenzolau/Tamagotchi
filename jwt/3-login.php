<?php
// (A) PROCESS LOGIN
// (A1) ALREADY SIGNED IN
if (isset($_COOKIE["jwt"])) {
  require "2-lib-users.php";
  $user = $_USER->validate($_COOKIE["jwt"]);
  if ($user===false) { setcookie("jwt", null, -1); }
  else { header("Location: 4b-admin.php"); exit(); }
}

// (A2) PROCESS SIGN IN
if (isset($_POST["email"]) && isset($_POST["password"])) {
  require "2-lib-users.php";
  $jwt = $_USER->login($_POST["email"], $_POST["password"]);
  if ($jwt!==false) {
    setcookie("jwt", $jwt);
    header("Location: 4b-admin.php");
    exit();
  }
} ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="0-dummy.css">
  </head>
  <body>
    <!-- (B) MESSAGE -->
    <?php if (isset($jwt)) { ?>
    <div class="note"><?=$_USER->error?></div>
    <?php } ?>

    <!-- (C) LOGIN FORM -->
    <form method="post">
      <h1>LOGIN</h1>
      <input type="email" placeholder="Email" name="email" required value="jon@doe.com">
      <input type="password" placeholder="Password" name="password" required value="123456">
      <input type="submit" value="Sign In">
    </form>
  </body>
</html>