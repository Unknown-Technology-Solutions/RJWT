<?php
session_start();
require_once 'rjwt_mod.php';

if (isset($_SESSION['jwt_token'])) {
  if (VerifyJWT($_SESSION['jwt_token'], "./rjwt.ini.php") == true) {
    #header("Location: ./home.php");
  } else {
    header("Location: ./index.php");
    echo "Token Invalid<br>";
    #return false;
  }
} else {
  header("Location: ./index.php");
  echo "Token Invalid<br>";
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login_lib_test_home</title>
</head>
<body>
wow, it works.
</body>
</html>
