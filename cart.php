<?php
header("Content-Type: application/json"); // change to JSON

// CONNECT DATABASE
$conn = new mysqli("localhost", "root", "", "stylemart");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database error!"]);
    exit;
}

// RECEIVE JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Cart empty!"]);
    exit;
}

$order_id = null;

foreach ($data as $item) {
    $name = $conn->real_escape_string($item["name"]);
    $price = $conn->real_escape_string($item["price"]);
    $image = $conn->real_escape_string($item["image"]);
    $qty = $conn->real_escape_string($item["quantity"]);

    $conn->query("INSERT INTO cart (name, price, image, quantity) 
                  VALUES ('$name', '$price', '$image', '$qty')");

    // store last inserted ID
    $order_id = $conn->insert_id;
}

// Return success and order ID
echo json_encode(["success" => true, "order_id" => $order_id]);
?>
