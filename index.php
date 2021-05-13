<?php
require_once __DIR__ .'/api/connDB.php';
require_once __DIR__ .'/api/res.php';
require_once __DIR__ .'/token.php';

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/api/client/login' :
        require __DIR__ . '/api/Client/login.php';
        break;
    case '/api/client/register' :
        require __DIR__ . '/api/Client/register.php';
        break;
    case '/api/admins/statuschange' :
        require __DIR__ . '/api/admins/statusChange.php';
        break;    
    case '/api/admins/search' :
        require __DIR__ . '/api/admins/search.php';
        break;
    case '/api/qrcode/qrcheck' :
        require __DIR__ . '/api/QRCode/qrCheck.php';
        break;
    case '/api/auth' :
        require __DIR__ . '/api/auth.php';
        break;
    default:
        echo "똑바로 경로 입력하세요ㅡㅡ";
        http_response_code(404);
        break;
}
?>