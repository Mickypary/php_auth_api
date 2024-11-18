<?php

require __DIR__ . "/../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHandler
{
  protected $jwt_secret;
  protected $token;
  protected $issuedAt;
  protected $expired;
  protected $jwt;

  public function __construct()
  {
    // default timezone setting
    date_default_timezone_set("Africa/Lagos");
    $this->issuedAt = time();

    // Token validity (3600 seconds = 1 hr)
    $this->expired = $this->issuedAt + 3600;

    // Set your secret for your token or signature
    $this->jwt_secret = "this_is_my_secret";
  }

  public function jwtEncodeData($iss, $data)
  {
    $this->token = [
      // Adding the identifiers to the token (who issued the token)
      'iss' => $iss,
      'aud' => $iss,
      // adding the current timestamp to the token, for identifying when the token was issued
      'iat' => $this->issuedAt,
      // token expiration
      'exp' => $this->expired,
      // payload
      'data' => $data,
    ];

    $this->jwt = JWT::encode($this->token, $this->jwt_secret, 'HS256');
    return $this->jwt;
  }

  public function jwtDecodeData($jwt_token)
  {
    try {
      $decode = JWT::decode($jwt_token, new Key($this->jwt_secret, 'HS256'));
      return [
        "data" => $decode->data,
      ];
    } catch (Exception $e) {
      return [
        "message" => $e->getMessage(),
      ];
    }
  }
}
