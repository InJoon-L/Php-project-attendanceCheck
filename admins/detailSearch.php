<?php
require_once('../connDB.php');
require_once('../res.php');

// 입력 값을 JSON으로 decoding 실시 -> 객체 생성
$req = json_decode(file_get_contents('php://input'));

// DBMS 날짜에 대한 출석상태 레코드 반환
function getStatusRecordsFromTable($argObj) {
    $dbConn = makeDBConnection();
    //join을 이용해서 id에 맞는 이름끼리 묶어서 가져오자
    $sql_stmt = "select  from attendance_status where class_id = $argObj->class_id 
                && date = \"$argObj->date\" && std_name = \"$argObj->std_name\ && std_id = \"$argObj->std_id\"";

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