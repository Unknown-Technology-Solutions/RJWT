<?php
$configLocation = "rjwt.ini.php";
$secConfLocation = "security_conf.ini.php";

$rjwtConfig = parse_ini_file($configLocation) or die("Could not read RJWT config");
print("RJWT Config read<br />");
$SecConfig  = parse_ini_file($secConfLocation) or die("Could not read Security config");
print("Security Config read<br />");

print($rjwtConfig["serverIP"] . "<br />");
print($rjwtConfig["secret"] . "<br />");
print($rjwtConfig["nasIPID"] . "<br />");
print($rjwtConfig["nasID"] . "<br />");
print($rjwtConfig["keyFile"] . "<br />");

require_once './radius/autoload.php';
use Dapphp\Radius\Radius;

$client = new Radius();
$client->setServer($rjwtConfig["serverIP"])
	->setSecret($rjwtConfig["secret"])
	->setNasIpAddress($rjwtConfig["nasIPID"])
	->setAttribute(32, $rjwtConfig["nasID"]);

$authenticated = $client->accessRequest($rjwtConfig["testingUsername"], $rjwtConfig["testingPassword"]);

if ($authenticated === false) {
	sprintf("Access-Request failed with error %d (%s).<br />", $client->getErrorMessaged());
} else {
	print("Configuration testing passed!");
}
