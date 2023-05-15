<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/api/database/dbFactory.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/api/env.php');

$db = new DB();
$conn = $db->connect();

$sql_file_path = $_SERVER['DOCUMENT_ROOT'] . '/scandiweb/api/sql/database_goods.sql';

if (!file_exists($sql_file_path)) {
    http_response_code(400);
    echo 'SQL file not found';
    exit;
}

$sql = file_get_contents($sql_file_path);

$stmt = $conn->prepare($sql);

$stmt->execute();
echo "Data loaded successfully!";