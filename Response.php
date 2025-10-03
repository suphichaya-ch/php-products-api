<?php
// ในไฟล์ src/Response.php

class Response {
    public static function json($data, int $statusCode = 200, array $headers = []): void {
        
        http_response_code($statusCode);
        
        // กำหนด Content-Type เป็น JSON (สำคัญมาก)
        header("Content-Type: application/json; charset=UTF-8"); 
        
        // อนุญาต CORS (สำคัญ)
        header("Access-Control-Allow-Origin: *"); 

        foreach ($headers as $name => $value) {
            header("$name: $value");
        }
        
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        
        exit; // หยุดการทำงานของสคริปต์ PHP ทันที
    }

    public static function error(string $message, int $statusCode): void {
        self::json(["error" => $message], $statusCode);
    }
}
