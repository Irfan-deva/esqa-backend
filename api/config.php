<?php
define("HOST", "localhost");
define("DB", "dbname");
define("USER", "usr");
define("PWD", "pwd");

$result['status'] = '';
$result['message'] = '';

function dbConnection()
{
  static $con;
  if ($con == NULL) {
    $con = new mysqli(HOST, USER, PWD, DB);
  }
  return $con;
}
