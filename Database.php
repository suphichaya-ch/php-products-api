<?php
// ในไฟล์ src/Database.php

class Database {
    private $conn;

    public function __construct() {
        // ข้อมูลการเชื่อมต่อ XAMPP
        $servername = "localhost";
        $username = "root"; 
        $password = "";     
        $dbname = "products_db"; 

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getAllProducts(): array {
        // SQL: ดึงข้อมูลทั้งหมดจากตาราง products
        $sql = "SELECT id, name, category, price, stock, created_at FROM products ORDER BY id DESC";
        $result = $this->conn->query($sql);
        
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    
    // public function getSingleProduct(string $id): ?array { ... } // สำหรับ GET /appliances/{id}
}
