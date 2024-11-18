<?php

class Database
{
  private $db_host = "localhost";
  private $db_name = "php_auth_api";
  private $db_user = "root";
  private $db_pass = "";

  public function connection()
  {
    try {
      $dsn = "mysql:host=" . $this->db_host . ";dbname=" . $this->db_name;
      $conn = new PDO($dsn, $this->db_user, $this->db_pass);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      return $conn;
    } catch (PDOException $e) {
      echo "Connection failed " . $e->getMessage();
      exit;
    }
  }
}
