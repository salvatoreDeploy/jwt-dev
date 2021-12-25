<?php
require '../vendor/autoload.php';

use Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

$authorization = $_SERVER["HTTP_AUTHORIZATION"];

$token = str_replace('Bearer', '', $authorization );
$token = trim($token, ' ');

try{
    $decode = JWT::decode($token, $_SERVER['KEY'], ['HS256']);
    echo json_encode($decode);
}catch(Throwable $e){
    if($e->getMessage() === 'Expired token'){
        http_response_code(401);
        die($e->getMessage());
    }
    echo json_encode($e->getMessage());
}

//echo json_encode($token);