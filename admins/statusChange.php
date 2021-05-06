<?php
require_once('../connDB.php');
require_once('../res.php');

// 입력 값을 JSON으로 decoding 실시 -> 객체 생성
$req = json_decode(file_get_contents('php://input'));

// DBMS 날짜에 대한 출석상태 레코드 변경
function changeStatusRecordsFromTable($argObj) {
    $dbConn = makeDBConnection();
    // where 수정할 것
    $sql_stmt = "update attendance_status set status = \"{$argObj->status}\" 
                where m_id = {$argObj->id}";
    print_r($sql_stmt);
    if ($result = $dbConn->query($sql_stmt)) {
        $dbConn->close();
        return  $result;
    }

    $dbConn->close();
    return null;
    
}

$resData = changeStatusRecordsFromTable($req);

$res = new Res(($resData != null ? true : false), $resData);

echo json_encode($res)

?>