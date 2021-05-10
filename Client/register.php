<?php
// require_once('../connDB.php');
// require_once('../res.php');

// 입력 값을 JSON으로 decoding 실시 -> 객체 생성
$req = json_decode(file_get_contents('php://input'));

// DBMS 회원가입 레코드 삽입
function registerInsertRecordsFromTable($argObj) {
    $dbConn = makeDBConnection();

    $hashedPassword = password_hash($argObj->password, PASSWORD_DEFAULT);

    $sql_stmt = "INSERT INTO member (m_id, m_name, m_password, email, position, phone, class_id)
    VALUES({$argObj->id}, \"{$argObj->name}\", \"{$hashedPassword}\", \"{$argObj->email}\",\"{$argObj->position}\", \"{$argObj->phone}\", {$argObj->class_id})";
    
    if ($result = $dbConn->query($sql_stmt)) {
        $dbConn->close();
        return $argObj;
    }

    $dbConn->close();
    return null;
    
}

$resData = registerInsertRecordsFromTable($req);

$res = new Res(($resData != null ? true : false), $resData);

echo json_encode($res)

?>