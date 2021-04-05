<?php
require_once('connDB.php');
require_once('res.php');

// 입력 값을 JSON으로 decoding 실시 -> 객체 생성
$req = json_decode(file_get_contents('php://input'));

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

    $sql_stmt = "select $pd from $tableName where email = '$argObj->email'";

    if ($result = $dbConn->query($sql_stmt)) {
        $dbConn->close();
        $result->fetch_all();
        if(password_verify($argObj->password, $result[0])) {
            return "login success";
        }
    }

    $dbConn->close();
    return null;
}

$resData = checkLoginRecordsFromTable($req);

$res = new Res(($resData != null ? true : false), $resData);

echo json_encode($res)

?>