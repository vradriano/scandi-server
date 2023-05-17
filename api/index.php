<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/api/helpers/cors.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/routes/Router.php');

setCorsHeaders(); 

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

$requestUri = $_SERVER['REQUEST_URI'];
$baseUri = '/api/';
$requestPath = trim(str_replace($baseUri, '', $requestUri), '/');
$requestPathSegments = explode('/', $requestPath);

$router = new Router($_SERVER['REQUEST_METHOD'], $requestPathSegments);
$router->handleRequest();
