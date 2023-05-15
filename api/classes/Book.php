<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/api/classes/Product.php');
    
class BookProduct extends Product 
{
    private $weight;

    public function __construct(string $sku, string $name, string $price, string $type, string $weight) 
    {
        if (!is_numeric($price)) {
            throw new InvalidArgumentException("Price must be a number");
        }
            
        parent::__construct($sku, $name, floatval($price), $type, $weight);
        $this->setWeight($weight);
    }

    public function getWeight(): string 
    {
        return $this->weight;
    }

    public function setWeight($weight) 
    {
        if ($weight !== null && is_numeric($weight)) {
            $this->weight = $weight;
        } else {
            throw new InvalidArgumentException("Weight must be a float and can't be null");
        }
    }

    public function save($conn): bool
    {
        try {
            $stmt = $conn->prepare("INSERT INTO products (sku, name, price, type, value) 
                    VALUES (:sku, :name, :price, :type, :weight)");
            $stmt->execute([
                ':sku' => $this->getSku(),
                ':name' => $this->getName(),
                ':price' => $this->getPrice(),
                ':type' => $this->getType(),
                ':weight' => $this->getWeight(),
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
