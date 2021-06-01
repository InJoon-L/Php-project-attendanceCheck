<?php
// 입력 값을 JSON으로 decoding 실시 -> 객체 생성
$req = json_decode(file_get_contents('php://input'));

// DBMS 로그인 확인에 대한 레코드 반환
function checkLoginRecordsFromTable($argObj) {
    $dbConn = makeDBConnection();

    $sql_stmt = "select * from member where email = \"{$argObj->email}\"";

    if ($result = $dbConn->query($sql_stmt)) {
        $dbConn->close();
        $fetchResult = $result->fetch_assoc();
        $jwt = null;

        $data = array(
            "id" => $fetchResult['m_id'],
            "name" => $fetchResult['m_name'],
            "position" => $fetchResult['position'],
            "email" => $argObj->email,
            "class_name" => $fetchResult['class_name']
        );

        if(password_verify($argObj->password, $fetchResult['m_password'])) {
            $jwt = setToken($data);
        } else {
            return null;
        }

        $data['jwt'] = $jwt;

        return $data;
    }

    $dbConn->close();
    return null;
}

$resData = checkLoginRecordsFromTable($req);

$res = new Res(($resData != null ? true : false), $resData);

echo json_encode($res);

?>