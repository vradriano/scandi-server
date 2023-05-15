<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/api/classes/Product.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/api/helpers/errorHandler.php');

class FurnitureProduct extends Product 
{
    private $height;
    private $width;
    private $length;

    public function __construct(string $sku, string $name, string $price, string $type, string $dimensions) 
    {
        if (!is_numeric($price)) {
            throw new InvalidArgumentException("Price must be a number");
        }
        
        parent::__construct($sku, $name, floatval($price), $type, $dimensions);
    
        $dimensionValues = explode('x', $dimensions);
        if (count($dimensionValues) === 3) {
            $this->setHeight($dimensionValues[0]);
            $this->setWidth($dimensionValues[1]);
            $this->setLength($dimensionValues[2]);
        } else {
            throw new InvalidArgumentException('Invalid dimensions provided');
        }
    }
    
    public function getHeight(): float 
    {
        return $this->height;
    }

    public function setHeight($height): void
    {
        if ($height !== null && is_numeric($height)) {
            $this->height = $height;
        } else {
            throw new InvalidArgumentException("Height must be a float and can't be null");
        }
    }

    public function getWidth(): ?float 
    {
        return $this->width;
    }

    public function setWidth($width): void
    {
        if ($width !== null && is_numeric($width)) {
            $this->width = $width;
        } else {
            throw new InvalidArgumentException("Width must be a float and can't be null");
        }
    }

    public function getLength(): ?float 
    {
        return $this->length;
    }

    public function setLength($length): void
    {
        if ($length !== null && is_numeric($length)) {
            $this->length = $length;
        } else {
            throw new InvalidArgumentException("Length  must be a float and can't be null");
        }
    }

    public function getValue(): string 
    {
        return $this->height . 'x' . $this->width . 'x' . $this->length;
    }

    public function save($conn): bool
    {
        try {
            $stmt = $conn->prepare("INSERT INTO products (sku, name, price, type, value) 
                VALUES (:sku, :name, :price, :type, :dimensions)");
            $stmt->execute([
                ':sku' => $this->getSku(),
                ':name' => $this->getName(),
                ':price' => $this->getPrice(),
                ':type' => $this->getType(),
                ':dimensions' => $this->getValue(),
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
