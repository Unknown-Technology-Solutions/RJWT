<?php
$configLocation = "rjwt.ini.php";

$rjwtConfig = parse_ini_file($configLocation);

echo $rjwtConfig["serverIP"] . "\n";
echo $rjwtConfig["secret"] . "\n";
echo $rjwtConfig["nasIPID"] . "\n";
echo $rjwtConfig["nasID"] . "\n";
echo $rjwtConfig["keyFile"] . "\n";
