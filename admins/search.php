<?php
require_once('../db_conf.php');
require_once('../res.php');


// 입력 값을 JSON으로 decoding 실시 -> 객체 생성
$req = json_decode(file_get_contents('php://input'));

function makeDBConnection()
{
    // DBMS 연결, 연결 성공 시 mysqli 객체 반환., 연결 실패 시 False
    $db_conn = new mysqli(db_info::DB_URL, db_info::USER_ID, db_info::PASSWD, db_info::DB_NAME);

    // DBMS 연결  실패 여부 검사
    if ($db_conn->connect_errno) {
        echo "Failed to connect to the MySQL Server";
        exit(-1); // 시스템 종료 : PHP 엔진 번역 작업 중지, 프로그램 종료.
    }

    return $db_conn;
}


// DBMS 날짜에 대한 출석상태 레코드 반환
function getStatusRecordsFromTable($argObj) {
    $dbConn = makeDBConnection();

    $sql_stmt = "select  from attendance_status where class_id = $argObj->class_id 
                && date = \"$argObj->date\"";

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