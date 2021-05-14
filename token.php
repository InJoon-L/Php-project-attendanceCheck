<?php
require_once __DIR__ . '/vendor/autoload.php';

use \Firebase\JWT\JWT;

// 토큰을 생성 
function setToken($argArr) {
    $secret_key = "secret";
    // $issuer_claim = "injoon"; // this can be the servername
    $audience_claim = $argArr['id'];
    $issuedat_claim = time(); // issued at
    // $notbefore_claim = $issuedat_claim; //not before in seconds
    $expire_claim = $issuedat_claim + 7200; // expire time in seconds
    $token = array(
        // "iss" => $issuer_claim, // 토큰 발급자
        "aud" => $audience_claim, // 토큰 대상자
        // "iat" => $issuedat_claim, // 토큰 발급된 시간
        // "nbf" => $notbefore_claim, //토큰 활성 날짜
        "exp" => $expire_claim, //토큰 만료시간
        "data" => array(
            "id" => $argArr['id'],
            "position" => $argArr['position']
        )
    );

    $jwt = JWT::encode($token, $secret_key);

    if(!storeToken($jwt, $argArr['id'])) {
        echo "토큰 저장 실패";
        exit(-1);
    }

    return $jwt;
}

// 토큰을 디비에 저장
function storeToken($jwt, $id) {
    $dbConn = makeDBConnection();

    $sql_stmt = "UPDATE member SET token = \"{$jwt}\"
                WHERE m_id = {$id}";

    if ($result = $dbConn->query($sql_stmt)) {
        $dbConn->close();
        
        return true;
    }

    $dbConn->close();
    return null;
}

// token을 통해 누군지 판단
function tokenCheck($authHeader) {
    $secret_key = "secret";
    $jwt = null;
    $result = null;
    
    $arr = explode(" ", $authHeader);
    $jwt = $arr[1];

    if($jwt){
        try {
            $decoded = JWT::decode($jwt, $secret_key, array('HS256'));
            
            // Access is granted. Add code of the operation here 
            $id = $decoded->data->id;
            $position = $decoded->data->position;
            
            $result = array(
                "message" => "Access granted:",
                "result" => true,
                "id" => $id,
                "position" => $position
            );
        }catch (Exception $e){
            $result = array(
                "message" => "Access denied.",
                "result" => false,
                "error" => $e->getMessage()
            );
        }
    }
    return $result;
}
?>