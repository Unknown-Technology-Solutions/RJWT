<?php

# // TODO: Move RADIUS and JWT Auth mechanism to an external service to reduce main application footprint and to distribute workload across the network

#Protect strings that are being handled

function protect($string)
{
    $string = trim(strip_tags(addslashes($string)));
    return $string;
}

function return_var_dump(){
    // It works like var_dump, but it returns a string instead of printing it.
    $args = func_get_args(); // For <5.3.0 support ...
    ob_start();
    call_user_func_array('var_dump', $args);
    return ob_get_clean();
}

#JWT Verify Function

require_once 'jwt/autoload.php';
use \Firebase\JWT\JWT;

function VerifyJWT($token, $configLocation)
{
    $rjwtConfig = parse_ini_file($configLocation); //Config File location
    $file = fopen($rjwtConfig['keyFile'], "r") or die("Unable to read key file!");
    $ServerKey = fread($file, filesize($rjwtConfig['keyFile']));
    fclose($file);
    try {
        date_default_timezone_set("America/Chicago");
        $payload = JWT::decode($token, $ServerKey, array('HS256'));
        $returnArray['nbf'] = $payload->nbf;
        $expire = date($returnArray['nbf'] + 3600);
        #echo "Expire Time: ".$expire."<br>";

        $time = date("U");
        #echo "Curren Time: ".$time."<br>";
        if ($time > $expire) {
            return false;
        } else {
            return true;
        }
        #echo $payload['username']."<br>";
        #if (isset($payload->exp)) {
        #    $returnArray['exp'] = date(DateTime::ISO8601, $payload->exp);
        #}
    } catch (Exception $e) {
        $returnArray = array('error' => $e->getMessage());
        echo $returnArray['error']."<br>";
        if ($returnArray['error'] == "Expired token") {
            return false;
        } else {
            return false;
        }
    }
}


#RADIUS Auth function

require_once './radius/autoload.php';
use Dapphp\Radius\Radius;

function rjwtAuth($username, $password, $configLocation) #, $server, $secret, $nasIP, $nasID)
{
    date_default_timezone_set("America/Chicago");
    $nbf = date('U');

    // set server, secret, and basic attributes
  $rjwtConfig = parse_ini_file($configLocation); //Config File location
  $client = new Radius();
    $client->setServer($rjwtConfig["serverIP"]) // RADIUS server address
   ->setSecret($rjwtConfig["secret"]) // Server Secret
   ->setNasIpAddress($rjwtConfig["nasIPID"]) // NAS server address
   ->setAttribute(32, $rjwtConfig["nasID"]);  // NAS identifier

  // PAP authentication; returns true if successful, false otherwise
    $authenticated = $client->accessRequest($username, $password);

    if ($authenticated === false) {
        #echo sprintf("Access-Request failed with error %d (%s).\n", $client->getErrorCode(), $client->getErrorMessage());
        return false;
    } else {
        $JWT_Payload_Array = array();
        $JWT_Payload_Array['username'] = $username;
        $JWT_Payload_Array['authenticated'] = $authenticated;
        $JWT_Payload_Array['nbf'] = $nbf;

        $file = fopen($rjwtConfig['keyFile'], "r") or die("Unable to read key file!");
        $ServerKey = fread($file, filesize($rjwtConfig['keyFile']));
        fclose($file);

        $token = JWT::encode($JWT_Payload_Array, $ServerKey);
        $_SESSION['jwt_token'] = $token;

        return true;
    }
}
