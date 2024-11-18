<?php

use Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");

require __DIR__ . "/classes/Database.php";
require __DIR__ . "/classes/JwtHandler.php";


$dbConnection = new Database();
$conn = $dbConnection->connection();

function msg($success, $status, $message, $extra = [])
{
  return [
    [
      'success' => $success,
      'status' => $status,
      'message' => $message,
    ],
    $extra
  ];
}

// DATA from on request

$data = json_decode(file_get_contents("php://input"));
// print_r($data);
$returnData = [];

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  $returnData = msg(0, 404, 'Page Not Found!');
} elseif (!isset($data->email) || !isset($data->password) || empty(trim($data->email)) || empty(trim($data->password))) {
  $fields = ['fields' => ['email', 'password']];
  $returnData = msg(0, 422, "Please fill in all required fields", $fields);
} else {
  $email = trim($data->email);
  $password = trim($data->password);

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $returnData = msg(0, 422, 'Invalid Email Address');
  } elseif (strlen($password) < 8) {
    $returnData = msg(0, 422, 'Your password must be at least 8 character long! ');
  } else {
    try {
      $sql = "SELECT * FROM users WHERE email = :email";
      $query_stmt = $conn->prepare($sql);
      $query_stmt->bindValue(":email", $data->email, PDO::PARAM_STR);
      $query_stmt->execute();

      if ($query_stmt->rowCount()) {
        $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
        $check_password = password_verify($password, $row['password']);

        if ($check_password) {
          $jwt = new JwtHandler();
          $token = $jwt->jwtEncodeData(
            'http://localhost/php_auth_api',
            array('user_id' => $row['id']),
          );

          $returnData = [
            'success' => 1,
            'message' => 'You have successfully logged in',
            'token' => $token,
          ];
        } else {
          $returnData = msg(0, 422, 'Invalid Password');
        }
      } else {
        $returnData = msg(0, 422, 'Invalid Email ');
      }
    } catch (PDOException $e) {
      $returnData = msg(0, 500, $e->getMessage());
    }
  }
}

echo json_encode($returnData);
