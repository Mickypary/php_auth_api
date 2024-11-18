<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");

require __DIR__ . "/classes/Database.php";
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
  $returnData = msg(0, 404, "Page Not Found!");
} elseif (!isset($data->name) || !isset($data->email) || !isset($data->password) || empty(trim($data->name)) || empty(trim($data->email)) || empty(trim($data->password))) {
  $fields = ['fields' => ['name', 'email', 'password']];
  $returnData = msg(0, 422, "Please fill in all required fields!", $fields);
} else {
  $name = trim($data->name);
  $email = trim($data->email);
  $password = trim($data->password);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $returnData = msg(0, 422, "Invalid Email Address");
  } elseif (strlen($password) < 8) {
    $returnData = msg(0, 422, "Your password must be atleast 8 characters long!");
  } elseif (strlen($name) < 3) {
    $returnData = msg(0, 422, "Your name must be atleast 3 characters long!");
  } else {
    try {
      $sql = "SELECT email FROM users WHERE email = :email";
      $check_email_stmt = $conn->prepare($sql);
      $check_email_stmt->bindValue(":email", $email, PDO::PARAM_STR);
      $check_email_stmt->execute();

      if ($check_email_stmt->rowCount()) {
        $returnData = msg(0, 422, "This E-mail is already in use!");
      } else {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $insert_stmt = $conn->prepare($sql);
        $insert_stmt->bindValue(":name", htmlspecialchars(strip_tags($name)), PDO::PARAM_STR);
        $insert_stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $insert_stmt->bindValue(":password", password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $insert_stmt->execute();

        $returnData = msg(1, 201, "Account created successfully!");
      }
    } catch (PDOException $e) {
      $returnData = msg(0, 500, $e->getMessage());
    }
  }
}

echo json_encode($returnData);
