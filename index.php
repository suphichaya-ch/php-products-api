<?php
// ในไฟล์ public/index.php

// 1. กำหนดค่าพื้นฐาน (require ไฟล์สำคัญ)
require dirname(__DIR__) . "/src/Database.php";
require dirname(__DIR__) . "/src/ApplianceController.php";
require dirname(__DIR__) . "/src/Response.php"; // ต้องเรียกใช้ Response

// 2. ตรวจสอบ Method และ Path (Routing)
$uri = '';

// A. ลองใช้ PATH_INFO ก่อน (สำหรับ URL: index.php/api/products)
if (isset($_SERVER['PATH_INFO']) && !empty($_SERVER['PATH_INFO'])) {
    $uri = $_SERVER['PATH_INFO'];
} 
// B. ถ้า PATH_INFO ว่าง ให้ดึงจาก REQUEST_URI
else {
    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $base_path_with_file = '/php-products-api/public/index.php'; 
    
    if (strpos($request_uri, $base_path_with_file) !== false) {
        $uri = substr($request_uri, strpos($request_uri, $base_path_with_file) + strlen($base_path_with_file));
    }
}

// แยก Path เป็นส่วนๆ (เช่น /api/appliances -> ['api', 'appliances'])
$uri_segments = explode('/', trim($uri, '/'));


// ตรวจสอบ Resource หลัก (ต้องเป็น /api/appliances)
$api_prefix = $uri_segments[0] ?? '';
$resource = $uri_segments[1] ?? '';

if ($api_prefix !== 'api' || $resource !== 'appliances') {
    // ถ้า Path ไม่ตรงตามที่กำหนด ให้ Response 404
    Response::error("Resource not found or incorrect API prefix", 404);
}

// ดึง ID (ถ้ามี)
$appliance_id = $uri_segments[2] ?? null;

// 3. เรียกใช้ Controller ตาม Method
$method = $_SERVER["REQUEST_METHOD"];

$controller = new ApplianceController();
$controller->processRequest($method, $appliance_id);
