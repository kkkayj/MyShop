<?php
header("Content-Type: application/json");
$conn = new mysqli("localhost", "root", "", "stylemart");

if ($conn->connect_error) {
    echo json_encode(["message" => "Database connection failed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["message" => "Cart is empty"]);
    exit;
}

// calculate total
$total = 0;
foreach($data as $item){
    $total += $item['price'] * $item['quantity'];
}

// create order
$conn->query("INSERT INTO orders (total) VALUES ('$total')");
$order_id = $conn->insert_id;

foreach($data as $item){
    $name = $conn->real_escape_string($item["name"]);
    $price = $conn->real_escape_string($item["price"]);
    $qty = $conn->real_escape_string($item["quantity"]);

    $conn->query("INSERT INTO order_items (order_id, product_name, product_price, quantity)
                  VALUES ('$order_id', '$name', '$price', '$qty')");
}

// clear cart
echo json_encode(["order_id" => $order_id]);
?>

