<?php
// 입력 값을 JSON으로 decoding 실시 -> 객체 생성
$req = json_decode(file_get_contents('php://input'));

// DBMS QR코드 레코드 삽입
function QRCodeInsertRecordsFromTable($argObj) {
    $dbConn = makeDBConnection();
    $date = date("Y-m-d");
    $time = date("H:i:s");
    $status = null;
    $startAMTime = "07:00:00";
    $endAMTime = "09:00:00";
    $endTime = "20:50:00";

    // 시간에 맞는 출석 알고리즘 필요
    // 오전 9시전까지 출석, 오전 9시 ~ 오후 5시 50분 지각, 오후 6시 50분 ~ 오후 7시 야자 출석, 오후 7시 50분 이후 퇴근
    // 오전 9시(혹은 오후 6시)가 지나고 QR코드를 한번도 입력이 안된 사람들을 찾아서 결석으로 지정 문제는 서버에 요청을
    // 어떻게 해야 될까
    // 그 이후 status를 조정 조퇴의 경우 무조건 수동입력으로만 해결 할 지 QR코드로 해결이 가능한 지
    // 결석의 대한 문제만 해결하면 끝
    if ($time > $startAMTime && $time < $endAMTime) {
        $status = "출석";
    } else if ($time > $endAMTime && $time < $endTime) {
        $status = "지각";
    }
    
    if ($argObj->attendance === "am_attendance" || $status == "지각") {
        $sql_stmt = "INSERT INTO Attendance_status (date, {$argObj->attendance}, status, m_id, m_name)
        VALUES(\"{$date}\", \"{$time}\", \"{$status}\", {$argObj->id}, \"{$argObj->name}\")";
    
        if ($result = $dbConn->query($sql_stmt)) {
            $dbConn->close();
            
            return $argObj;
        }
    } else {
        $sql_stmt = "UPDATE Attendance_status SET {$argObj->attendance} =
        \"$time\" WHERE m_id = {$argObj->id} AND date = \"{$date}\"";

        if ($result = $dbConn->query($sql_stmt)) {
            $dbConn-> close();

            return $argObj;
        }
    }
    

    $dbConn->close();
    return null;
    
}

$resData = QRCodeInsertRecordsFromTable($req);

$res = new Res(($resData != null ? true : false), $resData);

echo json_encode($res)

?>