<?php
// 입력 값을 JSON으로 decoding 실시 -> 객체 생성
$req = json_decode(file_get_contents('php://input'));

// DBMS 로그아웃 토큰반환 레코드 변경
function logoutRecordsFromTable($argObj) {
    $dbConn = makeDBConnection();

    $sql_stmt = "update student set token = \"\" where std_id = $argObj->std_id";

    if ($result = $dbConn->query($sql_stmt)) {
        $dbConn-> close();
        return $result;
    }

    $dbConn->close();
    return null;
}

$resData = logoutRecordsFromTable($req);

$res = new Res(($resData != null ? true : false), $resData);

echo json_encode($res);

?>