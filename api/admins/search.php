<?php
// 입력 값을 JSON으로 decoding 실시 -> 객체 생성
$req = json_decode(file_get_contents('php://input'));

// DBMS 날짜에 대한 출석상태 레코드 반환
function getStatusRecordsFromTable($argObj) {
    $dbConn = makeDBConnection();
    
    $sql_stmt = "select * from Attendance_status where date = \"$argObj->date\"";

    if ($result = $dbConn->query($sql_stmt)) {
        $dbConn->close();
        return  $result->fetch_all();
    }
    
    $dbConn->close();
    return null;
}

$resData = getStatusRecordsFromTable($req);

$res = new Res(($resData != null ? true : false), $resData);

echo json_encode($res)
?>