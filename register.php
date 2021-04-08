<?php
require_once('connDB.php');
require_once('res.php');

// 입력 값을 JSON으로 decoding 실시 -> 객체 생성
$req = json_decode(file_get_contents('php://input'));
// print_r($req);
// DBMS 회원가입 레코드 삽입
function registerInsertRecordsFromTable($argObj) {
    $dbConn = makeDBConnection();
    $tableName = null;
    $id = null;
    $pd = null;
    $userName = null;
    $hashedPassword = password_hash($argObj->pd, PASSWORD_DEFAULT);
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
    // echo $hashedPassword;
    $sql_stmt = "INSERT INTO $tableName ($id, $userName, $pd, email, phone, class_id)
    VALUES({$argObj->id}, \"{$argObj->name}\", \"{$hashedPassword}\", \"{$argObj->email}\", \"{$argObj->phone}\", {$argObj->class_id})";
    echo $sql_stmt;
    if ($result = $dbConn->query($sql_stmt)) {
        // echo "query success";
        $dbConn->close();
        return $result;
    }
    // echo  "query false";
    $dbConn->close();
    return null;
    
}

$resData = registerInsertRecordsFromTable($req);

$res = new Res(($resData != null ? true : false), $resData);

echo json_encode($res)

?>