<?php
// (A) JWT NOT SET!
if (!isset($_POST["jwt"])) { exit("NO"); }

// (B) VERIFY JWT
require "2-lib-users.php";
$user = $_USER->validate($_POST["jwt"]);
if ($user===false) { exit("NO"); }

// (C) PROCEED AS USUAL
echo "YES";