<?php

class ProductFactory {
    public static function newProduct($sku, $name, $price, $type, $value)
    {
      require_once($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/api/factories/Product/types.php');

      if (isset(PRODUCT_TYPES[$type])) {
          $product = PRODUCT_TYPES[$type];
          return new $product($sku, $name, $price, $type, $value);
      } else {
          throw new Exception('Invalid product type.');
      }
    }
}