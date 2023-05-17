<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/database/dbFactory.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/env.php');

class DatabaseController 
{
    public function createProductTable() {
        $sql = "CREATE TABLE IF NOT EXISTS products (
            id INT(11) NOT NULL AUTO_INCREMENT,
            sku VARCHAR(50) NOT NULL,
            name VARCHAR(255) NOT NULL,
            price DECIMAL(10, 2) NOT NULL,
            type ENUM('DVD', 'Book', 'Furniture') NOT NULL,
            value VARCHAR(50) NOT NULL,
            PRIMARY KEY (id),
            UNIQUE (sku)
        )";

        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            echo "Created products table successfully!";
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error creating table: ' . $e->getMessage()]);
        }
    }

    public function insertDatabaseGoods() {
        $db = new DB();
        $conn = $db->connect();

        $sql_file_path = $_SERVER['DOCUMENT_ROOT'] . '/api/sql/database_goods.sql';

        if (!file_exists($sql_file_path)) {
            http_response_code(400);
            echo 'SQL file not found';
            exit;
        }

        $sql = file_get_contents($sql_file_path);

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        echo "Data loaded successfully!";
    }
}