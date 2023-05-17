<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/api/classes/Product.php');

class ProductRepository 
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getAllProducts(): array
    {
        return Product::getAllProducts($this->conn);
    }

    public function saveProduct(Product $product): void
    {
        $product->save($this->conn);
    }

    public function deleteProduct(string $sku): void
    {
        Product::deleteProduct($this->conn, $sku);
    }
}
