<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Signup successful! Please login.'); window.location='login.html';</script>";
  } else {
    echo "Error: " . $conn->error;
  }
}
?>
