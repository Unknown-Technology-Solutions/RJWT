<?php
$configLocation = "rjwt.ini.php";

$rjwtConfig = parse_ini_file($configLocation) or die("Could not read config");

echo $rjwtConfig["serverIP"] . "\n";
echo $rjwtConfig["secret"] . "\n";
echo $rjwtConfig["nasIPID"] . "\n";
echo $rjwtConfig["nasID"] . "\n";
echo $rjwtConfig["keyFile"] . "\n";

require_once './radius/autoload.php';
use Dapphp\Radius\Radius;

$client = new Radius();
$client->setServer($rjwtConfig["serverIP"])
	->setSecret($rjwtConfig["secret"])
	->setNasIpAddress($rjwtConfig["nasIPID"])
	->setAttribute(32, $rjwtConfig["nasID"]);

$authenticated = $client->accessRequest($rjwtConfig["testingUsername"], $rjwtConfig["testingPassword"]);

if ($authenticated === false) {
	sprintf("Access-Request failed with error %d (%s).\n", $client->getErrorMessaged());
} else {
	print("Configuration testing passed!");
}
