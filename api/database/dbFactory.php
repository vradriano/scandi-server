<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/api/env.php');

class DB
{
    private $dbhost;
    private $dbname;
    private $dbuser;
    private $dbpass;

    public function __construct()
    {
        $this->dbhost = $_ENV['DB_HOST'] ?? 'localhost';
        $this->dbname = $_ENV['DB_NAME'];
        $this->dbuser = $_ENV['DB_USER'];
        $this->dbpass = $_ENV['DB_PASS'];
    }

    public function connect()
    {
        try {
            $conn = new PDO("mysql:host={$this->dbhost};dbname={$this->dbname}", $this->dbuser, $this->dbpass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            throw new Exception('Connection failed: ' . $e->getMessage(), 500) ;
        }
    }
}
