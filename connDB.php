<?php
require_once('db_conf.php');

function makeDBConnection()
{
    // DBMS 연결, 연결 성공 시 mysqli 객체 반환., 연결 실패 시 False
    $db_conn = new mysqli(db_info::DB_URL, db_info::USER_ID, db_info::PASSWD, db_info::DB_NAME);

    // DBMS 연결  실패 여부 검사
    if ($db_conn->connect_errno) {
        echo "Failed to connect to the MySQL Server";
        exit(-1); // 시스템 종료
    }

    return $db_conn;
}
?>