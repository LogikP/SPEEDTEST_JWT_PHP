<?php
// include_once './config/database.php';
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$email = '';
$password = '';
$data = json_decode(file_get_contents("php://input"));
$email = $data->email;
$password = $data->password;
$secret_key = "1234";
$issuer_claim = "test"; // this can be the servername
$audience_claim = "client";
$issuedat_claim = time(); // issued at
$notbefore_claim = $issuedat_claim + 10; //not before in seconds
$expire_claim = $issuedat_claim + 60; // expire time in seconds

$token = array(
    "iss" => $issuer_claim,
    "aud" => $audience_claim,
    "iat" => $issuedat_claim,
    "nbf" => $notbefore_claim,
    "exp" => $expire_claim,
    "data" => array(
        "id" => $id,
        "firstname" => $firstname,
        "lastname" => $lastname,
        "email" => $email
));

http_response_code(200);

$time_start = microtime_float();

$jwt = JWT::encode($token, $secret_key);

$time_end = microtime_float();
$time = $time_end - $time_start;

echo json_encode(
    array(
        "message" => "Successful login.",
        "jwt" => $jwt,
        "email" => $email,
        "expireAt" => $expire_claim,
        "JWT encode time" => $time
    ));



function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

?>
