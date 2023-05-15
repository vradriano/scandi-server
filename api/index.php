<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/api/controller/ProductController.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

$productController = new ProductController();

$request = $_GET['request'] ?? '';
$id = $_GET['id'] ?? null;

switch ($request) {
    case 'products':
        if ($requestMethod === 'GET') {
            $productController->getAllProducts();
        } elseif ($requestMethod === 'POST') {
            $productController->createProduct();
        } elseif ($requestMethod === 'DELETE') {
            $idList = explode(',', $id);
            $productController->deleteProduct($idList);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Unsupported method']);
        break;
}

// userNAME: scandiweb
// password: Scandiweb-1