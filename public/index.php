<?php

require __DIR__ . '/../vendor/autoload.php';

const REDIRECT_URL = "https://nwe-oo.web.app";
const DATABASE_URL = "https://nwe-oo-default-rtdb.firebaseio.com";

$uri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($uri, PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Authorization,X-Auth-Token');

if ($method === 'OPTIONS') {
  exit(0);
}

$url = DATABASE_URL . $path;
$options =  [
  'method' => $method,
];
$context = stream_context_create([
  'http' => $options,
  'https' => $options,
]);

if (str_match('/\.json$/', $uri)) {
  header('Content-Type: application/json; charset=utf-8');
  echo @file_get_contents($url, false, $context);
  exit(0);
}

if ($path == '/favicon.ico') {
  header('Content-Type: image/x-icon');
  echo @file_get_contents(REDIRECT_URL . $path, false, $context);
  exit(0);
}

if ($path == '/') {
  header('Location: ' . REDIRECT_URL);
  header('refresh: 0; url=' . REDIRECT_URL);
  exit(0);
}

http_response_code(404);

exit(0);
