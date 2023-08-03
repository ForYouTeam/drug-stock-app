<?php

namespace App\Helper;

class ApiResponse {

  public static function successRes(mixed $data, string $message, int $code = 200, mixed $meta = null)
  {
    return array(
      "code"    => $code   ,
      "message" => $message,
      "data"    => $data,
      "meta"    => $meta
    );
  }

  public static function errRes(string $message, int $code = 500, mixed $meta = null)
  {
    return array(
      "code"    => $code   ,
      "message" => $message,
      "meta"    => $meta
    );
  }
}