<?php
require_once('db_conf.php');
require_once('res.php');

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

// DBMS 로그인 확인에 대한 레코드 반환
function checkLoginRecordsFromTable($argObj) {
    $dbConn = makeDBConnection();
    $tableName = null;
    $id = null;
    $pd = null;
    $userName = null;
    switch ($argObj->mode) {
        case 'std':
            $tableName = 'student';
            $id = 'std_id';
            $pd = 'std_password';
            $userName = 'std_name';
            break;
        case 'pr':
            $tableName = 'professor';
            $id = 'pr_id';
            $pd = 'pr_password';
            $userName = 'pr_name';
            break;
    }

    $sql_stmt = "select $id, class_id, $userName from $tableName where email = \"$argObj->email\" 
                && $pd = \"$argObj->password\"";

    if ($result = $dbConn->query($sql_stmt)) {
        $dbConn->close();
        return  $result->fetch_all();
    }

    $dbConn->close();
    return null;
}

$resData = checkLoginRecordsFromTable($req);

$res = new Res(($resData != null ? true : false), $resData);

echo json_encode($res)

?>