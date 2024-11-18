<?php

use Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");

require __DIR__ . "/classes/Database.php";
require __DIR__ . "/AuthMiddleware.php";

$allHeaders = getallheaders();
print_r($allHeaders);
$db_connection = new Database();
$conn = $db_connection->connection();

$auth = new AuthMiddleware($conn, $allHeaders);

echo json_encode($auth->isValid());
