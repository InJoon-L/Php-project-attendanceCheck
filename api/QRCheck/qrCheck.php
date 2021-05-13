<?php
// require_once('../connDB.php');
// require_once('../res.php');

// 입력 값을 JSON으로 decoding 실시 -> 객체 생성
$req = json_decode(file_get_contents('php://input'));

// DBMS QR코드 레코드 삽입
function QRCodeInsertRecordsFromTable($argObj) {
    $dbConn = makeDBConnection();
    $when = null;
    $date = date("Y-m-d");
    $time = date("H:i:s");
    // 시간에 맞는 출석 알고리즘 필요
    // if (true) {
    //     $when = "am_attendance";
    //     $status = "출";
    // }

    $sql_stmt = "INSERT INTO Attendance_status (date, am_attendance, status, m_id)
    VALUES(\"{$argObj->date}\", \"{$argObj->attendance}\", \"{$argObj->status}\", {$argObj->id})";
    
    if ($result = $dbConn->query($sql_stmt)) {
        $dbConn->close();
        return $argObj;
    }

    $dbConn->close();
    return null;
    
}

$resData = QRCodeInsertRecordsFromTable($req);

$res = new Res(($resData != null ? true : false), $resData);

echo json_encode($res)

?>