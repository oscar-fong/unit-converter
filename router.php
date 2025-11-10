<?php
require 'templates.php';
$route = $_SERVER['REQUEST_URI'];
if (!$_POST) {
  switch ($route) {
    case '/':
    case '/lengths':
      echo length();
      break;
    case '/weights':
      echo weight();
      break;
    case '/temperatures':
      echo temperature();
      break;
    default:
      header("HTTP/1.1 404 Not Found");
  }
} else {
  ['value' => $value, 'from' => $from, 'to' => $to] = $_POST;
  switch ($route) {
    case '/':
    case '/lengths':
      echo lengthResult($value, $from, $to);
      break;
    case '/weights':
      echo weightResult($value, $from, $to);
      break;
    case '/temperatures':
      echo tempResult($value, $from, $to);
      break;
    default:
      header("HTTP/1.1 404 Not Found");
  }
}
