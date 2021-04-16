<?php
require_once('./vendor/autoload.php');

use \Firebase\JWT\JWT;
// 하는 중 미완성
function setToken() {
    $secret_key = "YOUR_SECRET_KEY";
    $issuer_claim = "THE_ISSUER"; // this can be the servername
    $audience_claim = "THE_AUDIENCE";
    $issuedat_claim = time(); // issued at
    $notbefore_claim = $issuedat_claim; //not before in seconds
    $expire_claim = $issuedat_claim + 7200; // expire time in seconds
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
        )
    );

    $jwt = JWT::encode($token, $secret_key);
    $result = array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "email" => $email,
                "expireAt" => $expire_claim
    );
}
// secret_key는 따로 관리할 것 
function tokenCheck() {
    $secret_key = "YOUR_SECRET_KEY";
    $jwt = null;
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    $arr = explode(" ", $authHeader);
    
    if($jwt){

        try {
    
            $decoded = JWT::decode($jwt, $secret_key, array('HS256'));
    
            // Access is granted. Add code of the operation here 
    
            $result = array(
                "message" => "Access granted:",
                "error" => $e->getMessage()
            );
    
        }catch (Exception $e){
    
            $result = array(
                "message" => "Access denied.",
                "error" => $e->getMessage()
            );
        }
    }
}
?>