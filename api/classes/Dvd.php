<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/api/classes/Product.php');

class DVDProduct extends Product 
{
    private $size;

    public function __construct(string $sku, string $name, string $price, string $type, string $size) 
    {
           
        if (!is_numeric($price)) {
            throw new InvalidArgumentException("Price must be a number");
        }
            
        parent::__construct($sku, $name, floatval($price), $type, $size);
        
        $this->setSize($size);
    }

    public function getSize(): string 
    {
        return $this->size;
    }

    public function setSize($size): void 
    {
        if ($size !== null && is_numeric($size)) {
            $this->size = $size;
        } else {
            throw new InvalidArgumentException("Size must be a float and can't be null");
        }
    }

    public function save($conn): bool
    {
        try {
            $stmt = $conn->prepare("INSERT INTO products (sku, name, price, type, value) 
                VALUES (:sku, :name, :price, :type, :size)");
            $stmt->bindValue(':sku', $this->getSku(), PDO::PARAM_STR);
            $stmt->bindValue(':name', $this->getName(), PDO::PARAM_STR);
            $stmt->bindValue(':price', $this->getPrice(), PDO::PARAM_STR);
            $stmt->bindValue(':type', $this->getType(), PDO::PARAM_STR);
            $stmt->bindValue(':size', $this->getSize(), PDO::PARAM_STR);
            $stmt->execute();
        
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new Exception("SKU is already taken, please select another one.", 400);
            } else {
                throw new Exception("Internal server error: " . $e->getMessage());
            }
        }
    }
}
