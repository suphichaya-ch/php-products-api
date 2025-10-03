<?php
// ในไฟล์ src/ApplianceController.php

class ApplianceController {
    private $db;

    public function __construct() {
        $this->db = new Database(); 
    }
    
    public function processRequest(string $method, ?string $id): void {
        switch ($method) {
            case "GET":
                if ($id) {
                    // $this->getSingleAppliance($id); // GET /appliances/{id}
                    Response::json(["message" => "GET Single Product ID: " . $id], 200); 
                } else {
                    $this->getAllAppliances(); // GET /appliances
                }
                break;
            default:
                Response::error("Method Not Allowed", 405);
        }
    }

    private function getAllAppliances(): void {
        // 1. ดึงข้อมูลจาก Database (จะได้ Array ของสินค้าทั้งหมด)
        $products = $this->db->getAllProducts();
        
        // 2. ใช้ Response Class ส่ง Array ทั้งหมดกลับไปในรูปแบบ { "data": [...] }
        Response::json(["data" => $products], 200);
    }
}
