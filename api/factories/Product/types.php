<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/classes/Dvd.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/classes/Book.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/classes/Furniture.php');

define('PRODUCT_TYPES', [
  'DVD' => DvdProduct::class,
  'Book' => BookProduct::class,
  'Furniture' => FurnitureProduct::class
]);
