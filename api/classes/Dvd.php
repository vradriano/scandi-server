<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/api/classes/Product.php');

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
            $stmt->execute([
                ':sku' => $this->getSku(),
                ':name' => $this->getName(),
                ':price' => $this->getPrice(),
                ':type' => $this->getType(),
                ':size' => $this->getSize(),
            ]);
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
