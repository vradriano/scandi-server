<?php

abstract class Product
{
    private string $sku;
    private string $name;
    private float $price;
    private string $type;
    private string $value;

    public function __construct(string $sku, string $name, float $price, string $type, string $value) 
    {
        $this->setSku($sku);
        $this->setName($name);
        $this->setPrice($price);
        $this->setType($type);
        $this->setValue($value);
    }

    public function getSku(): string 
    {
        return $this->sku;
    }

    public function setSku(string $sku): void 
    {
        if (empty($sku)) {
            throw new InvalidArgumentException("SKU can't be empty");
        }
        $this->sku = $sku;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function setName(string $name): void 
    {
        if (empty($name)) {
            throw new InvalidArgumentException("Name can't be empty");
        }
        $this->name = $name;
    }

    public function getPrice(): float 
    {
        return $this->price;
    }

    public function setPrice($price): void 
    {
        if ($price !== null && is_numeric($price) <= 0) {
            throw new InvalidArgumentException("Price must be greater than zero");
        }
        $this->price = $price;
    }

    public function getType(): string 
    {
        return $this->type;
    }

    public function setType(string $type): void 
    {
        if (empty($type)) {
            throw new InvalidArgumentException("Type can't be empty");
        }
        $this->type = $type;
    }

    public function getValue(): string 
    {
        return $this->value;
    }

    public function setValue(string $value): void 
    {
        if (empty($value)) {
            throw new InvalidArgumentException("Value can't be empty");
        }
        $this->value = $value;
    }

    public static function getAllProducts(PDO $conn): array
    {
        try {
            $sql = "SELECT * FROM products";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }   catch (Exception $e) {
            throw new Exception("Internal server error");
        }
    }

    public static function deleteProduct(PDO $conn, string $sku): void
    {
        try {
            $sql = "DELETE FROM products WHERE sku = :sku";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':sku', $sku, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() === 0) {
                throw new Exception("Product with SKU '$sku' doesn't exist.");
            }
        } catch (PDOException $e) {
            throw new Exception("Internal server error");
        }
    }

    public static function countProductsBySku(PDO $conn, string $sku): int
    {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE sku = :sku");
        $stmt->execute([':sku' => $sku]);
    
        $existingProductCount = $stmt->fetchColumn();
    
        return $existingProductCount;
    }
}
