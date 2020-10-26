<?php
// Auth API
header('Content-Type: application/json');

require_once 'rjwt_mod.php';

// Retreive recved values

$username  = protect($_POST["username"]);
$password  = protect($_POST["password"]);
$passkey   = protect($_POST["passkey"]);
$endClient = protect($_POST["endClient"]);

// Import security config

if (fopen(
$securityConf = parse
