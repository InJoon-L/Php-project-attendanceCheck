<?php
// 입력 값을 JSON으로 decoding 실시 -> 객체 생성
$authHeader = $_SERVER['HTTP_AUTHORIZATION'];

// DBMS 로그아웃 토큰반환 레코드 변경
function logoutRecordsFromTable($authHeader) {
    $dbConn = makeDBConnection();
    $jwt = tokenCheck($authHeader);

    if ($jwt['result'] == null) {
        return null;
    }
    
    $id = $jwt['id'];
    $sql_stmt = "update member set token = \"\" where m_id = \"{$id}\"";
  
    if ($result = $dbConn->query($sql_stmt)) {
        
        $dbConn-> close();
        return $result;
    }

    $dbConn->close();
    return null;
}

$resData = logoutRecordsFromTable($authHeader);

$res = new Res(($resData != null ? true : false), $resData);

echo json_encode($res, JSON_UNESCAPED_UNICODE);

?>