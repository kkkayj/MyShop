<?php
header("Content-Type: text/plain");

// CONNECT DATABASE
$conn = new mysqli("localhost", "root", "", "stylemart");

if ($conn->connect_error) {
    die("Database error!");
}

// RECEIVE JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo "Cart empty!";
    exit;
}

foreach ($data as $item) {
    $name = $conn->real_escape_string($item["name"]);
    $price = $conn->real_escape_string($item["price"]);
    $image = $conn->real_escape_string($item["image"]);
    $qty = $conn->real_escape_string($item["quantity"]);

    $conn->query("INSERT INTO cart (name, price, image, quantity)
                  VALUES ('$name', '$price', '$image', '$qty')");
}

echo "Checkout completed. Items saved to database!";
?>
