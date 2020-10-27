<?php
//
// Auth API
// Writen by Zane Reick
//

error_reporting(0);

//Make sure to set these variables to the correct locations!!
//User set variables:
$secConfLoc = "./security_conf.ini.php";  //Security Configuration Location
$rjwtConf   = "./rjwt.ini.php";           //RJWT Configuration Location

#header('Content-Type: application/json');
require_once 'rjwt_mod.php';

// Retreive recved values

$username  = protect($_POST["username"]);
$password  = protect($_POST["password"]);
$passkey   = protect($_GET["passkey"]);
$endClient = protect($_GET["endClient"]);

// Import security config

$fChk = fopen($secConfLoc, "r") or die("Invalid configuration location!\n");
fclose($fChk);

$securityConf = parse_ini_file($secConfLoc);

print($securityConf['passkey']."<br />");
#print(return_var_dump($securityConf['allowed_users']));
#print($securityConf['allowed_users'][1]);

if (in_array($endClient, $securityConf['allowed_users'])) {
  if ($passkey == $securityConf['passkey']) {
    print("Function test passed");
  } else {
    print("Function test failed");
  }
} else {
  print("Function test failed");
}
