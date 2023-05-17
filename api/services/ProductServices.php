<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/api/classes/Product.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/database/dbFactory.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/repositories/ProductRepository.php');

class ProductService
{
    private $productRepository;

    public function __construct()
    {
        $db = new DB();
        $pdo = $db->connect();
        $this->productRepository = new ProductRepository($pdo);
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAllProducts();
    }

    public function createProduct(Product $productData)
    {
        $this->productRepository->saveProduct($productData);
    }
  
    public function deleteProducts(string $skus)
    {
        if (empty($skus)) {
            throw new InvalidArgumentException("Missing SKUs parameter.", 400);
        }
    
        $skuList = explode(',', $skus);
    
        foreach ($skuList as $sku) {
            $this->productRepository->deleteProduct($sku);
        }
    }

    public function getSkuList()
    {
        if (!isset($_GET['skus'])) {
            return false;
        }

        $skus = $_GET['skus'];

        if (strpos($skus, ',') !== false) {
            return explode(',', $skus);
        } else {
            return [$skus];
        }
    }
}