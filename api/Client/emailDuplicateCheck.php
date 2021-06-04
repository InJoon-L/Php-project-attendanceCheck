<?php
// 입력 값을 JSON으로 decoding 실시 -> 객체 생성
$req = json_decode(file_get_contents('php://input'));

function getEmailRecordsFromTable($argObj) {
    $dbConn = makeDBConnection();

    $sql_stmt = "SELECT * FROM member WHERE email = '{$argObj->email}'";

    if ($result = $dbConn->query($sql_stmt)) {
        $dbConn->close();
        $check = $result->fetch_all() == null ? true : false;
        
        return $check;
    }

    $dbConn->close();
    return null;
}

$resData = getEmailRecordsFromTable($req);

$res = new Res(($resData != null ? true : false), $resData);

echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>