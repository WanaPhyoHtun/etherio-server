<?php

require __DIR__ . '/../vendor/autoload.php';

const RTDB_URL = "https://nwe-oo-default-rtdb.netlify.app";

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

header('Access-Control-Allow-Origin: *');

if ($method === 'OPTIONS') {
  header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
  exit(0);
}

$url = RTDB_URL . $path;
$context = stream_context_create([
  'http' => [
    'method' => $method,
  ],
]);

$response = @file_get_contents($url, false, $context);

header('Content-Type: application/json');

echo $response;
