
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/scandiweb/api/database/dbFactory.php');

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
    echo "Product table created successfully.";
} catch(PDOException $e) {
    echo 'Error creating table: ' . $e->getMessage();
}
