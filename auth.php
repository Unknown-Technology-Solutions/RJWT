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
$passkey   = protect($_POST["passkey"]);
$endClient = protect($_POST["endClient"]);

// Import security config

$fChk = fopen($secConfLoc, "r") or die("Invalid configuration location!\n");
fclose($fChk);

$securityConf = parse_ini_file($secConfLoc);

#print($securityConf['passkey']."<br />");
#print(return_var_dump($securityConf['allowed_users']));
#print($securityConf['allowed_users'][1]);

#print($username);
#print($password);
#print($passkey);
#print($endClient);

if (in_array($endClient, $securityConf['allowed_users']) || (!$username || !$password)) {
    if ($passkey == $securityConf['passkey']) {
        $authenticated = rjwtAuth($username, $password, "./rjwt.ini.php");

        if ($authenticated === false) {
            header('Content-Type: application/json');
            echo json_encode([ "validHost" => "True", "validKey" => "True", "error" => "Invalid Username or Password", "authenticated" => "False"]);
        } else {
            // access request was accepted - client authenticated successfully
            header('Content-Type: application/json');
            echo json_encode([ "validHost" => "True", "validKey" => "True", "error" => "null", "authenticated" => "True"]);
        }
    } else {
      header('Content-Type: application/json');
      echo json_encode([ "validHost" => "True", "validKey" => "False", "error" => "null", "authenticated" => "False"]);
    }
} else {
  header('Content-Type: application/json');
  echo json_encode([ "validHost" => "False", "validKey" => "False", "error" => "null", "authenticated" => "False"]);
}
