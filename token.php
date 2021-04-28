<?php
require_once('./vendor/autoload.php');

use \Firebase\JWT\JWT;

// 하는 중 미완성
function setToken($id, $email) {
    $secret_key = "secret";
    $issuer_claim = "server"; // this can be the servername
    $audience_claim = $id;
    $issuedat_claim = time(); // issued at
    $notbefore_claim = $issuedat_claim; //not before in seconds
    $expire_claim = $issuedat_claim + 7200; // expire time in seconds
    $token = array(
        "iss" => $issuer_claim, // 토큰 발급자
        "aud" => $audience_claim, // 토큰 대상자
        "iat" => $issuedat_claim, // 토큰 발급된 시간
        "nbf" => $notbefore_claim, //토큰 활성 날짜
        "exp" => $expire_claim, //토큰 만료시간
        "data" => array(
            "id" => $id,
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

function tokenCheck() {
    $secret_key = "secret";
    $jwt = null;
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    $arr = explode(".", $authHeader);
    
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