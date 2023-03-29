<?php
// (A) ACCESS CHECK
require "4a-protect.php";

// (B) SHOW THE PAGE ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Dummy Admin Page</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="0-dummy.css">
  </head>
  <body>
    <form method="post">
      <h1>IT WORKS!</h1>
      <?php print_r($user); ?>
      <input type="hidden" name="logout" value="1">
      <input type="submit" value="Logout">
    </form>
  </body>
</html>