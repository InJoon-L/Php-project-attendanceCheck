<?php
$authHeader = $_SERVER['HTTP_AUTHORIZATION'];

if (isset($authHeader)) {
    $data = tokenCheck($authHeader);
    echo json_encode($data);
} else {
    echo "헤더 보내주세요";
    exit(-1);
}


?>