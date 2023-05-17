<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/api/services/ProductServices.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/factories/Product/Product.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/factories/Product/types.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/helpers/errorHandler.php');


class ProductController 
{
    private $productService;
    private $conn;

    public function __construct() 
    {
        $db = new DB();
        $this->conn = $db->connect();
        $this->productService = new ProductService($this->conn);
    }

    public function getAllProducts() 
    {
        try {
            $products = $this->productService->getAllProducts();
            echo json_encode($products);
        } catch (Exception $e) {
            sendErrorResponse(500, $e->getMessage());
        }
    }
    
    public function createProduct() 
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        extract($requestData);

        try {
            $product = ProductFactory::newProduct($sku, $name, $price, $type, $value);
            $this->productService->createProduct($product);
            echo json_encode([ 'success' => true ]);
        } catch (Exception $e) {
            sendErrorResponse(400, $e->getMessage());
        }
    }
    
    public function deleteProduct() 
    {
        $skus = $_GET['skus'] ?? '';
    
        try {
            $this->productService->deleteProducts($skus);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            sendErrorResponse(400, $e->getMessage());
        }
    }
}
