<?php

class Router
{
    private $requestMethod;
    private $requestPathSegments;

    public function __construct($requestMethod, $requestPathSegments)
    {
        $this->requestMethod = $requestMethod;
        $this->requestPathSegments = $requestPathSegments;
    }

    public function handleRequest()
    {
        $requestPath = $this->requestPathSegments[0];
        $queryParameters = $_GET;
        
        $route = strtok($requestPath, '?'); 
        
        switch ($route) {
            case 'products':
                $this->handleProductRoutes($queryParameters);
                break;
            case 'sql':
                $this->handleDatabaseRoutes($queryParameters);
                break;
            default:
                throw new Exception('Unsupported request: ' . $route);
        }
    }

    private function handleProductRoutes()
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/api/controller/ProductController.php');
        $productController = new ProductController();
    
        switch ($this->requestMethod) {
            case 'GET':
                $productController->getAllProducts();
                break;
            case 'POST':
                $productController->createProduct();
                break;
            case 'DELETE':
                $idList = isset($this->requestPathSegments[1]) ? explode(',', $this->requestPathSegments[1]) : [];
                $productController->deleteProduct($idList);
                break;
            default:
                throw new Exception('Unsupported method');
        }
    }

    private function handleDatabaseRoutes()
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/api/controller/DatabaseController.php');
        $databaseController = new DatabaseController();

        switch ($this->requestMethod) {
            case 'POST':
                if ($this->requestPathSegments[1] === 'create_product_table.php') {
                    $databaseController->createProductTable();
                } elseif ($this->requestPathSegments[1] === 'insert_data.php') {
                    $databaseController->insertDatabaseGoods();
                } else {
                    throw new Exception('Unsupported request');
                }
                break;
            default:
                throw new Exception('Unsupported method');
        }
    }
}
