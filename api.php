<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case "GET":
        if(isset($_GET['id'])){
            $id = intval($_GET['id']);
            $result = $conn->query("SELECT * FROM products WHERE id=$id");
            $data = $result->fetch_assoc();
            echo json_encode($data);
        } else {
            $result = $conn->query("SELECT * FROM products");
            $data = [];
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
        }
        break;

    case "POST":
        $input = json_decode(file_get_contents('php://input'), true);
        $name = $input['name'];
        $category = $input['category'];
        $price = $input['price'];
        $stock = $input['stock'];
        $conn->query("INSERT INTO products (name, category, price, stock) VALUES ('$name','$category',$price,$stock)");
        echo json_encode(["message" => "Product added"]);
        break;

    case "PUT":
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'];
        $name = $input['name'];
        $category = $input['category'];
        $price = $input['price'];
        $stock = $input['stock'];
        $conn->query("UPDATE products SET name='$name', category='$category', price=$price, stock=$stock WHERE id=$id");
        echo json_encode(["message" => "Product updated"]);
        break;

    case "DELETE":
        $id = intval($_GET['id']);
        $conn->query("DELETE FROM products WHERE id=$id");
        echo json_encode(["message" => "Product deleted"]);
        break;
}

$conn->close();
?>
