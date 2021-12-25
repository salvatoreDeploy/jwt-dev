<?php

require '../vendor/autoload.php';

use app\database\Connection;
use Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

//echo json_encode('teste');

$userName = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

//echo json_encode($userName,);

$pdo = Connection::connect();

$prepare = $pdo->prepare("select * from user where userName = :userName");
$prepare->execute([
    'userName' => $userName
]);

$userFound = $prepare->fetch();

if(!$userFound){
    http_response_code(401);
}

if($password != $userFound->password){
    http_response_code(401);
}

//echo json_encode($userFound);

$payload = [
    "exp" => time() +10,
    "iat" => time(),
    "userName" => $userName
];

$encode = JWT::encode($payload, $_ENV['KEY']);

echo json_encode($encode);



